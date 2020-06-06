<?php

namespace Controllers;

use Core\Controller;
use DiDom\Document;
use HeadlessChromium\BrowserFactory;
use Helpers\Output;
use Libraries\Screens;
use Models\Table\Project;
use Models\Table\User;
use Requests\Telegram\SendPhotoRequest;

class Test extends Controller {

    public function test(): Output {
        Output()->disableLayout();

        $url = 'https://hyiplogs.com/project/tothemoon.one/';

        try {
            $document = new Document($url, true);
            $url = $document->first('.content div.hyip-img ')->attr('data-src');
        } catch (\Exception $exception) {
            die();
        }

        $id = 89;
        file_put_contents(Screens::getOriginalJpgScreen($id),file_get_contents($url));


        $from = Screens::getOriginalJpgScreen($id);
        $to = Screens::getJpgThumb($id);

        $imageFrom = imagecreatefromjpeg($from);

        dd(imagesx($imageFrom));



        $newImage = imagecrop($imageFrom, [
            'x' => 43,
            'y' => 0,
            'width' => 1280,
            'height' => 960,
        ]);
        imagejpeg($newImage, $to, 100);
        dd($newImage);
        $imageTo = imagecreatetruecolor($w, $h);
        imagecopyresampled($imageTo, $imageFrom, 0, 0, 0, 0, $w, $h, imagesx($imageFrom), imagesy($imageFrom));

        imagedestroy($imageFrom);
        imagedestroy($imageTo);



        return Output();
    }
}
