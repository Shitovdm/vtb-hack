<?php

namespace App\Helpers;

/**
 * Класс вспомогательных методов для работы с эмулятором АПИ.
 * Class PlatformHelper
 * @package App\Helpers
 */
class PlatformHelper
{

    /**
     * Делает запрос к жмулятору АПИ для активации нового аккаунта.
     * @param $deviceType
     * @param $deviceId
     * @return bool|mixed
     */
    static public function activateAccountSession($deviceType, $deviceId)
    {
        $url = 'http://89.208.84.235:31080/api/v1/session';

        $postBody = [
            "addresses" => [],
            "deviceId" => $deviceId,
            "deviceType" => $deviceType
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Connection: Keep-Alive'
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postBody));
        $result = curl_exec($ch);
        curl_close($ch);

        if ($result == false) return false;
        $data = json_decode($result, true);

        return $data['data'];
    }

    /**
     * Создает новый выставленный счет.
     * @param $amount
     * @param $currency
     * @param $description
     * @param $number
     * @param $payer
     * @param $recipient
     * @param $sessionId
     * @return bool
     */
    static public function makeNewInvoice($amount, $currency, $description, $number, $payer, $recipient, $sessionId)
    {
        $url = 'http://89.208.84.235:31080/api/v1/invoice';

        $postBody = [
            "amount" => $amount,
            "currencyCode" => $currency,
            "description" => $description,
            "number" => $number,
            "payer" => $payer,
            "recipient" => $recipient
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Connection: Keep-Alive',
            'FPSID: ' . $sessionId
        ));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postBody));
        $result = curl_exec($ch);
        curl_close($ch);

        if ($result == false) return false;
        $data = json_decode($result, true);

        return $data['data']['txId'];
    }

    /**
     * Получает информацию о выставленном счете.
     * @param $number
     * @param $currencyCode
     * @param $recipient
     * @return bool
     */
    static public function invoiceInfo($number, $currencyCode, $recipient)
    {
        $url = 'http://89.208.84.235:31080/api/v1/invoice/' . $currencyCode . '/' . $number . '/' . $recipient;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Connection: Keep-Alive'
        ));
        $result = curl_exec($ch);
        curl_close($ch);

        if ($result == false) return false;
        $data = json_decode($result, true);

        return $data['data'];
    }

}