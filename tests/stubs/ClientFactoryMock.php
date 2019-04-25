<?php

use flyeralarm\ResellerApi\client\Factory as ClientFactory;

class ClientFactoryMock extends ClientFactory
{
    protected function createSoapClient()
    {
        $soap_client = new SoapClientMock(
            $this->config->getWsdlURI(),
            ['trace' => true]
        );

        return $soap_client;
    }
}
