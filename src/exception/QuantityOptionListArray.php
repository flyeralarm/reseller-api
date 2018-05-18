<?php
namespace flyeralarm\ResellerApi\exception;

class QuantityOptionListArray extends DataStructure
{

    public function __construct(
        $message = "The data array used to create a ProductQuantityOptionList object was not valid.",
        $code = 5028,
        \Exception $previous = null
    ) {

        return parent::__construct($message, $code, $previous);
    }
}
