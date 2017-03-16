<?php
namespace flyeralarm\ResellerApi\client;

use flyeralarm\ResellerApi\productCatalog\Loader as ProductLoader;
use flyeralarm\ResellerApi\productCatalog\Group as ProductGroup;
use flyeralarm\ResellerApi\productCatalog\ProductAttributeList as ProductAttributeList;
use flyeralarm\ResellerApi\productCatalog\ProductAttribute as ProductAttribute;
use flyeralarm\ResellerApi\productCatalog\ProductAttributeValue as ProductAttributeValue;
use flyeralarm\ResellerApi\productCatalog\Product as Product;
use flyeralarm\ResellerApi\productCatalog\ProductOptionList as OptionList;
use flyeralarm\ResellerApi\productCatalog\ProductOption as Option;
use flyeralarm\ResellerApi\productCatalog\ProductOptionValue as OptionValue;
use flyeralarm\ResellerApi\client\AddressList as AddressList;
use flyeralarm\ResellerApi\productCatalog\ProductShippingType as ShippingType;
use flyeralarm\ResellerApi\productCatalog\ProductShippingOption as ShippingOption;
use flyeralarm\ResellerApi\productCatalog\ProductShippingOptionUpgrade as ShippingUpgrade;
use flyeralarm\ResellerApi\productCatalog\ProductPaymentOption as PaymentOption;
use flyeralarm\ResellerApi\client\UploadInfo as UploadInfo;
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

    private $api_cookies = array();

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
        $this->api_rest_ssl_check = (bool)$ssl_check;

        $this->api_client = $client;
        $this->product_loader = $product_loader;

        return $this;
    }

    /**
     * @return bool
     */
    private function login()
    {
        try {
            if (false === $this->api_client->loggedIn()) {

                $result = $this->api_client->login($this->reseller_email, $this->reseller_password);

                return $result;
            }
        } catch (\Exception $e) {
            throw new LoginFailException("The FLYERALARM API was not able to login.", 5101, $e);
        }

        return true;
    }

    /**
     * @return mixed
     */
    private function logout()
    {

        return $this->api_client->logout();

    }

    /**
     * Returns the current login status
     * @return mixed
     */
    public function loggedInTest()
    {
        $this->login();

        return $this->api_client->loggedIn();
    }

    /**
     * Returns a List of all ProductGroups
     * @return \flyeralarm\ResellerApi\productCatalog\GroupList
     * @throws \flyeralarm\ResellerApi\exception\ProductGroupListArray
     */
    public function getProductGroupIds()
    {
        try {
            $this->login();
            $array = $this->api_client->getProductGroupIds();
            $this->logout();
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
        $array = array();
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
     * @throws \flyeralarm\ResellerApi\exception\AttributeArray
     */
    public function getProductAttributesByProductGroupId($groupId)
    {

        try {
            $this->login();
            $array = $this->api_client->getProductAttributesByGroupId(
                (int)$groupId
            );
            $this->logout();
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


        $attributeList = $this->getProductAttributesByProductGroupId((int)$group->getProductGroupId());

        return $attributeList;
    }

    /**
     * @param ProductGroup $group
     * @param ProductAttributeList $attributes
     * @return \flyeralarm\ResellerApi\productCatalog\AttributeList
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
            $this->logout();
        } catch (\Exception $e) {
            throw new SoapCallException("FLYERALARM API Call: Unable to load available Attributes by preselected Attributes.",
                5113, $e);
        }

        $attributeList = $this->product_loader->loadAttributeListFromArrayWithPreselectedAttributes($array,
            $attributes);

        return $attributeList;

    }

    /**
     * @param ProductGroup $group
     * @param ProductAttributeList $attributes
     * @return \flyeralarm\ResellerApi\productCatalog\ProductQuantityOptionList
     * @throws \flyeralarm\ResellerApi\exception\QuantityOptionListArray
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
            $this->logout();
        } catch (\Exception $e) {
            throw new SoapCallException("FLYERALARM API Call: Unable to load available Quantities by Attributes.", 5114,
                $e);
        }

        $quantities = $this->product_loader->loadQuantityOptionListFromArray($quantitiesArray);

        return $quantities;
    }

    /**
     * @param $quantityId
     * @return Product
     * @throws \flyeralarm\ResellerApi\exception\AttributeValueArray
     */
    public function findProductByQuantityId($quantityId)
    {

        try {
            $this->login();
            $array = $this->api_client->findProductByQuantityId((int)$quantityId);
            $this->logout();
        } catch (\Exception $e) {
            throw new SoapCallException("FLYERALARM API Call: Unable to find Product by QuantityId.", 5115, $e);
        }

        $product = $this->product_loader->loadProductFromArray((int)$quantityId, $array);

        return $product;
    }

    /**
     * @param Product $product
     * @return mixed
     */
    private function addProductToCart($quantityId)
    {

        $result = $this->api_client->addProductToCart((int)$quantityId);

        return $result;

    }

    /**
     * @param Product $product
     * @return \flyeralarm\ResellerApi\productCatalog\ProductShippingTypeList
     * @throws \flyeralarm\ResellerApi\exception\ShippingTypeArray
     */
    public function getShippingTypeList(Product $product)
    {

        try {
            $this->login();
            $result = $this->addProductToCart($product->getQuantityId());
            $this->logout();
        } catch (\Exception $e) {
            throw new SoapCallException("FLYERALARM API Call: Unable to get ShippingTypes.", 5116, $e);
        }
        $shippingOptionList = $this->product_loader->loadShippingTypeListFromArray($result);

        return $shippingOptionList;

    }

    /**
     * @param Product $product
     * @return OptionList
     * @throws \flyeralarm\ResellerApi\exception\OptionArray
     */
    public function getAvailableProductOptions(Product $product)
    {

        try {
            $this->login();
            $this->addProductToCart($product->getQuantityId());
            $array = $this->api_client->getAvailableProductOptions();
            $this->logout();
        } catch (\Exception $e) {
            throw new SoapCallException("FLYERALARM API Call: Unable to get available ProductOptions.", 5117, $e);
        }

        $optionList = $this->product_loader->loadOptionsListFromArray($array);

        return $optionList;
    }

    /**
     * @param OptionList $options
     * @return mixed
     */
    private function addProductOptions($optionsArray)
    {

        $return = $this->api_client->addProductOptions($optionsArray);

        return $return;

    }

    /**
     * @param ShippingType $shippingType
     * @return mixed
     */
    private function addShippingTypeToProduct($shippingTypeId)
    {
        $return = $this->api_client->addShippingtypeToProduct((int)$shippingTypeId);

        return $return;
    }

    /**
     * @param Order $order
     * @return \flyeralarm\ResellerApi\productCatalog\ProductShippingOptionList
     * @throws \flyeralarm\ResellerApi\exception\ShippingOptionArray
     */
    public function getAvailableShippingOptions(Order $order)
    {

        try {
            $this->login();
            $this->addProductToCart($order->getQuantityId());
            $return = $this->api_client->getAvailableShippingOptions();
            $this->logout();
        } catch (\Exception $e) {
            throw new SoapCallException("FLYERALARM API Call: Unable to get available ShippingOptions.", 5118, $e);
        }

        $shippingOptions = $this->product_loader->loadShippingOptionListFromArray($return);

        return $shippingOptions;
    }

    /**
     * @param $senderType
     * @param AddressList $addressList
     * @param ShippingOption $shippingOption
     * @param ShippingUpgrade $shippingUpgrade
     * @return mixed
     */
    private function addShippingOptions(
        $senderType,
        AddressList $addressList,
        $shippingOptionId,
        $shipping_upgrade_id = null
    ) {


        $result = $this->api_client->addShippingOptions($senderType, $addressList->getArray(), $shippingOptionId,
            $shipping_upgrade_id);

        return $result;
    }

    /**
     * @param Order $order
     * @return \flyeralarm\ResellerApi\productCatalog\ProductPaymentOptionList
     * @throws \flyeralarm\ResellerApi\exception\PaymentOptionArray
     */
    public function getAvailablePaymentOptions(Order $order)
    {
        try {
            $this->login();
            $this->addProductToCart($order->getProduct()->getQuantityId());
            $this->addShippingTypeToProduct($order->getShippingTypeId());
            $this->addProductOptions($order->getProductOptionsArray());
            $this->addShippingOptions($order->getAddressHandling(), $order->getAddressList(),
                $order->getShippingOptionId(), $order->getShippingUpgradeId());
            $array = $this->api_client->getAvailablePaymentOptions();
            $this->logout();
        } catch (\Exception $e) {
            throw new SoapCallException("FLYERALARM API Call: Unable to get available PaymentOptions.", 5119, $e);
        }

        $paymentOptions = $this->product_loader->loadPaymentOptionListFromArray($array);

        return $paymentOptions;
    }

    /**
     * @param Order $order
     * @return mixed
     */
    public function sendFullOrder(Order $order)
    {

        try {
            $return = $this->api_client->sendFullOrder(
                (string)$this->reseller_email, (string)$this->reseller_password, // User login data from config.
                (int)$order->getQuantityId(),
                (int)$order->getShippingTypeId(),
                $order->getProductOptionsArray(),
                $order->getAddressList()->getArray(),
                (int)$order->getShippingOptionId(),
                $order->getAddressHandling(),
                $order->getShippingUpgradeId(),
                (int)$order->getPaymentOptionId(),
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
     * @return mixed
     */
    public function getOrderStatus($orderId)
    {
        $this->login();
        $return = $this->api_client->getOrderStatus(array((string)$orderId));

        return $return;
    }

    /**
     * @param string $fileName
     * @param int $fileSize
     * @param string $orderId
     * @param string $orderItemId
     * @return mixed
     */
    public function createUploadTarget($fileName, $fileSize, $orderId, $orderItemId = null)
    {

        if ($orderItemId === null) {
            $orderItemId = $orderId . 'X01';
        }


        $getData_url = $this->api_rest_base . '/v1/sales-orders/' . $orderId . '/items/' . $orderItemId . '/printing-data';

        $getData_headers = array(
            'Authorization: FLYERALARM app_token="' . $this->app_token . '", user_token="' . $this->user_token . '"',
            'Accept: application/json',
            'Content-Type: text/plain'
        );

        $getData_post = '{"fileName": "' . $fileName . '", "fileSize": ' . $fileSize . ', "hasEmptyRearPage": false}';

        // Start the curl magic:
        //var_dump($getData_headers);
        //var_dump($getData_post);

        // setup
        $getData_curl = curl_init();
        curl_setopt($getData_curl, CURLOPT_URL, $getData_url);
        curl_setopt($getData_curl, CURLOPT_HTTPHEADER, $getData_headers);
        curl_setopt($getData_curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($getData_curl, CURLOPT_POST, 1);
        curl_setopt($getData_curl, CURLOPT_POSTFIELDS, $getData_post);
        curl_setopt($getData_curl, CURLOPT_SSL_VERIFYPEER, $this->api_rest_ssl_check);
        // just do it
        $getData_response = curl_exec($getData_curl);
        // what did we get ?
        $getData_info = curl_getinfo($getData_curl);
        // did any errors happen?
        $getData_error = curl_error($getData_curl);
        // we are done with this call
        curl_close($getData_curl);

        // make the data usefull

        $data = json_decode($getData_response, true);

        return $data['url'];
    }

    /**
     * @param string $targetUrl
     * @param string $filePath
     * @return mixed
     */
    public function uploadFileByPaths($targetUrl, $filePath)
    {

        $getData_url = $this->api_rest_base . '/..' . $targetUrl;

        $getData_headers = array(
            'Authorization: FLYERALARM app_token="' . $this->app_token . '", user_token="' . $this->user_token . '"',
            'Accept: application/json'
        );;

        $fh_res = fopen($filePath, 'r');

        // Start the curl magic:

        // setup
        $getData_curl = curl_init();
        curl_setopt($getData_curl, CURLOPT_URL, $getData_url);
        curl_setopt($getData_curl, CURLOPT_HTTPHEADER, $getData_headers);
        curl_setopt($getData_curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($getData_curl, CURLOPT_PUT, 1);
        curl_setopt($getData_curl, CURLOPT_INFILE, $fh_res);
        curl_setopt($getData_curl, CURLOPT_INFILESIZE, filesize($filePath));
        curl_setopt($getData_curl, CURLOPT_SSL_VERIFYPEER, $this->api_rest_ssl_check);
        // just do it
        $getData_response = curl_exec($getData_curl);
        // what did we get ?
        $getData_info = curl_getinfo($getData_curl);
        // did any errors happen?
        $getData_error = curl_error($getData_curl);
        // we are done with this call
        curl_close($getData_curl);

        fclose($fh_res);


        // make the data usefull

        $data = $getData_response;

        return $data;
    }

}