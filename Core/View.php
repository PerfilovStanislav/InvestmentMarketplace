<?php

namespace Core {

    use Helpers\Locale;

    class View {
		private $data = [];
		private $pageView;

		final function __construct(string $template, array $data = []) {
            $data = array_merge($data, ['locale' => Locale::getLocale()]);
			$this->set($data);

			ob_start();
			require_once real_path($template . '.php');
			$this->pageView = ob_get_clean();
			$this->pageView = str_replace(["\n", "\r"], ' ', $this->pageView);
			$this->pageView = preg_replace('/\<!--.*?--\>/i', '', $this->pageView);
			$this->pageView = preg_replace('/\s+/', ' ', $this->pageView);
		}

		final public function set($data) {
			foreach($data as $key => $value) {
				$this->data[$key] = $value;
			}
			return $this;
		}

		final public function __get($name) {
		    return $this->data[$name]??'';
		}

		final public function get() {
			return $this->pageView;
		}
	}

}
