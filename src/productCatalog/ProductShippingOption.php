<?php
namespace flyeralarm\ResellerApi\productCatalog;

use flyeralarm\ResellerApi\productCatalog\ProductShippingOptionUpgradeList as ShippingUpgradeList;

class ProductShippingOption
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
     * @var ProductShippingOptionUpgradeList
     */
    private $upgrades;

    /**
     * @param $id
     * @param $name
     * @param $defaultName
     * @param $price
     * @param $priceWithTax
     * @param ProductShippingOptionUpgradeList $upgrades
     */
    public function __construct($id, $name, $defaultName, $price, $priceWithTax, ShippingUpgradeList $upgrades = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->defaultName = $defaultName;
        $this->price = $price;
        $this->priceWithTax = $priceWithTax;
        $this->upgrades = $upgrades;
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
        return $this->getPriceWithTax();
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
        return $this->getPrice();
    }

    /**
     * @return ProductShippingOptionUpgradeList
     */
    public function getUpgrades()
    {
        return $this->upgrades;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $string = ' [ SO#' . $this->id . '|' . $this->name . " ->\n";
        $string = $string . '  price:' . (string) $this->priceWithTax . "( excl.:" . (string) $this->price . ")\n";

        if ($this->upgrades instanceof ShippingUpgradeList) {
            $string = $string . '  upgradeOptions: ' . (string) $this->upgrades . "\n";
        }

        $string = $string . " ]\n";

        return $string;
    }
}
