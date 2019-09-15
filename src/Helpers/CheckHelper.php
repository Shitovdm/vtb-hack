<?php

namespace App\Helpers;

/**
 * Class CheckHelper
 * @package App\Helpers
 */
class CheckHelper
{

    /**
     * Dispatcher between ofd services.
     * @param $fn
     * @param $fd
     * @param $fp
     * @param null $s
     * @param null $t
     * @return array|bool
     */
    static public function checkerDispatcher($fn, $fd, $fp, $s = null, $t = null)
    {
        $checkData = self::getCheckInfoFromProverkachekaCom($fn, $fd, $fp, $s, $t);
        if ($checkData != false && gettype($checkData) == 'array') {
            return $checkData;
        }

        //  Прочии запросы к апи офд
        //  ...

        return [
            "code" => 0,
            "data" => "Нет информации по чеку"
        ];
    }

    /**
     * @param $fn
     * @param $fd
     * @param $fp
     * @param $s
     * @param $t
     * @return array|bool
     */
    static public function getCheckInfoFromProverkachekaCom($fn, $fd, $fp, $s, $t)
    {
        $url = 'https://proverkacheka.com/check/get';

        $postBody = [
            "fn" => $fn,
            "fd" => $fd,
            "fp" => $fp,
            "s" => $s,
            "t" => urlencode($t)
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postBody);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        curl_close($ch);

        if ($result == false) return false;

        $data = json_decode($result, true);

        return $data;

    }

}