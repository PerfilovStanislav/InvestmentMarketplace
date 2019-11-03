<?php

namespace Libraries {

    class Screens {

        private static function getFolderName(int $id) : string  {
            return ((int)(($id) / 1000)+1)*1000;
        }

        private static function getFolderPath(int $id) : string  {
            return 'screens/'.(self::getFolderName($id)).'/';
        }

        public static function getFilePath(int $id) : string  {
            return self::getFolderPath($id) . ($id);
        }

        public static function getOriginalJpgScreen(int $id) : string {
            return self::getFilePath($id) . '.jpg';
        }

        public static function getOriginalWebpScreen(int $id) : string {
            return self::getFilePath($id) . '.webp';
        }

        public static function getOriginalScreen(int $id) : string {
            // Убрать в будущем && file_exists
            return WEBP && file_exists(self::getOriginalWebpScreen($id)) ? self::getOriginalWebpScreen($id) : self::getOriginalJpgScreen($id);
        }

        public static function getJpgThumb(int $id) : string {
            return self::getFilePath($id) . '_th.jpg';
        }

        public static function getWebpThumb(int $id) : string {
            return self::getFilePath($id) . '_th.webp';
        }

        public static function getJpgPreThumb(int $id) : string {
            return self::getFilePath($id) . '_pre_th.jpg';
        }

        public static function getWebpPreThumb(int $id) : string {
            return self::getFilePath($id) . '_pre_th.webp';
        }

        public static function getThumb(int $id) : string {
            return WEBP ? self::getWebpThumb($id) : self::getJpgThumb($id);
        }

        public static function getPreThumb(int $id) : string {
            return WEBP ? self::getWebpPreThumb($id) : self::getJpgPreThumb($id);
        }

        public static function saveScreenShot(string $url, int $id) {
            self::createFolder($id);
            
            require(ROOT . '/composer/vendor/autoload.php');

            $factory = new \HeadlessChromium\BrowserFactory('google-chrome');
            $browser = $factory->createBrowser([
                'headless' => true,
                'keepAlive' => false,
                'windowSize' => [1280, 960],
                'sendSyncDefaultTimeout' => 45000
            ]);

            $page = $browser->createPage();

            $page->navigate($url)->waitForNavigation();
            $page->screenshot([
                'format'  => 'jpeg',
                'quality' => 95,
            ])->saveToFile(self::getOriginalJpgScreen($id));

            self::makeWebp(self::getOriginalJpgScreen($id), self::getOriginalWebpScreen($id));
            self::makeThumb(self::getOriginalJpgScreen($id), self::getJpgThumb($id));
            self::makeWebp(self::getJpgThumb($id), self::getWebpThumb($id));
            self::makeWebp(self::getJpgThumb($id), self::getWebpPreThumb($id), 0);
            self::changeQualityJpg(self::getJpgThumb($id), 10, self::getJpgPreThumb($id));
            self::addIPTC(self::getOriginalJpgScreen($id), [5 => $url, 120 => $url]);
            self::addIPTC(self::getJpgThumb($id), [5 => $url, 120 => $url]);
        }

        public static function changeQualityJpg(string $from, int $quality, ?string $to) {
            imagejpeg(imagecreatefromjpeg($from), $to ?? $from, $quality);
        }

        public static function makeThumb(string $from, string $to, int $quality = 100) {
            $w = 320;
            $h = 240;
            $imageFrom = imagecreatefromjpeg($from);
            $imageTo = imagecreatetruecolor($w, $h);
            imagecopyresampled($imageTo, $imageFrom, 0, 0, 0, 0, $w, $h, imagesx($imageFrom), imagesy($imageFrom));

            imagejpeg($imageTo, $to, $quality);
            imagedestroy($imageFrom);
            imagedestroy($imageTo);
        }

        public static function makeWebp(string $from, string $to, int $quality = 100) {
            imagewebp(imagecreatefromjpeg($from), $to, $quality);
        }

        public static function createFolder(int $id) {
            if (!file_exists(self::getFolderPath($id))) {
                mkdir(self::getFolderPath($id), 0755);
            }
        }

        public static function addIPTC(string $path, array $data = []) {
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
                $data .= self::iptcMakeTag(2, $tag, $string);
            }
            // Встраивание IPTC данных
            $content = iptcembed($data, $path);

            // запись нового изображения в файл
            $fp = fopen($path, 'wb');
            fwrite($fp, $content);
            fclose($fp);
        }

        private static function iptcMakeTag($rec, $data, $value)
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
