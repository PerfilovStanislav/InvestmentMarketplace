<?php

namespace Controllers {

    use Core\{
        Auth,
        Controller,
        Database,
        Router
    };
    use Helpers\{
        Arrays,
        Locale,
        Validator,
        Output,
        Data\Currency
    };
	use Libraries\File;
	use Models\{
        Investment as Model,
	    Users as UserModels,
        ProjectStatus
    };
    use Params\Investment\ShowParams;
    use Views\Investment\{
        Added,
        Registration,
        Show,
        NoShow
    };

    class Investment extends Controller {
		private $model;

		function __construct() {
			parent::__construct();
			$this->model = new Model();
		}

		final public function registration() {
		    $data = $this->model->getRegistrationData();
            $data['currency'] = Currency::getCurrency();
            Output::$r['c']['content'] = [Registration::class, $data];
            Output::$r['f']['content'] = ['ProjectRegistration' => []];
		}

		final public function show(ShowParams $params) {
            $filterLangs = $this->model->getFilterLangs();

            $lang = $filterLangs[$params->lang] ?? $filterLangs[ShowParams::$defaults->lang];
            $params->set([
                'lang'   => $lang['shortname'],
                'page'   => max((int)($params->page), 1),
                'status' => ProjectStatus::getValue($params->status ?? '') ?: ProjectStatus::ACTIVE,
            ]);
			unset($filterLangs[$params->lang]);

            $data = $this->model->getShowData($lang['id'], $params->status);

            $params->excludeDefault();
            if ($params->status) {
                $params->status = ProjectStatus::getConstName($params->status);
            }

			$pageParams = [
                'filter' => $params,
                'url'    => Router::getInstance()->getCurrentPageUrl(),
                'flag'   => $lang['flag'],
            ] + ['filterLangs' => $filterLangs];

            Output::$r['f']['content'] = [
                'initChat',
                'panelScrollerInit',
                'imgClickInit',
            ];

            if (!$data) {
                return Output::$r['c']['content'] = [NoShow::class, $pageParams];
            }

            foreach ($data['projects'] as $project_id => &$val) {
                $val['file_name'] = File::get_file_path($project_id);
            }

            Output::$r['c']['content'] = [Show::class, $data + $pageParams];
			$chatParams = array_map(function($a){return ['id'=>$a,'max_id'=>0];}, $data['projectIds']);
			$this->getChatMessages($chatParams);
		}

		final public function add() {
            $data = $this->post
                ->checkAll('projectname', 		1, 		null, 	Validator::TEXT)
				->checkAll('paymenttype', 		1, 		3, 	    Validator::NUM)
				->checkAll('date', 				10, 	10, 	Validator::DATE)

            	->checkAll('percents', 			1, 		null,  Validator::FLOAT,    'plan_percents', 		true, 0)
            	->checkAll('period', 			1, 		null,  Validator::NUM,      'plan_period', 		true, 0)
            	->checkAll('periodtype', 		1, 		6, 	    Validator::NUM,      'plan_period_type', 	true, 0)
            	->checkAll('minmoney', 			0.00001, null, 	Validator::FLOAT, 	   'plan_start_deposit', true, 0)
				->checkAll('currency', 			1, 		8, 	    Validator::NUM,		'plan_currency_type',true, 0)

				->checkAll('ref_percent', 		null, 	null, 	Validator::FLOAT,     null,                true)
				->checkAll('payment', 			1, 		null, 	Validator::NUM,		'id_payments')
                ->checkAll('description', 		1, 		null, 	null,                 null,                null,  1)
                ->checkAll('lang', 				1, 		null, 	Validator::NUM,		'languages',         null,  1)

                ->exitWithErrors()->getData();

            foreach ($data['languages'] as $key => $val) {
			    if (!isset($data['description'][$val])) {
                    Output::alert(['is_absent' => [$val]], 'error');
                }
            }

            $this->post->addFields(['url' => $this->checkWebsite()]);
            if ($project_id = $this->model->addProject($this->post)) {
                // Save screenshots
                $file = new File($project_id);
                $file->save($_POST['screen_data'])->addIPTC([5 => $this->post->url, 120 => $this->post->url]);
                $file->save($_POST['thumb_data'], true)->addIPTC([5 => $this->post->url, 120 => $this->post->url]);

                Output::$r['c']['content'] = [Added::class, $data];
                Output::alert(['Success!' => [Locale::get('project_is_added')]], 'success');
            }
		}

		final public function checkWebsite(array $params = []) {
            $ref_url = $this->post->checkAll('website', 1, 128, Validator::URL, 'ref_url')->getData()['ref_url'];
            $url = 'http://'.str_replace(['www.', 'https://', 'http://'], '', strtolower($ref_url));
            $url = array_reverse(explode('.', parse_url($url, PHP_URL_HOST)));

            if (count($url) < 2) {
				return Output::fieldError('website', 'wrong_url');
            }
            else {
                $url_str = $url[1] . '.' . $url[0];
                if (($res = $this->model->db->getRow('project', 'id', "url = '{$url_str}'"))) {
					return Output::fieldError('website', 'site_exists');
                }
                elseif ($params['showsuccess'] ?? false) return Output::fieldSuccess('website', 'site_is_free');
                else return $url_str;
            }
        }

        final public function sendMessage(array $params = []) {
            $project_id = (int)$params['project'];

            $post = $this->post
                ->checkAll('message', 		1, 		2047)
                ->checkAlerts();

            $info = Auth::getUserInfo();
            $data = [
                'user_id'       => [[$info['id']], \PDO::PARAM_INT],
                'project_id'    => [[$project_id], \PDO::PARAM_INT],
                'lang_id'       => [[217], \PDO::PARAM_INT],
                'message'       => [[$post->message]],
                'session_id'    => [[$info['session_id']], \PDO::PARAM_INT],
            ];
            $this->model->db->insert('message', $data);

            $return['f']['content'][] = 'checkChats';

            return Output::json($return);
        }

        final public function getChatMessages(array $params = []) {
		    // если есть $params, значит вызвали из $this->show()
            $chats = $params ?: $this->post->checkAll('chats')->exitWithErrors()->chats;

            if ($new_messages = $this->model->getChatMessages($chats)) {
            	$array = new Arrays();
				$usersIds = $array
					->setArray($new_messages)
					->getUnique('user_id')
					->getArray();

				Output::$r['f']['content']['setNewChatMessages'] =
					[
						'users' => $usersIds ? $array
							->setArray((new UserModels())->getUsersByIds($usersIds))
							->groupBy(['id'])
							->getArray() : [],
						'messages' => $new_messages
					];
			}
			Output::$r['f']['content'][] = 'startChatCheck';
        }

        final public function redirect(array $params = []) {
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