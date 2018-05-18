<?php
namespace flyeralarm\ResellerApi\exception;

use flyeralarm\ResellerApi\exception\General as GeneralException;

class Connection extends GeneralException
{

    public function __construct(
        $message = "The FLYERALARM API had problems executing your command. Some error happened during th API call.",
        $code = 5100,
        \Exception $previous = null
    ) {

        return parent::__construct($message, $code, $previous);
    }
}
