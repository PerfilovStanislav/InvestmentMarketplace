<?php

namespace Libraries {

	class File {

        private $filename;
        private $path;

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

        final public function save($data, $thumb = false) {
            if (!file_exists(self::get_folder_path($this->filename))) {
                mkdir(self::get_folder_path($this->filename), 0755);
            }
            $postfix = $thumb ? '_th' : '';
            $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
            file_put_contents($this->path = self::get_file_path($this->filename)."{$postfix}.jpg", $data);
            if ($thumb) {
                imagewebp(imagecreatefromjpeg($this->path), self::get_file_path($this->filename)."{$postfix}.webp", 0);
            }

            return $this;
        }

        final public function addIPTC(array $data = []) {
            // установка IPTC тэгов
            $iptc = $data + [
                  5 => 'richinme.com',        // ObjectName
                 15 => 'investment',          // Category
                 25 => 'investment;richinme', // keywords
                 26 => '9G7VQJ2C+9P4',        // LocationCode
                 27 => 'Moscow',              // LocationName
                 80 => 'richinme.com',        // Author
                 85 => 'Richinme',            // AuthorName
                 90 => 'Moscow',              // City
                100 => 'RU',                  // CountryCode
                101 => 'Russia',              // CountryCode
                105 => 'richinme.com',        // HeadLine
                115 => 'richinme.com',        // Source
                116 => 'Richinme',            // Copyright
                118 => 'admin@richinme.com',  // Contact
                120 => 'Richinme.com',        // Caption
                122 => 'Richinme.com',        // Writer
                135 => 'ru',                  // Lang
            ];

            // Преобразование IPTC тэгов в двоичный код
            $data = '';
            foreach($iptc as $tag => $string)
            {
                $data .= self::iptc_make_tag(2, $tag, $string);
            }
            // Встраивание IPTC данных
            $content = iptcembed($data, $this->path);

            // запись нового изображения в файл
            $fp = fopen($this->path, 'wb');
            fwrite($fp, $content);
            fclose($fp);
        }

        final private static function iptc_make_tag($rec, $data, $value)
        {
            $length = strlen($value);
            $retval = chr(0x1C) . chr($rec) . chr($data);

            if($length < 0x8000) {
                $retval .= chr($length >> 8) . chr($length & 0xFF);
            }
            else {
                $retval .= chr(0x80) .
                    chr(0x04) .
                    chr(($length >> 24) & 0xFF) .
                    chr(($length >> 16) & 0xFF) .
                    chr(($length >> 8) & 0xFF) .
                    chr($length & 0xFF);
            }

            return $retval . $value;
        }
	}
}
