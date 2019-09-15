<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Helpers\DataHelper;

/**
 * Invoices
 *
 * @ORM\Table(name="invoices")
 * @ORM\Entity(repositoryClass="App\Repository\InvoicesRepository")
 */
class Invoices
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="amount", type="integer", nullable=false)
     */
    private $amount;

    /**
     * @ORM\Column(name="currency_code", type="integer", nullable=false)
     */
    private $currency_code;

    /**
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(name="number", type="string", nullable=true, length=36)
     */
    private $number;

    /**
     * @ORM\Column(name="owner_session_id", type="string", nullable=true)
     */
    private $owner_session_id;

    /**
     * @ORM\Column(name="payer", type="string", nullable=true, length=40)
     */
    private $payer;

    /**
     * @ORM\Column(name="recipient", type="string", nullable=true, length=40)
     */
    private $recipient;

    /**
     * @ORM\Column(name="tx_id", type="string", nullable=true)
     */
    private $tx_id;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(name="status_code", type="integer", nullable=true)
     */
    private $status_code;

    /**
     * @ORM\Column(name="name_cheque", type="string", nullable=true)
     */
    private $name_cheque;

    /**
     * @ORM\Column(name="date_pay_cheque", type="string", nullable=true)
     */
    private $date_pay_cheque;

    /**
     * @ORM\Column(name="items", type="json_array", nullable=true)
     */
    private $items;

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
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getCurrencyCode()
    {
        return $this->currency_code;
    }

    /**
     * @param mixed $currency_code
     */
    public function setCurrencyCode($currency_code): void
    {
        $this->currency_code = $currency_code;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number): void
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getOwnerSessionId()
    {
        return $this->owner_session_id;
    }

    /**
     * @param mixed $owner_session_id
     */
    public function setOwnerSessionId($owner_session_id): void
    {
        $this->owner_session_id = $owner_session_id;
    }

    /**
     * @return mixed
     */
    public function getPayer()
    {
        return $this->payer;
    }

    /**
     * @param mixed $payer
     */
    public function setPayer($payer): void
    {
        $this->payer = $payer;
    }

    /**
     * @return mixed
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param mixed $recipient
     */
    public function setRecipient($recipient): void
    {
        $this->recipient = $recipient;
    }

    /**
     * @return mixed
     */
    public function getTxId()
    {
        return $this->tx_id;
    }

    /**
     * @param mixed $tx_id
     */
    public function setTxId($tx_id): void
    {
        $this->tx_id = $tx_id;
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

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->status_code;
    }

    /**
     * @param mixed $status_code
     */
    public function setStatusCode($status_code): void
    {
        $this->status_code = $status_code;
    }

    /**
     * @return mixed
     */
    public function getNameCheque()
    {
        return $this->name_cheque;
    }

    /**
     * @param mixed $name_cheque
     */
    public function setNameCheque($name_cheque): void
    {
        $this->name_cheque = $name_cheque;
    }

    /**
     * @return mixed
     */
    public function getDatePayCheque()
    {
        return $this->date_pay_cheque;
    }

    /**
     * @param mixed $date_pay_cheque
     */
    public function setDatePayCheque($date_pay_cheque): void
    {
        $this->date_pay_cheque = $date_pay_cheque;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $items
     */
    public function setItems($items): void
    {
        $this->items = $items;
    }
}
