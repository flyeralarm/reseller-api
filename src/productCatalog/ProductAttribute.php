<?php
namespace flyeralarm\ResellerApi\productCatalog;

use flyeralarm\ResellerApi\productCatalog\ProductAttributeValue as AttributeValue;
use flyeralarm\ResellerApi\productCatalog\ProductAttributePossibleValuesList as PossibleValues;

class ProductAttribute
{
    /**
     * @var int $id
     */
    private $id;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var AttributeValue $selection
     */
    private $selection;

    /**
     * @var PossibleValues $possible_values
     */
    private $possibe_values;

    /**
     * @param $id
     * @param $name
     * @param ProductAttributePossibleValuesList $possible_values
     */
    public function __construct($id, $name, PossibleValues $possible_values)
    {
        $this->id = $id;
        $this->name = $name;
        $this->possibe_values = $possible_values;
        $this->value = null;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param ProductAttributeValue $value
     * @return $this
     */
    public function setSelection(AttributeValue $value)
    {
        $this->selection = $value;

        return $this;
    }

    /**
     * @return AttributeValue
     */
    public function getSelection()
    {
        return $this->selection;
    }

    /**
     * @return ProductAttributePossibleValuesList
     */
    public function getPossibleValues()
    {
        return $this->possibe_values;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $string = ' [ A#' . $this->id . '|' . $this->name . " ->\n";
        $string = $string . '  current value:' . (string)$this->selection . "\n";
        $string = $string . "  possible values: \n" . (string)$this->possibe_values . "\n";
        $string = $string . " ]\n";

        return $string;
    }


}