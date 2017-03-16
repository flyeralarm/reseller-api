<?php
namespace flyeralarm\ResellerApi\exception;


class QuantityOptionArray extends DataStructure
{

    public function __construct(
        $message = "The data array used to create a ProductQuantityOption object was not valid.",
        $code = 5027,
        \Exception $previous = null
    ) {

        return parent::__construct($message, $code, $previous);

    }
}