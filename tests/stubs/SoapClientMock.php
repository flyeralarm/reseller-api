<?php

class SoapClientMock extends SoapClient
{

    private $last_login = false;

    public function __call($function_name, $arguments)
    {
        switch ($function_name) {
        case 'login':
            if ($arguments[0] == 'test@local.com' && $arguments[1] == '<some-test-pw>') {
                $this->last_login = true;

                return true;
            }
            $this->last_login = false;
            throw new Exception('SOAP Error ... Access denied.', 999);
                break;

        case 'loggedIn':
            return $this->last_login;

        case 'getProductGroupIds':
            return array(
                    0 =>
                        array(
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
                            'recoPictureUrl' => '/images/upload/content/products/Sitzsack/flyeralarm-sitzsack-nurdruck-260x260.jpg',
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
                        ),
                    1 =>
                        array(
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
                            'recoPictureUrl' => '/images/upload/content/images/products/flyer/countries/flyeralarm-flyer-klassiker-583x335-config-hu.jpg',
                            '_language' => 'de',
                            '_name' => 'Flyer Klassiker',
                            '_description' => 'some HTML will go here',
                            '_image' => '/images/upload/content/images/products/flyer/config/flyeralarm-flyer-klassiker-240x200-config.jpg',
                            '_technicalDetail' => '',
                            '_seotext' => 'some seo text',
                            '_parentSites' => 'bread crumbs',
                            '_pagetitle' => 'Flyer Klassiker günstig drucken bei FLYERALARM',
                            '_metakeywords' => '',
                            '_metadescription' => '',
                            '_importantHint' => '',
                        ),
                    2 =>
                        array(
                            'productgroup_id' => '3',
                            'internalName' => 'old-plattendruck:aluminiumverbundplatte im wunschformat',
                            'tid_technicalDetail' => '21435',
                            'tid_seotext' => null,
                            'tid_pagetitle' => '21436',
                            'tid_parentSites' => '21437',
                            'tid_metakeywords' => null,
                            'tid_metadescription' => null,
                            'tid_importantHint' => null,
                            'created' => '2015-01-19 10:24:45',
                            'pictureUrl' => null,
                            'recoPictureUrl' => '/images/upload/content/products/plattendruck/Aluminiumverbundplatte%20weiss/flyeralarm-plattendruck-aluverbundplatte-weiss-wunschformat-920x600.jpg',
                            '_language' => 'de',
                            '_name' => 'Aluminiumverbundplatte weiß im Wunschformat ',
                            '_description' => 'some HTML Code will go here.',
                            '_image' => '/images/upload/content/images/products/flyer/config/flyeralarm-flyer-klassiker-240x200-config.jpg',
                            '_technicalDetail' => '',
                            '_seotext' => 'some seo text',
                            '_parentSites' => 'bread crumbs',
                            '_pagetitle' => 'Weiße Aluminiumverbundplatte im Wunschformat kaufen',
                            '_metakeywords' => '',
                            '_metadescription' => '',
                            '_importantHint' => '',
                        )
                );

        case 'getProductAttributesByGroupId':
        case 'getAvailableAttributesByPreselectedAttributes':
            return array(
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
                                ),
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

        case 'getAvailableQuantitiesByAttributes':
            return array(
                    'quantity_50' =>
                        array(
                            'standard' =>
                                array(
                                    'id' => 10785733,
                                    'shipping' =>
                                        array(
                                            'deadline' => 10,
                                            'from' => 20,
                                            'to' => 20,
                                        ),
                                ),
                            'express' =>
                                array(
                                    'id' => 10785733,
                                    'shipping' =>
                                        array(
                                            'deadline' => 10,
                                            'from' => 2,
                                            'to' => 2,
                                        ),
                                ),
                            'overnight' =>
                                array(
                                    'id' => 10785733,
                                    'shipping' =>
                                        array(
                                            'deadline' => 10,
                                            'from' => 2,
                                            'to' => 2,
                                        ),
                                ),
                        ),
                    'quantity_100' =>
                        array(
                            'standard' =>
                                array(
                                    'id' => 10785691,
                                    'shipping' =>
                                        array(
                                            'deadline' => 10,
                                            'from' => 20,
                                            'to' => 20,
                                        ),
                                ),
                            'express' =>
                                array(
                                    'id' => 10785691,
                                    'shipping' =>
                                        array(
                                            'deadline' => 10,
                                            'from' => 2,
                                            'to' => 2,
                                        ),
                                ),
                            'overnight' =>
                                array(
                                    'id' => 10785691,
                                    'shipping' =>
                                        array(
                                            'deadline' => 10,
                                            'from' => 2,
                                            'to' => 2,
                                        ),
                                )
                        ),
                );

        case 'findProductByQuantityId':
            return array(
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
                                ),
                            1 =>
                                array(
                                    'attributeGroupId' => 2794,
                                    'attributeGroupName' => 'Material',
                                    'attributeId' => 14596,
                                    'attributeName' => '250g Bilderdruck matt',
                                ),
                            2 =>
                                array(
                                    'attributeGroupId' => 2795,
                                    'attributeGroupName' => 'Veredelung',
                                    'attributeId' => 15965,
                                    'attributeName' => 'keine Veredelung',
                                ),
                            3 =>
                                array(
                                    'attributeGroupId' => 2798,
                                    'attributeGroupName' => 'Ausführung',
                                    'attributeId' => 14562,
                                    'attributeName' => 'DIN-Format',
                                ),
                        ),
                );

        case 'addProductToCart':
            return array(
                    0 =>
                        array(
                            '_id' => 1,
                            '_name' => 'Standard',
                            '_from' => '20',
                            '_to' => '20',
                            '_deadline' => '10',
                            '_price_netto' => 19.18,
                            '_price_brutto' => 22.824200000000001,
                        ),
                    1 =>
                        array(
                            '_id' => 2,
                            '_name' => 'Express',
                            '_from' => '2',
                            '_to' => '2',
                            '_deadline' => '10',
                            '_price_netto' => 29.18,
                            '_price_brutto' => 34.724200000000003,
                        ),
                    2 =>
                        array(
                            '_id' => 3,
                            '_name' => 'Overnight',
                            '_from' => '2',
                            '_to' => '2',
                            '_deadline' => '10',
                            '_price_netto' => 49.18,
                            '_price_brutto' => 54.724200000000003,
                        ),
                );

        case 'getAvailableProductOptions':
            return array(
                    3 =>
                        array(
                            'name' => 'Datencheck',
                            'options' =>
                                array(
                                    3001 =>
                                        array(
                                            'name' => 'Basis-Datencheck',
                                            'description' => 'Datencheck: Basis-Datencheck',
                                            'bruttoPrice' => '0,00 €',
                                            'nettoPrice' => '0,00 €',
                                        ),
                                    3002 =>
                                        array(
                                            'name' => 'Profi-Datencheck',
                                            'description' => 'Datencheck: Profi-Datencheck',
                                            'bruttoPrice' => '5,00 €',
                                            'nettoPrice' => '5,95 €',
                                        ),
                                ),
                        ),
                    9 =>
                        array(
                            'name' => 'Digitalproof',
                            'options' =>
                                array(
                                    9001 =>
                                        array(
                                            'name' => 'Nein',
                                            'description' => 'Digitalproof: Nein',
                                            'bruttoPrice' => '0,00 €',
                                            'nettoPrice' => '0,00 €',
                                        ),
                                    9002 =>
                                        array(
                                            'name' => 'Ja',
                                            'description' => 'Digitalproof: Ja',
                                            'bruttoPrice' => '25,00 €',
                                            'nettoPrice' => '29,75 €',
                                        ),
                                ),
                        )
                );

        case 'getAvailableShippingOptions':
            return array(
                    'shippingoptions' =>
                        array(
                            0 =>
                                array(
                                    'id' => '1',
                                    'name' => 'Versand via UPS',
                                    'defaultName' => 'Versand via UPS',
                                    'price' => 0,
                                    'priceWithTax' => 0,
                                    'upgrades' => array(
                                        array(
                                            'id' => 1001,
                                            'name' => 'Samstags- Zustellung',
                                            'defaultName' => 'Samstags- Zustellung',
                                            'price' => 35,
                                            'priceWithTax' => 40
                                        )
                                    )
                                ),
                            1 =>
                                array(
                                    'id' => '4',
                                    'name' => 'Würzburg',
                                    'defaultName' => 'Würzburg',
                                    'price' => 0,
                                    'priceWithTax' => 0,
                                ),
                        ),
                    'customertypes' =>
                        array(),
                );

        case 'getAvailablePaymentOptions':
            return array(
                    0 =>
                        array(
                            'id' => 1,
                            'name' => 'Vorauskasse',
                            'price' => 0,
                            'serviceFee' => 0,
                        ),
                    1 =>
                        array(
                            'id' => 5,
                            'name' => 'Barnachnahme',
                            'price' => 5.75,
                            'serviceFee' => 0,
                        )
                );
        case 'getCurrentCart':
              return
                  array(
                      "netPrice" =>  45.11,
                      "provisionValue" => "-10.00",
                      "priceProvisionNet" => 40.6,
                      "tax" => 7.71,
                      "grossPrice" => 48.31,
                      "carts" =>
                          array(
                              0 => array(
                                  "quantityId" => 11119750,
                                  "shippingType" => 1,
                                  "created" => "2019-04-25 13:42:24",
                                  "quantity" => 100
                              )
                          )
                  );
        case 'sendFullOrder':
            return 'DE001234567';

        case 'getOrderStatus':
            return array(
                    0 =>
                        array(
                            'orderId' => 'DE001234567',
                            'statusId' => '42',
                            'status' => 'Daten gehen in Druck',
                            'parcelamount' => 0,
                        ),
                );

        default:
            return false;
        }


    }

    public function __construct($wsdl, $options = null)
    {

    }

    public function __doRequest($request, $location, $action, $version, $one_way = 0)
    {

    }

    public function __getFunctions()
    {

    }

    public function __getLastRequest()
    {

    }

    public function __getLastRequestHeaders()
    {

    }

    public function __getLastResponse()
    {

    }

    public function __getLastResponseHeaders()
    {
        // Required for cookies
        return "HTTP/1.1 200 OK
Server: nginx
Date: Mon, 13 Mar 2017 10:26:19 GMT
Content-Type: text/xml; charset=utf-8
Content-Length: 531
Connection: keep-alive
Expires: Thu, 19 Nov 1981 08:52:00 GMT
Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0
Pragma: no-cache
Set-Cookie: FlyFE_de_language=de; expires=Tue, 13-Mar-2018 10:26:19 GMT; Max-Age=31536000; path=/; secure; httponly
Set-Cookie: FA_COMMERCE_LOCALE=de_DE; expires=Tue, 13-Mar-2018 10:26:19 GMT; Max-Age=31536000; path=/; secure; httponly
Set-Cookie: FlyFE_de_user=deleted; expires=Thu, 01-Jan-1970 00:00:01 GMT; Max-Age=0; path=/; secure; httponly
Set-Cookie: FlyFE_de_cartItems=0%2F10; expires=Wed, 15-Mar-2017 10:26:19 GMT; Max-Age=172800; path=/; secure
Set-Cookie: FlyFE_de=test3lqp8nh80j8jevue3mtea1radl6n; path=/; secure; HttpOnly
Set-Cookie: FlyFE_de_user=testYW4uc2NoYXBmbEBmbHllcmFsYXJtLmNvbQ%3D%3D; path=/; secure
X-XSS-Protection: 1; mode=block
X-Frame-Options: SAMEORIGIN
X-Content-Type-Options: nosniff
";

    }

    public function __getTypes()
    {

    }


    public function __setCookie($name, $value = null)
    {
        // Required for cookie handling

    }


    public function __setLocation($new_location = null)
    {

    }


    public function __setSoapHeaders($soapheaders = null)
    {

    }

    public function __soapCall(
        $function_name,
        $arguments,
        $options = null,
        $input_headers = null,
        &$output_headers = null
    ) {

    }


}