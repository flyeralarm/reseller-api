<?php

namespace flyeralarm\ResellerApi\client;

use flyeralarm\ResellerApi\config\AbstractConfig;
use flyeralarm\ResellerApi\config\TestDE_Internal as Config;
use flyeralarm\ResellerApi\client\Api as ApiClient;
use flyeralarm\ResellerApi\config\TestDEInternal;

/**
 * @covers \flyeralarm\ResellerApi\client\Factory
 * @covers \flyeralarm\ResellerApi\client\Api as ApiClient
 */
class FactoryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers \flyeralarm\ResellerApi\client\AddressList
     */
    public function testCreateAddressList()
    {
        $c = new TestDEInternal();

        $f = new Factory($c);

        $al = $f->createAddressList();

        $this->assertInstanceOf(
            AddressList::class,
            $al
        );
    }

    /**
     * @covers \flyeralarm\ResellerApi\client\Order
     */
    public function testCreateOrder()
    {
        $c = new TestDEInternal();
        $f = new Factory($c);
        $o = $f->createOrder();

        $this->assertInstanceOf(
            Order::class,
            $o
        );
    }

    /**
     * @covers \flyeralarm\ResellerApi\client\UploadInfo
     */
    public function testCreateUploadInfo()
    {
        date_default_timezone_set('Europe/Berlin');

        $c = new TestDEInternal();
        $f = new Factory($c);
        $string = '9753 - Some - UNIT TEST String';
        $ui = $f->createUploadInfo($string);

        $this->assertInstanceOf(
            UploadInfo::class,
            $ui
        );
    }

    /**
     * @covers \flyeralarm\ResellerApi\client\Factory
     */
    public function testCreateClient()
    {
        $c = new TestDEInternal();

        $f = new Factory($c);

        $api = $f->createClient();

        $this->assertInstanceOf(
            ApiClient::class,
            $api
        );
    }
}
