<?php

namespace App\Helpers;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Класс вспомогательных методов работы с данными.
 * Class DataHelper
 * @package App\Helpers
 */
class DataHelper
{

    /**
     * Генерирует новый номер счета.
     * @param int $length
     * @return string
     */
    static public function generateAccountNumber($length = 40)
    {
        $characters = '0123456789abcdef';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * Генерирует новый идентификатор устройства.
     * @param int $length
     * @return string
     */
    static public function generateDeviceId($length = 20)
    {
        $characters = '0123456789abcdef';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * Генерирует uuid.
     * @return string
     */
    static public function generateTimestampUuid()
    {
        return Uuid::uuid1()->toString();
    }

    /**
     *
     * @param Request $request
     * @return bool|mixed
     */
    static public function validateRouteMethodData(Request $request)
    {
        if ($request->isXMLHttpRequest()) {
            $content = $request->request->all();
            if (!empty($content)) {
                return $content;
                //return json_decode($content, true);
            }
        }

        return false;
    }

}