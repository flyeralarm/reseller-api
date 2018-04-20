<?php
namespace flyeralarm\ResellerApi\productCatalog;

use flyeralarm\ResellerApi\productCatalog\ProductOptionPossibleValuesList as PossibleValues;
use flyeralarm\ResellerApi\productCatalog\ProductOptionValue as OptionValue;

class ProductOption
{

    /**
     * @var int
     */
    private $optionId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var OptionValue
     */
    private $selection;

    /**
     * @var ProductOptionPossibleValuesList
     */
    private $possibleValues;

    /**
     * @param $optionId
     * @param $name
     * @param ProductOptionPossibleValuesList $possible_values
     */
    public function __construct($optionId, $name, PossibleValues $possible_values)
    {
        $this->optionId = $optionId;
        $this->name = $name;
        $this->possibleValues = $possible_values;
        $this->value = null;
    }

    /**
     * @return int
     */
    public function getOptionId()
    {
        return $this->optionId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param ProductOptionValue $value
     * @return $this
     */
    public function setSelection(OptionValue $value)
    {
        $this->selection = $value;

        return $this;
    }

    /**
     * @return OptionValue
     */
    public function getSelection()
    {
        return $this->selection;
    }

    /**
     * @return ProductOptionPossibleValuesList
     */
    public function getPossibleValues()
    {
        return $this->possibleValues;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $string = ' [ O#' . $this->optionId . '|' . $this->name . " ->\n";
        $string = $string . '  current value:' . (string) $this->selection . "\n";
        $string = $string . "  possible values: \n" . (string) $this->possibleValues . "\n";
        $string = $string . " ]\n";

        return $string;
    }
}
