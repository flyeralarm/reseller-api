<?php
namespace flyeralarm\ResellerApi\client;

use flyeralarm\ResellerApi\client\Api as ApiClient;
use flyeralarm\ResellerApi\client\UploadInfo as UploadInfo;
use flyeralarm\ResellerApi\client\Order as Order;
use flyeralarm\ResellerApi\config\AbstractConfig as Config;
use flyeralarm\ResellerApi\productCatalog\Loader as ProductLoader;
use flyeralarm\ResellerApi\productCatalog\Serializer as ProductSerializer;
use flyeralarm\ResellerApi\productCatalog\Factory as ProductFactory;

/**
 * Class Factory
 *
 * This class creates the API Client Objects that shall be used
 * as a PHP Binding to the FLYERALARM Reseller API.
 *
 * Usage:
 *
 * $config = new Config();
 * $config ->setApiKey('my_api_key')
 *         ->setResellerUserEmail('me@email.test')
 *         ->setResellerUserPassword('my_secret_password');
 *
 * $api_factory = new flyeralarm\ResellerApi\client\Factory($config);
 *
 * $api_client = $api_factory->createClient();
 *
 * @package flyeralarm\ResellerApi\client
 */
class Factory
{

    /**
     * @var Config
     */
    protected $config = null;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $host The hostname of the server you are trying to connect to. e.g. ClientFactory::ENV_TEST_API
     * @param string $key The API key that was provided to use for your application.
     * @return ApiClient
     */
    public function createClient()
    {

        $soap_client = $this->createSoapClient();

        $product_loader = $this->createProductLoader();

        $api_client = new ApiClient(
            $this->config->getAppToken(),
            $this->config->getUserToken(),
            $this->config->getResellerUserEmail(),
            $this->config->getResellerUserPassword(),
            $this->config->getRestBase(),
            $this->config->getRestSSLCheck(),
            $soap_client,
            $product_loader
        );

        return $api_client;
    }


    /**
     * @return \SoapClient
     */
    protected function createSoapClient()
    {

        $soap_client = new \SoapClient(
            $this->config->getWsdlURI(),
            array('trace' => true)
        );

        return $soap_client;
    }

    /**
     * @return ProductLoader
     */
    private function createProductLoader()
    {
        $factory = $this->createProductFactory();

        return new ProductLoader($this->config, $factory);
    }

    /**
     * @return ProductFactory
     */
    private function createProductFactory()
    {
        return new ProductFactory();
    }


    /**
     * @return Address
     */
    private function createAddress()
    {
        return new Address();
    }

    /**
     * @return AddressList
     */
    public function createAddressList()
    {

        $al = new AddressList();
        $al->setSender($this->createAddress())
            ->setDelivery($this->createAddress())
            ->setInvoice($this->createAddress());

        return $al;

    }

    /**
     * @param $text
     * @return UploadInfo
     */
    public function createUploadInfo($text)
    {
        $ui = new UploadInfo();
        $ui->setDateToNow();
        $ui->setText($text);

        return $ui;
    }

    /**
     * @return Order
     */
    public function createOrder()
    {
        $o = new Order();

        return $o;
    }


}