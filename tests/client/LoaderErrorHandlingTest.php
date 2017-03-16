<?php

use PHPUnit\Framework\TestCase;
use flyeralarm\ResellerApi\productCatalog\Factory as ProductFactory;
use flyeralarm\ResellerApi\productCatalog\Loader as ProductLoader;

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


use flyeralarm\ResellerApi\client\Api;

/**
 * @covers flyeralarm\ResellerApi\client\Api
 * @covers flyeralarm\ResellerApi\productCatalog\Loader
 * @covers flyeralarm\ResellerApi\productCatalog\Factory
 * @covers flyeralarm\ResellerApi\client\Factory
 * @covers flyeralarm\ResellerApi\client\Order
 * @covers flyeralarm\ResellerApi\exception\ProductGroupArray as ProductGroupArrayException;
 * @covers flyeralarm\ResellerApi\exception\ProductGroupListArray as ProductGroupListArrayException;
 * @covers flyeralarm\ResellerApi\exception\AttributeValueArray as AttributeValueArrayException;
 * @covers flyeralarm\ResellerApi\exception\AttributePossibleValuesArray as AttributePossibleValuesArrayException;
 * @covers flyeralarm\ResellerApi\exception\AttributeArray as AttributeArrayException;
 * @covers flyeralarm\ResellerApi\exception\QuantityOptionArray as QuantityOptionArrayException;
 * @covers flyeralarm\ResellerApi\exception\QuantityOptionListArray as QuantityOptionListArrayException;
 * @covers flyeralarm\ResellerApi\exception\OptionArray as OptionArrayException;
 * @covers flyeralarm\ResellerApi\exception\ShippingTypeArray as ShippingTypeArrayException;
 * @covers flyeralarm\ResellerApi\exception\ShippingOptionArray as ShippingOptionArrayException;
 * @covers flyeralarm\ResellerApi\exception\PaymentOptionArray as PaymentOptionArrayException;
 */
class LoaderErrorHandlingTest extends TestCase
{


    /**
     * @var ConfigMock $config
     */
    private $config;

    /**
     * @var ProductLoader $order
     */
    private $loader;

    /**
     * @var ClientFactoryMock $factory
     */
    private $factory;

    public function setUp()
    {

        $this->config = new ConfigMock();
        $this->config->setResellerUserEmail('test@local.com')
            ->setResellerUserPassword('<some-test-pw>')
            ->setUserToken('12345678901234567890')
            ->setAppToken('09876543210987654321');

        $this->factory = new ProductFactory();
        $this->loader = new ProductLoader($this->config, $this->factory);

    }

    public function testLoadGroupFromArray()
    {

        $this->expectException(ProductGroupArrayException::class);
        $this->loader->loadGroupFromArray(array());
    }

    public function testLoadGroupListFromArray()
    {

        $this->expectException(ProductGroupListArrayException::class);
        $this->loader->loadGroupListFromArray('test');
    }

    public function testLoadAttributeListFromArray()
    {

        $this->expectException(AttributeArrayException::class);
        $this->loader->loadAttributeListFromArray('test');
    }

    public function testLoadAttributeFromArray()
    {

        $this->expectException(AttributeArrayException::class);
        $this->loader->loadAttributeFromArray(array());
    }

    public function testLoadAttributePossibleValuesFromArray()
    {

        $this->expectException(AttributePossibleValuesArrayException::class);
        $this->loader->loadAttributeFromArray(array('name' => 'dsf', 'id' => 123, 'options' => array()));
    }

    public function testLoadAttributeValueFromArray()
    {

        $this->expectException(AttributeValueArrayException::class);
        $this->loader->loadAttributeFromArray(array(
            'name' => 'dsf',
            'id' => 123,
            'options' => array('name' => 'sdfsdf', 'id' => 'dsfgsdfg')
        ));
    }


    public function testLoadQuantityOptionListFromArray()
    {

        $this->expectException(QuantityOptionListArrayException::class);
        $this->loader->loadQuantityOptionListFromArray('test');
    }

    public function testLoadQuantityOptionListFromArray2()
    {

        $this->expectException(QuantityOptionListArrayException::class);
        $this->loader->loadQuantityOptionListFromArray(array('0_2' => array()));
    }

    public function testLoadQuantityOptionFromArray()
    {

        $this->expectException(QuantityOptionArrayException::class);
        $this->loader->loadQuantityOptionListFromArray(array('quantity_2' => array('test' => array())));
    }

    public function testLoadQuantityShippingOptionFromArray()
    {

        $this->expectException(QuantityOptionArrayException::class);
        $this->loader->loadQuantityOptionListFromArray(array('quantity_2' => array('standard' => array())));
    }

    public function testLoadProductFromArray()
    {

        $this->expectException(AttributeValueArrayException::class);
        $this->loader->loadProductFromArray(123, array());
    }

    public function testLoadAttributeListFromProductArray()
    {

        $this->expectException(AttributeValueArrayException::class);
        $this->loader->loadAttributeListFromProductArray(null);
    }

    public function testLoadAttributeListFromProductArray2()
    {

        $this->expectException(AttributeValueArrayException::class);
        $this->loader->loadAttributeListFromProductArray(array(1 => null));
    }

    public function testLoadAttributeFromProductArray()
    {

        $this->expectException(AttributeArrayException::class);
        $this->loader->loadAttributeFromProductArray(array());
    }

    public function testLoadOptionsListFromArray()
    {

        $this->expectException(OptionArrayException::class);
        $this->loader->loadOptionsListFromArray(null);
    }

    public function testLoadOptionFromArray()
    {

        $this->expectException(OptionArrayException::class);
        $this->loader->loadOptionFromArray(123, null);
    }

    public function testLoadPossibleOptionValuesListFromArray()
    {

        $this->expectException(OptionArrayException::class);
        $this->loader->loadPossibleOptionValuesListFromArray(null);
    }

    public function testLoadPossibleOptionValuesListFromArray2()
    {

        $this->expectException(OptionArrayException::class);
        $this->loader->loadPossibleOptionValuesListFromArray(array(2 => null));
    }

    public function testLoadOptionValueFromArray()
    {

        $this->expectException(OptionArrayException::class);
        $this->loader->loadOptionValueFromArray(123, array(2 => null));
    }

    public function testLoadShippingTypeListFromArray()
    {

        $this->expectException(ShippingTypeArrayException::class);
        $this->loader->loadShippingTypeListFromArray(null);
    }

    public function testLoadShippingTypeFromArray()
    {

        $this->expectException(ShippingTypeArrayException::class);
        $this->loader->loadShippingTypeFromArray(null);
    }

    public function testLoadShippingOptionUpgradeFromArray()
    {

        $this->expectException(ShippingOptionArrayException::class);
        $this->loader->loadShippingOptionUpgradeFromArray(null);
    }

    public function testLoadShippingOptionUpgradeListFromArray()
    {

        $this->expectException(ShippingOptionArrayException::class);
        $this->loader->loadShippingOptionUpgradeListFromArray(null);
    }

    public function testLoadShippingOptionFromArray()
    {

        $this->expectException(ShippingOptionArrayException::class);
        $this->loader->loadShippingOptionFromArray(null);
    }

    public function testLoadShippingOptionListFromArray()
    {

        $this->expectException(ShippingOptionArrayException::class);
        $this->loader->loadShippingOptionListFromArray(null);
    }

    public function testLoadPaymentOptionListFromArray()
    {

        $this->expectException(PaymentOptionArrayException::class);
        $this->loader->loadPaymentOptionListFromArray(null);
    }

    public function testLoadPaymentOptionFromArray()
    {

        $this->expectException(PaymentOptionArrayException::class);
        $this->loader->loadPaymentOptionFromArray(null);
    }


}