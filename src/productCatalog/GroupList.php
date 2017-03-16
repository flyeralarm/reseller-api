<?php
namespace flyeralarm\ResellerApi\productCatalog;

use flyeralarm\ResellerApi\lib\AbstractList as AbstractList;
use flyeralarm\ResellerApi\productCatalog\Group as ProductGroup;
use flyeralarm\ResellerApi\exception\AddObjectType as AddObjectTypeException;

class GroupList extends AbstractList
{
    /**
     * This class inherits $this->elements from parent.
     */

    /**
     * Add an Item to the list.
     * @param mixed $item
     * @return void
     */
    public function add($item)
    {

        if (!$item instanceof ProductGroup) {
            throw new AddObjectTypeException('GroupList only accepts objects of type Group', 5081);
        }

        $this->elements[] = $item;
    }

}