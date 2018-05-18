<?php
namespace flyeralarm\ResellerApi\exception;

use \Exception as PHPException;

class General extends PHPException
{

    public function __construct(
        $message = "The FLYERALARM API has thrown an exception.",
        $code = 5000,
        \Exception $previous = null
    ) {

        return parent::__construct($message, $code, $previous);
    }
}
