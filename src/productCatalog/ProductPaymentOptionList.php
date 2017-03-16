<?php
namespace flyeralarm\ResellerApi\productCatalog;

use flyeralarm\ResellerApi\productCatalog\ProductPaymentOption as PaymentOption;
use flyeralarm\ResellerApi\lib\AbstractList as AbstractList;
use flyeralarm\ResellerApi\exception\AddObjectType as AddObjectTypeException;

class ProductPaymentOptionList extends AbstractList
{

    /**
     * @param mixed $item
     * @throws AddObjectTypeException
     */
    public function add($item)
    {
        if (!$item instanceof PaymentOption) {
            throw new AddObjectTypeException('PaymentOptionList only accepts objects of type PaymentOption.', 5086);
        }
        $this->elements[] = $item;
    }

    /**
     * @param $name
     * @return ProductPaymentOption|null
     */
    public function getByName($name)
    {
        foreach ($this->elements as $value) {
            /**
             * @var $value PaymentOption
             */
            if (strtolower($value->getName()) == strtolower($name)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * @param $id
     * @return ProductPaymentOption|null
     */
    public function getById($id)
    {
        foreach ($this->elements as $value) {
            /**
             * @var $value PaymentOption
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