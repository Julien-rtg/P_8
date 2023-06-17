<?php

use App\Entity\User;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskControllerTest extends WebTestCase{

    private $client;
    private $faker;
    private $user;
    private $userRepository;
    private $taskRepository;

    public function setUp() : void
    {
        $this->faker = Factory::create('fr_FR');
        $this->client = static::createClient();
        $this->userRepository = static::getContainer()->get(UserRepository::class);
        $this->taskRepository = static::getContainer()->get(TaskRepository::class);
        $this->user = $this->userRepository->findOneByEmail('admin@email.fr');
        $this->client->loginUser($this->user);
    }
    
    private function getResponse($http, $route, $code){
        $this->client->request($http, $route);
        $this->assertEquals($code, $this->client->getResponse()->getStatusCode());
    }

    public function testIndexTask(){
        $this->getResponse('GET', '/tasks', 200);
    }
    public function testIndexCreateTasks(){
        $this->getResponse('GET', '/tasks/create', 200);
    }
    public function testIndexEditTasks(){
        $this->getResponse('GET', '/tasks/1/edit', 200);
    }

    public function testMissingFieldTask(){
        $crawler = $this->client->request('GET', 'tasks/create');
        $form = $crawler->selectButton('Ajouter')->form([
            'task[title]' => '',
            'task[content]'=>'',
        ]);
        $this->client->submit($form);
        
        $this->assertStringContainsString("Vous devez saisir un titre.", $this->client->getResponse()->getContent());
        $this->assertStringContainsString("Vous devez saisir un contenu.", $this->client->getResponse()->getContent());
    }

    public function testCreateTask(){
        $crawler = $this->client->request('GET', 'tasks/create');
        $buttonCrawlerNode = $crawler->selectButton('Ajouter');
        $form = $buttonCrawlerNode->form();
        $crawler = $this->client->submit($form, [
                'task[title]' => $this->faker->text(10),
                'task[content]'=>$this->faker->text(100),
        ]);

        $this->assertResponseRedirects();
    }
    public function testEditTask(){
        $crawler = $this->client->request('GET', 'tasks/3/edit');
        $buttonCrawlerNode = $crawler->selectButton('Modifier');
        $form = $buttonCrawlerNode->form();
        $crawler = $this->client->submit($form, [
                'task[title]' => $this->faker->text(10),
                'task[content]'=>$this->faker->text(100),
        ]);

        $this->assertResponseRedirects();
    }

    public function testToggleTask(){
        $this->client->request('GET', 'tasks/2/toggle');

        $this->assertResponseRedirects();
    }

}