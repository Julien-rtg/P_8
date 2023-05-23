<?php


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase{

    private $client;

    public function setUp() : void
    {
        $this->client = static::createClient();
    }
    
    private function getResponse($http, $route, $code){
        $this->client->request($http, $route);
        $this->assertEquals($code, $this->client->getResponse()->getStatusCode());
    }

    public function testIndexLogin(){
        $this->getResponse('GET', '/login', 200);
    }


}