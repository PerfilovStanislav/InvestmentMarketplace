<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Output;
use App\Helpers\Sql;
use App\Queries\Orders\GetActive;
use App\Services\Db;
use App\Models\{
    Constant\DomElements,
    Constant\Language,
    Constant\UserStatus,
    Constant\Views,
    Table\User,};
use App\Requests\{LanguageAvailableRequest, User\AuthorizeRequest, User\RegistrationRequest};
use App\Views\{SideLeft,
    Users\Head\Authorized,
    Users\Head\NotAuthorized,
    Users\Login,
    Users\Registered,
    Users\Registration};

class Users extends Controller {
    /**
     * @deprecated как я сюда попадаю?
     */
    public function login(array $data = []) {
        Output()->addView(Login::class);
    }

    public function logout(array $data = []): Output {
        App()->auth()->logout();
        return $this->reloadPage();
    }

    public function reloadPage(array $data = []): Output {
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

    public function registration(array $data = []): Output {
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

    public function setUserHead(array $data = []): Output {
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

    public function setLeftSide(array $data = []): Output {
        $isAdmin = CurrentUser()->isAdmin();
        $banners = Db::inst()->exec(GetActive::index(2));
        $counts = Db::inst()->exec(
            new Sql('
                SELECT p.status_id,
                       count(*) AS cnt
                FROM project p
                GROUP BY p.status_id'
            )
        );
        $counts = \array_column($counts, null, 'status_id');

        return Output()
            ->addView(SideLeft::class, [
                'counts' => array_map(fn (array $cnt):string => $isAdmin ? ' ' . $cnt['cnt'] : '', $counts),
                'isAdmin' => $isAdmin,
                'banners' => $banners,
        ], Views::SIDEBAR_LEFT)
            ->addFunctions([
                'setBanners' => $banners
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
