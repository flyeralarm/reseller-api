<?php
namespace flyeralarm\ResellerApi\productCatalog;

use flyeralarm\ResellerApi\productCatalog\ProductQuantityOption as QuantityOption;
use flyeralarm\ResellerApi\lib\AbstractList as AbstractList;
use flyeralarm\ResellerApi\exception\AddObjectType as AddObjectTypeException;

class ProductQuantityOptionList extends AbstractList
{

    /**
     * @param mixed $item
     * @throws AddObjectTypeException
     */
    public function add($item)
    {
        if (!$item instanceof QuantityOption) {
            throw new AddObjectTypeException('QuantityOptionList only accepts objects of type QuantityOption.', 5087);
        }
        $this->elements[] = $item;
    }

    /**
     * @param $q quantity
     * @return ProductQuantityOption|null
     */
    public function getByQuantity($q)
    {
        foreach ($this->elements as $option) {
            /**
             * @var $option QuantityOption
             */
            if ($option->getQuantity() == $q) {
                return $option;
            }
        }

        return null;
    }
}
