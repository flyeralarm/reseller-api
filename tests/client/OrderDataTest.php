<?php

namespace flyeralarm\ResellerApi\client;

use ClientFactoryMock;
use ConfigMock;
use flyeralarm\ResellerApi\productCatalog\Factory as ProductFactory;
use flyeralarm\ResellerApi\productCatalog\Loader as ProductLoader;
use flyeralarm\ResellerApi\productCatalog\ProductShippingOption;
use flyeralarm\ResellerApi\productCatalog\ProductShippingOptionUpgrade;
use flyeralarm\ResellerApi\productCatalog\ProductPaymentOption;
use flyeralarm\ResellerApi\exception\OrderPersistencyData as OrderPersistencyDataException;

/**
 * @covers \flyeralarm\ResellerApi\client\Api
 * @covers \flyeralarm\ResellerApi\productCatalog\Loader
 * @covers \flyeralarm\ResellerApi\productCatalog\Factory
 * @covers \flyeralarm\ResellerApi\client\Factory
 * @covers \flyeralarm\ResellerApi\client\Order
 * @covers \flyeralarm\ResellerApi\client\Address
 * @covers \flyeralarm\ResellerApi\client\AddressList
 * @covers \flyeralarm\ResellerApi\client\UploadInfo
 * @covers \flyeralarm\ResellerApi\lib\AbstractList
 * @covers \flyeralarm\ResellerApi\exception\OrderPersistencyData
 * @covers \flyeralarm\ResellerApi\exception\General
 * @covers \flyeralarm\ResellerApi\exception\Connection
 * @covers \flyeralarm\ResellerApi\exception\ArrayAccess
 * @covers \flyeralarm\ResellerApi\exception\DataStructure
 */
class OrderDataTest extends \PHPUnit\Framework\TestCase
{
    public function testOrder()
    {
        $config = new ConfigMock();
        $config->setResellerUserEmail('test@local.com')
            ->setResellerUserPassword('<some-test-pw>')
            ->setUserToken('12345678901234567890')
            ->setAppToken('09876543210987654321');


        $factory = new ClientFactoryMock($config);


        $order = $factory->createOrder();
        $order->loadByPersistencyString(
            'eJzlU8tywjAM/JWMrg2MTcIjufEB5VI6vfQibAU849ipHxTK8O+1odBpP6G'.
            '9rVZaeWXLJ3hT0HI2X0xnDS/BhxROShgsQmui1iWghvYEnowkl5Gw/YDmCC1ACdsvGnrUlOJOOR9W2FOiHvGQGI3fRPSBXI/G'.
            'JB6ldOR9ope6cyRHK7shPXoKDl8jY7Kjgi++65ZS3gwN1gdhZe7YzNmcpSKhQjb0kpWdcB+b6LaZttHkxFWnrcgmb1121hBP'.
            'ooe6aSpez6aLGs4lSNJqT+74D0ZVZm+VoD8/aRoVd9BWab1tWm/gkM/Le5+YqG7ijE4gMeDaofEdufVxyIbioC3KJPqRU5f'.
            'xeTVm1XjC+Lzgs3Zat4z9LqRDyBcSg+0xKFE8X9oVe4XFclDj/BLu/tvE+x3truj8CR0JJ/E='
        );

        $this->assertEquals(
            10785691,
            $order->getQuantityId()
        );

        $this->assertEquals(
            1,
            $order->getShippingOptionId()
        );

        $this->assertEquals(
            2,
            $order->getShippingTypeId()
        );

        $this->assertEquals(
            null,
            $order->getResellerPrice()
        );

        $this->assertEquals(
            null,
            $order->getShippingUpgradeId()
        );

        $this->assertEquals(
            null,
            $order->getProductOptionsArray()
        );

        $this->assertEquals(
            3,
            $order->getAddressHandling()
        );

        $checkAddress = [
            'sender' =>
                [
                    'customertype' => null,
                    'vatnumber' => null,
                    'taxnumber' => null,
                    'company' => '',
                    'gender' => 'male',
                    'firstName' => 'Max',
                    'lastName' => 'Mustermann',
                    'address' => 'Alfred-Nobel-Straße 18',
                    'addressAdd' => null,
                    'postcode' => '97070',
                    'city' => 'Würzburg',
                    'county' => null,
                    'locale' => null,
                    'phone1' => '+4993146584',
                ],
            'delivery' =>
                [
                    'customertype' => null,
                    'vatnumber' => null,
                    'taxnumber' => null,
                    'company' => '',
                    'gender' => 'male',
                    'firstName' => 'Max',
                    'lastName' => 'Mustermann',
                    'address' => 'Alfred-Nobel-Straße 18',
                    'addressAdd' => null,
                    'postcode' => '97070',
                    'city' => 'Würzburg',
                    'county' => null,
                    'locale' => null,
                    'phone1' => '+4993146584',
                ],
            'invoice' =>
                [
                    'customertype' => null,
                    'vatnumber' => null,
                    'taxnumber' => null,
                    'company' => '',
                    'gender' => 'male',
                    'firstName' => 'Max',
                    'lastName' => 'Mustermann',
                    'address' => 'Alfred-Nobel-Straße 18',
                    'addressAdd' => null,
                    'postcode' => '97070',
                    'city' => 'Würzburg',
                    'county' => null,
                    'locale' => null,
                    'phone1' => '+4993146584',
                ],
        ];
        $this->assertEquals(
            $checkAddress,
            $order->getAddressList()->getArray()
        );

        $this->assertEquals(
            null,
            $order->getProductOptions()
        );

        $this->assertEquals(
            null,
            $order->getShippingOption()
        );

        $this->assertEquals(
            null,
            $order->getShippingType()
        );

        $this->assertEquals(
            null,
            $order->getProduct()
        );

        $this->assertEquals(
            null,
            $order->getCustomHeight()
        );

        $this->assertEquals(
            null,
            $order->getCustomWidth()
        );

        $this->assertInstanceOf(
            UploadInfo::class,
            $order->getUploadInfo()
        );

        date_default_timezone_set('Europe/Berlin');

        $infoCheck = [
            'dataTransferType' => 'upload',
            'dataTransferTime' => date('d.m.Y H:i:s'),
            'dataTransferText' => 'Automatic Upload via Api.',
            'referenceText' => 'Automatic Upload via Api.',
        ];

        $this->assertEquals(
            $infoCheck,
            $order->getUploadInfo()->getArray()
        );
    }


    public function testSetters()
    {
        $config = new ConfigMock();
        $config->setResellerUserEmail('test@local.com')
            ->setResellerUserPassword('<some-test-pw>')
            ->setUserToken('12345678901234567890')
            ->setAppToken('09876543210987654321');

        $factory = new ProductFactory();
        $loader = new ProductLoader($config, $factory);

        $cfactory = new ClientFactoryMock($config);

        $order = $cfactory->createOrder();

        $shippingType = $loader->loadShippingTypeFromArray(
            [
                '_id' => 12345,
                '_name' => 'Standard',
                '_from' => '20',
                '_to' => '20',
                '_deadline' => '10',
                '_price_netto' => 19.18,
                '_price_brutto' => 22.824200000000001,
            ]
        );

        $order->setShippingType($shippingType);

        $this->assertEquals(
            12345,
            $order->getShippingTypeId()
        );

        $pol = $loader->loadOptionsListFromArray(
            [
                3 =>
                    [
                        'name' => 'Datencheck',
                        'options' =>
                            [
                                3001 =>
                                    [
                                        'name' => 'Basis-Datencheck',
                                        'description' => 'Datencheck: Basis-Datencheck',
                                        'bruttoPrice' => '0,00 €',
                                        'nettoPrice' => '0,00 €',
                                    ],
                                3002 =>
                                    [
                                        'name' => 'Profi-Datencheck',
                                        'description' => 'Datencheck: Profi-Datencheck',
                                        'bruttoPrice' => '5,00 €',
                                        'nettoPrice' => '5,95 €',
                                    ],
                            ],
                    ]
            ]
        );

        $pol->getById(3)->setSelection($pol->getById(3)->getPossibleValues()->getById(3001));

        $order->setProductOptions($pol);

        $this->assertEquals(
            [3 => 3001],
            $order->getProductOptionsArray()
        );

        $al = $cfactory->createAddressList();

        $order->setAddressList($al);

        $this->assertInstanceOf(
            AddressList::class,
            $order->getAddressList()
        );

        $so = $factory->createShippingOption(99, 'test', 'Test', 123, 156);

        $order->setShippingOption($so);

        $this->assertInstanceOf(
            ProductShippingOption::class,
            $order->getShippingOption()
        );

        $su = $factory->createShippingOptionUpgrade(999, 'test', 'Test', 123, 156);

        $order->setShippingUpgrade($su);

        $this->assertEquals(
            999,
            $order->getShippingUpgradeId()
        );

        $this->assertInstanceOf(
            ProductShippingOptionUpgrade::class,
            $order->getShippingUpgrade()
        );

        $payo = $factory->createPaymentOption(345, 'paytest', 234, 345);

        $order->setPaymentOption($payo);

        $this->assertInstanceOf(
            ProductPaymentOption::class,
            $order->getPaymentOption()
        );

        $ui = $cfactory->createUploadInfo('A test Text');
        $ui->setDateToNow();

        $order->setUploadInfo($ui);
        $order->setResellerPrice(6789);
        $order->setCustomHeight(3344);
        $order->setCustomWidth(6677);

        $this->assertInstanceOf(
            UploadInfo::class,
            $order->getUploadInfo()
        );

        $order->setAddressHandlingUseSenderFromAddressList();

        $this->assertEquals(
            3,
            $order->getAddressHandling()
        );

        $order->setAddressHandlingUseNeutralAsSender();

        $this->assertEquals(
            2,
            $order->getAddressHandling()
        );

        $order->setAddressHandlingUseFlyeralarmAsSender();

        $this->assertEquals(
            1,
            $order->getAddressHandling()
        );

        $this->assertEquals(
            6789,
            $order->getResellerPrice()
        );

        $this->assertEquals(
            3344,
            $order->getCustomHeight()
        );

        $this->assertEquals(
            6677,
            $order->getCustomWidth()
        );
    }

    public function testFaultyPersistencyString()
    {
        $config = new ConfigMock();
        $config->setResellerUserEmail('test@local.com')
            ->setResellerUserPassword('<some-test-pw>')
            ->setUserToken('12345678901234567890')
            ->setAppToken('09876543210987654321');


        $factory = new ClientFactoryMock($config);

        $order = $factory->createOrder();

        $this->expectException(OrderPersistencyDataException::class);
        $order->loadByPersistencyString("uselessString!");
    }

    public function testFaultyPersistencyString2()
    {
        $config = new ConfigMock();
        $config->setResellerUserEmail('test@local.com')
            ->setResellerUserPassword('<some-test-pw>')
            ->setUserToken('12345678901234567890')
            ->setAppToken('09876543210987654321');


        $factory = new ClientFactoryMock($config);

        $order = $factory->createOrder();


        $this->expectException(OrderPersistencyDataException::class);
        $order->loadByPersistencyString(
            'eJyrVirMVLIyNDC3MDWzNNRRKi4Bco10lAryE5Ws8kpzcnSUEjOUrIyBMvlAGSVDJZ'.
            'AcSAtQpDQTpqYIrjq5HM7KgLBqAXdvHVc='
        );
    }
}
