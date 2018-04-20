<?php

use flyeralarm\ResellerApi\config\AbstractConfig as AbstractConfig;

class ConfigMock extends AbstractConfig
{
    protected $wsdl_uri = 'https://unittest.flyeralarm.local/soap/?wsdl';

    protected $api_image_base = 'https://unittest.flyeralarm.local';

    protected $api_rest_base = 'https://api.unittest.flyeralarm.local';

    protected $api_rest_ssl_check = false;
}
