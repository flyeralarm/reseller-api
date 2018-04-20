<?php

namespace flyeralarm\ResellerApi\productCatalog;

class ProductShippingType
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $from;

    /**
     * @var int
     */
    private $to;

    /**
     * @var int
     */
    private $deadline;

    /**
     * @var string
     */
    private $bruttoPrice;

    /**
     * @var string
     */
    private $nettoPrice;

    /**
     * @param $id
     * @param $name
     * @param $from
     * @param $to
     * @param $deadline
     * @param $bruttoPrice
     * @param $nettoPrice
     */
    public function __construct($id, $name, $from, $to, $deadline, $bruttoPrice, $nettoPrice)
    {
        $this->id = $id;
        $this->name = $name;
        $this->from = $from;
        $this->to = $to;
        $this->deadline = $deadline;
        $this->bruttoPrice = $bruttoPrice;
        $this->nettoPrice = $nettoPrice;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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

    /**
     * @return int
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * @return string
     */
    public function getBruttoPrice()
    {
        return $this->bruttoPrice;
    }

    /**
     * @return string
     */
    public function getNettPrice()
    {
        return $this->nettoPrice;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $string = ' [ ST#' . $this->id . '|' . $this->name . " ->\n";
        $string = $string . '  price:' . (string) $this->bruttoPrice . "( excl.:" . (string) $this->nettoPrice . ")\n";
        $string = $string . '  from:' . (string) $this->from . " to:" . (string) $this->to . "\n";
        $string = $string . " ]\n";

        return $string;
    }
}
