<?php
namespace flyeralarm\ResellerApi\exception;


class AttributePossibleValuesArray extends DataStructure
{

    public function __construct(
        $message = "The data array used to create an AttributePossibleValues object was not valid.",
        $code = 5025,
        \Exception $previous = null
    ) {

        return parent::__construct($message, $code, $previous);

    }
}