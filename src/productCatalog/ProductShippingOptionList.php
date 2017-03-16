<?php
namespace flyeralarm\ResellerApi\productCatalog;

use flyeralarm\ResellerApi\productCatalog\ProductShippingOption as ShippingOption;
use flyeralarm\ResellerApi\lib\AbstractList as AbstractList;
use flyeralarm\ResellerApi\exception\AddObjectType as AddObjectTypeException;

class ProductShippingOptionList extends AbstractList
{

    /**
     * Add an Item to the list.
     * @param ShippingOption $item
     * @return void
     */
    public function add($item)
    {
        if (!$item instanceof ShippingOption) {
            throw new AddObjectTypeException('ShippingOptionList only accepts objects of type ShippingOption.', 5088);
        }
        $this->elements[] = $item;
    }

    /**
     * @param $name
     * @return ProductShippingOption|null
     */
    public function getByName($name)
    {
        foreach ($this->elements as $value) {
            /**
             * @var $value ShippingOption
             */
            if (strtolower($value->getName()) == strtolower($name)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param $id
     * @return ProductShippingOption|null
     */
    public function getById($id)
    {
        foreach ($this->elements as $value) {
            /**
             * @var $value ShippingOption
             */
            if ($value->getId() == $id) {
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
            $string = $string . "   " . (string)$value . " \n";
        }
        $string = $string . '  }';

        return $string;
    }


}