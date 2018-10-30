<?php

namespace Core {

    use Helpers\Locale;

    class View {
		private $data = [];
		private $template;
		private $pageView;

		function __construct( $template, $data = []) {
            $data = array_merge($data, ['locale' => Locale::getLocale()]);
			$this->set($data);
			$this->template = 'Views/'.$template.'.php';

			ob_start();
			require_once $this->template;
			$this->pageView = ob_get_clean();
			$this->pageView = str_replace(["\n", "\r"], ' ', $this->pageView);
			$this->pageView = preg_replace('/\<!--.*?--\>/i', ' ', $this->pageView);
			$this->pageView = preg_replace('/\s+/', ' ', $this->pageView);
		}

		public function set($data) {
			foreach($data as $key => $value) {
				$this->data[$key] = $value;
			}
			return $this;
		}

		public function __get($name) {
		    return $this->data[$name]??'';
		}

		public function get() {
			return $this->pageView;
		}
	}

}
