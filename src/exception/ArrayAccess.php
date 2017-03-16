<?php
namespace flyeralarm\ResellerApi\exception;


class ArrayAccess extends DataStructure
{

    public function __construct(
        $message = "The FLYERALARM API business object lists allow you to use the array access for reading but not for writing. Use the add method of the list.",
        $code = 5021,
        \Exception $previous = null
    ) {

        return parent::__construct($message, $code, $previous);

    }
}