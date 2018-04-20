<?php
namespace flyeralarm\ResellerApi\productCatalog;

use flyeralarm\ResellerApi\productCatalog\ProductShippingOptionUpgrade as ShippingUpgrade;
use flyeralarm\ResellerApi\lib\AbstractList as AbstractList;
use flyeralarm\ResellerApi\exception\AddObjectType as AddObjectTypeException;

class ProductShippingOptionUpgradeList extends AbstractList
{

    /**
     * @param mixed $item
     * @return null
     * @throws AddObjectTypeException
     */
    public function add($item)
    {
        if (!$item instanceof ShippingUpgrade) {
            throw new AddObjectTypeException('ShippingUpgradeList only accepts objects of type ShippingUpgrade.', 5089);
        }
        $this->elements[] = $item;
    }

    /**
     * @param $id
     * @return ProductShippingOptionUpgrade|null
     */
    public function getById($id)
    {
        foreach ($this->elements as $value) {
            /**
             * @var $value ShippingUpgrade
             */
            if ($value->getId() == $id) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param $name
     * @return ProductShippingOptionUpgrade|null
     */
    public function getByName($name)
    {
        foreach ($this->elements as $value) {
            /**
             * @var $value ShippingUpgrade
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
