<?php

use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase{

    private $client;
    private $faker;
    private $userRepository;
    private $taskRepository;
    private $user;

    public function setUp() : void
    {
        $this->client = static::createClient();
        $this->userRepository = static::getContainer()->get(UserRepository::class);
        $this->taskRepository = static::getContainer()->get(TaskRepository::class);
        $this->user = $this->userRepository->findOneByEmail('admin@email.fr');
        $this->client->loginUser($this->user);
        $this->faker = Factory::create('fr_FR');
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
            'user[password][first]' => 'azefyuggyufeyuhgfes',
            'user[password][second]' => 'azefyuggyufeyuhgfes',
            'user[roleSelection]' => 'ROLE_ADMIN'
        ]);
        $this->client->submit($form);
        
        $this->assertStringContainsString("This value is already used.", $this->client->getResponse()->getContent());

    }
    public function testSameUsernameUser(){
        $crawler = $this->client->request('GET', 'users/create');
        $form = $crawler->selectButton('Ajouter')->form([
            'user[username]' => 'admin',
            'user[email]'=>'dzqdzqdn@email.fr',
            'user[password][first]' => 'azefyuggyufeyuhgfes',
            'user[password][second]' => 'azefyuggyufeyuhgfes',
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
        $buttonCrawlerNode = $crawler->selectButton('Ajouter');
        $form = $buttonCrawlerNode->form();
        $crawler = $this->client->submit($form, [
                'user[username]' => $this->faker->text(10),
                'user[email]'=> $this->faker->email(),
                'user[password][first]' => 'azefyuggyufeyuhgfes',
                'user[password][second]' => 'azefyuggyufeyuhgfes',
                'user[roleSelection]' => 'ROLE_ADMIN'
        ]);

        $this->assertResponseRedirects();
    }
    public function testEditUser(){
        $crawler = $this->client->request('GET', 'users/3/edit');
        $buttonCrawlerNode = $crawler->selectButton('Modifier');
        $form = $buttonCrawlerNode->form();
        $crawler = $this->client->submit($form, [
                'user[username]' => $this->faker->text(25),
                'user[email]'=> $this->faker->email(),
                'user[password][first]' => 'azefyuggyufeyuhgfes',
                'user[password][second]' => 'azefyuggyufeyuhgfes',
                'user[roleSelection]' => 'ROLE_ADMIN'
        ]);

        $this->assertResponseRedirects();
    }

}