<?php
namespace flyeralarm\ResellerApi\exception;

use flyeralarm\ResellerApi\exception\General as GeneralException;


class LoginFail extends Connection
{

    public function __construct(
        $message = "The FLYERALARM API was not able to login.",
        $code = 5101,
        \Exception $previous = null
    ) {

        return parent::__construct($message, $code, $previous);

    }
}