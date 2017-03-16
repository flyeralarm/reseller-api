<?php
namespace flyeralarm\ResellerApi\productCatalog;


class ProductPaymentOption
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
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $serviceFee;

    /**
     * @param $id
     * @param $name
     * @param $price
     * @param $serviceFee
     */
    public function __construct($id, $name, $price, $serviceFee)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->serviceFee = $serviceFee;
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
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getServiceFee()
    {
        return $this->serviceFee;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $string = ' [ PO#' . $this->id . '|' . $this->name . " ->\n";
        $string = $string . '  price:' . (string)$this->price . " serviceFee:" . (string)$this->serviceFee . ")\n";
        $string = $string . " ]\n";

        return $string;
    }

}