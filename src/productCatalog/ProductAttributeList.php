<?php
namespace flyeralarm\ResellerApi\productCatalog;

use flyeralarm\ResellerApi\productCatalog\ProductAttribute as Attribute;
use flyeralarm\ResellerApi\lib\AbstractList as AbstractList;
use flyeralarm\ResellerApi\exception\AddObjectType as AddObjectTypeException;

class ProductAttributeList extends AbstractList
{

    /**
     * @param mixed $item
     * @throws AddObjectTypeException
     */
    public function add($item)
    {
        if (!$item instanceof Attribute) {
            throw new AddObjectTypeException('AttributeList only accepts objects of type Attribute.', 5082);
        }
        $this->elements[] = $item;
    }

    /**
     * @param $id
     * @return ProductAttribute|null
     */
    public function getById($id)
    {
        foreach ($this->elements as $attribute) {
            /**
             * @var $attribute Attribute
             */
            if ($attribute->getId() == $id) {
                return $attribute;
            }
        }

        return null;
    }

    /**
     * @return bool
     */
    public function hasAttributes()
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
        $string = "{ AL ->\n";
        foreach ($this->elements as $value) {
            $string = $string . (string) $value;
        }
        $string = $string . '}';

        return $string;
    }
}
