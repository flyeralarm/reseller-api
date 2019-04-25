<?php

namespace flyeralarm\ResellerApi\client;

use flyeralarm\ResellerApi\client\Api as ApiClient;
use flyeralarm\ResellerApi\productCatalog\Product as Product;
use flyeralarm\ResellerApi\productCatalog\ProductOptionList as OptionList;
use flyeralarm\ResellerApi\productCatalog\ProductOptionValue as OptionValue;
use flyeralarm\ResellerApi\client\AddressList as AddressList;
use flyeralarm\ResellerApi\productCatalog\ProductShippingType as ShippingType;
use flyeralarm\ResellerApi\productCatalog\ProductShippingOption as ShippingOption;
use flyeralarm\ResellerApi\productCatalog\ProductShippingOptionUpgrade as ShippingUpgrade;
use flyeralarm\ResellerApi\productCatalog\ProductPaymentOption as PaymentOption;
use flyeralarm\ResellerApi\client\UploadInfo as UploadInfo;
use flyeralarm\ResellerApi\exception\OrderPersistencyData as OrderPersistencyDataException;

class Order
{

    /**
     * @var Product
     */
    private $product;
    private $quantityId;

    /**
     * @var ShippingType
     */
    private $shippingType;
    private $shippingTypeId;

    /**
     * @var OptionList
     */
    private $productOptions;
    private $productOptionsArray;

    /**
     * @var AddressList
     */
    private $addressList;

    private $senderAddressHandling = ApiClient::ADDRESS_OVERWRITE_SENDER_WITH_FLYERALARM;

    /**
     * @var ShippingOption
     */
    private $shippingOption;
    private $shippingOptionId;

    /**
     * @var PaymentOption
     */
    private $paymentOption;
    private $paymentOptionId;

    /**
     * @var ShippingUpgrade
     */
    private $shippingUpgrade;
    private $shippingUpgradeId;

    /**
     * @var UploadInfo
     */
    private $uploadInfo;

    private $resellerAmount = null;
    private $customWidth = null;
    private $customHeight = null;

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;
        $this->quantityId = $product->getQuantityId();

        return $this;
    }

    public function getQuantityId()
    {
        return $this->quantityId;
    }

    public function getShippingType()
    {
        return $this->shippingType;
    }

    public function setShippingType(ShippingType $shippingType)
    {
        $this->shippingType = $shippingType;
        $this->shippingTypeId = $shippingType->getId();

        return $this;
    }

    public function getShippingTypeId()
    {
        return $this->shippingTypeId;
    }

    public function getProductOptions()
    {
        return $this->productOptions;
    }

    private function parseProductOptionsArray()
    {

        $array = [];

        if ($this->productOptions instanceof OptionList) {
            foreach ($this->productOptions as $opt) {
                if ($opt->getSelection() instanceof OptionValue) {
                    $array[(int) $opt->getOptionId()] = (int) $opt->getSelection()->getOptionValueId();
                }
            }

            $this->productOptionsArray = $array;
        }
    }

    public function setProductOptions(OptionList $productOptionList)
    {
        $this->productOptions = $productOptionList;

        return $this;
    }

    public function getProductOptionsArray()
    {
        $this->parseProductOptionsArray();

        return $this->productOptionsArray;
    }

    public function getAddressList()
    {
        return $this->addressList;
    }


    public function setAddressList(AddressList $addressList)
    {
        $this->addressList = $addressList;

        return $this;
    }

    public function setShippingOption(ShippingOption $shippingOption)
    {
        $this->shippingOption = $shippingOption;
        $this->shippingOptionId = $shippingOption->getId();

        return $this;
    }

    public function getShippingOption()
    {
        return $this->shippingOption;
    }

    public function getShippingOptionId()
    {
        return $this->shippingOptionId;
    }

    public function setShippingUpgrade(ShippingUpgrade $shippingUpgrade)
    {
        $this->shippingUpgrade = $shippingUpgrade;
        $this->shippingUpgradeId = $shippingUpgrade->getId();

        return $this;
    }

    public function getShippingUpgrade()
    {
        return $this->shippingUpgrade;
    }

    public function getShippingUpgradeId()
    {
        return $this->shippingUpgradeId;
    }

    public function setPaymentOption(PaymentOption $paymentOption)
    {
        $this->paymentOption = $paymentOption;
        $this->paymentOptionId = $paymentOption->getId();

        return $this;
    }

    public function getPaymentOption()
    {
        return $this->paymentOption;
    }

    public function getPaymentOptionId()
    {
        return $this->paymentOptionId;
    }

    public function getUploadInfo()
    {
        return $this->uploadInfo;
    }


    public function setUploadInfo(UploadInfo $uploadInfo)
    {
        $this->uploadInfo = $uploadInfo;

        return $this;
    }


    public function setAddressHandlingUseFlyeralarmAsSender()
    {
        $this->senderAddressHandling = ApiClient::ADDRESS_OVERWRITE_SENDER_WITH_FLYERALARM;

        return $this;
    }

    public function setAddressHandlingUseNeutralAsSender()
    {
        $this->senderAddressHandling = ApiClient::ADDRESS_OVERWRITE_SENDER_WITH_NEUTRAL;

        return $this;
    }

    public function setAddressHandlingUseSenderFromAddressList()
    {
        $this->senderAddressHandling = ApiClient::ADDRESS_KEEP_DEFINED_SENDER;

        return $this;
    }

    public function getAddressHandling()
    {
        return $this->senderAddressHandling;
    }

    public function setResellerPrice($price)
    {
        $this->resellerAmount = (float) $price;

        return $this;
    }

    public function getResellerPrice()
    {
        return $this->resellerAmount;
    }

    public function setCustomWidth($width)
    {
        $this->customWidth = (float) $width;

        return $this;
    }

    public function getCustomWidth()
    {
        return $this->customWidth;
    }

    public function setCustomHeight($height)
    {
        $this->customHeight = (float) $height;

        return $this;
    }

    public function getCustomHeight()
    {
        return $this->customHeight;
    }

    private function getPersistencyArray()
    {

        $array = [
            'qi' => $this->quantityId,
            'sti' => $this->shippingTypeId,
            'poa' => $this->productOptionsArray,
            'al' => (($this->addressList instanceof AddressList) ? $this->addressList->getArray() : null),
            'ah' => $this->senderAddressHandling,
            'soi' => $this->shippingOptionId,
            'poi' => $this->paymentOptionId,
            'sui' => $this->shippingUpgradeId,
            'ui' => (($this->uploadInfo instanceof UploadInfo) ? $this->uploadInfo->getArray() : null),
            'ra' => $this->resellerAmount,
            'cw' => $this->customWidth,
            'ch' => $this->customHeight

        ];

        return $array;
    }

    public function getPersistencyString()
    {

        $array = $this->getPersistencyArray();

        $string = base64_encode(gzcompress(json_encode($array)));

        return $string;
    }

    private function loadByPersistencyArray($array)
    {

        if (!is_array($array)
            || !array_key_exists('qi', $array)
            || !array_key_exists('sti', $array)
            || !array_key_exists('poa', $array)
            || !array_key_exists('ah', $array)
            || !array_key_exists('soi', $array)
            || !array_key_exists('poi', $array)
            || !array_key_exists('sui', $array)
            || !array_key_exists('ra', $array)
            || !array_key_exists('cw', $array)
            || !array_key_exists('ch', $array)
            || !array_key_exists('al', $array)
            || !array_key_exists('ui', $array)
        ) {
            throw new OrderPersistencyDataException();
        }


        $this->quantityId = $array['qi'];
        $this->shippingTypeId = $array['sti'];
        $this->productOptionsArray = $array['poa'];
        $this->senderAddressHandling = $array['ah'];
        $this->shippingOptionId = $array['soi'];
        $this->paymentOptionId = $array['poi'];
        $this->shippingUpgradeId = $array['sui'];
        $this->resellerAmount = $array['ra'];
        $this->customWidth = $array['cw'];
        $this->customHeight = $array['ch'];


        if ($array['al'] !== null) {
            $this->addressList = new AddressList();

            if (isset($array['al']['sender']) && !empty($array['al']['sender'])) {
                $sender = new Address();

                $sender
                    ->setCompany($array['al']['sender']['company'])
                    ->setGender($array['al']['sender']['gender'])
                    ->setFirstName($array['al']['sender']['firstName'])
                    ->setLastName($array['al']['sender']['lastName'])
                    ->setAddress($array['al']['sender']['address'])
                    ->setAddressAdd($array['al']['sender']['addressAdd'])
                    ->setPostcode($array['al']['sender']['postcode'])
                    ->setCity($array['al']['sender']['city'])
                    ->setCounty($array['al']['sender']['county'])
                    ->setLocale($array['al']['sender']['locale'])
                    ->setPhone1($array['al']['sender']['phone1']);

                if (isset($array['al']['sender']['customertype'])) {
                    $sender
                        ->setCustomerType($array['al']['sender']['customertype']);
                }
                if (isset($array['al']['sender']['vatnumber'])) {
                    $sender
                        ->setVatNumber($array['al']['sender']['vatnumber']);
                }
                if (isset($array['al']['delivery']['taxnumber'])) {
                    $sender
                        ->setTaxNumber($array['al']['sender']['taxnumber']);
                }

                $this->addressList->setSender($sender);
            }

            if (isset($array['al']['delivery']) && !empty($array['al']['delivery'])) {
                $delivery = new Address();

                $delivery
                    ->setCompany($array['al']['delivery']['company'])
                    ->setGender($array['al']['delivery']['gender'])
                    ->setFirstName($array['al']['delivery']['firstName'])
                    ->setLastName($array['al']['delivery']['lastName'])
                    ->setAddress($array['al']['delivery']['address'])
                    ->setAddressAdd($array['al']['delivery']['addressAdd'])
                    ->setPostcode($array['al']['delivery']['postcode'])
                    ->setCity($array['al']['delivery']['city'])
                    ->setCounty($array['al']['delivery']['county'])
                    ->setLocale($array['al']['delivery']['locale'])
                    ->setPhone1($array['al']['delivery']['phone1']);

                if (isset($array['al']['delivery']['customertype'])) {
                    $delivery
                        ->setCustomerType($array['al']['delivery']['customertype']);
                }
                if (isset($array['al']['delivery']['vatnumber'])) {
                    $delivery
                        ->setVatNumber($array['al']['delivery']['vatnumber']);
                }
                if (isset($array['al']['delivery']['taxnumber'])) {
                    $delivery
                        ->setTaxNumber($array['al']['delivery']['taxnumber']);
                }

                $this->addressList->setDelivery($delivery);
            }

            if (isset($array['al']['invoice']) && !empty($array['al']['invoice'])) {
                $invoice = new Address();

                $invoice
                    ->setCompany($array['al']['invoice']['company'])
                    ->setGender($array['al']['invoice']['gender'])
                    ->setFirstName($array['al']['invoice']['firstName'])
                    ->setLastName($array['al']['invoice']['lastName'])
                    ->setAddress($array['al']['invoice']['address'])
                    ->setAddressAdd($array['al']['invoice']['addressAdd'])
                    ->setPostcode($array['al']['invoice']['postcode'])
                    ->setCity($array['al']['invoice']['city'])
                    ->setCounty($array['al']['invoice']['county'])
                    ->setLocale($array['al']['invoice']['locale'])
                    ->setPhone1($array['al']['invoice']['phone1']);

                if (isset($array['al']['invoice']['customertype'])) {
                    $invoice
                        ->setCustomerType($array['al']['invoice']['customertype']);
                }
                if (isset($array['al']['invoice']['vatnumber'])) {
                    $invoice
                        ->setVatNumber($array['al']['invoice']['vatnumber']);
                }
                if (isset($array['al']['invoice']['taxnumber'])) {
                    $invoice
                        ->setTaxNumber($array['al']['invoice']['taxnumber']);
                }


                $this->addressList->setInvoice($invoice);
            }
        }

        if ($array['ui'] !== null) {
            $this->uploadInfo = new UploadInfo();
            if (isset($array['ui']['dataTransferText'])) {
                $this->uploadInfo->setText($array['ui']['dataTransferText']);
                $this->uploadInfo->setDateToNow();
            }
        }
    }

    public function loadByPersistencyString($string)
    {

        try {
            $array = json_decode(gzuncompress(base64_decode($string)), true);
        } catch (\Exception $e) {
            throw new OrderPersistencyDataException();
        }

        //var_dump($array);

        $this->loadByPersistencyArray($array);

        return $this;
    }
}
