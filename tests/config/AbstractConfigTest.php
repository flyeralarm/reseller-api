<?php

namespace flyeralarm\ResellerApi\config;

use PHPUnit\Framework\TestCase;

/**
 * @covers \flyeralarm\ResellerApi\config\AbstractConfig
 */
class AbstractConfigTest extends TestCase
{
    public function testCreateConfigObjects()
    {
        $system_variations = [
            'Live' =>
                [
                    'url' => 'https://soap.flyeralarm.com/{country}/shop/soap/?wsdl',
                    'rest' => 'https://api.flyeralarm.com/de',
                    'img' => 'https://flyeralarm.com',
                    'class' => 'flyeralarm\ResellerApi\config\Live',
                    'ssl' => true
                ],
            'Test' =>
                [
                    'url' => 'https://staging.flyeralarm.com/{country}/shop/soap/?wsdl',
                    'rest' => 'https://api.staging.flyeralarm.com/de',
                    'img' => 'https://staging.flyeralarm.com',
                    'class' => 'flyeralarm\ResellerApi\config\Test',
                    'ssl' => false
                ],
        ];
        $countries = ['at', 'be', 'ch', 'de', 'dk', 'es', 'fi', 'fr', 'hu', 'ie', 'it', 'nl', 'pl', 'se', 'uk'];

        foreach ($countries as $c) {
            foreach ($system_variations as $env => $param) {
                $class = $param['class'] . strtoupper($c);

                /**
                 * @var AbstractConfig $config
                 */
                $config = new $class;

                $appToken = 'UnitTestApiToken-' . $c;
                $userToken = 'UnitTestUserToken-' . $c;
                $userPassword = 'UnitTestUserPassword-' . $c;
                $userEmail = 'UnitTestUserEmail-' . $c;

                $config->setAppToken($appToken)
                    ->setUserToken($userToken)
                    ->setResellerUserEmail($userEmail)
                    ->setResellerUserPassword($userPassword);

                $this->assertTrue($config instanceof AbstractConfig);

                $this->assertEquals(
                    str_replace('{country}', $c, $param['url']),
                    $config->getWsdlURI()
                );

                $this->assertEquals(
                    str_replace('{country}', $c, $param['rest']),
                    $config->getRestBase()
                );

                $this->assertEquals(
                    str_replace('{country}', $c, $param['img']),
                    $config->getImageBase()
                );

                $this->assertEquals(
                    $appToken,
                    $config->getAppToken()
                );

                $this->assertEquals(
                    $userToken,
                    $config->getUserToken()
                );

                $this->assertEquals(
                    $userEmail,
                    $config->getResellerUserEmail()
                );

                $this->assertEquals(
                    $userPassword,
                    $config->getResellerUserPassword()
                );

                $this->assertEquals(
                    $param['ssl'],
                    $config->getRestSSLCheck()
                );
            }
        }
    }
}
