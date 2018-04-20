<?php
namespace flyeralarm\ResellerApi\productCatalog;

class ProductQuantityShippingOption
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var int
     */
    private $quantityId;

    /**
     * @var int
     */
    private $deadline;

    /**
     * @var int
     */
    private $from;

    /**
     * @var int
     */
    private $to;

    /**
     * @param $type
     * @param $quantityId
     * @param $deadline
     * @param $from
     * @param $to
     */
    public function __construct($type, $quantityId, $deadline, $from, $to)
    {
        $this->type = $type;
        $this->quantityId = $quantityId;
        $this->deadline = $deadline;
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getQuantityID()
    {
        return $this->quantityId;
    }

    /**
     * @return int
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * @return int
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return int
     */
    public function getTo()
    {
        return $this->to;
    }
}
