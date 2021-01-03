<?php

namespace App\Traits;

use App\Exceptions\ErrorException;

trait UrlValidate
{
    private function validate(string $url)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_HEADER           => false,
            CURLOPT_NOBODY           => false,
            CURLOPT_FOLLOWLOCATION   => true,
            CURLOPT_RETURNTRANSFER   => true,
        ]);
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $size = curl_getinfo($ch, CURLINFO_SIZE_DOWNLOAD);

        curl_close($ch);

        if ($status !== 200 || (bool)$error || $size < 1024) {
            throw new ErrorException($this->getClassName(__CLASS__), 'Not found');
        }
    }

    private function getClassName($classname)
    {
        if ($pos = strrpos($classname, '\\')) return substr($classname, $pos + 1);
        return $classname;
    }
}