<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Helpers\DataHelper;

/**
 * Accounts
 *
 * @ORM\Table(name="accounts")
 * @ORM\Entity(repositoryClass="App\Repository\AccountsRepository")
 */
class Accounts
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="device_id", type="string", nullable=false, length=256)
     */
    private $device_id;

    /**
     * @ORM\Column(name="device_type", type="integer", nullable=false)
     */
    private $device_type;

    /**
     * @ORM\Column(name="session_id", type="string", nullable=true)
     */
    private $session_id;

    /**
     * @ORM\Column(name="account_number", type="string", nullable=true, length=40)
     */
    private $account_number;

    /**
     * @ORM\Column(name="push_token", type="string", nullable=true, length=512)
     */
    private $push_token;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $deleted;

    /**
     * @ORM\Column(name="last_active_at", type="datetime", nullable=true)
     */
    private $last_active_at;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $created_at;


    public function __construct()
    {
        $this->deleted = false;
        $this->created_at = new \DateTime();
        $this->account_number = DataHelper::generateAccountNumber();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDeviceId()
    {
        return $this->device_id;
    }

    /**
     * @param mixed $device_id
     */
    public function setDeviceId($device_id): void
    {
        $this->device_id = $device_id;
    }

    /**
     * @return mixed
     */
    public function getDeviceType()
    {
        return $this->device_type;
    }

    /**
     * @param mixed $device_type
     */
    public function setDeviceType($device_type): void
    {
        $this->device_type = $device_type;
    }

    /**
     * @return mixed
     */
    public function getSessionId()
    {
        return $this->session_id;
    }

    /**
     * @param mixed $session_id
     */
    public function setSessionId($session_id): void
    {
        $this->session_id = $session_id;
    }

    /**
     * @return mixed
     */
    public function getAccountNumber()
    {
        return $this->account_number;
    }

    /**
     * @param mixed $account_number
     */
    public function setAccountNumber($account_number): void
    {
        $this->account_number = $account_number;
    }

    /**
     * @return mixed
     */
    public function getPushToken()
    {
        return $this->push_token;
    }

    /**
     * @param mixed $push_token
     */
    public function setPushToken($push_token): void
    {
        $this->push_token = $push_token;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted): void
    {
        $this->deleted = $deleted;
    }

    /**
     * @return mixed
     */
    public function getLastActiveAt()
    {
        return $this->last_active_at;
    }

    /**
     * @param mixed $last_active_at
     */
    public function setLastActiveAt($last_active_at): void
    {
        $this->last_active_at = $last_active_at;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->created_at = $created_at;
    }

}
