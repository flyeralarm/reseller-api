<?php
/**
 * Created by PhpStorm.
 * User: r.schapfl
 * Date: 14/02/17
 * Time: 12:32
 */

namespace flyeralarm\ResellerApi\exception;


class ShippingOptionArray extends DataStructure
{

    public function __construct(
        $message = "The data array used to create a ProductShippingOptionList object was not valid.",
        $code = 5031,
        \Exception $previous = null
    ) {

        return parent::__construct($message, $code, $previous);

    }
}