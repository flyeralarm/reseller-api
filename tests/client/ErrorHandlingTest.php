<?php

use PHPUnit\Framework\TestCase;
use flyeralarm\ResellerApi\productCatalog\Group;
use flyeralarm\ResellerApi\productCatalog\GroupList;
use flyeralarm\ResellerApi\productCatalog\Product;
use flyeralarm\ResellerApi\productCatalog\ProductAttributeList;
use flyeralarm\ResellerApi\productCatalog\ProductAttribute;
use flyeralarm\ResellerApi\productCatalog\ProductAttributePossibleValuesList;
use flyeralarm\ResellerApi\productCatalog\ProductAttributeValue;
use flyeralarm\ResellerApi\productCatalog\ProductShippingType;
use flyeralarm\ResellerApi\productCatalog\ProductShippingTypeList;
use flyeralarm\ResellerApi\productCatalog\ProductOption;
use flyeralarm\ResellerApi\productCatalog\ProductOptionList;
use flyeralarm\ResellerApi\productCatalog\ProductOptionPossibleValuesList;
use flyeralarm\ResellerApi\productCatalog\ProductOptionValue;
use flyeralarm\ResellerApi\productCatalog\ProductShippingOption;
use flyeralarm\ResellerApi\productCatalog\ProductShippingOptionList;
use flyeralarm\ResellerApi\productCatalog\ProductShippingOptionUpgrade;
use flyeralarm\ResellerApi\productCatalog\ProductShippingOptionUpgradeList;
use flyeralarm\ResellerApi\productCatalog\ProductPaymentOption;
use flyeralarm\ResellerApi\productCatalog\ProductPaymentOptionList;
use flyeralarm\ResellerApi\productCatalog\Factory as ProductFactory;
use flyeralarm\ResellerApi\productCatalog\Loader as ProductLoader;
use flyeralarm\ResellerApi\productCatalog\ProductQuantityOption;
use flyeralarm\ResellerApi\productCatalog\ProductQuantityOptionList;
use flyeralarm\ResellerApi\productCatalog\ProductQuantityShippingOption;
use flyeralarm\ResellerApi\exception\LoginFail as LoginFailException;
use flyeralarm\ResellerApi\exception\SoapCall as SoapCallException;
use flyeralarm\ResellerApi\exception\AddObjectType as AddObjectTypeException;


use flyeralarm\ResellerApi\client\Api;

/**
 * @covers flyeralarm\ResellerApi\client\Api
 * @covers flyeralarm\ResellerApi\productCatalog\Loader
 * @covers flyeralarm\ResellerApi\productCatalog\Factory
 * @covers flyeralarm\ResellerApi\client\Factory
 * @covers flyeralarm\ResellerApi\client\Order
 * @covers flyeralarm\ResellerApi\exception\LoginFail
 * @covers flyeralarm\ResellerApi\exception\SoapCall
 * @covers flyeralarm\ResellerApi\exception\AddObjectType
 * @covers flyeralarm\ResellerApi\exception\General
 * @covers flyeralarm\ResellerApi\exception\Connection
 * @covers flyeralarm\ResellerApi\exception\ArrayAccess
 * @covers flyeralarm\ResellerApi\exception\DataStructure
 */
class ErrorHandlingTest extends TestCase
{


    /**
     * @var ConfigMock $config
     */
    private $config;

    /**
     * @var Api $client
     */
    private $client;

    /**
     * @var Order $order
     */
    private $api_order;

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

        $this->factory = new ClientFactoryMockFail($this->config);
        $this->client = $this->factory->createClient();

        $this->api_order = $this->factory->createOrder();
        $this->api_order->loadByPersistencyString("eJzlU8tywjAM/JWMrg2MTcIjufEB5VI6vfQibAU849ipHxTK8O+1odBpP6G9rVZaeWXLJ3hT0HI2X0xnDS/BhxROShgsQmui1iWghvYEnowkl5Gw/YDmCC1ACdsvGnrUlOJOOR9W2FOiHvGQGI3fRPSBXI/GJB6ldOR9ope6cyRHK7shPXoKDl8jY7Kjgi++65ZS3gwN1gdhZe7YzNmcpSKhQjb0kpWdcB+b6LaZttHkxFWnrcgmb1121hBPooe6aSpez6aLGs4lSNJqT+74D0ZVZm+VoD8/aRoVd9BWab1tWm/gkM/Le5+YqG7ijE4gMeDaofEdufVxyIbioC3KJPqRU5fxeTVm1XjC+Lzgs3Zat4z9LqRDyBcSg+0xKFE8X9oVe4XFclDj/BLu/tvE+x3truj8CR0JJ/E=");


    }

    public function testLogin()
    {

        $this->expectException(LoginFailException::class);
        $logged = $this->client->loggedInTest();

    }

    public function testGetProductGroupIds()
    {

        $this->expectException(SoapCallException::class);
        $logged = $this->client->getProductGroupIds();

    }

    public function testGetProductAttributesByProductGroupId()
    {

        $this->expectException(SoapCallException::class);
        $logged = $this->client->getProductAttributesByProductGroupId(10);

    }

    public function testGetAvailableAttributesByPreselectedAttributes()
    {

        $factory = new ProductFactory();
        $loader = new ProductLoader($this->config, $factory);

        $group = $factory->createGroup(2, 'Flyer Klassik', 'group test description', 'test_img.jpg', 'de');

        $attrArray = array(
            2798 =>
                array(
                    'id' => 2798,
                    'name' => 'Ausführung',
                    'sortvalue' => '1',
                    'descr' => null,
                    'options' =>
                        array(
                            14562 =>
                                array(
                                    'sortvalue' => '1',
                                    'name' => 'DIN-Format',
                                    'tooltipp' => '',
                                ),
                            14563 =>
                                array(
                                    'sortvalue' => '2',
                                    'name' => 'Rechteck',
                                    'tooltipp' => '',
                                ),
                        )
                ),
            2791 =>
                array(
                    'id' => 2791,
                    'name' => 'Format',
                    'sortvalue' => '2',
                    'descr' => null,
                    'options' =>
                        array(
                            14582 =>
                                array(
                                    'sortvalue' => '1',
                                    'name' => 'DIN A8(5,2 x 7,4 cm)',
                                    'tooltipp' => '',
                                ),
                            14580 =>
                                array(
                                    'sortvalue' => '2',
                                    'name' => 'DIN A7(7,4 x 10,5 cm)',
                                    'tooltipp' => '',
                                ),
                        ),
                )
        );

        $attributes = $loader->loadAttributeListFromArray($attrArray);

        $this->expectException(SoapCallException::class);
        $logged = $this->client->getAvailableAttributesByPreselectedAttributes($group, $attributes);

    }


    public function testGetAvailableQuantitiesByAttributes()
    {

        $factory = new ProductFactory();
        $loader = new ProductLoader($this->config, $factory);

        $group = $factory->createGroup(2, 'Flyer Klassik', 'group test description', 'test_img.jpg', 'de');

        $attrArray = array(
            2798 =>
                array(
                    'id' => 2798,
                    'name' => 'Ausführung',
                    'sortvalue' => '1',
                    'descr' => null,
                    'options' =>
                        array(
                            14562 =>
                                array(
                                    'sortvalue' => '1',
                                    'name' => 'DIN-Format',
                                    'tooltipp' => '',
                                ),
                            14563 =>
                                array(
                                    'sortvalue' => '2',
                                    'name' => 'Rechteck',
                                    'tooltipp' => '',
                                ),
                        )
                ),
            2791 =>
                array(
                    'id' => 2791,
                    'name' => 'Format',
                    'sortvalue' => '2',
                    'descr' => null,
                    'options' =>
                        array(
                            14582 =>
                                array(
                                    'sortvalue' => '1',
                                    'name' => 'DIN A8(5,2 x 7,4 cm)',
                                    'tooltipp' => '',
                                ),
                            14580 =>
                                array(
                                    'sortvalue' => '2',
                                    'name' => 'DIN A7(7,4 x 10,5 cm)',
                                    'tooltipp' => '',
                                ),
                        ),
                )
        );

        $attributes = $loader->loadAttributeListFromArray($attrArray);

        $this->expectException(SoapCallException::class);
        $logged = $this->client->getAvailableQuantitiesByAttributes($group, $attributes);

    }


    public function testFindProductByQuantityId()
    {

        $this->expectException(SoapCallException::class);
        $logged = $this->client->findProductByQuantityId(12345);

    }

    public function testGetAvailableProductOptions()
    {

        $factory = new ProductFactory();
        $loader = new ProductLoader($this->config, $factory);

        $pArray = array(
            'productId' => 310198,
            'description' => 'DIN A5 (14,8 x 21 cm), 250g Bilderdruck matt, keine Veredelung, DIN-Format',
            'datasheet' => '/sheets/de/flyer_a5_mass.pdf',
            'attributes' =>
                array(
                    0 =>
                        array(
                            'attributeGroupId' => 2791,
                            'attributeGroupName' => 'Format',
                            'attributeId' => 14576,
                            'attributeName' => 'DIN A5 (14,8 x 21 cm)',
                        )
                )
        );

        $product = $loader->loadProductFromArray(12345, $pArray);

        $this->expectException(SoapCallException::class);
        $logged = $this->client->getAvailableProductOptions($product);

    }

    public function testGetShippingTypeList()
    {

        $factory = new ProductFactory();
        $loader = new ProductLoader($this->config, $factory);

        $pArray = array(
            'productId' => 310198,
            'description' => 'DIN A5 (14,8 x 21 cm), 250g Bilderdruck matt, keine Veredelung, DIN-Format',
            'datasheet' => '/sheets/de/flyer_a5_mass.pdf',
            'attributes' =>
                array(
                    0 =>
                        array(
                            'attributeGroupId' => 2791,
                            'attributeGroupName' => 'Format',
                            'attributeId' => 14576,
                            'attributeName' => 'DIN A5 (14,8 x 21 cm)',
                        )
                )
        );

        $product = $loader->loadProductFromArray(12345, $pArray);

        $this->expectException(SoapCallException::class);
        $logged = $this->client->getShippingTypeList($product);

    }

    public function testGetAvailableShippingOptions()
    {

        $this->expectException(SoapCallException::class);
        $logged = $this->client->getAvailableShippingOptions($this->api_order);

    }

    public function testGetAvailablePaymentOptions()
    {

        $this->expectException(SoapCallException::class);
        $logged = $this->client->getAvailablePaymentOptions($this->api_order);

    }

    public function testSendFullOrder()
    {

        $this->expectException(SoapCallException::class);
        $logged = $this->client->sendFullOrder($this->api_order);

    }


    public function testGetOrderStatus()
    {

        $this->expectException(LoginFailException::class);
        $logged = $this->client->getOrderStatus('DE001234567');

    }

    /**
     * @covers \flyeralarm\ResellerApi\productCatalog\GroupList
     */
    public function testProductGroupListAdd()
    {

        $factory = new ProductFactory();

        $list = $factory->createGroupList();


        $this->expectException(AddObjectTypeException::class);
        $list->add($this->api_order);

    }

    /**
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductAttributeList
     */
    public function testProductAttributeListAdd()
    {

        $factory = new ProductFactory();

        $list = $factory->createAttributeList();

        $this->assertEquals(
            null,
            $list->getById(666)
        );

        $this->assertFalse(
            $list->hasAttributes()
        );


        $this->expectException(AddObjectTypeException::class);
        $list->add($this->api_order);

    }

    /**
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductAttributePossibleValuesList
     */
    public function testProductAttributePossibleValuesListAdd()
    {

        $factory = new ProductFactory();

        $list = $factory->createAttributePossibleValuesList();


        $this->assertFalse(
            $list->hasValues()
        );


        $this->expectException(AddObjectTypeException::class);
        $list->add($this->api_order);

    }

    /**
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductOptionList
     */
    public function testProductOptionListAdd()
    {

        $factory = new ProductFactory();

        $list = $factory->createOptionList();


        $this->assertFalse(
            $list->hasValues()
        );


        $this->expectException(AddObjectTypeException::class);
        $list->add($this->api_order);

    }

    /**
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductOptionPossibleValuesList
     */
    public function testProductOptionPossibleValuesListAdd()
    {

        $factory = new ProductFactory();

        $list = $factory->createOptionPossibleValuesList();


        $this->assertFalse(
            $list->hasValues()
        );


        $this->expectException(AddObjectTypeException::class);
        $list->add($this->api_order);

    }

    /**
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductPaymentOptionList
     */
    public function testProductPaymentOptionListAdd()
    {

        $factory = new ProductFactory();

        $list = $factory->createPaymentOptionList();


        $this->assertFalse(
            $list->hasValues()
        );


        $this->expectException(AddObjectTypeException::class);
        $list->add($this->api_order);

    }

    /**
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductQuantityOption
     */
    public function testProductQuantityOption()
    {

        $factory = new ProductFactory();

        $o = $factory->createQuantityOption(100, array());


        $this->assertFalse(
            $o->hasStandardShipping()
        );

        $this->assertEquals(
            null,
            $o->getStandardShippingOption()
        );

        $this->assertFalse(
            $o->hasExpressShipping()
        );

        $this->assertEquals(
            null,
            $o->getExpressShippingOption()
        );

        $this->assertFalse(
            $o->hasOvernightShipping()
        );

        $this->assertEquals(
            null,
            $o->getOvernightShippingOption()
        );


    }

    /**
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductQuantityOptionList
     */
    public function testProductQuantityOptionListAdd()
    {

        $factory = new ProductFactory();

        $list = $factory->createQuantityOptionList();


        $this->expectException(AddObjectTypeException::class);
        $list->add($this->api_order);

    }

    /**
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductShippingOptionUpgradeList
     */
    public function testProductShippingOptionUpgradeListAdd()
    {

        $factory = new ProductFactory();

        $list = $factory->createShippingOptionUpgradeList();

        $this->assertFalse(
            $list->hasValues()
        );

        $this->assertEquals(
            null,
            $list->getById(666)
        );

        $this->assertEquals(
            null,
            $list->getByName('NonExistingName')
        );

        $this->expectException(AddObjectTypeException::class);
        $list->add($this->api_order);

    }


    /**
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductShippingTypeList
     */
    public function testProductShippingTypeListAdd()
    {

        $factory = new ProductFactory();

        $list = $factory->createShippingTypeList();

        $this->assertFalse(
            $list->hasValues()
        );

        $this->assertEquals(
            null,
            $list->getByName('NonExistingName')
        );

        $this->expectException(AddObjectTypeException::class);
        $list->add($this->api_order);

    }

    /**
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductShippingOptionList
     */
    public function testProductShippingOptionListAdd()
    {

        $factory = new ProductFactory();

        $list = $factory->createShippingOptionList();

        $this->assertFalse(
            $list->hasValues()
        );


        $this->expectException(AddObjectTypeException::class);
        $list->add($this->api_order);

    }


}