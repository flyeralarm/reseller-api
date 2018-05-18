<?php
namespace flyeralarm\ResellerApi\productCatalog;

class ProductShippingOptionUpgrade
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
    private $defaultName;

    /**
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $priceWithTax;

    /**
     * @param $id
     * @param $name
     * @param $defaultName
     * @param $price
     * @param $priceWithTax
     */
    public function __construct($id, $name, $defaultName, $price, $priceWithTax)
    {
        $this->id = $id;
        $this->name = $name;
        $this->defaultName = $defaultName;
        $this->price = $price;
        $this->priceWithTax = $priceWithTax;
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
    public function getDefaultName()
    {
        return $this->defaultName;
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
    public function getBruttoPrice()
    {
        return $this->getPrice();
    }

    /**
     * @return string
     */
    public function getPriceWithTax()
    {
        return $this->priceWithTax;
    }

    /**
     * @return string
     */
    public function getNettoPrice()
    {
        return $this->getPriceWithTax();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $string = ' [ SOU#' . $this->id . '|' . $this->name . " ->\n";
        $string = $string . '  price:' . (string) $this->priceWithTax . "( excl.:" . (string) $this->price . ")\n";
        $string = $string . " ]\n";

        return $string;
    }
}
