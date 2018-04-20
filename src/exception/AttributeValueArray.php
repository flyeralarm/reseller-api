<?php
namespace flyeralarm\ResellerApi\exception;

class AttributeValueArray extends DataStructure
{

    public function __construct(
        $message = "The data array used to create an AttributeValue object was not valid.",
        $code = 5024,
        \Exception $previous = null
    ) {

        return parent::__construct($message, $code, $previous);
    }
}
