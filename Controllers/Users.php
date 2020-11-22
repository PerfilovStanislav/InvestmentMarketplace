<?php

namespace Controllers;

use Core\Controller;
use Models\{
    Constant\DomElements,
    Constant\UserStatus,
    Constant\Views,
    Constant\Language,
    Table\User,
    Collection\MVProjectCounts,
};
use Helpers\Output;
use Requests\{
    LanguageAvailableRequest,
    User\AuthorizeRequest,
    User\RegistrationRequest
};
use Views\{
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
        Output()->addView(Login::class);
    }

    public function logout(): Output {
        App()->auth()->logout();
        return $this->reloadPage();
    }

    public function reloadPage(): Output {
        $url = parse_url($_SERVER['HTTP_REFERER'] ?? '');

        $this->setUserHead();
        $this->setLeftSide();

        return Router()->go($url['path'] ?? '');
    }

    public function authorize(AuthorizeRequest $request): Output {
        if (App()->auth()->authorize($request)) {
            return $this->reloadPage();
        }
        return Output();
    }

    public function registration(): Output {
        return Output()
            ->addView(
            CurrentUser()->is_authorized
                ? Registered::class
                : Registration::class
            )->addFunction('initForms');
    }

    public function add(RegistrationRequest $request): Output {
        $user = (new User())->getRowFromDbAndFill([
            'login' => strtolower($request->login)
        ]);
        if ($user->id) {
            return Output()->addFieldDanger('login', Translate()->loginIsBusy, DomElements::ADD_USER_FORM);
        }

        $user->fromArray([
            'name'      => $request->name,
            'password'  => App()->auth()->hashPassword($request->password),
            'status_id' => UserStatus::USER,
            'lang_id'   => Language::getValue(App()->locale()->getLanguage()),
            'has_photo' => false,
        ])->save();

        Output()->addAlertSuccess(Translate()->success, Translate()->userRegistered);

        return $this->authorize(new AuthorizeRequest([
            'login'    => $request->login,
            'password' => $request->password,
        ]));
    }

    public function setUserHead(): Output {
        Output()->addFunctions([
            'setParams' => [
                'webp' => WEBP,
                'auth' => CurrentUser()->toArray()
            ],
        ], Output::DOCUMENT, 1)
            ->addFunction('imgClickInit', [], Views::USER_HEAD);
        $params = [
            'siteLanguages'     => App()->siteLanguages(),
            'selectedLanguage'  => App()->locale()->getLanguage(),
            'avatar'            => CurrentUser()->getUserAvatar(),
        ];

        if (CurrentUser()->is_authorized) {
            return Output()->addView(
                Authorized::class,
                $params + ['user' => CurrentUser()->user],
                Views::USER_HEAD
            );
        }

        return Output()->addView(
            NotAuthorized::class,
            $params,
            Views::USER_HEAD
        )->addFunction('initForms', [], Views::USER_HEAD, 1);
    }

    public function setLeftSide(): Output {
        $isAdmin = CurrentUser()->isAdmin();
        return Output()->addView(SideLeft::class, [
            'counts' => array_map(fn (array $cnt):string => $isAdmin ? ' ' . $cnt['cnt'] : '', (new MVProjectCounts())->toArray()),
            'isAdmin' => $isAdmin,
        ], Views::SIDEBAR_LEFT);
    }

    public function changeLanguage(LanguageAvailableRequest $request): Output {
        if ($request->lang) {
            if (CurrentUser()->is_authorized) {
                $user = CurrentUser()->user;
                $user->lang_id = Language::getValue($request->lang);
                $user->save();
            }
            else {
                $_SESSION['lang'] = $request->lang;
            }
        }

        return $this->reloadPage();
    }
}
