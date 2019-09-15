<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use App\Helpers\CheckHelper;
use App\Helpers\RdbmsHelper;
use App\Helpers\PlatformHelper;
use App\Helpers\DataHelper;
use App\Helpers\NotifacationsHelper;

class ApiController extends FOSRestController
{

    /**
     * Метод отдает тело чека, если он будет найден.
     * @Rest\Get("/mobile-api/check/info", name="ApiController_get_check_info", methods={"GET"})
     */
    public function getCheckInfoAction(Request $request)
    {
        $fn = $request->get('fn') | null;
        $fd = $request->get('fd');
        $fp = $request->get('fp');
        $s = $request->get('s');
        $t = $request->get('t');

        $checkData = json_encode(CheckHelper::checkerDispatcher($fn, $fd, $fp, $s, $t));

        return new Response($checkData, Response::HTTP_OK, array('Content-Type' => 'application/json'));
    }


    /**
     * Метод создания нового аккаута.
     * @Rest\Get("/mobile-api/account/add", name="ApiController_account_add", methods={"POST"})
     */
    public function addAccountAction(Request $request)
    {
        $params = $request->request->all();

        if ($params !== false && $params !== null) {

            if (!key_exists("type", $params)) {
                return new Response(json_encode([
                    'status' => 'error',
                    'description' => 'Invalid post body or not enough required parameters!'
                ]), Response::HTTP_ACCEPTED, array('Content-Type' => 'application/json'));
            }

            $push_token = null;
            if (key_exists('push_token', $params)) $push_token = $params['push_token'];

            $RdbmsHelper = new RdbmsHelper();
            $session_id = $RdbmsHelper->addAccount($params['type'], $push_token);

            if ($session_id != false) {
                return new Response(json_encode([
                    'status' => 'success',
                    'sessionId' => $session_id
                ]), Response::HTTP_CREATED, array('Content-Type' => 'application/json'));
            }
        }

        return new Response(json_encode([
            'status' => 'error',
            'description' => 'Service temporarily unavailable!'
        ]), Response::HTTP_ACCEPTED, array('Content-Type' => 'application/json'));
    }


    /**
     * Отдает все выставленные счета с аккаунта.
     * @Rest\Get("/mobile-api/account/info/{sessionId}", name="ApiController_account_info", methods={"GET"}, requirements={"sessionId"="[a-z0-9-]+"})
     */
    public function getAccountInfoAction($sessionId = null, Request $request)
    {
        if ($sessionId == null) return new Response("Empty sessionId argument!", Response::HTTP_ACCEPTED, array('Content-Type' => 'application/json'));

        $RdbmsHelper = new RdbmsHelper();
        $accountData = $RdbmsHelper->getAccountInfo($sessionId);

        if ($accountData != false) {
            return new Response(json_encode([
                'status' => 'success',
                'data' => $accountData
            ]), Response::HTTP_CREATED, array('Content-Type' => 'application/json'));
        }

        return new Response(json_encode([
            'status' => 'error',
            'descripotion' => 'Service temporarily unavailable!'
        ]), Response::HTTP_ACCEPTED, array('Content-Type' => 'application/json'));
    }


    /**
     * Отдает все выставленные счета с аккаунта.
     * @Rest\Get("/mobile-api/accounts/list", name="ApiController_accounts_list", methods={"GET"})
     */
    public function getAllAccountsAction(Request $request)
    {
        $RdbmsHelper = new RdbmsHelper();
        $accountsData = $RdbmsHelper->getAllAccounts();

        if ($accountsData != false) {
            return new Response(json_encode([
                'status' => 'success',
                'data' => $accountsData
            ]), Response::HTTP_CREATED, array('Content-Type' => 'application/json'));
        }

        return new Response(json_encode([
            'status' => 'error',
            'descripotion' => 'Service temporarily unavailable!'
        ]), Response::HTTP_ACCEPTED, array('Content-Type' => 'application/json'));
    }


    /**
     * Метод создания нового аккаута.
     * @Rest\Get("/mobile-api/invoice/make", name="ApiController_invoice_make", methods={"POST"})
     */
    public function makeInvoiceAction(Request $request)
    {
        $params = $request->request->all();

        if ($params !== false && $params !== null) {

            if ( !key_exists("amount", $params) || !key_exists("currencyCode", $params) ||
                 !key_exists("description", $params) || !key_exists("payer", $params) ||
                 !key_exists("recipient", $params) || !key_exists("sessionId", $params) ) {
                return new Response(json_encode([
                    'status' => 'error',
                    'description' => 'Invalid post body or not enough required parameters!'
                ]), Response::HTTP_ACCEPTED, array('Content-Type' => 'application/json'));
            }

            $number = DataHelper::generateTimestampUuid();
            $txId = PlatformHelper::makeNewInvoice(
                $params['amount'], $params['currencyCode'], $params['description'],
                $number, $params['payer'], $params['recipient'], $params['sessionId']
            );

            //return $txId;

            if ($txId != false) {
                $RdbmsHelper = new RdbmsHelper();
                $invoiceId = $RdbmsHelper->addInvoice(
                    $params['amount'], $params['currencyCode'], $params['description'], $number,
                    $txId, $params['sessionId'], $params['payer'], $params['recipient'],
                    $params['items'], $params['nameCheque'], $params['datePayCheque']
                );

                if (is_integer($invoiceId)) {
                    // Send push notification.
                    $pushToken = $RdbmsHelper->getPushTokenBySessionId($params['sessionId']);
                    if($pushToken != false)
                    {
                       /* NotifacationsHelper::sendNotification(
                            $params['amount'], $params['currencyCode'], $params['description'], $number,
                            $params['recipient'], $params['sessionId'], $pushToken,
                            $params['items'], $params['nameCheque'], $params['datePayCheque']
                        );*/
                    }

                    return new Response(json_encode([
                        'status' => 'success',
                        'number' => $number
                    ]), Response::HTTP_CREATED, array('Content-Type' => 'application/json'));
                }

            }
        }

        return new Response(json_encode([
            'status' => 'error',
            'description' => 'Service temporarily unavailable!'
        ]), Response::HTTP_ACCEPTED, array('Content-Type' => 'application/json'));
    }


    /**
     * Отдает все выставленные счета с аккаунта.
     * @Rest\Get("/mobile-api/account/{sessionId}/invoices/list", name="ApiController_account_invoices_list", methods={"GET"}, requirements={"sessionId"="[a-z0-9-]+"})
     */
    public function getAccountInvoicesAction($sessionId = null, Request $request)
    {
        if ($sessionId == null) return new Response("Empty sessionId argument!", Response::HTTP_ACCEPTED, array('Content-Type' => 'application/json'));

        $RdbmsHelper = new RdbmsHelper();
        $invoiceData = $RdbmsHelper->getAccountInvoices($sessionId);

        if ($invoiceData != false) {
            return new Response(json_encode([
                'status' => 'success',
                'data' => $invoiceData
            ]), Response::HTTP_CREATED, array('Content-Type' => 'application/json'));
        }

        return new Response(json_encode([
            'status' => 'error',
            'descripotion' => 'Service temporarily unavailable!'
        ]), Response::HTTP_ACCEPTED, array('Content-Type' => 'application/json'));
    }


    /**
     * Получает статус транзакции.
     * @Rest\Get("/mobile-api/invoice/info/{number}", name="ApiController_get_invoice_info", methods={"GET"}, requirements={"number"="[a-f0-9-]+"})
     */
    public function getInvoiceInfoAction($number = null, Request $request)
    {
        if ($number == null) return new Response("Empty number argument!", Response::HTTP_ACCEPTED, array('Content-Type' => 'application/json'));

        $RdbmsHelper = new RdbmsHelper();
        $invoiceData = $RdbmsHelper->getInvoiceData($number);

        if ($invoiceData == false) {
            return new Response(json_encode([
                'status' => 'error',
                'description' => 'Invoice with number not found!'
            ]), Response::HTTP_ACCEPTED, array('Content-Type' => 'application/json'));
        }

        $invoiceDataExt = PlatformHelper::invoiceInfo($number, $invoiceData['currency_code'], $invoiceData['recipient']);
        $invoiceDataExt['state'] = $invoiceData['status_code'];

        $invoiceDataExt['items'] = json_decode($invoiceData['items']);
        $invoiceDataExt['date_pay_cheque'] = $invoiceData['date_pay_cheque'];
        $invoiceDataExt['name_cheque'] = $invoiceData['name_cheque'];

        if ($invoiceDataExt != false) {
            return new Response(json_encode([
                'status' => 'success',
                'data' => $invoiceDataExt
            ]), Response::HTTP_CREATED, array('Content-Type' => 'application/json'));
        }

        return new Response(json_encode([
            'status' => 'error',
            'descripotion' => 'Service temporarily unavailable!'
        ]), Response::HTTP_ACCEPTED, array('Content-Type' => 'application/json'));
    }


    /**
     * Метод создания нового аккаута.
     * @Rest\Get("/mobile-api/invoice/pay", name="ApiController_invoice_pay", methods={"POST"})
     */
    public function payInvoiceAction(Request $request)
    {
        $params = $request->request->all();

        if ($params !== false && $params !== null) {

            if (!key_exists("number", $params) || !key_exists("currencyCode", $params) ||
                !key_exists('description', $params) || !key_exists('recipient', $params) ||
                !key_exists('amount', $params) || !$params['sessionId']) {
                return new Response(json_encode([
                    'status' => 'error',
                    'description' => 'Invalid post body or not enough required parameters!'
                ]), Response::HTTP_ACCEPTED, array('Content-Type' => 'application/json'));
            }

            $RdbmsHelper = new RdbmsHelper();

            $invoiceStatus = $RdbmsHelper->isInvoicePayed($params['number']);
            if ($invoiceStatus == true) {
                return new Response(json_encode([
                    'status' => 'error',
                    'description' => "Invoice was paid earlier!"
                ]), Response::HTTP_CREATED, array('Content-Type' => 'application/json'));
            }

            $paymentId = $RdbmsHelper->payInvoice(
                $params['number']
            );

            if ($paymentId != false) {
                return new Response(json_encode([
                    'status' => 'success',
                    'data' => [
                        "amount" => $params['amount'],
                        "currencyCode" => $params['currencyCode'],
                        "description" => $params['description'],
                        "number" => $params['number'],
                        "recipient" => $params['recipient']
                    ]
                ]), Response::HTTP_CREATED, array('Content-Type' => 'application/json'));
            }

        }

        return new Response(json_encode([
            'status' => 'error',
            'description' => 'Service temporarily unavailable!'
        ]), Response::HTTP_ACCEPTED, array('Content-Type' => 'application/json'));
    }


    /**
     * Метод создания нового аккаута.
     * @Rest\Get("/mobile-api/push/send", name="ApiController_push_send", methods={"POST"})
     */
    public function sendPushNotification(Request $request)
    {
        $params = $request->request->all();

        if ($params !== false && $params !== null) {

            if( key_exists('items', $params) && key_exists('nameCheque', $params) && key_exists('datePayCheque', $params) )
            {
                $fcmResponce = NotifacationsHelper::sendNotification(
                    $params['amount'], $params['currencyCode'], $params['description'], $params['number'],
                    $params['recipient'], $params['sessionId'], $params['push_token'],
                    $params['items'], $params['nameCheque'], $params['datePayCheque']
                );
            }else{
                $fcmResponce = NotifacationsHelper::sendNotification(
                    $params['amount'], $params['currencyCode'], $params['description'], $params['number'],
                    $params['recipient'], $params['sessionId'], $params['push_token'], null, null, null
                );
            }

            return new Response(
                json_encode($fcmResponce),
                Response::HTTP_OK,
                array('Content-Type' => 'application/json')
            );
        }

        return new Response(json_encode([
            'status' => 'error',
            'description' => 'Invalid post body or not enough required parameters!'
        ]), Response::HTTP_ACCEPTED, array('Content-Type' => 'application/json'));
    }

}