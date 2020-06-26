<?php

namespace Helpers;

use Controllers\Users;
use Core\View;
use Models\Constant\Views;
use Traits\Instance;
use Views\Investment\ChatMessage;
use Views\Investment\GoogleAnalitic;
use Views\Investment\GoogleTagManager;
use Views\Investment\ShowMeta;
use Views\Investment\YandexMetrika;
use Views\Layout;

class Output
{
    use Instance;

    public CONST
        DOCUMENT        = 'document',
        VIEW            = 'view',
        FUNCTION        = 'function',
        ALERT           = 'alert',
        FIELD           = 'field',
        DANGER_TYPE     = 'danger',
        SUCCESS_TYPE    = 'success',
        INFO_TYPE       = 'info';

    public CONST
        HTML     = 'text/html; charset=UTF-8',
        MANIFEST = 'application/manifest+json',
        JSON     = 'application/json',
        XML      = 'text/xml';

    public CONST
        S200     = 'HTTP/1.1 200 OK',
        R303     = 'HTTP/1.1 303 See Other',
        E404     = 'HTTP/1.0 404 Not Found',
        E500     = 'HTTP/1.0 500 Internal Server Error';

    private CONST
        LAYOUT           = 'layout',
        ADDITIONAL_VIEWS = 'additional_views';

    private array
        $result = [],
        $headers = [],
        $template = [
            self::LAYOUT => Layout::class,
            self::ADDITIONAL_VIEWS => [
                Views::CHAT_MESSAGE         => [ChatMessage::class, []],
                Views::META                 => [ShowMeta::class, []],
                Views::GOOGLE_TAG_MANAGER   => [GoogleTagManager::class, []],
//                Views::YANDEX_METRICA       => [YandexMetrika::class, []],
//                Views::GOOGLE_ANALITIC      => [GoogleAnalitic::class, []],
            ],
        ];

    private bool
        $inProcess = false,
        $isLayoutEnabled = true,
        $minify = true,
        $contentIsLoaded = false;

    public function addHeader(string $head): self {
        $this->headers[] = $head;
        return $this;
    }

    public function addRedirectHeader(string $url): self {
        return $this
            ->addHeader(self::R303)
            ->addHeader('Location: ' . $url);
    }

    public function addContentTypeHeader(string $head): self {
        return $this->addHeader('Content-type: ' . $head);
    }

    private function addObjectType(string $type, string $objectName, array $params = [], string $scope = self::DOCUMENT, ?int $priority = null): self {
        if ($type === self::VIEW && $scope === Views::CONTENT) {
            $this->contentIsLoaded = true;
        }
        if ($priority) {
            $link = &$this->result[$type][$priority][$scope][$objectName];
        }
        else {
            $link = &$this->result[$type][$scope][$objectName];
        }
        $link = array_merge($link ?? [], $params);
        unset($link);

        return $this;
    }

    private function addObjectTypes(string $type, array $functions, string $scope = self::DOCUMENT, int $priority = null): self {
        foreach ($functions as $functionName => $params) {
            if (is_numeric($functionName)) {
                $this->addObjectType($type, $params, [], $scope, $priority);
            }
            else {
                $this->addObjectType($type, $functionName, $params, $scope, $priority);
            }
        }

        return $this;
    }

    public function addFunction(string $functionName, array $params = [], string $scope = Views::CONTENT, int $priority = 10): self {
        return $this->addObjectType(self::FUNCTION, $functionName, $params, $scope, $priority);
    }

    public function addFunctions(array $functions, string $scope = Views::CONTENT, int $priority = 10): self {
        return $this->addObjectTypes(self::FUNCTION, $functions, $scope, $priority);
    }

    public function addView(string $viewName, array $params = [], string $scope = Views::CONTENT): self {
        return $this->addObjectType(self::VIEW, $viewName, $params, $scope);
    }

    public function addViews(array $views, string $scope = Views::CONTENT): self {
        return $this->addObjectTypes(self::VIEW, $views, $scope);
    }

    public function addFieldStatus(string $field, string $type, string $text, string $scope = Views::CONTENT): self {
        return $this->addObjectType(self::FIELD, $field, [$type => $text], $scope);
    }

    public function addFieldSuccess(string $field, string $text, string $scope = Views::CONTENT): self {
        return $this->addFieldStatus($field, self::SUCCESS_TYPE, $text, $scope);
    }

    public function addFieldDanger(string $field, string $text, string $scope = self::DOCUMENT): self {
        return $this->addFieldStatus($field, self::DANGER_TYPE, $text, $scope);
    }

    // error primary info success warning danger alert system dark success
    public function addAlert(string $type, string $title, string $text): self {
        return $this->addObjectType(self::ALERT, $type, [$title => $text]);
    }

    public function addAlertSuccess(string $title, string $text): self {
        return $this->addAlert(self::SUCCESS_TYPE, $title, $text);
    }

    public function addAlertDanger(string $title, string $text): self {
        return $this->addAlert(self::DANGER_TYPE, $title, $text);
    }

    public function addAdditionalLayoutView(string $dom, string $template, array $params = []): self {
        $this->template[self::ADDITIONAL_VIEWS][$dom] = [$template, $params];
        return $this;
    }

    public function headers(): self {
        foreach ($this->headers as $head) {
            header($head);
        }
        return $this;
    }

    public function disableLayout(): self {
        $this->isLayoutEnabled = false;
        return $this;
    }

    public function isLayoutEnabled(): bool {
        return $this->isLayoutEnabled;
    }

    public function isContentLoaded(): bool {
        return $this->contentIsLoaded;
    }

    public function result(): string {
        if ($this->isLayoutEnabled) {
            if (!$this->headers) {
                $this->addContentTypeHeader(self::HTML)->addHeader(self::S200);
            }
            $str = $this->layoutWithViews();
        } else if ($this->headers) {
            $this->views();
            $str = $this->result[self::VIEW][Views::CONTENT] ?? '';
        } else {
            $this->addContentTypeHeader(self::JSON)->addHeader(self::S200);
            $this->views();
            $str = json_encode($this->result);
        }
        if ($this->minify) {
            $str = str_replace(["\n", "\r"], ' ', $str);
            $str = preg_replace('/<!--.*?-->/', '', $str);
            $str = preg_replace('/\s+/', ' ', $str);
        }

        return $str ?? '';
    }

    public function disableMinifying(): void
    {
        $this->minify = false;
    }

    public function views(): void {
        if (isset($this->result[self::FUNCTION])) {
            ksort($this->result[self::FUNCTION]);
        }

        $priority = [self::VIEW => 10, self::FUNCTION => 20, self::FIELD => 30, self::ALERT => 40];
        uksort($this->result, static function($first, $second) use ($priority) {
            return $priority[$first] - $priority[$second];
        });

        foreach($this->result[self::VIEW]??[] as $dom => $views) {
            foreach ($views as $viewPath => $params) {
                $this->result[self::VIEW][$dom] = (new View($viewPath, $params))->render();
            }
        }
    }

    private function layoutWithViews() {
        $users = new Users();
        $users->setUserHead();
        $users->setLeftSide();
        $this->views();

        foreach ([self::FUNCTION, self::FIELD, self::ALERT] as $type) {
            if ($this->result[$type] ?? null) {
                $this->result[self::VIEW][$type] = $this->result[$type];
                unset($this->result[$type]);
            }
        }

        return (new View($this->template[self::LAYOUT], $this->result[self::VIEW]
            + array_map(fn (array $data) => new View($data[0], $data[1]), $this->template[self::ADDITIONAL_VIEWS])
        ))->render();
    }
}
