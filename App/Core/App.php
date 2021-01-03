<?php

namespace App\Core;

use App\Exceptions\ErrorException;
use App\Helpers\Errors;
use App\Helpers\Locale;
use App\Helpers\Output;
use App\Libraries\Telegram;
use App\Models\Collection\SiteLanguages;
use App\Models\CurrentUser;
use App\Services\FacebookService;
use App\Traits\Instance;
use App\Views\Errors\ErrorDefault;

class App
{
    use Instance;

    /**
     * @return $this
     * @throws \ReflectionException
     */
    public function start(): self {
        if (IS_AJAX) {
            $this->output()->disableLayout();
        }
        if (DEBUG) {
            $this->output()->disableMinifying();
        }

        try {
            $this->router()->go();
            Db()->endTransaction();
        } catch (\Throwable $e) {
            if (!$this->output()->isContentLoaded() && $this->output()->isLayoutEnabled()) {
                if ($e instanceof ErrorException) {
                    $this->output()->addView(ErrorDefault::class, [
                        'description' => $e->getMessage(),
                        'title'       => $e->getKey(),
                        'code'        => $e->getCode(),
                    ]);
                } else {
                    Output()->addHeader(Output::E404);
                    $this->output()->addView(ErrorDefault::class, [
                        'description' => Translate()->error,
                        'title'       => Translate()->error,
                        'code'        => 404,
                    ]);
                }
            } elseif (!($e instanceof ErrorException)) {
                Error()->add('Unknown', $e->getMessage());
            }
            Db()->rollBackTransaction();
        } finally {
            echo $this->output()
                ->headers()
                ->result();
        }

        return $this;
    }

    public function db(): Database {
        return Database::getInstance();
    }

    public function router(): Router {
        return Router::getInstance();
    }

    public function output(): Output {
        return Output::getInstance();
    }

    public function error(): Errors {
        return Errors::getInstance();
    }

    public function locale(): Locale {
        return Locale::getInstance();
    }

    public function currentUser(): CurrentUser {
        return CurrentUser::getInstance();
    }

    public function siteLanguages(): SiteLanguages {
        return SiteLanguages::getInstance();
    }

    public function auth(): Auth {
        return Auth::getInstance();
    }

    public function telegram(): Telegram {
        return Telegram::getInstance();
    }

    public function facebook(): FacebookService {
        return FacebookService::getInstance();
    }
}
