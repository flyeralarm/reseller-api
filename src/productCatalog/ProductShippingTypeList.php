<?php

namespace flyeralarm\ResellerApi\productCatalog;

use flyeralarm\ResellerApi\lib\AbstractList as AbstractList;
use flyeralarm\ResellerApi\productCatalog\ProductShippingType as ShippingType;
use flyeralarm\ResellerApi\exception\AddObjectType as AddObjectTypeException;

class ProductShippingTypeList extends AbstractList
{
    /**
     * @param mixed $item
     * @throws AddObjectTypeException
     */
    public function add($item)
    {
        if (!$item instanceof ShippingType) {
            throw new AddObjectTypeException('ShippingTypeList only accepts objects of type ShippingType.', 5090);
        }
        $this->elements[] = $item;
    }

    /**
     * @param $name
     * @return ProductShippingType|null
     */
    public function getByName($name)
    {
        foreach ($this->elements as $value) {
            /**
             * @var $value ShippingType
             */
            if (strtolower($value->getName()) == strtolower($name)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @return bool
     */
    public function hasValues()
    {
        if (count($this->elements)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $string = "  { \n";
        foreach ($this as $value) {
            $string = $string . "   " . (string) $value . " \n";
        }
        $string = $string . '  }';

        return $string;
    }
}
