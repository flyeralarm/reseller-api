<?php
namespace flyeralarm\ResellerApi\exception;

class AddObjectType extends ArrayAccess
{

    public function __construct(
        $message = "This list object only accepts a specific type.",
        $code = 5080,
        \Exception $previous = null
    ) {

        return parent::__construct($message, $code, $previous);
    }
}
