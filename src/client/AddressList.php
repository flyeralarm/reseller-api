<?php
namespace flyeralarm\ResellerApi\client;

use flyeralarm\ResellerApi\client\Address;

class AddressList
{

    /**
     * @var Address
     */
    private $sender;

    /**
     * @var Address
     */
    private $delivery;

    /**
     * @var Address
     */
    private $invoice;

    /**
     * @param Address $sender
     * @return $this
     */
    public function setSender(Address $sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * @param Address $delivery
     * @return $this
     */
    public function setDelivery(Address $delivery)
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * @param Address $invoice
     * @return $this
     */
    public function setInvoice(Address $invoice)
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * @return Address
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @return Address
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * @return Address
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * @return array
     */
    public function getArray()
    {
        return array(
            'sender' => $this->getSender()->getArray(),
            'delivery' => $this->getDelivery()->getArray(),
            'invoice' => $this->getInvoice()->getArray()
        );
    }

}