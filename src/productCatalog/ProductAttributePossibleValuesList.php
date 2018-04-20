<?php

namespace flyeralarm\ResellerApi\productCatalog;

use flyeralarm\ResellerApi\lib\AbstractList as AbstractList;
use flyeralarm\ResellerApi\productCatalog\ProductAttributeValue as AttributeValue;
use flyeralarm\ResellerApi\exception\AddObjectType as AddObjectTypeException;

class ProductAttributePossibleValuesList extends AbstractList
{
    /**
     * Add an Item to the list.
     *
     * @param  AttributeValue $item
     * @throws AddObjectTypeException
     */
    public function add($item)
    {
        if (!$item instanceof AttributeValue) {
            throw new AddObjectTypeException(
                'AttributePossibleValuesList only accepts objects of type AttributeValue.',
                5083
            );
        }
        $this->elements[] = $item;
    }

    /**
     * @param $id
     * @return ProductAttributeValue|null
     */
    public function getById($id)
    {
        foreach ($this->elements as $value) {
            /**
             * @var $value AttributeValue
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
            $string = $string . "   " . (string) $value . " \n";
        }
        $string = $string . '  }';

        return $string;
    }
}
