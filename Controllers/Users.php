<?php

namespace Controllers {

    use Core\{
        Auth,
        Controller,
        View
    };
    use Libraries\Mail;
    use Models\{
        AuthModel,
        Collection\MVSiteAvailableLanguages,
        Constant\DomElements,
        Constant\UserStatus,
        Constant\Views,
        MailMessage,
        Table\User,
        Table\UserConfirm};
	use Helpers\{
        Output,
        Locale
	};
    use Requests\{
        LanguageAvailableRequest,
        User\AuthorizeRequest,
        User\ConfirmRequest,
        User\RegistrationRequest
    };
    use Views\{Emails\ConfirmEmail,
        Error,
        Success,
        Users\Head\Authorized,
        Users\Head\NotAuthorized,
        Users\Login,
        Users\Registered,
        Users\Registration,
        SideLeft
    };

	class Users extends Controller {

        /**
         * @deprecated как я сюда попадаю?
         */
        public function login() {
            Output::addView(Login::class);
        }

        public function logout() {
			Auth::getInstance()->logout();
			$this->reloadPage();
        }

        private function reloadPage() {
			$url = parse_url($_SERVER['HTTP_REFERER']??'');
			Output::addFunctions([
			    'allClear',
			    'addToAjaxQueue' => [
                    '/Users/setUserHead',
                    '/Users/setLeftSide',
                    $url['path']
                ]
            ], Output::DOCUMENT);
		}

		public function authorize(AuthorizeRequest $request) {
            if (Auth::getInstance()->authorize($request)) {
                $this->reloadPage();
            }
		}

		public function registration() {
            Output::addView(
                AuthModel::getInstance()->is_authorized
                    ? Registered::class
                    : Registration::class
            );
            Output::addFunction('UserRegistration');
		}

		public function add(RegistrationRequest $request) {
            $user = (new User())->getRowFromDbAndFill([
                'login' => $request->login
            ]);
            if ($user->id) {
                Output::addFieldDanger('login', Locale::get('login_is_busy'), DomElements::ADDUSER_FORM);
                return;
            }

            $user->getRowFromDbAndFill([
                'email' => $request->email
            ]);
            if ($user->id) {
                Output::addFieldDanger('email', Locale::get('email_is_busy'), DomElements::ADDUSER_FORM);
                return;
            }

            $user->fromArray([
                'name' => $request->name,
                'password' => Auth::hashPassword($request->password),
                'status_id' => UserStatus::NEED_CONFIRM,
                'lang_id' => MVSiteAvailableLanguages::getInstance()->{Locale::getLanguage()}->id,
                'has_photo' => false,
            ])->save();

            $userConfirm = (new UserConfirm())->fromArray([
                'user_id' => $user->id,
                'code'    => bin2hex(random_bytes(32)), // 64 random
            ])->save();

            /** @var MailMessage $mailMessage */
            $mailMessage = (new MailMessage())->fromArray([
                'subject'       => Locale::get('email_confirmation'),
                'body'          => (new View(ConfirmEmail::class, ['user' => $user, 'code' => $userConfirm->code]))->get(),
                'receiverEmail' => $user->email,
                'receiverName'  => $user->name,
            ]);
            (new Mail())->sendMail($mailMessage);

            Output::addView(Success::class, ['text' => Locale::get('email_confirm_sent')]);
            Output::addAlertSuccess(Locale::get('success'), Locale::get('email_confirm_sent'));
		}

        public function confirm(ConfirmRequest $request) {
            $userConfirm = new UserConfirm();
            $userConfirm->getRowFromDbAndFill(['code' => $request->code]);

            if ($userConfirm->id) {
                $user = (new User())->getById($userConfirm->user_id);
                $user->status_id = UserStatus::USER;
                $user->save();

                Output::addView(Success::class, ['text' => Locale::get('success')]);
                Output::addAlertSuccess(Locale::get('success'), Locale::get('email_confirmation'));
            }
            else {
                Output::addView(Error::class, ['text' => Locale::get('no_confirm_code')]);
                Output::addAlertDanger(Locale::get('error'), Locale::get('no_confirm_code'));
            }
		}

        public static function setUserHead() {
            Output::addFunctions([
                'setStorage' => [
                    'webp' => WEBP,
                    'auth' => AuthModel::getInstance()->toArray()
                ],
            ], Output::DOCUMENT, 1);
		    $params = [
                'siteLanguages'     => MVSiteAvailableLanguages::getInstance(),
                'selectedLanguage'  => Locale::getLanguage(),
                'avatar'            => AuthModel::getInstance()->getUserAvatar(),
            ];
		    if (AuthModel::getInstance()->is_authorized) {
                Output::addView(
                    Authorized::class,
                    $params + ['user' => AuthModel::getInstance()->user],
                    Views::USER_HEAD
                );
            }
		    else {
                Output::addView(
                    NotAuthorized::class,
                    $params,
                    Views::USER_HEAD
                );
                Output::addFunctions(['UserAuthorization'], Output::DOCUMENT, 1);
            }
		}

        public static function setLeftSide() {
            Output::addView(SideLeft::class, [], Views::SIDEBAR_LEFT);
        }

		public function changeLanguage(LanguageAvailableRequest $request) {
			if ($request->lang) {
				if (AuthModel::getInstance()->is_authorized) {
				    $user = AuthModel::getInstance()->user;
                    $user->lang_id = MVSiteAvailableLanguages::getInstance()->{$request->lang}->id;
                    $user->save();
				}
				else {
					$_SESSION['lang'] = $request->lang;
				}
                $this->reloadPage();
			}
		}
	}
}