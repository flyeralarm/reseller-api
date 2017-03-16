<?php
namespace flyeralarm\ResellerApi\config;


abstract class AbstractConfig
{

    protected $wsdl_uri = null;

    protected $api_rest_base = null;

    protected $api_rest_ssl_check = true;

    protected $api_image_base = null;


    private $app_token = null;

    private $user_token = null;

    private $reseller_email = null;

    private $reseller_password = null;

    final public function setAppToken($key)
    {
        $this->app_token = $key;

        return $this;
    }

    final public function setUserToken($key)
    {
        $this->user_token = $key;

        return $this;
    }

    final public function setResellerUserEmail($email)
    {
        $this->reseller_email = $email;

        return $this;
    }

    final public function setResellerUserPassword($pw)
    {
        $this->reseller_password = $pw;

        return $this;
    }

    final public function getAppToken()
    {
        return $this->app_token;
    }

    final public function getUserToken()
    {
        return $this->user_token;
    }

    final public function getWsdlURI()
    {
        return $this->wsdl_uri;
    }

    final public function getRestBase()
    {
        return $this->api_rest_base;
    }

    final public function getRestSSLCheck()
    {
        return $this->api_rest_ssl_check;
    }

    final public function getImageBase()
    {
        return $this->api_image_base;
    }

    final public function getResellerUserEmail()
    {
        return $this->reseller_email;
    }

    final public function getResellerUserPassword()
    {
        return $this->reseller_password;
    }

}