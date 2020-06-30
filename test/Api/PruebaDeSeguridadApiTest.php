<?php
namespace SecurityTestPeru\Client;

class PruebaDeSeguridadApiTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $password = getenv('KEY_PASSWORD');
        $this->signer = new \SecurityTestPeru\Client\Interceptor\KeyHandler(null, null, $password);
        $events = new \SecurityTestPeru\Client\Interceptor\MiddlewareEvents($this->signer);
        $handler = \GuzzleHttp\HandlerStack::create();
        $handler->push($events->add_signature_header('x-signature'));
        $handler->push($events->verify_signature_header('x-signature'));

        $client = new \GuzzleHttp\Client(['handler' => $handler]);

        $config = new \SecurityTestPeru\Client\Configuration();
        $config->setHost('the_url');
        
        $this->apiInstance = new \SecurityTestPeru\Client\Api\PruebaDeSeguridadApi($client, $config);
    }

    public function testSecurityTest()
    {
        $x_api_key = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
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
