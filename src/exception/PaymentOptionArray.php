<?php
namespace flyeralarm\ResellerApi\exception;


class PaymentOptionArray extends DataStructure
{

    public function __construct(
        $message = "The data array used to create a ProductPaymentOptionList object was not valid.",
        $code = 5032,
        \Exception $previous = null
    ) {

        return parent::__construct($message, $code, $previous);

    }
}