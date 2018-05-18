<?php
namespace flyeralarm\ResellerApi\exception;

use flyeralarm\ResellerApi\exception\General as GeneralException;

class DataStructure extends GeneralException
{

    public function __construct(
        $message = "The FLYERALARM API business objects only allow specific business objects.",
        $code = 5020,
        \Exception $previous = null
    ) {

        return parent::__construct($message, $code, $previous);
    }
}
