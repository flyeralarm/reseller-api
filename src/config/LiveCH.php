<?php
namespace flyeralarm\ResellerApi\config;

use flyeralarm\ResellerApi\config\AbstractConfig as AbstractConfig;

class LiveCH extends AbstractConfig
{

    protected $wsdl_uri = 'https://soap.flyeralarm.com/ch/shop/soap/?wsdl';

    protected $api_image_base = 'https://flyeralarm.com';

    protected $api_rest_base = 'https://api.flyeralarm.com/de';

    protected $api_rest_ssl_check = true;
}
