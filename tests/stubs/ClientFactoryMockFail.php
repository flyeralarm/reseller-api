<?php

use flyeralarm\ResellerApi\client\Factory as ClientFactory;

class ClientFactoryMockFail extends ClientFactory
{
    protected function createSoapClient()
    {
        $soap_client = new SoapClientMockFail(
            $this->config->getWsdlURI(),
            ['trace' => true]
        );

        return $soap_client;
    }
}
