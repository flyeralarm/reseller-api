<?php
/**
 * Created by PhpStorm.
 * User: r.schapfl
 * Date: 13/02/17
 * Time: 14:01
 */

namespace flyeralarm\ResellerApi\exception;


class OptionArray extends DataStructure
{

    public function __construct(
        $message = "The data array used to create a ProductOptionList object was not valid.",
        $code = 5029,
        \Exception $previous = null
    ) {

        return parent::__construct($message, $code, $previous);

    }
}