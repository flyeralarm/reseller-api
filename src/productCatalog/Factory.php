<?php
namespace flyeralarm\ResellerApi\productCatalog;

use flyeralarm\ResellerApi\productCatalog\ProductQuantityOption as QuantityOption;
use flyeralarm\ResellerApi\productCatalog\ProductQuantityOptionList as QuantityOptionList;
use flyeralarm\ResellerApi\productCatalog\ProductQuantityShippingOption as QuantityShippingOption;
use flyeralarm\ResellerApi\productCatalog\ProductAttribute as Attribute;
use flyeralarm\ResellerApi\productCatalog\ProductAttributeList as AttributeList;
use flyeralarm\ResellerApi\productCatalog\ProductAttributeValue as AttributeValue;
use flyeralarm\ResellerApi\productCatalog\ProductAttributePossibleValuesList as AttributePossibleValuesList;
use flyeralarm\ResellerApi\productCatalog\GroupList as ProductGroupList;
use flyeralarm\ResellerApi\productCatalog\Group as ProductGroup;
use flyeralarm\ResellerApi\productCatalog\Product as Product;
use flyeralarm\ResellerApi\productCatalog\ProductOption as Option;
use flyeralarm\ResellerApi\productCatalog\ProductOptionList as OptionList;
use flyeralarm\ResellerApi\productCatalog\ProductOptionPossibleValuesList as OptionPossibleValuesList;
use flyeralarm\ResellerApi\productCatalog\ProductOptionValue as OptionValue;
use flyeralarm\ResellerApi\productCatalog\ProductShippingTypeList as ShippingTypeList;
use flyeralarm\ResellerApi\productCatalog\ProductShippingType as ShippingType;
use flyeralarm\ResellerApi\productCatalog\ProductShippingOption as ShippingOption;
use flyeralarm\ResellerApi\productCatalog\ProductShippingOptionList as ShippingOptionList;
use flyeralarm\ResellerApi\productCatalog\ProductShippingOptionUpgrade as ShippingOptionUpgrade;
use flyeralarm\ResellerApi\productCatalog\ProductShippingOptionUpgradeList as ShippingOptionUpgradeList;
use flyeralarm\ResellerApi\productCatalog\ProductPaymentOption as PaymentOption;
use flyeralarm\ResellerApi\productCatalog\ProductPaymentOptionList as PaymentOptionList;

/**
 * Class Factory
 *
 * @package flyeralarm\ResellerApi\productCatalog
 */
class Factory
{

    /**
     * @return GroupList
     */
    public function createGroupList()
    {
        // Create a ProductGroupList object.
        return new ProductGroupList();
    }

    /**
     * @param $productgroup_id
     * @param $name
     * @param $description
     * @param $image_uri
     * @param $language
     * @return Group
     */
    public function createGroup($productgroup_id, $name, $description, $image_uri, $language)
    {
        return new ProductGroup($productgroup_id, $name, $description, $image_uri, $language);
    }

    /**
     * @return ProductAttributeList
     */
    public function createAttributeList()
    {
        return new AttributeList();
    }

    /**
     * @return ProductAttributePossibleValuesList
     */
    public function createAttributePossibleValuesList()
    {
        return new AttributePossibleValuesList();
    }

    /**
     * @param $id
     * @param $name
     * @param ProductAttributePossibleValuesList $possible_values
     * @return ProductAttribute
     */
    public function createAttribute($id, $name, AttributePossibleValuesList $possible_values)
    {
        return new Attribute($id, $name, $possible_values);
    }

    /**
     * @param $id
     * @param $name
     * @return ProductAttributeValue
     */
    public function createAttributeValue($id, $name)
    {
        return new AttributeValue($id, $name);
    }

    /**
     * @param $quantity
     * @param $shipping_options
     * @return ProductQuantityOption
     */
    public function createQuantityOption($quantity, $shipping_options)
    {
        return new QuantityOption($quantity, $shipping_options);
    }

    /**
     * @return ProductQuantityOptionList
     */
    public function createQuantityOptionList()
    {
        return new QuantityOptionList();
    }

    /**
     * @param $type
     * @param $quantityId
     * @param $deadline
     * @param $from
     * @param $to
     * @return ProductQuantityShippingOption
     */
    public function createQuantityShippingOption($type, $quantityId, $deadline, $from, $to)
    {
        return new QuantityShippingOption($type, $quantityId, $deadline, $from, $to);
    }

    /**
     * @param $quantityId
     * @param $productId
     * @param $description
     * @param $datasheet
     * @param ProductAttributeList $attributes
     * @return Product
     */
    public function createProduct($quantityId, $productId, $description, $datasheet, AttributeList $attributes)
    {
        return new Product($quantityId, $productId, $description, $datasheet, $attributes);
    }

    /**
     * @return ProductOptionList
     */
    public function createOptionList()
    {
        return new OptionList();
    }

    /**
     * @param $optionId
     * @param $name
     * @param ProductOptionPossibleValuesList $possible_values
     * @return ProductOption
     */
    public function createOption($optionId, $name, OptionPossibleValuesList $possible_values)
    {
        return new Option($optionId, $name, $possible_values);
    }

    /**
     * @return ProductOptionPossibleValuesList
     */
    public function createOptionPossibleValuesList()
    {
        return new OptionPossibleValuesList();
    }

    /**
     * @param $optionValueId
     * @param $name
     * @param $description
     * @param $bruttoPrice
     * @param $nettoPrice
     * @return ProductOptionValue
     */
    public function createOptionValue($optionValueId, $name, $description, $bruttoPrice, $nettoPrice)
    {
        return new OptionValue($optionValueId, $name, $description, $bruttoPrice, $nettoPrice);
    }

    /**
     * @param $id
     * @param $name
     * @param $from
     * @param $to
     * @param $deadline
     * @param $bruttoPrice
     * @param $nettoPrice
     * @return ProductShippingType
     */
    public function createShippingType($id, $name, $from, $to, $deadline, $bruttoPrice, $nettoPrice)
    {
        return new ShippingType($id, $name, $from, $to, $deadline, $bruttoPrice, $nettoPrice);
    }

    /**
     * @return ProductShippingTypeList
     */
    public function createShippingTypeList()
    {
        return new ShippingTypeList();
    }

    /**
     * @return ProductShippingOptionList
     */
    public function createShippingOptionList()
    {
        return new ShippingOptionList();
    }

    /**
     * @param $id
     * @param $name
     * @param $defaultName
     * @param $price
     * @param $priceWithTax
     * @param ProductShippingOptionUpgradeList $upgrades
     * @return ProductShippingOption
     */
    public function createShippingOption(
        $id,
        $name,
        $defaultName,
        $price,
        $priceWithTax,
        ShippingOptionUpgradeList $upgrades = null
    ) {
        return new ShippingOption($id, $name, $defaultName, $price, $priceWithTax, $upgrades);
    }

    /**
     * @return ProductShippingOptionUpgradeList
     */
    public function createShippingOptionUpgradeList()
    {
        return new ShippingOptionUpgradeList();
    }

    /**
     * @param $id
     * @param $name
     * @param $defaultName
     * @param $price
     * @param $priceWithTax
     * @return ProductShippingOptionUpgrade
     */
    public function createShippingOptionUpgrade($id, $name, $defaultName, $price, $priceWithTax)
    {
        return new ShippingOptionUpgrade($id, $name, $defaultName, $price, $priceWithTax);
    }

    /**
     * @return ProductPaymentOptionList
     */
    public function createPaymentOptionList()
    {
        return new PaymentOptionList();
    }

    /**
     * @param $id
     * @param $name
     * @param $price
     * @param $serviceFee
     * @return ProductPaymentOption
     */
    public function createPaymentOption($id, $name, $price, $serviceFee)
    {
        return new PaymentOption($id, $name, $price, $serviceFee);
    }
}
