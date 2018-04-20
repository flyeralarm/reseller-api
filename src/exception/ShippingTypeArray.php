<?php
namespace flyeralarm\ResellerApi\exception;

class ShippingTypeArray extends DataStructure
{

    public function __construct(
        $message = "The data array used to create a ProductShippingTypeList object was not valid.",
        $code = 5030,
        \Exception $previous = null
    ) {

        return parent::__construct($message, $code, $previous);
    }
}
