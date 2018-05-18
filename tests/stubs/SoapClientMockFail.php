<?php

class SoapClientMockFail extends SoapClient
{
    private $last_login = false;

    public function __call($function_name, $arguments)
    {
        if($function_name === 'logout')
            return null;
        throw new Exception('SOAP Error ...', 999);
    }

    public function __construct($wsdl, $options = null)
    {

    }

    public function __doRequest($request, $location, $action, $version, $one_way = 0)
    {

    }

    public function __getFunctions()
    {

    }

    public function __getLastRequest()
    {

    }

    public function __getLastRequestHeaders()
    {

    }

    public function __getLastResponse()
    {

    }

    public function __getLastResponseHeaders()
    {
        // Required for cookies
        return "HTTP/1.1 200 OK
Server: nginx
Date: Mon, 13 Mar 2017 10:26:19 GMT
Content-Type: text/xml; charset=utf-8
Content-Length: 531
Connection: keep-alive
Expires: Thu, 19 Nov 1981 08:52:00 GMT
Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0
Pragma: no-cache
Set-Cookie: FlyFE_de_language=de; expires=Tue, 13-Mar-2018 10:26:19 GMT; Max-Age=31536000; path=/; secure; httponly
Set-Cookie: FA_COMMERCE_LOCALE=de_DE; expires=Tue, 13-Mar-2018 10:26:19 GMT; Max-Age=31536000; path=/; secure; httponly
Set-Cookie: FlyFE_de_user=deleted; expires=Thu, 01-Jan-1970 00:00:01 GMT; Max-Age=0; path=/; secure; httponly
Set-Cookie: FlyFE_de_cartItems=0%2F10; expires=Wed, 15-Mar-2017 10:26:19 GMT; Max-Age=172800; path=/; secure
Set-Cookie: FlyFE_de=test3lqp8nh80j8jevue3mtea1radl6n; path=/; secure; HttpOnly
Set-Cookie: FlyFE_de_user=testYW4uc2NoYXBmbEBmbHllcmFsYXJtLmNvbQ%3D%3D; path=/; secure
X-XSS-Protection: 1; mode=block
X-Frame-Options: SAMEORIGIN
X-Content-Type-Options: nosniff
";

    }

    public function __getTypes()
    {

    }


    public function __setCookie($name, $value = null)
    {
        // Required for cookie handling

    }


    public function __setLocation($new_location = null)
    {

    }


    public function __setSoapHeaders($soapheaders = null)
    {

    }

    public function __soapCall(
        $function_name,
        $arguments,
        $options = null,
        $input_headers = null,
        &$output_headers = null
    ) {

    }


}