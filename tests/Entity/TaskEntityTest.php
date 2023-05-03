<?php

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskEntityTest extends KernelTestCase{

    
    public function getEntity() : User
    {
        $user = new User();
        return $user
        ->setId(1)
        ->setUsername('username')
        ->setEmail('email@email.fr')
        ->setPassword("mdp123")
        ->setRoles(["ROLE_USER"]);
    }
    
    public function getTaskEntity() : Task
    {
        $task = new Task();
        $date = new DateTime();
        return $task
            ->setId(1)
            ->setTitle('titre')
            ->setContent('content')
            ->setIsDone(true)
            ->setCreatedAt($date)
            ->setUserId($this->getEntity());
    }

    public function assertHasErrors(Task $entity, int $number = 0){
        self::bootKernel();
        $error = self::getContainer()->get('validator')->validate($entity);
        $this->assertCount($number, $error);
    }

    // public function testToggle(){
    //     $this->assertHasErrors($this->getTaskEntity()->toggle(), 0);
    // }

    public function testGetId(){
        self::assertSame(1, $this->getTaskEntity()->getId());
    }
    public function testGetTitle(){
        self::assertSame('titre', $this->getTaskEntity()->getTitle());
    }
    public function testGetContent(){
        self::assertSame('content', $this->getTaskEntity()->getContent());
    }
    public function testGetIsDone(){
        self::assertSame(true, $this->getTaskEntity()->isIsDone());
    }
    // public function testGetCreated(){
    //     self::assertSame($this->getTaskEntity()->getCreatedAt(), $this->getTaskEntity()->getCreatedAt());
    // }
    // public function testGetUserId(){
    //     self::assertSame($this->getEntity(), $this->getTaskEntity()->getUserId());
    // }


}