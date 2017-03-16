<?php
namespace flyeralarm\ResellerApi\exception;

use flyeralarm\ResellerApi\exception\General as GeneralException;


class SoapCall extends Connection
{

    public function __construct(
        $message = "Some SOAP call to the FLYERALARM API failed.",
        $code = 5110,
        \Exception $previous = null
    ) {

        return parent::__construct($message, $code, $previous);

    }
}