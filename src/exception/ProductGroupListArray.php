<?php
/**
 * Created by PhpStorm.
 * User: r.schapfl
 * Date: 09/02/17
 * Time: 10:44
 */

namespace flyeralarm\ResellerApi\exception;

class ProductGroupListArray extends DataStructure
{

    public function __construct(
        $message = "The data array used to create a ProductGroupList object was not valid.",
        $code = 5023,
        \Exception $previous = null
    ) {

        return parent::__construct($message, $code, $previous);
    }
}
