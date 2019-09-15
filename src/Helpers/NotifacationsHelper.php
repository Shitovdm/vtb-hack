<?php

namespace App\Helpers;

/**
 * Class NotifacationsHelper
 * @package App\Helpers
 */
class NotifacationsHelper
{


    /**
     * @param $amount
     * @param $currency
     * @param $description
     * @param $invoice_number
     * @param $recipient
     * @param $sessionId
     * @param $push_token
     * @param $items
     * @param $nameCheque
     * @param $datePayCheque
     * @return mixed
     */
    static public function sendNotification($amount, $currency, $description, $invoice_number, $recipient, $sessionId, $push_token, $items, $nameCheque, $datePayCheque)
    {

        $postData = json_encode([
            "notification" => [
                "title" => "Вам выставлен счет на оплату",
                "body" => "Нажмите, чтобы перейти к оплате.",
                "sound" => "default",
                "click_action" => "FCM_PLUGIN_ACTIVITY",
                "icon" => "fcm_push_icon"
            ],
            "data" => [
                "title" => "Вам выставлен счет на оплату",
                "action" => "pay",
                "amount" => $amount,
                "currency" => $currency,
                "description" => $description,
                "invoice_number" => $invoice_number,
                "recipient" => $recipient,
                "user_session_id" => $sessionId,
                "datePayCheque" => $datePayCheque,
                "nameCheque" => $nameCheque,
                "items" => $items
            ],
            "to" => $push_token,
            "priority" => "high"
        ]);

        $headers = [
            'Content-Type: application/json',
            'Authorization: key=API_KEY'
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false );
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}