<?php

namespace Core;

use Helpers\Validator;
use Mappers\StaticRouteMapper;
use Models\Constant\DomElements;
use Models\Table\ProjectChatMessage;
use Models\Table\Session;
use Models\Table\User;
use Models\Table\UserRemember;
use Requests\User\AuthorizeRequest;
use Traits\Instance;
use Models\CurrentUser;

class Auth {
    use Instance;

    protected function __construct() {
        $this->startSession();
        $this->login();
    }

    private function login(): void {
        $s = &$_SESSION;
        $c = &$_COOKIE;

        if (isset($s['user_id'])) {
            $this->setUserAuth((new User())->getById($s['user_id']));
            return;
        }

        if (isset($c['user_id'], $c['hash'])) {
            $user_id = Validator::validate('user_id', $c['user_id'], AbstractEntity::TYPE_INT, [Validator::MIN => 1]);
            $hash    = Validator::validate('hash', $c['hash'], AbstractEntity::TYPE_STRING, [Validator::LENGTH => 53, Validator::REGEX => Validator::HASH]);

            $userRemember = (new UserRemember())->getRowFromDbAndFill([
                'user_id'   => $user_id,
                'hash'      => $hash,
                'ip'        => $this->getIP()
            ]);
            if ($userRemember->id) {
                $s['user_id'] = $user_id;
                setcookie('user_id' , $user_id,    null,'/',DOMAIN,null,false);
                setcookie('hash'    , $hash,    null,'/',DOMAIN,null,false);
                $this->setUserAuth((new User())->getById($user_id));
                return;
            }

            $this->removeCookies(['hash', 'user_id']);
        }

        CurrentUser()->is_authorized = false;
        CurrentUser()->session_id    = $this->getSessionId();
    }

    private function getSessionId() : ?int {
        if ($session_id = ($_SESSION['session_id'] ?? null)) {
            return $session_id;
        }

        $session = new Session();
        $session->getRowFromDbAndFill(['uid' => session_id()]);

        if ($session->id) {
            return $session->id;
        }

        if (StaticRouteMapper::get($_SERVER['REQUEST_URI'])) {
            return null;
        }

        $session->fromArray(['ip' => $this->getIP()]);
        $session->save();

        return $session->id;
    }

    private function startSession():void {
        session_name('uid');
        session_set_cookie_params(60 * 60 * 24 * 20, '/', DOMAIN, false, true); // 20 days
        session_start();
    }

    public function authorize(AuthorizeRequest $request): bool {
        if (CurrentUser()->is_authorized) {
            Output()->addAlertSuccess('Authorized', Translate()->youAreAuthorized);
            return true;
        }

        if (($user = (new User())->getRowFromDbAndFill(['login' => strtolower($request->login)]))->id) {
            if ($this->confirmPassword($request->password, $user->password)) {
                $this->setUserAuth($user);
                ProjectChatMessage::setTable()->update(['user_id' => $user->id], ['session_id' => CurrentUser()->session_id]);
                $s = &$_SESSION;
                $s['user_id'] = $user->id;

                if ($request->remember === 'on') {
                    $userRemember = (new UserRemember())->getRowFromDbAndFill([
                        'user_id' => $user->id,
                        'ip' => $this->getIP()
                    ]);

                    if (!$userRemember->id) {
                        $userRemember->fromArray(['hash' => $this->hashPassword(uniqid($user->id. $this->getIP(), true))])->save();
                    }
                    setcookie('user_id', $user->id, null, '/', DOMAIN, null, false);
                    setcookie('hash', $userRemember->hash, null, '/', DOMAIN, null, false);
                }
                return true;
            }

            Output()->addFieldDanger('password', Translate()->badPassword, DomElements::AUTHORIZATION_USER_FORM);
        } else {
            Output()->addFieldDanger('login', Translate()->noUser, DomElements::AUTHORIZATION_USER_FORM);
        }
        return false;
    }

    public function logout(): bool {
        if (!CurrentUser()->is_authorized) {
            return true;
        }

        UserRemember::setTable()->delete([
            'user_id' => CurrentUser()->getId(),
            'ip' => $this->getIP(),
        ]);

        $this->removeCookies(['uid', 'hash', 'user_id']);
        session_destroy();
        CurrentUser()->is_authorized = false;

        return true;
    }

    private function confirmPassword($password, $hash): bool {
        return crypt($password, \Config::CRYPT_PREFIX.$hash) === \Config::CRYPT_PREFIX.$hash;
    }

    public function hashPassword($password): string {
        return substr(crypt($password, \Config::CRYPT_PREFIX . bin2hex(random_bytes(11))), 7);
    }

    private function setUserAuth(User $user): void {
        $authModel                = CurrentUser::getInstance();
        $authModel->user          = $user;
        $authModel->is_authorized = true;
        $authModel->session_id    = $this->getSessionId();
    }

    private function getIP() : ?string {
        return $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.1';
    }

    private function removeCookies(array $keys): void {
        $params = session_get_cookie_params();
        foreach ($keys as $k => $v) {
            setcookie($v, '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }
    }
}

