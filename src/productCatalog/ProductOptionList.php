<?php
namespace flyeralarm\ResellerApi\productCatalog;

use flyeralarm\ResellerApi\lib\AbstractList as AbstractList;
use flyeralarm\ResellerApi\productCatalog\ProductOption as Option;
use flyeralarm\ResellerApi\exception\AddObjectType as AddObjectTypeException;

class ProductOptionList extends AbstractList
{

    /**
     * @param mixed $item
     * @throws AddObjectTypeException
     */
    public function add($item)
    {
        if (!$item instanceof Option) {
            throw new AddObjectTypeException('OptionList only accepts objects of type Option.', 5084);
        }
        $this->elements[] = $item;
    }

    /**
     * @param $id
     * @return ProductOption|null
     */
    public function getById($id)
    {
        foreach ($this->elements as $value) {
            /**
             * @var $value Option
             */
            if ($value->getOptionId() == $id) {
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
