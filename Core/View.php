<?php

namespace Core {

	class View {
		const LAYOUT = 'Layout';
		private $data = [];
		private $template;
		private $pageView;
		private $isLayout;

		function __construct( $template, $data = []) {
			$this->isLayout = ($template == self::LAYOUT);
			$this->set($data);
			$this->template = 'Views/'.$template.'.php';

			ob_start();
			require $this->template;
			$this->pageView = ob_get_clean();
		}

		public function set($data) {
			foreach($data as $key => $value) {
				$this->data[$key] = $value;
			}
			return $this;
		}

		public function __get($name) {
			if (isset($this->data[$name])) return $this->data[$name];
			return '';
		}

		/*public function get() {
			if($this->isLayout || isset($_POST['ajax'])) {
				return $this->pageView;
			}
			else {
				return (new View(self::LAYOUT, ['content' => $this->pageView]))->get();
			}
		}*/

		public function get() {
			return $this->pageView;
		}
	}

}?>