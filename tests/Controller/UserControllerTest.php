<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase{

    private $client;

    public function setUp() : void
    {
        $this->client = static::createClient();
    }
    
    private function getResponse($http, $route, $code){
        $this->client->request($http, $route);
        $this->assertEquals($code, $this->client->getResponse()->getStatusCode());
    }

    public function testIndexUsers(){
        $this->getResponse('GET', '/users', 200);
    }
    public function testIndexCreateUsers(){
        $this->getResponse('GET', '/users/create', 200);
    }
    public function testIndexEditUsers(){
        $this->getResponse('GET', '/users/1/edit', 200);
    }

    public function testSameEmailUser(){
        $crawler = $this->client->request('GET', 'users/create');
        $form = $crawler->selectButton('Ajouter')->form([
            'user[username]' => 'John Doe',
            'user[email]'=>'admin@email.fr',
            'user[password][first]' => '',
            'user[password][second]' => '',
            'user[roleSelection]' => 'ROLE_ADMIN'
        ]);
        $this->client->submit($form);
        
        $this->assertStringContainsString("This value is already used.", $this->client->getResponse()->getContent());

    }
    public function testMissingFieldUser(){
        $crawler = $this->client->request('GET', 'users/create');
        $form = $crawler->selectButton('Ajouter')->form([
            'user[username]' => '',
            'user[email]'=>'',
            'user[password][first]' => '',
            'user[password][second]' => '',
            'user[roleSelection]' => 'ROLE_ADMIN'
        ]);
        $this->client->submit($form);
        
        $this->assertStringContainsString("Vous devez saisir un nom d&#039;utilisateur.", $this->client->getResponse()->getContent());
        $this->assertStringContainsString("Vous devez saisir une adresse email.", $this->client->getResponse()->getContent());
        $this->assertStringContainsString("Vous devez saisir un mot de passe.", $this->client->getResponse()->getContent());
    }
    public function testCreateUser(){
        $crawler = $this->client->request('GET', 'users/create');
        $form = $crawler->selectButton('Ajouter')->form([
            'user[username]' => '1',
            'user[email]'=>'1',
            'user[password][first]' => '1',
            'user[password][second]' => '1',
            'user[roleSelection]' => 'ROLE_ADMIN'
        ]);
        $this->client->submit($form);
        
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        // $this->assertSelectorTextContains('div.alert.alert-success','L\'utilisateur a bien été ajouté.');
        $this->assertSelectorExists('div.alert.alert-success');
    }



}