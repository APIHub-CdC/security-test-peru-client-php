<?php
namespace SecurityTestPeru\Client;

use Security\Test\Configuration;
use Signer\Manager\ApiException;
use Signer\Manager\Interceptor\MiddlewareEvents;
use Signer\Manager\Interceptor\KeyHandler;

class PruebaDeSeguridadApiTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $password = getenv('KEY_PASSWORD');
        $this->keypair = '/Users/globatos/Documents/CERTIFICADOS/keypair.p12';
        $this->cert = '/Users/globatos/Documents/CERTIFICADOS/cdc_cert_1222746041.pem';

        $this->signer = new \Signer\Manager\Interceptor\KeyHandler($this->keypair, $this->cert, $password);
        
        $events = new MiddlewareEvents($this->signer);
        $handler = \GuzzleHttp\HandlerStack::create();
        $handler->push($events->add_signature_header('x-signature'));
        $handler->push($events->verify_signature_header('x-signature'));

        $client = new \GuzzleHttp\Client(['handler' => $handler]);

        $config = new Configuration();
        $config->setHost('https://services.circulodecredito.com.pe/v1/securitytest');

        $this->apiInstance = new \Security\Test\Api\PruebaDeSeguridadApi($client,$config);
        
    }

    public function testSecurityTest()
    {
        $x_api_key = "3nxAay74GQAWZSJZekdedX52HlFViMTI";
        $body = "Esto es un mensaje de prueba";

        try {
            $result = $this->apiInstance->securityTest($x_api_key, $body);
            $this->signer->close();
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling PruebaDeSeguridadApi->securityTest: ', $e->getMessage(), PHP_EOL;
        }
    }
}
