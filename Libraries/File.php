<?php

namespace Libraries {

	class File {

        private $filename;

        function __construct($project_id) {
            $this->filename = $project_id;
        }

        final private static function get_folder_name($id) {
            return ((int)(($id) / 1000)+1)*1000;
        }

        final private static function get_folder_path($id) {
            return 'screens/'.(self::get_folder_name($id)).'/';
        }

        final public static function get_file_path($id) {
            return self::get_folder_path($id) . ($id);
        }

        public function save($data, $thumb = false) {
            if (!file_exists(self::get_folder_path($this->filename))) {
                mkdir(self::get_folder_path($this->filename), 0200);
            }
            $prefix = $thumb ? '_th' : '';
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
            file_put_contents(self::get_file_path($this->filename)."{$prefix}.jpg", $data);
        }
	}
}
