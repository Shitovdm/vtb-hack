<?php

namespace App\Helpers;

use Doctrine\ORM\EntityManager;
use App\Entity\Accounts;
use App\Entity\Invoices;
use App\Helpers\DataHelper;
use App\Helpers\PlatformHelper;
use App\Controller\DefaultController;

class RdbmsHelper
{

    protected $container;
    protected $defaultController;
    protected $entityManager;
    protected $usersAuthRepository;
    protected $usersAuth;

    /**
     * RdbmsHelper constructor.
     */
    public function __construct()
    {
        date_default_timezone_set('Europe/Moscow');

        global $kernel;
        if ($kernel instanceOf \AppCache) $kernel = $kernel->getKernel();
        $this->container = $kernel->getContainer();
        $this->defaultController = new DefaultController();
        $this->defaultController->setContainer($this->container);
        $this->entityManager = $this->defaultController->getEntityManager();
    }


    /**
     * @param $deviceType
     * @param $push_token
     * @return mixed
     */
    public function addAccount($deviceType, $push_token)
    {
        $deviceId = DataHelper::generateDeviceId();

        $newAccount = new Accounts();
        $newAccount->setDeviceId($deviceId);
        $newAccount->setDeviceType($deviceType);
        $newAccount->setSessionId(PlatformHelper::activateAccountSession($deviceType, $deviceId));
        $newAccount->setAccountNumber(DataHelper::generateAccountNumber());
        $newAccount->setPushToken($push_token);
        $newAccount->setDeleted(false);
        $newAccount->setLastActiveAt(new \DateTime());
        $newAccount->setCreatedAt(new \DateTime());

        $this->entityManager->persist($newAccount);
        $this->entityManager->flush();

        return $newAccount->getSessionId();
    }

    /**
     * @return bool
     */
    public function getAllAccounts()
    {
        $conn = $this->entityManager->getConnection();

        $sql = '
                SELECT id, device_id, device_type, session_id, account_number, created_at
                FROM accounts a
                WHERE a.deleted = FALSE
                ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll();
        if (isset($result[0])) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     *
     * @param $sessionId
     * @return bool
     */
    public function getAccountInfo($sessionId)
    {
        $conn = $this->entityManager->getConnection();

        $sql = '
                SELECT *
                FROM accounts a
                WHERE a.session_id = :sessionId
                ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['sessionId' => $sessionId]);

        $result = $stmt->fetchAll();
        if (isset($result[0])) {
            return $result[0];
        } else {
            return false;
        }
    }

    /**
     * @param $amount
     * @param $currency
     * @param $description
     * @param $number
     * @param $txId
     * @param $sessionId
     * @param $payer
     * @param $recipient
     * @param $items
     * @param $nameCheque
     * @param $datePayCheque
     * @return mixed
     */
    public function addInvoice($amount, $currency, $description, $number, $txId, $sessionId, $payer, $recipient, $items, $nameCheque, $datePayCheque)
    {
        $newInvoice = new Invoices();
        $newInvoice->setAmount($amount);
        $newInvoice->setCurrencyCode($currency);
        $newInvoice->setDescription($description);
        $newInvoice->setNumber($number);
        $newInvoice->setPayer($payer);
        $newInvoice->setRecipient($recipient);
        $newInvoice->setTxId($txId);
        $newInvoice->setStatusCode(2);
        $newInvoice->setOwnerSessionId($sessionId);
        $newInvoice->setCreatedAt(new \DateTime());
        $newInvoice->setItems($items);
        $newInvoice->setDatePayCheque($datePayCheque);
        $newInvoice->setNameCheque($nameCheque);


        $this->entityManager->persist($newInvoice);
        $this->entityManager->flush();

        return $newInvoice->getId();
    }

    /**
     * @param $number
     * @return bool
     */
    public function getInvoiceData($number)
    {
        $conn = $this->entityManager->getConnection();

        $sql = '
                SELECT * 
                FROM invoices i
                WHERE i.number = :number
                ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['number' => $number]);

        $result = $stmt->fetchAll();
        if (isset($result[0])) {
            return $result[0];
        } else {
            return false;
        }
    }

    /**
     *
     * @param $sessionId
     * @return bool
     */
    public function getAccountInvoices($sessionId)
    {
        $conn = $this->entityManager->getConnection();

        $sql = '
                SELECT amount, currency_code, description, number, payer, recipient, tx_id, status_code, created_at 
                FROM invoices i
                WHERE i.owner_session_id = :sessionId
                ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['sessionId' => $sessionId]);

        $result = $stmt->fetchAll();
        if (isset($result[0])) {
            return $result;
        } else {
            return false;
        }
    }


    /**
     * @param $number
     * @return bool
     */
    public function isInvoicePayed($number)
    {
        $conn = $this->entityManager->getConnection();

        $sql = '
                SELECT status_code
                FROM invoices i
                WHERE i.number = :number
                ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['number' => $number]);

        $result = $stmt->fetchAll();
        if (isset($result[0])) {
            return ($result[0]['status_code'] == 5);
        } else {
            return false;
        }
    }


    /**
     *
     * @param $number
     * @return mixed
     */
    public function payInvoice($number)
    {
        $conn = $this->entityManager->getConnection();
        $sql = '
                UPDATE invoices
                SET status_code = 5
                WHERE number = :number
                ';
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'number' => $number
        ]);

        $result = $stmt->fetchAll();
        if (isset($result[0])) {
            return true;
        } else {
            return false;
        }
    }


    /**
     *
     * @param $sessionId
     * @return bool
     */
    public function getPushTokenBySessionId($sessionId)
    {
        $conn = $this->entityManager->getConnection();

        $sql = '
                SELECT push_token
                FROM accounts a
                WHERE a.session_id = :session_id AND push_token != NULL
                LIMIT 1
                ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['session_id' => $sessionId]);

        $result = $stmt->fetchAll();
        if (isset($result[0])) {
            return $result[0]['push_token'];
        } else {
            return false;
        }
    }

}