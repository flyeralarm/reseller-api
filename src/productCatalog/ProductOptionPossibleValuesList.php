<?php
namespace flyeralarm\ResellerApi\productCatalog;

use flyeralarm\ResellerApi\lib\AbstractList as AbstractList;
use flyeralarm\ResellerApi\productCatalog\ProductOptionValue as OptionValue;
use flyeralarm\ResellerApi\exception\AddObjectType as AddObjectTypeException;

class ProductOptionPossibleValuesList extends AbstractList
{

    /**
     * Add an Item to the list.
     * @param OptionValue $item
     * @return void
     */
    public function add($item)
    {
        if (!$item instanceof OptionValue) {
            throw new AddObjectTypeException('OptionPossibleValuesList only accepts objects of type OptionValue.',
                5085);
        }
        $this->elements[] = $item;
    }

    /**
     * @param $id
     * @return ProductOptionValue|null
     */
    public function getById($id)
    {
        foreach ($this->elements as $value) {
            /**
             * @var $value OptionValue
             */
            if ($value->getOptionValueId() == $id) {
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