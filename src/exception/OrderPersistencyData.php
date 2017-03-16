<?php
namespace flyeralarm\ResellerApi\exception;


class OrderPersistencyData extends DataStructure
{

    public function __construct(
        $message = "The data in your persistency string is corrupted. The order can not be recreated.",
        $code = 5033,
        \Exception $previous = null
    ) {

        return parent::__construct($message, $code, $previous);

    }
}