<?php

namespace flyeralarm\ResellerApi;

use ClientFactoryMock;
use ConfigMock;
use flyeralarm\ResellerApi\client\Order;
use flyeralarm\ResellerApi\productCatalog\Group;
use flyeralarm\ResellerApi\productCatalog\GroupList;
use flyeralarm\ResellerApi\productCatalog\Product;
use flyeralarm\ResellerApi\productCatalog\ProductAttributeList;
use flyeralarm\ResellerApi\productCatalog\ProductAttribute;
use flyeralarm\ResellerApi\productCatalog\ProductAttributePossibleValuesList;
use flyeralarm\ResellerApi\productCatalog\ProductAttributeValue;
use flyeralarm\ResellerApi\productCatalog\ProductShippingType;
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
use flyeralarm\ResellerApi\client\Api;

/**
 * @covers \flyeralarm\ResellerApi\client\Api
 * @covers \flyeralarm\ResellerApi\productCatalog\Loader
 * @covers \flyeralarm\ResellerApi\productCatalog\Factory
 * @covers \flyeralarm\ResellerApi\client\Factory
 * @covers \flyeralarm\ResellerApi\client\Order
 * @covers \flyeralarm\ResellerApi\lib\AbstractList
 */
class IntegrationTest extends \PHPUnit\Framework\TestCase
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

        $this->factory = new ClientFactoryMock($this->config);
        $this->client = $this->factory->createClient();

        $this->api_order = $this->factory->createOrder();
        $this->api_order->loadByPersistencyString(
            'eJzlU8tywjAM/JWMrg2MTcIjufEB5VI6vfQibAU849ipHxTK8O+1odBpP6G9rVZaeWXLJ3hT0HI2X0xnDS/' .
            'BhxROShgsQmui1iWghvYEnowkl5Gw/YDmCC1ACdsvGnrUlOJOOR9W2FOiHvGQGI3fRPSBXI/GJB6ldOR9ope6' .
            'cyRHK7shPXoKDl8jY7Kjgi++65ZS3gwN1gdhZe7YzNmcpSKhQjb0kpWdcB+b6LaZttHkxFWnrcgmb1121hBPooe' .
            '6aSpez6aLGs4lSNJqT+74D0ZVZm+VoD8/aRoVd9BWab1tWm/gkM/Le5+YqG7ijE4gMeDaofEdufVxyIbioC3KJPq' .
            'RU5fxeTVm1XjC+Lzgs3Zat4z9LqRDyBcSg+0xKFE8X9oVe4XFclDj/BLu/tvE+x3truj8CR0JJ/E='
        );
    }

    public function testLogin()
    {
        $logged = $this->client->loggedInTest();

        $this->assertTrue(
            $logged
        );
    }

    public function testLoginFail()
    {
        $config = new ConfigMock();
        $config->setResellerUserEmail('test@local.com')
            ->setResellerUserPassword('<wrong-pw>')
            ->setUserToken('12345678901234567890')
            ->setAppToken('09876543210987654321');

        $factory = new ClientFactoryMock($config);
        $client = $factory->createClient();

        $this->expectException(LoginFailException::class);
        $client->loggedInTest();
    }

    /**
     * @covers \flyeralarm\ResellerApi\productCatalog\GroupList
     * @covers \flyeralarm\ResellerApi\productCatalog\Group
     */
    public function testProductGroupIds()
    {
        /**
         * @var \flyeralarm\ResellerApi\productCatalog\GroupList $productGroups
         */
        $productGroups = $this->client->getProductGroupIds();

        $checkArray = [
            0 => [
                'id' => 1,
                'name' => 'Sitzsack, nur Druck',
                'desc' => 'some HTML',
                'lang' => 'de',
                'img' => 'https://unittest.flyeralarm.local/images/upload/content/products/' .
                    'Sitzsack/flyeralarm-sitzsack-nurdruck-260x260.jpg',
            ],
            1 => [
                'id' => 2,
                'name' => 'Flyer Klassiker',
                'desc' => 'some HTML will go here',
                'lang' => 'de',
                'img' => 'https://unittest.flyeralarm.local/images/upload/content/images/products/flyer/' .
                    'config/flyeralarm-flyer-klassiker-240x200-config.jpg',
            ],
            2 => [
                'id' => 3,
                'name' => 'Aluminiumverbundplatte weiß im Wunschformat ',
                'desc' => 'some HTML Code will go here.',
                'lang' => 'de',
                'img' => 'https://unittest.flyeralarm.local/images/upload/content/images/products/flyer/' .
                    'config/flyeralarm-flyer-klassiker-240x200-config.jpg',
            ],
        ];

        $this->assertInstanceOf(
            GroupList::class,
            $productGroups
        );


        $i = 0;
        /**
         * @var \flyeralarm\ResellerApi\productCatalog\Group $group
         */
        foreach ($productGroups as $group) {
            $this->assertInstanceOf(
                Group::class,
                $group
            );

            $this->assertEquals(
                $checkArray[$i]['id'],
                $group->getProductGroupId()
            );

            $this->assertEquals(
                $checkArray[$i]['name'],
                $group->getName()
            );

            $this->assertEquals(
                $checkArray[$i]['desc'],
                $group->getDescription()
            );

            $this->assertEquals(
                $checkArray[$i]['img'],
                $group->getImageURL()
            );

            $this->assertEquals(
                $checkArray[$i]['lang'],
                $group->getLanguage()
            );

            $i++;
        }
    }

    /**
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductAttributeList
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductAttribute
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductAttributePossibleValuesList
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductAttributeValue
     */
    public function testProductAttributesByProductGroupId()
    {
        /**
         * @var \flyeralarm\ResellerApi\productCatalog\ProductAttributeList
         */
        $attributes = $this->client->getProductAttributesByProductGroupId(2);

        $checkArray = [
            0 => [
                'id' => 2798,
                'name' => 'Ausführung',
                'possible' => [
                    0 => ['id' => 14562, 'name' => 'DIN-Format'],
                    1 => ['id' => 14563, 'name' => 'Rechteck'],
                ],
            ],
            1 => [
                'id' => 2791,
                'name' => 'Format',
                'possible' => [
                    0 => ['id' => 14582, 'name' => 'DIN A8(5,2 x 7,4 cm)'],
                    1 => ['id' => 14580, 'name' => 'DIN A7(7,4 x 10,5 cm)'],
                ],
            ],
        ];


        $this->assertInstanceOf(
            ProductAttributeList::class,
            $attributes
        );

        $this->assertTrue(
            $attributes->hasAttributes()
        );

        $i = 0;

        /**
         * @var \flyeralarm\ResellerApi\productCatalog\ProductAttribute $attr
         */
        foreach ($attributes as $attr) {
            $this->assertInstanceOf(
                ProductAttribute::class,
                $attr
            );

            $this->assertEquals(
                $checkArray[$i]['id'],
                $attr->getId()
            );

            $this->assertEquals(
                $checkArray[$i]['name'],
                $attr->getName()
            );

            $values = $attr->getPossibleValues();

            $this->assertInstanceOf(
                ProductAttributePossibleValuesList::class,
                $values
            );

            $this->assertTrue(
                $values->hasValues()
            );

            $v1 = $values->getById($checkArray[$i]['possible'][0]['id']);

            $this->assertInstanceOf(
                ProductAttributeValue::class,
                $v1
            );

            $v2 = $values->getById(3);
            $this->assertEquals(
                null,
                $v2
            );

            $j = 0;
            /**
             * @var \flyeralarm\ResellerApi\productCatalog\ProductAttributeValue $value
             */
            foreach ($values as $value) {
                $this->assertInstanceOf(
                    ProductAttributeValue::class,
                    $value
                );

                $this->assertEquals(
                    $checkArray[$i]['possible'][$j]['id'],
                    $value->getId()
                );

                $this->assertEquals(
                    $checkArray[$i]['possible'][$j]['name'],
                    $value->getName()
                );

                $string = (string) $value;

                $this->assertEquals(
                    '[AV#' . $checkArray[$i]['possible'][$j]['id'] .
                    '|' . $checkArray[$i]['possible'][$j]['name'] . ']',
                    $string
                );

                if ($j == 0) {
                    $attr->setSelection($value);

                    $this->assertEquals(
                        $checkArray[$i]['possible'][$j]['id'],
                        $attr->getSelection()->getId()
                    );
                }
                $j++;
            }
            $i++;
        }
    }

    /**
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductAttributeList
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductAttribute
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductAttributePossibleValuesList
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductAttributeValue
     */
    public function testProductAttributesByProductGroup()
    {
        $factory = new ProductFactory();
        $loader = new ProductLoader($this->config, $factory);
        $array = [
            'productgroup_id' => '2',
            'internalName' => 'old-flyer:klassiker',
            'tid_technicalDetail' => '21162',
            'tid_seotext' => '21156',
            'tid_pagetitle' => '21155',
            'tid_parentSites' => '21148',
            'tid_metakeywords' => null,
            'tid_metadescription' => null,
            'tid_importantHint' => null,
            'created' => '0000-00-00 00:00:00',
            'pictureUrl' => null,
            'recoPictureUrl' => '/images/upload/content/images/products/flyer/' .
                'countries/flyeralarm-flyer-klassiker-583x335-config-hu.jpg',
            '_language' => 'de',
            '_name' => 'Flyer Klassiker',
            '_description' => 'some HTML will go here',
            '_image' => '/images/upload/content/images/products/flyer/' .
                'config/flyeralarm-flyer-klassiker-240x200-config.jpg',
            '_technicalDetail' => '',
            '_seotext' => 'some seo text',
            '_parentSites' => 'bread crumbs',
            '_pagetitle' => 'Flyer Klassiker günstig drucken bei FLYERALARM',
            '_metakeywords' => '',
            '_metadescription' => '',
            '_importantHint' => '',
        ];

        $group = $loader->loadGroupFromArray($array);

        /**
         * @var \flyeralarm\ResellerApi\productCatalog\ProductAttributeList
         */
        $attributes = $this->client->getProductAttributesByProductGroup($group);

        $checkArray = [
            0 => [
                'id' => 2798,
                'name' => 'Ausführung',
                'possible' => [
                    0 => ['id' => 14562, 'name' => 'DIN-Format'],
                    1 => ['id' => 14563, 'name' => 'Rechteck'],
                ],
            ],
            1 => [
                'id' => 2791,
                'name' => 'Format',
                'possible' => [
                    0 => ['id' => 14582, 'name' => 'DIN A8(5,2 x 7,4 cm)'],
                    1 => ['id' => 14580, 'name' => 'DIN A7(7,4 x 10,5 cm)'],
                ],
            ],
        ];

        $this->assertInstanceOf(
            ProductAttributeList::class,
            $attributes
        );

        $this->assertTrue(
            $attributes->hasAttributes()
        );

        $i = 0;

        /**
         * @var \flyeralarm\ResellerApi\productCatalog\ProductAttribute $attr
         */
        foreach ($attributes as $attr) {
            $this->assertInstanceOf(
                ProductAttribute::class,
                $attr
            );

            $this->assertEquals(
                $checkArray[$i]['id'],
                $attr->getId()
            );

            $this->assertEquals(
                $checkArray[$i]['name'],
                $attr->getName()
            );

            $values = $attr->getPossibleValues();

            $this->assertInstanceOf(
                ProductAttributePossibleValuesList::class,
                $values
            );

            $this->assertTrue(
                $values->hasValues()
            );

            $v1 = $values->getById($checkArray[$i]['possible'][0]['id']);

            $this->assertInstanceOf(
                ProductAttributeValue::class,
                $v1
            );

            $v2 = $values->getById(3);
            $this->assertEquals(
                null,
                $v2
            );

            $j = 0;
            /**
             * @var \flyeralarm\ResellerApi\productCatalog\ProductAttributeValue $value
             */
            foreach ($values as $value) {
                $this->assertInstanceOf(
                    ProductAttributeValue::class,
                    $value
                );

                $this->assertEquals(
                    $checkArray[$i]['possible'][$j]['id'],
                    $value->getId()
                );

                $this->assertEquals(
                    $checkArray[$i]['possible'][$j]['name'],
                    $value->getName()
                );

                $string = (string) $value;

                $this->assertEquals(
                    '[AV#' . $checkArray[$i]['possible'][$j]['id'] .
                    '|' . $checkArray[$i]['possible'][$j]['name'] . ']',
                    $string
                );

                if ($j == 0) {
                    $attr->setSelection($value);

                    $this->assertEquals(
                        $checkArray[$i]['possible'][$j]['id'],
                        $attr->getSelection()->getId()
                    );
                }
                $j++;
            }
            $i++;
        }
    }

    /**
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductAttributeList
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductAttribute
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductAttributePossibleValuesList
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductAttributeValue
     */
    public function testgetAvailableAttributesByPreselectedAttributes()
    {
        $factory = new ProductFactory();
        $loader = new ProductLoader($this->config, $factory);

        $group = $factory->createGroup(2, 'Flyer Klassik', 'group test description', 'test_img.jpg', 'de');

        $attrArray = [
            2798 =>
                [
                    'id' => 2798,
                    'name' => 'Ausführung',
                    'sortvalue' => '1',
                    'descr' => null,
                    'options' =>
                        [
                            14562 =>
                                [
                                    'sortvalue' => '1',
                                    'name' => 'DIN-Format',
                                    'tooltipp' => '',
                                ],
                            14563 =>
                                [
                                    'sortvalue' => '2',
                                    'name' => 'Rechteck',
                                    'tooltipp' => '',
                                ],
                        ]
                ],
            2791 =>
                [
                    'id' => 2791,
                    'name' => 'Format',
                    'sortvalue' => '2',
                    'descr' => null,
                    'options' =>
                        [
                            14582 =>
                                [
                                    'sortvalue' => '1',
                                    'name' => 'DIN A8(5,2 x 7,4 cm)',
                                    'tooltipp' => '',
                                ],
                            14580 =>
                                [
                                    'sortvalue' => '2',
                                    'name' => 'DIN A7(7,4 x 10,5 cm)',
                                    'tooltipp' => '',
                                ],
                        ],
                ]
        ];

        $attributes = $loader->loadAttributeListFromArray($attrArray);

        $attributes->getById(2798)->setSelection($attributes->getById(2798)->getPossibleValues()->getById(14562));

        /**
         * @var ProductAttributeList $newAttribute
         */
        $newAttribute = $this->client->getAvailableAttributesByPreselectedAttributes($group, $attributes);

        $this->assertInstanceOf(
            ProductAttributeList::class,
            $newAttribute
        );

        $this->assertTrue(
            $newAttribute->hasAttributes()
        );

        $this->assertInstanceOf(
            ProductAttribute::class,
            $newAttribute->getById(2798)
        );

        $this->assertInstanceOf(
            ProductAttributeValue::class,
            $newAttribute->getById(2798)->getSelection()
        );

        $this->assertEquals(
            14562,
            $newAttribute->getById(2798)->getSelection()->getId()
        );

        $this->assertInstanceOf(
            ProductAttribute::class,
            $newAttribute->getById(2791)
        );

        $this->assertEquals(
            null,
            $newAttribute->getById(2791)->getSelection()
        );
    }

    /**
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductQuantityOption
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductQuantityOptionList
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductQuantityShippingOption
     */
    public function testGetAvailableQuantitiesByAttributes()
    {
        $factory = new ProductFactory();
        $loader = new ProductLoader($this->config, $factory);

        $group = $factory->createGroup(2, 'Flyer Klassik', 'group test description', 'test_img.jpg', 'de');

        $attrArray = [
            2798 =>
                [
                    'id' => 2798,
                    'name' => 'Ausführung',
                    'sortvalue' => '1',
                    'descr' => null,
                    'options' =>
                        [
                            14562 =>
                                [
                                    'sortvalue' => '1',
                                    'name' => 'DIN-Format',
                                    'tooltipp' => '',
                                ],
                            14563 =>
                                [
                                    'sortvalue' => '2',
                                    'name' => 'Rechteck',
                                    'tooltipp' => '',
                                ],
                        ]
                ],
            2791 =>
                [
                    'id' => 2791,
                    'name' => 'Format',
                    'sortvalue' => '2',
                    'descr' => null,
                    'options' =>
                        [
                            14582 =>
                                [
                                    'sortvalue' => '1',
                                    'name' => 'DIN A8(5,2 x 7,4 cm)',
                                    'tooltipp' => '',
                                ],
                            14580 =>
                                [
                                    'sortvalue' => '2',
                                    'name' => 'DIN A7(7,4 x 10,5 cm)',
                                    'tooltipp' => '',
                                ],
                        ],
                ]
        ];

        $attributes = $loader->loadAttributeListFromArray($attrArray);

        $attributes->getById(2798)->setSelection($attributes->getById(2798)->getPossibleValues()->getById(14562));
        $attributes->getById(2791)->setSelection($attributes->getById(2791)->getPossibleValues()->getById(14582));

        /**
         * @var ProductQuantityOptionList $quantities
         */
        $quantities = $this->client->getAvailableQuantitiesByAttributes($group, $attributes);


        $this->assertInstanceOf(
            ProductQuantityOptionList::class,
            $quantities
        );

        $quantity = $quantities->getByQuantity(50);

        $this->assertInstanceOf(
            ProductQuantityOption::class,
            $quantity
        );

        $this->assertInstanceOf(
            ProductQuantityOption::class,
            $quantities->getByQuantity(100)
        );

        $this->assertEquals(
            null,
            $quantities->getByQuantity(666)
        );

        $this->assertTrue(
            $quantity->hasStandardShipping()
        );

        $this->assertTrue(
            $quantity->hasExpressShipping()
        );

        $this->assertTrue(
            $quantity->hasOvernightShipping()
        );

        $this->assertInstanceOf(
            ProductQuantityShippingOption::class,
            $quantity->getStandardShippingOption()
        );

        $this->assertInstanceOf(
            ProductQuantityShippingOption::class,
            $quantity->getExpressShippingOption()
        );

        $this->assertInstanceOf(
            ProductQuantityShippingOption::class,
            $quantity->getOvernightShippingOption()
        );

        $this->assertEquals(
            10785733,
            $quantity->getStandardShippingOption()->getQuantityID()
        );

        $this->assertEquals(
            10,
            $quantity->getStandardShippingOption()->getDeadline()
        );

        $this->assertEquals(
            20,
            $quantity->getStandardShippingOption()->getFrom()
        );

        $this->assertEquals(
            20,
            $quantity->getStandardShippingOption()->getTo()
        );

        $this->assertEquals(
            'standard',
            $quantity->getStandardShippingOption()->getType()
        );
    }

    /**
     * @covers \flyeralarm\ResellerApi\productCatalog\Product
     */
    public function testFindProductByQuantityId()
    {
        /**
         * @var \flyeralarm\ResellerApi\productCatalog\Product
         */
        $product = $this->client->findProductByQuantityId(10785691);

        $this->assertInstanceOf(
            Product::class,
            $product
        );

        $this->assertEquals(
            10785691,
            $product->getQuantityId()
        );

        $this->assertEquals(
            'DIN A5 (14,8 x 21 cm), 250g Bilderdruck matt, keine Veredelung, DIN-Format',
            $product->getDescription()
        );

        $this->assertEquals(
            'https://unittest.flyeralarm.local/sheets/de/flyer_a5_mass.pdf',
            $product->getDatasheetURI()
        );

        $this->assertEquals(
            310198,
            $product->getProductId()
        );

        $attrs = $product->getAttributes();

        $this->assertTrue(
            $attrs->hasAttributes()
        );

        $this->api_order->setProduct($product);
    }

    /**
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductShippingType
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductShippingTypeList
     */
    public function testGetShippingTypeList()
    {
        $product = $this->client->findProductByQuantityId($this->api_order->getQuantityId());

        $shippingTypes = $this->client->getShippingTypeList($product);

        $this->assertTrue(
            $shippingTypes->hasValues()
        );

        $standard = $shippingTypes->getByName('standard');

        $this->assertInstanceOf(
            ProductShippingType::class,
            $standard
        );

        $this->assertEquals(
            19.18,
            $standard->getNettPrice()
        );

        $this->assertEquals(
            '10',
            $standard->getDeadline()
        );

        $this->assertEquals(
            '20',
            $standard->getFrom()
        );

        $this->assertEquals(
            1,
            $standard->getId()
        );

        $this->assertEquals(
            22.824200000000001,
            $standard->getBruttoPrice()
        );

        $this->assertEquals(
            '20',
            $standard->getTo()
        );

        $this->assertEquals(
            'Standard',
            $standard->getName()
        );

        $express = $shippingTypes->getByName('express');

        $this->assertInstanceOf(
            ProductShippingType::class,
            $express
        );

        $overnight = $shippingTypes->getByName('overnight');

        $this->assertInstanceOf(
            ProductShippingType::class,
            $overnight
        );
    }

    /**
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductOption
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductOptionList
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductOptionPossibleValuesList
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductOptionValue
     */
    public function testGetAvailableProductOptions()
    {
        $product = $this->client->findProductByQuantityId($this->api_order->getQuantityId());

        $checkArray = [
            0 => [
                'id' => 3,
                'name' => 'Datencheck',
                'possible' => [
                    0 => [
                        'id' => 3001,
                        'name' => 'Basis-Datencheck',
                        'description' => 'Datencheck: Basis-Datencheck',
                        'bruttoPrice' => '0,00 €',
                        'nettoPrice' => '0,00 €',
                    ],
                    1 => [
                        'id' => 3002,
                        'name' => 'Profi-Datencheck',
                        'description' => 'Datencheck: Profi-Datencheck',
                        'bruttoPrice' => '5,00 €',
                        'nettoPrice' => '5,95 €',
                    ],
                ],
            ],
            1 => [
                'id' => 9,
                'name' => 'Digitalproof',
                'possible' => [
                    0 => [
                        'id' => 9001,
                        'name' => 'Nein',
                        'description' => 'Digitalproof: Nein',
                        'bruttoPrice' => '0,00 €',
                        'nettoPrice' => '0,00 €',
                    ],
                    1 => [
                        'id' => 9002,
                        'name' => 'Ja',
                        'description' => 'Digitalproof: Ja',
                        'bruttoPrice' => '25,00 €',
                        'nettoPrice' => '29,75 €',
                    ],
                ],
            ],
        ];

        $order = $this->factory->createOrder();
        $order->setProduct($product);

        $productOptions = $this->client->getAvailableProductOptions($order);

        $this->assertInstanceOf(
            ProductOptionList::class,
            $productOptions
        );

        $this->assertTrue(
            $productOptions->hasValues()
        );

        $o1 = $productOptions->getById(3);

        $this->assertInstanceOf(
            ProductOption::class,
            $o1
        );

        $o2 = $productOptions->getById(666);

        $this->assertEquals(
            null,
            $o2
        );

        $i = 0;
        /**
         * @var ProductOption $pOption
         */
        foreach ($productOptions as $pOption) {
            $this->assertInstanceOf(
                ProductOption::class,
                $pOption
            );

            $this->assertEquals(
                $checkArray[$i]['id'],
                $pOption->getOptionId()
            );

            $this->assertEquals(
                $checkArray[$i]['name'],
                $pOption->getName()
            );

            $possible = $pOption->getPossibleValues();

            $this->assertTrue(
                $possible->hasValues()
            );

            $this->assertInstanceOf(
                ProductOptionPossibleValuesList::class,
                $possible
            );

            $v1 = $possible->getById($checkArray[$i]['possible'][0]['id']);

            $this->assertInstanceOf(
                ProductOptionValue::class,
                $v1
            );

            $v2 = $possible->getById(666);

            $this->assertEquals(
                null,
                $v2
            );

            $j = 0;
            /**
             * @var ProductOptionValue $value
             */
            foreach ($possible as $value) {
                $this->assertInstanceOf(
                    ProductOptionValue::class,
                    $value
                );

                $this->assertEquals(
                    $checkArray[$i]['possible'][$j]['id'],
                    $value->getOptionValueId()
                );

                $this->assertEquals(
                    $checkArray[$i]['possible'][$j]['name'],
                    $value->getName()
                );

                $this->assertEquals(
                    $checkArray[$i]['possible'][$j]['description'],
                    $value->getDescription()
                );

                $this->assertEquals(
                    $checkArray[$i]['possible'][$j]['bruttoPrice'],
                    $value->getBruttoPrice()
                );

                $this->assertEquals(
                    $checkArray[$i]['possible'][$j]['nettoPrice'],
                    $value->getNettoPrice()
                );

                $pOption->setSelection($value);

                $this->assertEquals(
                    $checkArray[$i]['possible'][$j]['id'],
                    $pOption->getSelection()->getOptionValueId()
                );
                $j++;
            }
            $i++;
        }
    }

    /**
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductShippingOption
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductShippingOptionList
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductShippingOptionUpgrade
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductShippingOptionUpgradeList
     */
    public function testGetAvailableShippingOptions()
    {
        $shippingOptions = $this->client->getAvailableShippingOptions($this->api_order);

        $checkArray = [
            0 =>
                [
                    'id' => '1',
                    'name' => 'Versand via UPS',
                    'defaultName' => 'Versand via UPS',
                    'price' => 0,
                    'priceWithTax' => 0,
                    'upgrades' => [
                        0 => [
                            'id' => 1001,
                            'name' => 'Samstags- Zustellung',
                            'defaultName' => 'Samstags- Zustellung',
                            'price' => 35,
                            'priceWithTax' => 40
                        ]
                    ]
                ],
            1 =>
                [
                    'id' => '4',
                    'name' => 'Würzburg',
                    'defaultName' => 'Würzburg',
                    'price' => 0,
                    'priceWithTax' => 0,
                ],
        ];

        $this->assertInstanceOf(
            ProductShippingOptionList::class,
            $shippingOptions
        );

        $i = 0;
        /**
         * @var ProductShippingOption $so
         */
        foreach ($shippingOptions as $so) {
            $this->assertInstanceOf(
                ProductShippingOption::class,
                $so
            );

            $this->assertEquals(
                $checkArray[$i]['id'],
                $so->getId()
            );

            $this->assertEquals(
                $checkArray[$i]['name'],
                $so->getName()
            );

            $this->assertEquals(
                $checkArray[$i]['defaultName'],
                $so->getDefaultName()
            );

            $this->assertEquals(
                $checkArray[$i]['price'],
                $so->getPrice()
            );

            $this->assertEquals(
                $checkArray[$i]['priceWithTax'],
                $so->getPriceWithTax()
            );

            $this->assertEquals(
                $checkArray[$i]['price'],
                $so->getBruttoPrice()
            );

            $this->assertEquals(
                $checkArray[$i]['priceWithTax'],
                $so->getNettoPrice()
            );

            $su = $so->getUpgrades();
            if (isset($checkArray[$i]['upgrades']) && is_array($checkArray[$i]['upgrades'])) {
                $this->assertInstanceOf(
                    ProductShippingOptionUpgradeList::class,
                    $su
                );

                $this->assertTrue(
                    $su->hasValues()
                );

                $suo = $su->getById(1001);

                $this->assertInstanceOf(
                    ProductShippingOptionUpgrade::class,
                    $suo
                );

                $this->assertInstanceOf(
                    ProductShippingOptionUpgrade::class,
                    $su->getByName('Samstags- Zustellung')
                );

                $this->assertEquals(
                    $checkArray[$i]['upgrades'][0]['id'],
                    $suo->getId()
                );

                $this->assertEquals(
                    $checkArray[$i]['upgrades'][0]['name'],
                    $suo->getName()
                );

                $this->assertEquals(
                    $checkArray[$i]['upgrades'][0]['defaultName'],
                    $suo->getDefaultName()
                );

                $this->assertEquals(
                    $checkArray[$i]['upgrades'][0]['price'],
                    $suo->getPrice()
                );

                $this->assertEquals(
                    $checkArray[$i]['upgrades'][0]['price'],
                    $suo->getBruttoPrice()
                );

                $this->assertEquals(
                    $checkArray[$i]['upgrades'][0]['priceWithTax'],
                    $suo->getPriceWithTax()
                );

                $this->assertEquals(
                    $checkArray[$i]['upgrades'][0]['priceWithTax'],
                    $suo->getNettoPrice()
                );
            } else {
                $this->assertEquals(
                    null,
                    $su
                );
            }

            $i++;
        }

        $so1 = $shippingOptions->getById('4');

        $this->assertInstanceOf(
            ProductShippingOption::class,
            $so1
        );

        $so1 = $shippingOptions->getByName('Versand via UPS');

        $this->assertInstanceOf(
            ProductShippingOption::class,
            $so1
        );

        $so1 = $shippingOptions->getById('666');

        $this->assertEquals(
            null,
            $so1
        );

        $so1 = $shippingOptions->getByName('SomeNonExistingName');

        $this->assertEquals(
            null,
            $so1
        );

        $this->assertTrue(
            $shippingOptions->hasValues()
        );
    }

    /**
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductPaymentOption
     * @covers \flyeralarm\ResellerApi\productCatalog\ProductPaymentOptionList
     */
    public function testGetAvailablePaymentOptions()
    {
        $paymentOptions = $this->client->getAvailablePaymentOptions($this->api_order);

        $checkArray = [
            0 =>
                [
                    'id' => 1,
                    'name' => 'Vorauskasse',
                    'price' => 0,
                    'serviceFee' => 0,
                ],
            1 =>
                [
                    'id' => 5,
                    'name' => 'Barnachnahme',
                    'price' => 5.75,
                    'serviceFee' => 0,
                ]
        ];

        $this->assertInstanceOf(
            ProductPaymentOptionList::class,
            $paymentOptions
        );

        $this->assertTrue(
            $paymentOptions->hasValues()
        );

        $i = 0;
        /**
         * @var ProductPaymentOption $po
         */
        foreach ($paymentOptions as $po) {
            $this->assertInstanceOf(
                ProductPaymentOption::class,
                $po
            );

            $this->assertEquals(
                $checkArray[$i]['id'],
                $po->getId()
            );

            $this->assertEquals(
                $checkArray[$i]['name'],
                $po->getName()
            );

            $this->assertEquals(
                $checkArray[$i]['price'],
                $po->getPrice()
            );

            $this->assertEquals(
                $checkArray[$i]['serviceFee'],
                $po->getServiceFee()
            );

            $i++;
        }

        $po1 = $paymentOptions->getById(5);

        $this->assertInstanceOf(
            ProductPaymentOption::class,
            $po1
        );

        $po1 = $paymentOptions->getByName('Vorauskasse');

        $this->assertInstanceOf(
            ProductPaymentOption::class,
            $po1
        );

        $po1 = $paymentOptions->getById(666);

        $this->assertEquals(
            null,
            $po1
        );

        $po1 = $paymentOptions->getByName('SomeNonExistingName');

        $this->assertEquals(
            null,
            $po1
        );
    }

    public function testSendFullOrder()
    {
        $orderId = $this->client->sendFullOrder($this->api_order);

        $this->assertEquals(
            'DE001234567',
            $orderId
        );
    }

    public function testGetOrderStatus()
    {
        $orderStatus = $this->client->getOrderStatus('DE001234567');

        $this->assertEquals(
            [
                0 =>
                    [
                        'orderId' => 'DE001234567',
                        'statusId' => '42',
                        'status' => 'Daten gehen in Druck',
                        'parcelamount' => 0,
                    ],
            ],
            $orderStatus
        );
    }

    public function testCreateUploadTarget()
    {
        $return = $this->client->createUploadTarget('curl_test.txt', 1234, 'DE001234567');

        $this->assertEquals(
            null,
            $return
        );
    }

    public function testUploadFileByPaths()
    {
        $return = $this->client->uploadFileByPaths('/curl_test.txt', __DIR__ . '/../stubs/curl_test.txt');

        $this->assertEquals(
            null,
            $return
        );
    }

    public function testCurrentPriceTest()
    {
        $api_order = $this->factory->createOrder();
        $api_order->loadByPersistencyString(
            'eJyrVirMVLIyBAJLc1MDHaXiEiA3rzQnR0epID8RxkzMgbMygKqByvKRlMGZxaVwJoJVBDcluVzJysgAaEky0BBjY4NaAE1dJck='
        );

        $netPrice = $this->client->getCurrentNetPrice($api_order);

        $this->assertEquals(
            45.11,
            $netPrice
        );

        $grossPrice = $this->client->getCurrentGrossPrice($api_order);

        $this->assertEquals(
            48.31,
            $grossPrice
        );
    }
}
