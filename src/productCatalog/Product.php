<?php
namespace flyeralarm\ResellerApi\productCatalog;

use flyeralarm\ResellerApi\productCatalog\ProductAttributeList as AttributeList;

class Product
{

    private $quantityId;

    private $productId;

    private $description;

    private $datasheet;

    /**
     * @var ProductAttributeList
     */
    private $attributes;

    /**
     * @param $quantityId
     * @param $productId
     * @param $description
     * @param $datasheet
     * @param ProductAttributeList $attributes
     */
    public function __construct($quantityId, $productId, $description, $datasheet, AttributeList $attributes)
    {
        $this->quantityId = $quantityId;
        $this->productId = $productId;
        $this->description = $description;
        $this->datasheet = $datasheet;
        $this->attributes = $attributes;
    }

    /**
     * @return int
     */
    public function getQuantityId()
    {
        return $this->quantityId;
    }

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->productId;
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
    public function getDatasheetURI()
    {
        return $this->datasheet;
    }

    /**
     * @return ProductAttributeList
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $string = "{{ Product#quantityId=" . $this->quantityId . "&productId=" . $this->productId . " \n";
        $string = $string . "  descr: " . $this->description . " \n";
        $string = $string . "  datasheet: " . $this->datasheet . " \n";
        $string = $string . "  attributes: " . (string) $this->attributes . " \n";
        $string = $string . "}} \n";

        return $string;
    }
}
