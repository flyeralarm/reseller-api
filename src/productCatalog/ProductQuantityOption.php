<?php
namespace flyeralarm\ResellerApi\productCatalog;

use flyeralarm\ResellerApi\productCatalog\ProductQuantityShippingOption;

class ProductQuantityOption
{
    /**
     * @var float
     */
    private $quantity;

    /**
     * @var array
     */
    private $shipping_options;

    public function __construct($quantity, $shipping_options)
    {
        $this->quantity = $quantity;
        $this->shipping_options = $shipping_options;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return (int) $this->quantity;
    }

    /**
     * @return bool
     */
    public function hasStandardShipping()
    {
        if (is_array($this->shipping_options) && isset($this->shipping_options['standard'])) {
            return true;
        }

        return false;
    }

    /**
     * @return ProductQuantityShippingOption | null
     */
    public function getStandardShippingOption()
    {
        if ($this->hasStandardShipping()) {
            return $this->shipping_options['standard'];
        }

        return null;
    }

    /**
     * @return bool
     */
    public function hasExpressShipping()
    {
        if (is_array($this->shipping_options) && isset($this->shipping_options['express'])) {
            return true;
        }

        return false;
    }

    /**
     * @return ProductQuantityShippingOption | null
     */
    public function getExpressShippingOption()
    {
        if ($this->hasExpressShipping()) {
            return $this->shipping_options['express'];
        }

        return null;
    }

    /**
     * @return bool
     */
    public function hasOvernightShipping()
    {
        if (is_array($this->shipping_options) && isset($this->shipping_options['overnight'])) {
            return true;
        }

        return false;
    }

    /**
     * @return ProductQuantityShippingOption | null
     */
    public function getOvernightShippingOption()
    {
        if ($this->hasOvernightShipping()) {
            return $this->shipping_options['overnight'];
        }

        return null;
    }
}
