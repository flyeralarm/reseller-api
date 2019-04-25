<?php

namespace flyeralarm\ResellerApi\productCatalog;

use flyeralarm\ResellerApi\config\AbstractConfig as Config;
use flyeralarm\ResellerApi\productCatalog\Factory as ProductFactory;
use flyeralarm\ResellerApi\exception\ProductGroupArray as ProductGroupArrayException;
use flyeralarm\ResellerApi\exception\ProductGroupListArray as ProductGroupListArrayException;
use flyeralarm\ResellerApi\exception\AttributeValueArray as AttributeValueArrayException;
use flyeralarm\ResellerApi\exception\AttributePossibleValuesArray as AttributePossibleValuesArrayException;
use flyeralarm\ResellerApi\exception\AttributeArray as AttributeArrayException;
use flyeralarm\ResellerApi\exception\QuantityOptionArray as QuantityOptionArrayException;
use flyeralarm\ResellerApi\exception\QuantityOptionListArray as QuantityOptionListArrayException;
use flyeralarm\ResellerApi\exception\OptionArray as OptionArrayException;
use flyeralarm\ResellerApi\exception\ShippingTypeArray as ShippingTypeArrayException;
use flyeralarm\ResellerApi\exception\ShippingOptionArray as ShippingOptionArrayException;
use flyeralarm\ResellerApi\exception\PaymentOptionArray as PaymentOptionArrayException;
use flyeralarm\ResellerApi\productCatalog\ProductAttributeList as ProductAttributeList;

/**
 * Class Loader
 *
 * @package flyeralarm\ResellerApi\productCatalog
 */
class Loader
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var ProductFactory
     */
    private $factory;

    /**
     * @param Config  $config
     * @param Factory $factory
     */
    public function __construct(Config $config, ProductFactory $factory)
    {
        $this->config = $config;
        $this->factory = $factory;
    }

    /**
     * @param $array
     * @return Group
     * @throws ProductGroupArrayException
     */
    public function loadGroupFromArray($array)
    {

        // Check if the array data is valid.
        if (!is_array($array)
            || !isset($array['productgroup_id'])
            || !isset($array['_name'])
            || !isset($array['_description'])
            || !isset($array['_image'])
            || !isset($array['_language'])
        ) {
            throw new ProductGroupArrayException();
        }

        // Create a ProductGroup object.
        return $this->loadGroup(
            $array['productgroup_id'],
            $array['_name'],
            $array['_description'],
            $array['_image'],
            $array['_language']
        );
    }

    /**
     * @param $array
     * @return GroupList
     * @throws ProductGroupArrayException
     * @throws ProductGroupListArrayException
     */
    public function loadGroupListFromArray($array)
    {
        // Check if the array data is valid.
        if (!is_array($array)
        ) {
            throw new ProductGroupListArrayException();
        }

        // Create a ProductGroupList object.
        $groupList = $this->factory->createGroupList();
        // Add all the ProductGroups from the array to the List.
        foreach ($array as $array_part) {
            $group = $this->loadGroupFromArray($array_part);
            $groupList->add($group);
        }

        // Return the full list.
        return $groupList;
    }

    /**
     * @param $productgroup_id
     * @param $name
     * @param $description
     * @param $image_path
     * @param $language
     * @return Group
     */
    private function loadGroup($productgroup_id, $name, $description, $image_path, $language)
    {
        // Create a ProductGroup object.
        return $this->factory->createGroup(
            (int) $productgroup_id,
            (string) $name,
            (string) $description,
            ((string) $this->config->getImageBase() . (string) $image_path), // Add image base path to uri.
            (string) $language
        );
    }


    /**
     * @param $array
     * @return ProductAttributeList
     * @throws AttributeArrayException
     */
    public function loadAttributeListFromArray($array)
    {
        if (!is_array($array)
        ) {
            throw new AttributeArrayException();
        }

        $attributeList = $this->factory->createAttributeList();


        foreach ($array as $attr_array) {
            $attribute = $this->loadAttributeFromArray($attr_array);
            $attributeList->add($attribute);
        }

        return $attributeList;
    }

    /**
     * @param $array
     * @param ProductAttributeList $attributes
     * @return ProductAttributeList
     * @throws AttributeArrayException
     */
    public function loadAttributeListFromArrayWithPreselectedAttributes($array, ProductAttributeList $attributes)
    {
        $newAttributes = $this->loadAttributeListFromArray($array);

        if ($newAttributes->hasAttributes()) {
            /**
             * @var $old_attr Attribute
             * @var $new_attr Attribute
             */
            foreach ($attributes as $old_attr) {
                $new_attr = $newAttributes->getById($old_attr->getId());
                if ($new_attr !== null && $old_attr->getSelection() !== null) {
                    $selected_value = $new_attr->getPossibleValues()->getById($old_attr->getSelection()->getId());
                    if ($selected_value !== null) {
                        $new_attr->setSelection($selected_value);
                    }
                }
            }
        }

        return $newAttributes;
    }

    /**
     * @param $array
     * @return ProductAttribute
     * @throws AttributeArrayException
     * @throws AttributePossibleValuesArrayException
     */
    public function loadAttributeFromArray($array)
    {
        // Check if the array data is valid.
        if (!is_array($array)
            || !isset($array['name'])
            || !isset($array['id'])
            || !isset($array['options'])
            || !is_array($array['options'])
        ) {
            throw new AttributeArrayException();
        }

        $possible_values = $this->loadAttributePossibleValuesFromArray($array['options']);

        // Create a AttributeValue object.
        return $this->factory->createAttribute(
            (int) $array['id'],
            (string) $array['name'],
            $possible_values
        );
    }

    /**
     * @param $array
     * @return ProductAttributePossibleValuesList
     * @throws AttributePossibleValuesArrayException
     * @throws AttributeValueArrayException
     */
    private function loadAttributePossibleValuesFromArray($array)
    {
        // Check if the array data is valid.
        if (!is_array($array)
            || !(count($array) > 0)
        ) {
            throw new AttributePossibleValuesArrayException();
        }

        $possibleValues = $this->factory->createAttributePossibleValuesList();

        foreach ($array as $id => $data) {
            $value = $this->loadAttributeValueFromArray($id, $data);
            $possibleValues->add($value);
        }

        return $possibleValues;
    }

    /**
     * @param $id
     * @param $array
     * @return ProductAttributeValue
     * @throws AttributeValueArrayException
     */
    private function loadAttributeValueFromArray($id, $array)
    {

        // Check if the array data is valid.
        if (!is_array($array)
            || !isset($array['name'])
            || !is_numeric($id)
        ) {
            throw new AttributeValueArrayException();
        }

        // Create a AttributeValue object.
        return $this->factory->createAttributeValue(
            (int) $id,
            (string) $array['name']
        );
    }

    /**
     * @param $array
     * @return ProductQuantityOptionList
     * @throws QuantityOptionArrayException
     * @throws QuantityOptionListArrayException
     */
    public function loadQuantityOptionListFromArray($array)
    {

        if (!is_array($array)) {
            throw new QuantityOptionListArrayException();
        }

        $optionList = $this->factory->createQuantityOptionList();

        foreach ($array as $key => $value) {
            $exploded_key = explode('_', $key);
            $quantity = $exploded_key[1];

            if ($exploded_key[0] !== 'quantity'
                || !is_numeric($quantity)
                || !is_array($value)
            ) {
                throw new QuantityOptionListArrayException();
            }

            $option = $this->loadQuantityOptionFromArray($quantity, $value);

            $optionList->add($option);
        }

        return $optionList;
    }

    /**
     * @param $quantity
     * @param $array
     * @return ProductQuantityOption
     * @throws QuantityOptionArrayException
     */
    private function loadQuantityOptionFromArray($quantity, $array)
    {

        $shippingOptions = [];
        foreach ($array as $type => $value) {
            if (!in_array($type, ['standard', 'express', 'overnight'])
                || !is_array($value)
            ) {
                throw new QuantityOptionArrayException();
            }

            $option = $this->loadQuantityShippingOptionFromArray($type, $value);
            $shippingOptions[$type] = $option;
        }

        return $this->factory->createQuantityOption($quantity, $shippingOptions);
    }

    /**
     * @param $type
     * @param $array
     * @return ProductQuantityShippingOption
     * @throws QuantityOptionArrayException
     */
    private function loadQuantityShippingOptionFromArray($type, $array)
    {

        if (!in_array($type, ['standard', 'express', 'overnight'])
            || !isset($array['id'])
            || !isset($array['shipping'])
            || !isset($array['shipping']['deadline'])
            || !isset($array['shipping']['from'])
            || !isset($array['shipping']['to'])
        ) {
            throw new QuantityOptionArrayException();
        }

        return $this->factory->createQuantityShippingOption(
            $type,
            $array['id'],
            $array['shipping']['deadline'],
            $array['shipping']['from'],
            $array['shipping']['to']
        );
    }

    /**
     * @param $quantityId
     * @param $array
     * @return Product
     * @throws AttributeValueArrayException
     */
    public function loadProductFromArray($quantityId, $array)
    {

        // Check if the array data is valid.
        if (!is_array($array)
            || !isset($array['productId'])
            || !isset($array['description'])
            || !isset($array['datasheet'])
            || !is_numeric($array['productId'])
            || !is_numeric($quantityId)
        ) {
            throw new AttributeValueArrayException();
        }
        if (!isset($array['attributes']) || !is_array($array['attributes'])) {
            $attributeList = new ProductAttributeList();
        } else {
            $attributeList = $this->loadAttributeListFromProductArray($array['attributes']);
        }
        $product = $this->factory->createProduct(
            $quantityId,
            $array['productId'],
            $array['description'],
            ((string) $this->config->getImageBase() . (string) $array['datasheet']),
            $attributeList
        );

        return $product;
    }

    /**
     * @param $array
     * @return ProductAttributeList
     * @throws AttributeArrayException
     * @throws AttributeValueArrayException
     * @throws \flyeralarm\ResellerApi\exception\AddObjectType
     */
    public function loadAttributeListFromProductArray($array)
    {

        // Check if the array data is valid.
        if (!is_array($array)) {
            throw new AttributeValueArrayException();
        }

        $attributeList = $this->factory->createAttributeList();
        foreach ($array as $key => $value) {
            if (!is_array($value)) {
                throw new AttributeValueArrayException();
            }

            $attribute = $this->loadAttributeFromProductArray($value);
            $attributeList->add($attribute);
        }

        return $attributeList;
    }

    /**
     * @param $array
     * @return ProductAttribute
     * @throws AttributeArrayException
     * @throws \flyeralarm\ResellerApi\exception\AddObjectType
     */
    public function loadAttributeFromProductArray($array)
    {

        // Check if the array data is valid.
        if (!is_array($array)
            || !isset($array['attributeGroupId'])
            || !isset($array['attributeId'])
            || !isset($array['attributeGroupName'])
            || !isset($array['attributeName'])
            || !is_numeric($array['attributeGroupId'])
            || !is_numeric($array['attributeId'])
        ) {
            throw new AttributeArrayException();
        }


        $options = $this->factory->createAttributePossibleValuesList();
        $value = $this->factory->createAttributeValue($array['attributeId'], $array['attributeName']);
        $options->add($value);

        $attribute = $this->factory->createAttribute(
            $array['attributeGroupId'],
            $array['attributeGroupName'],
            $options
        );
        $attribute->setSelection($value);

        return $attribute;
    }

    /**
     * @param $array
     * @return ProductOptionList
     * @throws OptionArrayException
     * @throws \flyeralarm\ResellerApi\exception\AddObjectType
     */
    public function loadOptionsListFromArray($array)
    {
        // Check if the array data is valid.
        if (!is_array($array)
        ) {
            throw new OptionArrayException();
        }

        $optionList = $this->factory->createOptionList();
        foreach ($array as $key => $value) {
            $option = $this->loadOptionFromArray($key, $value);
            $optionList->add($option);
        }

        return $optionList;
    }

    /**
     * @param $id
     * @param $array
     * @return ProductOption
     * @throws OptionArrayException
     */
    public function loadOptionFromArray($id, $array)
    {
        // Check if the array data is valid.
        if (!is_array($array)
            || !isset($array['name'])
            || !isset($array['options'])
            || !is_array($array['options'])
            || !is_numeric($id)
        ) {
            throw new OptionArrayException();
        }

        $possibleValues = $this->loadPossibleOptionValuesListFromArray($array['options']);

        $option = $this->factory->createOption($id, $array['name'], $possibleValues);

        return $option;
    }

    /**
     * @param $array
     * @return ProductOptionPossibleValuesList
     * @throws OptionArrayException
     * @throws \flyeralarm\ResellerApi\exception\AddObjectType
     */
    public function loadPossibleOptionValuesListFromArray($array)
    {

        // Check if the array data is valid.
        if (!is_array($array)) {
            throw new OptionArrayException();
        }

        $possibleValues = $this->factory->createOptionPossibleValuesList();
        foreach ($array as $key => $value) {
            if (!is_numeric($key)
                || !is_array($value)
            ) {
                throw new OptionArrayException();
            }
            /**
             * @var $option ProductOptionValue
             */
            $optionValue = $this->loadOptionValueFromArray($key, $value);
            $possibleValues->add($optionValue);
        }

        return $possibleValues;
    }

    /**
     * @param $id
     * @param $array
     * @return ProductOptionValue
     * @throws OptionArrayException
     */
    public function loadOptionValueFromArray($id, $array)
    {

        // Check if the array data is valid.
        if (!is_array($array)
            || !isset($array['name'])
            || !isset($array['description'])
            || !isset($array['bruttoPrice'])
            || !isset($array['nettoPrice'])
            || !is_numeric($id)
        ) {
            throw new OptionArrayException();
        }

        $value = $this->factory->createOptionValue(
            $id,
            $array['name'],
            $array['description'],
            $array['bruttoPrice'],
            $array['nettoPrice']
        );

        return $value;
    }

    /**
     * @param $array
     * @return ProductShippingTypeList
     * @throws ShippingTypeArrayException
     * @throws \flyeralarm\ResellerApi\exception\AddObjectType
     */
    public function loadShippingTypeListFromArray($array)
    {

        // Check if the array data is valid.
        if (!is_array($array)
        ) {
            throw new ShippingTypeArrayException();
        }

        $stList = $this->factory->createShippingTypeList();

        foreach ($array as $value) {
            $st = $this->loadShippingTypeFromArray($value);
            $stList->add($st);
        }

        return $stList;
    }

    /**
     * @param $array
     * @return ProductShippingType
     * @throws ShippingTypeArrayException
     */
    public function loadShippingTypeFromArray($array)
    {

        // Check if the array data is valid.
        if (!is_array($array)
            || !isset($array['_id'])
            || !isset($array['_name'])
            || !isset($array['_from'])
            || !isset($array['_to'])
            || !isset($array['_deadline'])
            || !isset($array['_price_netto'])
            || !isset($array['_price_brutto'])
        ) {
            throw new ShippingTypeArrayException();
        }

        $st = $this->factory->createShippingType(
            $array['_id'],
            $array['_name'],
            $array['_from'],
            $array['_to'],
            $array['_deadline'],
            $array['_price_brutto'],
            $array['_price_netto']
        );

        return $st;
    }

    /**
     * @param $array
     * @return ProductShippingOptionUpgrade
     * @throws ShippingOptionArrayException
     */
    public function loadShippingOptionUpgradeFromArray($array)
    {

        // Check if the array data is valid.
        if (!is_array($array)
            || !isset($array['id'])
            || !isset($array['name'])
            || !isset($array['defaultName'])
            || !isset($array['price'])
            || !isset($array['priceWithTax'])
        ) {
            throw new ShippingOptionArrayException();
        }

        $sou = $this->factory->createShippingOptionUpgrade(
            $array['id'],
            $array['name'],
            $array['defaultName'],
            $array['price'],
            $array['priceWithTax']
        );

        return $sou;
    }

    /**
     * @param $array
     * @return ProductShippingOptionUpgradeList
     * @throws ShippingOptionArrayException
     * @throws \flyeralarm\ResellerApi\exception\AddObjectType
     */
    public function loadShippingOptionUpgradeListFromArray($array)
    {

        // Check if the array data is valid.
        if (!is_array($array)
        ) {
            throw new ShippingOptionArrayException();
        }

        $soul = $this->factory->createShippingOptionUpgradeList();
        foreach ($array as $value) {
            $sou = $this->loadShippingOptionUpgradeFromArray($value);
            $soul->add($sou);
        }

        return $soul;
    }

    /**
     * @param $array
     * @return ProductShippingOption
     * @throws ShippingOptionArrayException
     */
    public function loadShippingOptionFromArray($array)
    {

        // Check if the array data is valid.
        if (!is_array($array)
            || !isset($array['id'])
            || !isset($array['name'])
            || !isset($array['defaultName'])
            || !isset($array['price'])
            || !isset($array['priceWithTax'])
        ) {
            throw new ShippingOptionArrayException();
        }

        if (isset($array['upgrades'])
            && is_array($array['upgrades'])
            && !empty($array['upgrades'])
        ) {
            $soul = $this->loadShippingOptionUpgradeListFromArray($array['upgrades']);
        } else {
            $soul = null;
        }


        $so = $this->factory->createShippingOption(
            $array['id'],
            $array['name'],
            $array['defaultName'],
            $array['price'],
            $array['priceWithTax'],
            $soul
        );

        return $so;
    }

    /**
     * @param $array
     * @return ProductShippingOptionList
     * @throws ShippingOptionArrayException
     * @throws \flyeralarm\ResellerApi\exception\AddObjectType
     */
    public function loadShippingOptionListFromArray($array)
    {

        // Check if the array data is valid.
        if (!is_array($array)
            || !isset($array['shippingoptions'])
            || !is_array($array['shippingoptions'])
        ) {
            throw new ShippingOptionArrayException();
        }


        $sol = $this->factory->createShippingOptionList();

        foreach ($array['shippingoptions'] as $value) {
            $so = $this->loadShippingOptionFromArray($value);
            $sol->add($so);
        }

        return $sol;
    }

    /**
     * @param $array
     * @return ProductPaymentOptionList
     * @throws PaymentOptionArrayException
     * @throws \flyeralarm\ResellerApi\exception\AddObjectType
     */
    public function loadPaymentOptionListFromArray($array)
    {

        // Check if the array data is valid.
        if (!is_array($array)
        ) {
            throw new PaymentOptionArrayException();
        }

        $pol = $this->factory->createPaymentOptionList();
        foreach ($array as $value) {
            $po = $this->loadPaymentOptionFromArray($value);
            $pol->add($po);
        }

        return $pol;
    }

    /**
     * @param $array
     * @return ProductPaymentOption
     * @throws PaymentOptionArrayException
     */
    public function loadPaymentOptionFromArray($array)
    {

        // Check if the array data is valid.
        if (!is_array($array)
            || !isset($array['id'])
            || !isset($array['name'])
            || !isset($array['price'])
            || !isset($array['serviceFee'])
        ) {
            throw new PaymentOptionArrayException();
        }

        $po = $this->factory->createPaymentOption($array['id'], $array['name'], $array['price'], $array['serviceFee']);

        return $po;
    }
}
