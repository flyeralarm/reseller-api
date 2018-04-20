<?php

namespace flyeralarm\ResellerApi\lib;

use ClientFactoryMock;
use ConfigMock;
use flyeralarm\ResellerApi\productCatalog\Factory as ProductFactory;
use flyeralarm\ResellerApi\productCatalog\Loader as ProductLoader;
use flyeralarm\ResellerApi\productCatalog\GroupList;
use flyeralarm\ResellerApi\productCatalog\Group;
use flyeralarm\ResellerApi\exception\ArrayAccess as ArrayAccessException;

/**
 * @covers \flyeralarm\ResellerApi\lib\AbstractList
 */
class ArrayInterfaceTest extends \PHPUnit\Framework\TestCase
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

    /**
     * @var GroupList $group
     */
    private $group;

    public function setUp()
    {

        $this->config = new ConfigMock();
        $this->config->setResellerUserEmail('test@local.com')
            ->setResellerUserPassword('<some-test-pw>')
            ->setUserToken('12345678901234567890')
            ->setAppToken('09876543210987654321');

        $this->factory = new ProductFactory();
        $this->loader = new ProductLoader($this->config, $this->factory);

        $this->group = $this->loader->loadGroupListFromArray(
            [
                0 =>
                    [
                        'productgroup_id' => '1',
                        'internalName' => 'old-werbetechnik:sitzsack, nur druck',
                        'tid_technicalDetail' => '23898',
                        'tid_seotext' => null,
                        'tid_pagetitle' => null,
                        'tid_parentSites' => '23899',
                        'tid_metakeywords' => null,
                        'tid_metadescription' => null,
                        'tid_importantHint' => null,
                        'created' => '2016-10-13 14:42:56',
                        'pictureUrl' => null,
                        'recoPictureUrl' =>
                            '/images/upload/content/products/Sitzsack/flyeralarm-sitzsack-nurdruck-260x260.jpg',
                        '_language' => 'de',
                        '_name' => 'Sitzsack, nur Druck',
                        '_description' => 'some HTML',
                        '_image' => '/images/upload/content/products/Sitzsack/flyeralarm-sitzsack-nurdruck-260x260.jpg',
                        '_technicalDetail' => '<strong>Material:</strong> 220g Polyestergewebe (100% Polyester)',
                        '_seotext' => '',
                        '_parentSites' => 'bread crumbs ...',
                        '_pagetitle' => '',
                        '_metakeywords' => '',
                        '_metadescription' => '',
                        '_importantHint' => '',
                    ],
                1 =>
                    [
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
                        'recoPictureUrl' =>
                            '/images/upload/content/images/products/flyer/' .
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
                    ]
            ]
        );
    }

    public function testOffsetExists()
    {
        $this->assertEquals(
            false,
            $this->group->offsetExists(3)
        );
    }

    public function testOffsetGet()
    {
        $this->assertEquals(
            null,
            $this->group->offsetGet(3)
        );


        $this->assertInstanceOf(
            Group::class,
            $this->group->offsetGet(1)
        );
    }

    public function testOffsetSet()
    {
        $this->expectException(ArrayAccessException::class);
        $this->group->offsetSet(4, 'sdf');
    }

    public function testOffsetUnset()
    {
        $this->assertInstanceOf(
            Group::class,
            $this->group->offsetGet(1)
        );

        $this->group->offsetUnset(1);

        $this->assertEquals(
            null,
            $this->group->offsetGet(1)
        );
    }


    public function testCount()
    {
        $this->assertEquals(
            2,
            $this->group->count()
        );
    }

    public function testKey()
    {
        $this->assertEquals(
            0,
            $this->group->key()
        );
    }
}
