<?php

namespace Libraries {

	class File {
        /*private static $filename;

		function __construct($project_id) {
            $this->filename = $project_id;
		}

		final static public function get_folder_name($id = null) {
            return ((int)(($id ?? $this->filename) / 1000)+1)*1000;
        }

        final static public function get_folder_path() {
            return 'screens/'.($this->get_folder_name()).'/';
        }

        private function get_file_path($id = null) {
            return $this->get_folder_path().($id ?? $this->filename);
		}

		public function save($data, $thumb = false) {
		    if (!file_exists($this->get_folder_path())) mkdir($this->get_folder_path(), 0644);
			$prefix = $thumb ? '_th' : '';
			$data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
			file_put_contents($this->get_file_path()."{$prefix}.jpg", $data);
		}*/

        private $filename;

        function __construct($project_id) {
            $this->filename = $project_id;
        }

        final private function get_folder_name($id) {
            return ((int)(($id) / 1000)+1)*1000;
        }

        final public function get_folder_path($id) {
            return 'screens/'.($this->get_folder_name($id)).'/';
        }

        final public function get_file_path($id) {
            return $this->get_folder_path($id).($id);
        }

        public function save($data, $thumb = false) {
            if (!file_exists($this->get_folder_path($this->filename))) mkdir($this->get_folder_path($this->filename), 0644);
            $prefix = $thumb ? '_th' : '';
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
            file_put_contents($this->get_file_path($this->filename)."{$prefix}.jpg", $data);
        }

	}

}?>