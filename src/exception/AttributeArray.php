<?php
namespace flyeralarm\ResellerApi\exception;


class AttributeArray extends DataStructure
{

    public function __construct(
        $message = "The data array used to create an Attribute object was not valid.",
        $code = 5026,
        \Exception $previous = null
    ) {

        return parent::__construct($message, $code, $previous);

    }
}