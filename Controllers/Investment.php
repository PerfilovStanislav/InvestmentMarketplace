<?php

namespace Controllers {

    use Core\{
        Auth,
        Controller,
        Database,
        Router,
        View,
    };
    use Helpers\{
        Locale,
        Errors,
        Output,
        Data\Currency,
    };
	use Libraries\File;
    use Models\Collection\{
        Languages,
        ProjectChatMessages,
        MVProjectLangs,
        Payments,
        ProjectLangs,
        Projects,
        MVProjectFilterAvailableLangs,
        MVProjectSearchs,
        Users,
    };
    use Models\Table\{Language, Project, ProjectChatMessage, ProjectLang};
    use Models\{
        AuthModel,
    };
    use Models\Constant\{
        ProjectStatus,
        UserStatus,
        Views,
    };
    use Requests\Investment\{
        AddRequest,
        ChatMessagesRequest,
        CheckSiteRequest,
        SetChatMessageRequest,
        ShowRequest,
    };
    use Traits\AuthTrait;
    use Views\Investment\{
        Added,
        ProjectFilter,
        Registration,
        Show,
        NoShow,
    };

    class Investment extends Controller {
        use AuthTrait;
        private CONST LIMIT = 20;

		public function registration() {
            $params = [
                'payments'                  => new Payments(),
                'mainProjectLanguages'      => new Languages('pos is not null', 'pos asc'),
                'secondaryProjectLanguages' => new Languages('pos is null'),
                'currency'                  => Currency::getCurrency(),
                'authModel'                 => AuthModel::getInstance(),
            ];

            Output::addView(Registration::class, $params);
            Output::addFunction('ProjectRegistration');
		}

		public function show(ShowRequest $request) {
            $MVProjectFilterAvailableLangs = new MVProjectFilterAvailableLangs(['status_id' => $request->getActual('status')]);
            if (!$MVProjectFilterAvailableLangs->get()) {
                // без фильтра
                return self::noShow([Views::PROJECT_FILTER => '']);
            }
            $languages = new Languages(['id' => $MVProjectFilterAvailableLangs->getValuesByKey()]);
            /** @var Language $pageLanguage текущий язык*/
            $pageLanguage = $languages->getByKeyAndValue('shortname', $request->getActual('lang'));

            $projectFilter = (new View(ProjectFilter::class, [
                'request'                       => $request,
                'url'                           => Router::getInstance()->getCurrentPageUrl(),
                'languages'                     => $languages,
                'MVProjectFilterAvailableLangs' => $MVProjectFilterAvailableLangs,
                'pageLanguage'                  => $pageLanguage ?? new Language(['flag' => 'xx']), // фэйк
            ]));

            if (!$pageLanguage) {
                return self::noShow([Views::PROJECT_FILTER => $projectFilter]);
            }

            // ID найденных проектов
            $projectSearchs = new MVProjectSearchs([
                'lang_id' => $pageLanguage->id,
                'status_id' => $request->getActual('status'),
            ], min(self::LIMIT, $MVProjectFilterAvailableLangs->{$pageLanguage->id}->cnt));

            if (empty($projectSearchs->get())) {
                return self::noShow([Views::PROJECT_FILTER => $projectFilter]);
            }

            $projectIds     = $projectSearchs->getValuesByKey();
            $projects       = new Projects(['id' => $projectIds]);
            $MVProjectLangs = new MVProjectLangs(['id' => $projectIds]);
            $payments       = new Payments(['id' => $projects->getUniqueValuesByKey('id_payments')]);
            $projectLangs   = new ProjectLangs(['project_id' => $projectIds, 'lang_id' => $pageLanguage->id]);

            $pageParams = [
                'projects'            => $projects,
                'MVProjectLangs'      => $MVProjectLangs,
                'pageLanguage'        => $pageLanguage,
                'payments'            => $payments,
                'projectLangs'        => $projectLangs,
                'languages'           => $languages,
                Views::PROJECT_FILTER => $projectFilter,
            ];

            Output::addFunctions([
                'setStorage' => ['lang' => $pageLanguage->id, 'chat' => []],
                'initChat',
                'panelScrollerInit',
                'imgClickInit',
                'loadRealThumbs',
                'checkChats',
            ], Output::DOCUMENT);

            Output::addView(Show::class, $pageParams);
		}

		private static function noShow(array $pageParams) {
            Output::addView(NoShow::class, $pageParams);
        }

		public function add(AddRequest $request, CheckSiteRequest $checkSiteRequest) {
            self::needAuthorization();

            $url = $this->checkWebsite($checkSiteRequest, true);

            if (count(array_unique([
                count($request->plan_percents),
                count($request->plan_period),
                count($request->plan_period_type),
                count($request->plan_start_deposit),
                count($request->plan_currency_type)
                ])) !== 1)
            {
                // Кол-во элементов отличается
                Errors::add(Locale::get('plans'), 'error', true);
            }

            // Сохраняем проект
            $project = (new Project())->fromArray($request->toArray());
            $project->admin     = AuthModel::getInstance()->user->id;
            $project->url       = $url;
            $project->ref_url   = $checkSiteRequest->website;
            $project->status_id = AuthModel::getInstance()->user->status_id === UserStatus::ADMIN
                ? ProjectStatus::ACTIVE
                : ProjectStatus::NOT_PUBLISHED;
            $project->save();

            $file = new File($project->id);
            $file->save($request->screen_data)->addIPTC([5 => $url, 120 => $url]);
            $file->save($request->thumb_data, true)->addIPTC([5 => $url, 120 => $url]);

            // Сохраняем описания
            foreach ($request->description as $langId => $description) {
                $projectLang = new ProjectLang();
                $projectLang->project_id  = $project->id;
                $projectLang->lang_id     = $langId;
                $projectLang->description = $description;
                $projectLang->save();
                unset($projectLang);
            }

            // Обновляем вьюшки @TODO перенести в rabbit
            MVProjectFilterAvailableLangs::refresh();
            MVProjectLangs::refresh();
            MVProjectSearchs::refresh();

            Output::addView(Added::class);
            Output::addAlertSuccess(Locale::get('success'), Locale::get('project_is_added'));
		}

		public function checkWebsite(CheckSiteRequest $request, bool $getUrl = false) : string {
            $url = 'http://'.str_replace(['www.', 'https://', 'http://'], '', strtolower($request->website));
            $url = array_reverse(explode('.', parse_url($url, PHP_URL_HOST)));

            if (count($url) < 2) {
                Errors::add('website', Locale::get('wrong_url'), true);
            }
            else {
                $url_str = $url[1] . '.' . $url[0];
                if (($res = Project::getDb()->selectRow(['url' => $url_str]))) {
                    Errors::add('website', Locale::get('site_exists'), true);
                }
                elseif ($getUrl) return $url_str;
                else Output::addFieldSuccess('website', Locale::get('site_is_free'));
            }
        }

        public function sendMessage(SetChatMessageRequest $request) {
            (new ProjectChatMessage([
                'user_id'       => AuthModel::getUserId(),
                'project_id'    => $request->project,
                'lang_id'       => $request->lang,
                'message'       => $request->message,
                'session_id'    => AuthModel::getInstance()->session_id,
            ]))->save();

            Output::addFunction('checkChats');
        }

        public function getChatMessages(ChatMessagesRequest $request) {
            $messages = new ProjectChatMessages($request);

            if ($messages->get()) {
                $userIds = $messages->getUniqueValuesByKey('user_id');
                if (!empty($userIds)) {
                    $users = new Users(['id' => $messages->getUniqueValuesByKey('user_id')], ['id', 'login', 'name', 'status_id']);
                    Output::addFunction('setNewChatMessages', ['users' => $users->toArray()]);
                }
                Output::addFunction('setNewChatMessages', ['messages' => $messages->toArray()]);
			}
            Output::addFunction('sleepAndCheckChats');
        }

        public function redirect(array $params = []) {
		    $projectId = (int)($params['project'] ?? 0);
            $refUrl = $this->model->db->getOne('project', "id = $projectId", 'ref_url'); /** @see Database::getOne() */
            if (!$refUrl) {
                return Output::header(Output::E404);
            }

            $info = Auth::getUserInfo();
            $data = [
                'user_id'       => [[$info['id']], \PDO::PARAM_INT],
                'project_id'    => [[$projectId], \PDO::PARAM_INT],
                'session_id'    => [[$info['session_id']], \PDO::PARAM_INT],
            ];
            $this->model->db->insert('redirect', $data);

            header('HTTP/1.1 200 OK');
            header('Location: ' . $refUrl);
        }
	}

}