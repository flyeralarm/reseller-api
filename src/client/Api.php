<?php

namespace flyeralarm\ResellerApi\client;

use flyeralarm\ResellerApi\productCatalog\Loader as ProductLoader;
use flyeralarm\ResellerApi\productCatalog\Group as ProductGroup;
use flyeralarm\ResellerApi\productCatalog\ProductAttributeList as ProductAttributeList;
use flyeralarm\ResellerApi\productCatalog\ProductAttribute as ProductAttribute;
use flyeralarm\ResellerApi\productCatalog\ProductAttributeValue as ProductAttributeValue;
use flyeralarm\ResellerApi\productCatalog\Product as Product;
use flyeralarm\ResellerApi\productCatalog\ProductOptionList as OptionList;
use flyeralarm\ResellerApi\client\AddressList as AddressList;
use flyeralarm\ResellerApi\exception\SoapCall as SoapCallException;
use flyeralarm\ResellerApi\exception\LoginFail as LoginFailException;

class Api
{
    const ADDRESS_OVERWRITE_SENDER_WITH_FLYERALARM = 1;

    const ADDRESS_OVERWRITE_SENDER_WITH_NEUTRAL = 2;

    const ADDRESS_KEEP_DEFINED_SENDER = 3;

    private $app_token = null;
    private $user_token = null;

    private $api_rest_base = null;
    private $api_rest_ssl_check = true;

    private $api_client = null;

    private $reseller_email = null;

    private $reseller_password = null;

    private $api_cookies = [];

    private $api_sequence_check_login = false;

    private $product_loader;

    public function __construct(
        $app_token,
        $user_token,
        $reseller_email,
        $reseller_password,
        $rest_base,
        $ssl_check,
        $client,
        ProductLoader $product_loader
    ) {

        $this->app_token = $app_token;
        $this->user_token = $user_token;

        $this->reseller_email = $reseller_email;
        $this->reseller_password = $reseller_password;

        $this->api_rest_base = $rest_base;
        $this->api_rest_ssl_check = (bool) $ssl_check;

        $this->api_client = $client;
        $this->product_loader = $product_loader;

        return $this;
    }

    public function __destruct()
    {
        return $this->api_client->logout();
    }

    /**
     * @return bool
     * @throws LoginFailException
     */
    private function login()
    {
        try {
            if ($this->api_client->loggedIn() === false) {
                $result = $this->api_client->login($this->reseller_email, $this->reseller_password);

                return $result;
            }
        } catch (\Exception $e) {
            throw new LoginFailException("The FLYERALARM API was not able to login.", 5101, $e);
        }

        return true;
    }

    /**
     * Returns the current login status
     *
     * @return bool
     */
    public function loggedInTest()
    {
        $this->login();

        return $this->api_client->loggedIn();
    }

    /**
     * Returns the product loader
     */
    public function getProductLoader()
    {
        return $this->product_loader;
    }

    /**
     * Returns a List of all ProductGroups
     *
     * @return \flyeralarm\ResellerApi\productCatalog\GroupList
     * @throws SoapCallException
     */
    public function getProductGroupIds()
    {
        try {
            $this->login();
            $array = $this->api_client->getProductGroupIds();
        } catch (\Exception $e) {
            throw new SoapCallException("FLYERALARM API Call: Unable to load Productgroups.", 5111, $e);
        }

        return $this->product_loader->loadGroupListFromArray($array);
    }

    /**
     * @param ProductAttributeList $attributes
     * @return array
     */
    private function getSoapAttributeArray(ProductAttributeList $attributes)
    {
        $array = [];
        /**
         * @var $attr ProductAttribute
         */
        foreach ($attributes as $attr) {
            if ($attr->getSelection() instanceof ProductAttributeValue) {
                $array[$attr->getId()] = $attr->getSelection()->getId();
            }
        }

        return $array;
    }

    /**
     * @param $groupId int
     * @return ProductAttributeList
     * @throws SoapCallException
     */
    public function getProductAttributesByProductGroupId($groupId)
    {
        try {
            $this->login();
            $array = $this->api_client->getProductAttributesByGroupId(
                (int) $groupId
            );
        } catch (\Exception $e) {
            throw new SoapCallException("FLYERALARM API Call: Unable to load ProductAttributes.", 5112, $e);
        }

        $attributeList = $this->product_loader->loadAttributeListFromArray($array);

        return $attributeList;
    }

    /**
     * @param ProductGroup $group
     * @return ProductAttributeList
     */
    public function getProductAttributesByProductGroup(ProductGroup $group)
    {
        $attributeList = $this->getProductAttributesByProductGroupId((int) $group->getProductGroupId());

        return $attributeList;
    }

    /**
     * @param ProductGroup $group
     * @param ProductAttributeList $attributes
     * @return \flyeralarm\ResellerApi\productCatalog\AttributeList
     * @throws SoapCallException
     */
    public function getAvailableAttributesByPreselectedAttributes(ProductGroup $group, ProductAttributeList $attributes)
    {
        $arrayAttributes = $this->getSoapAttributeArray($attributes);

        try {
            $this->login();
            $array = $this->api_client->getAvailableAttributesByPreselectedAttributes(
                $group->getProductGroupId(),
                $arrayAttributes
            );
        } catch (\Exception $e) {
            throw new SoapCallException(
                "FLYERALARM API Call: Unable to load available Attributes by preselected Attributes.",
                5113,
                $e
            );
        }

        $attributeList = $this->product_loader->loadAttributeListFromArrayWithPreselectedAttributes(
            $array,
            $attributes
        );

        return $attributeList;
    }

    /**
     * @param ProductGroup $group
     * @param ProductAttributeList $attributes
     * @return \flyeralarm\ResellerApi\productCatalog\ProductQuantityOptionList
     * @throws SoapCallException
     */
    public function getAvailableQuantitiesByAttributes(ProductGroup $group, ProductAttributeList $attributes)
    {

        $array = $this->getSoapAttributeArray($attributes);

        try {
            $this->login();
            $quantitiesArray = $this->api_client->getAvailableQuantitiesByAttributes(
                $group->getProductGroupId(),
                $array
            );
        } catch (\Exception $e) {
            throw new SoapCallException(
                "FLYERALARM API Call: Unable to load available Quantities by Attributes.",
                5114,
                $e
            );
        }

        $quantities = $this->product_loader->loadQuantityOptionListFromArray($quantitiesArray);

        return $quantities;
    }

    /**
     * @param $quantityId
     * @return Product
     * @throws SoapCallException
     */
    public function findProductByQuantityId($quantityId)
    {

        try {
            $this->login();
            $array = $this->api_client->findProductByQuantityId((int) $quantityId);
        } catch (\Exception $e) {
            throw new SoapCallException("FLYERALARM API Call: Unable to find Product by QuantityId.", 5115, $e);
        }

        $product = $this->product_loader->loadProductFromArray((int) $quantityId, $array);

        return $product;
    }

    /**
     * @param $quantityId
     * @return bool
     * @internal param Product $product
     */
    private function addProductToCart($quantityId)
    {
        $result = $this->api_client->addProductToCart((int) $quantityId);

        return $result;
    }

    /**
     * @param Product $product
     * @return \flyeralarm\ResellerApi\productCatalog\ProductShippingTypeList
     * @throws SoapCallException
     */
    public function getShippingTypeList(Product $product)
    {
        try {
            $this->login();
            $result = $this->addProductToCart($product->getQuantityId());
        } catch (\Exception $e) {
            throw new SoapCallException("FLYERALARM API Call: Unable to get ShippingTypes.", 5116, $e);
        }
        $shippingOptionList = $this->product_loader->loadShippingTypeListFromArray($result);

        return $shippingOptionList;
    }

    /**
     * @param Order $order
     * @return OptionList
     * @throws SoapCallException
     */
    public function getAvailableProductOptions(Order $order)
    {
        try {
            $this->login();
            $this->addProductToCart($order->getQuantityId());
            $this->addShippingTypeToProduct($order->getShippingTypeId());
            $array = $this->api_client->getAvailableProductOptions();
        } catch (\Exception $e) {
            throw new SoapCallException("FLYERALARM API Call: Unable to get available ProductOptions.", 5117, $e);
        }

        $optionList = $this->product_loader->loadOptionsListFromArray($array);

        return $optionList;
    }

    /**
     * @param $optionsArray
     * @return bool
     * @internal param OptionList $options
     */
    private function addProductOptions($optionsArray)
    {
        $return = $this->api_client->addProductOptions($optionsArray);

        return $return;
    }

    /**
     * @param $shippingTypeId
     * @return bool
     * @internal param ShippingType $shippingType
     */
    private function addShippingTypeToProduct($shippingTypeId)
    {
        $return = $this->api_client->addShippingtypeToProduct((int) $shippingTypeId);

        return $return;
    }

    /**
     * @param Order $order
     * @return \flyeralarm\ResellerApi\productCatalog\ProductShippingOptionList
     * @throws SoapCallException
     */
    public function getAvailableShippingOptions(Order $order)
    {
        try {
            $this->login();
            $this->addProductToCart($order->getQuantityId());
            $return = $this->api_client->getAvailableShippingOptions();
        } catch (\Exception $e) {
            throw new SoapCallException("FLYERALARM API Call: Unable to get available ShippingOptions.", 5118, $e);
        }

        $shippingOptions = $this->product_loader->loadShippingOptionListFromArray($return);

        return $shippingOptions;
    }

    /**
     * @param $senderType
     * @param AddressList $addressList
     * @param $shippingOptionId
     * @param null $shipping_upgrade_id
     * @return bool
     * @internal param ShippingOption $shippingOption
     * @internal param ShippingUpgrade $shippingUpgrade
     */
    private function addShippingOptions(
        $senderType,
        AddressList $addressList,
        $shippingOptionId,
        $shipping_upgrade_id = null
    ) {
        $result = $this->api_client->addShippingOptions(
            $senderType,
            $addressList->getArray(),
            $shippingOptionId,
            $shipping_upgrade_id
        );

        return $result;
    }

    /**
     * @param Order $order
     * @return \flyeralarm\ResellerApi\productCatalog\ProductPaymentOptionList
     * @throws SoapCallException
     */
    public function getAvailablePaymentOptions(Order $order)
    {
        try {
            $this->login();
            $this->addProductToCart($order->getQuantityId());
            $this->addShippingTypeToProduct($order->getShippingTypeId());
            $this->addProductOptions($order->getProductOptionsArray());
            $this->addShippingOptions(
                $order->getAddressHandling(),
                $order->getAddressList(),
                $order->getShippingOptionId(),
                $order->getShippingUpgradeId()
            );
            $array = $this->api_client->getAvailablePaymentOptions();
        } catch (\Exception $e) {
            throw new SoapCallException("FLYERALARM API Call: Unable to get available PaymentOptions.", 5119, $e);
        }

        $paymentOptions = $this->product_loader->loadPaymentOptionListFromArray($array);

        return $paymentOptions;
    }

    /**
     * @param Order $order
     * @return float
     * @throws SoapCallException
     */
    public function getCurrentNetPrice(Order $order){

        try {
            $this->login();
            $this->addProductToCart($order->getQuantityId(), $order->getCustomWidth(), $order->getCustomHeight());
            $array = $this->api_client->getCurrentCart();
            $price = (float)$array["netPrice"];
        } catch (\Exception $e) {
            throw new SoapCallException("FLYERALARM API Call: Unable to get current cart.", 5160, $e);
        }

        return $price;

    }

    /**
     * @param Order $order
     * @return float
     * @throws SoapCallException
     */
    public function getCurrentGrossPrice(Order $order){

        try {
            $this->login();
            $this->addProductToCart($order->getQuantityId(), $order->getCustomWidth(), $order->getCustomHeight());
            $array = $this->api_client->getCurrentCart();
            $price = (float)$array["grossPrice"];
        } catch (\Exception $e) {
            throw new SoapCallException("FLYERALARM API Call: Unable to get current cart.", 5160, $e);
        }

        return $price;

    }

    /**
     * @param Order $order
     * @return bool
     * @throws SoapCallException
     */
    public function sendFullOrder(Order $order)
    {
        try {
            $return = $this->api_client->sendFullOrder(
                (string) $this->reseller_email,
                (string) $this->reseller_password, // User login data from config.
                (int) $order->getQuantityId(),
                (int) $order->getShippingTypeId(),
                $order->getProductOptionsArray(),
                $order->getAddressList()->getArray(),
                (int) $order->getShippingOptionId(),
                $order->getAddressHandling(),
                $order->getShippingUpgradeId(),
                (int) $order->getPaymentOptionId(),
                $order->getUploadInfo()->getArray(),
                $order->getResellerPrice(),
                $order->getCustomWidth(),
                $order->getCustomHeight()
            );
        } catch (\Exception $e) {
            throw new SoapCallException("FLYERALARM API Call: Unable to send order.", 5120, $e);
        }

        return $return;
    }

    /**
     * @param $orderId
     * @return string
     */
    public function getOrderStatus($orderId)
    {
        $this->login();
        $return = $this->api_client->getOrderStatus([(string) $orderId]);

        return $return;
    }

    /**
     * @param string $fileName
     * @param int $fileSize
     * @param string $orderId
     * @param string $orderItemId
     * @param bool $hasEmptyRearPage
     * @return string
     */
    public function createUploadTarget($fileName, $fileSize, $orderId, $orderItemId = null, $hasEmptyRearPage = false)
    {
        if ($orderItemId === null) {
            $orderItemId = $orderId . 'X01';
        }

        $hasEmptyRearPage = (bool) $hasEmptyRearPage;

        $hasEmptyRearPageString = '"hasEmptyRearPage": false';

        if ($hasEmptyRearPage) {
            $hasEmptyRearPageString = '"hasEmptyRearPage": true';
        }


        $getDataUrl = $this->api_rest_base . '/v1/sales-orders/' .
            $orderId . '/items/' . $orderItemId . '/printing-data';

        $getDataHeaders = [
            'Authorization: FLYERALARM app_token="' . $this->app_token . '", user_token="' . $this->user_token . '"',
            'Accept: application/json',
            'Content-Type: text/plain'
        ];

        $getDataPost = '{"fileName": "' . $fileName . '", "fileSize": ' .
            $fileSize . ', ' . $hasEmptyRearPageString . '}';

        // Start the curl magic:
        //var_dump($getData_headers);
        //var_dump($getData_post);

        // setup
        $getDataCurl = curl_init();
        curl_setopt($getDataCurl, CURLOPT_URL, $getDataUrl);
        curl_setopt($getDataCurl, CURLOPT_HTTPHEADER, $getDataHeaders);
        curl_setopt($getDataCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($getDataCurl, CURLOPT_POST, 1);
        curl_setopt($getDataCurl, CURLOPT_POSTFIELDS, $getDataPost);
        curl_setopt($getDataCurl, CURLOPT_SSL_VERIFYPEER, $this->api_rest_ssl_check);
        // just do it
        $getDataResponse = curl_exec($getDataCurl);
        // what did we get ?
        $getDataInfo = curl_getinfo($getDataCurl);
        // did any errors happen?
        $getDataError = curl_error($getDataCurl);
        // we are done with this call
        curl_close($getDataCurl);

        // make the data usefull

        $data = json_decode($getDataResponse, true);

        return $data['url'];
    }

    /**
     * @param string $targetUrl
     * @param string $filePath
     * @return string
     */
    public function uploadFileByPaths($targetUrl, $filePath)
    {
        $getDataUrl = $this->api_rest_base . '/..' . $targetUrl;

        $getDataHeaders = [
            'Authorization: FLYERALARM app_token="' . $this->app_token . '", user_token="' . $this->user_token . '"',
            'Accept: application/json'
        ];


        $fhRes = fopen($filePath, 'r');

        // Start the curl magic:

        // setup
        $getDataCurl = curl_init();
        curl_setopt($getDataCurl, CURLOPT_URL, $getDataUrl);
        curl_setopt($getDataCurl, CURLOPT_HTTPHEADER, $getDataHeaders);
        curl_setopt($getDataCurl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($getDataCurl, CURLOPT_PUT, 1);
        curl_setopt($getDataCurl, CURLOPT_INFILE, $fhRes);
        curl_setopt($getDataCurl, CURLOPT_INFILESIZE, filesize($filePath));
        curl_setopt($getDataCurl, CURLOPT_SSL_VERIFYPEER, $this->api_rest_ssl_check);
        // just do it
        $getDataResponse = curl_exec($getDataCurl);
        // what did we get ?
        $getDataInfo = curl_getinfo($getDataCurl);
        // did any errors happen?
        $getDataError = curl_error($getDataCurl);
        // we are done with this call
        curl_close($getDataCurl);

        fclose($fhRes);


        // make the data usefull
        $data = $getDataResponse;

        return $data;
    }
}
