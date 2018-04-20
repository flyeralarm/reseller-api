<?php
namespace flyeralarm\ResellerApi\productCatalog;

class ProductOptionValue
{

    /**
     * @var int
     */
    private $optionValueId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $bruttoPrice;

    /**
     * @var string
     */
    private $nettoPrice;

    /**
     * @param $optionValueId
     * @param $name
     * @param $description
     * @param $bruttoPrice
     * @param $nettoPrice
     */
    public function __construct($optionValueId, $name, $description, $bruttoPrice, $nettoPrice)
    {
        $this->optionValueId = $optionValueId;
        $this->name = $name;
        $this->description = $description;
        $this->bruttoPrice = $bruttoPrice;
        $this->nettoPrice = $nettoPrice;
    }

    /**
     * @return int
     */
    public function getOptionValueId()
    {
        return $this->optionValueId;
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
    public function getDescription()
    {
        return $this->description;
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
    public function getNettoPrice()
    {
        return $this->nettoPrice;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '[OV#' . $this->optionValueId . '|' . $this->name . ']';
    }
}
