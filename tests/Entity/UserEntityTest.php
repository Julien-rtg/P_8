<?php

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserEntityTest extends KernelTestCase{

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
        return $task
            ->setId(1)
            ->setTitle('titre')
            ->setContent('content')
            ->setIsDone(true)
            ->setCreatedAt(new DateTime())
            ->setUserId($this->getEntity());
    }

    public function assertHasErrors(User|Task $entity, int $number = 0){
        self::bootKernel();
        $error = self::getContainer()->get('validator')->validate($entity);
        $this->assertCount($number, $error);
    }

    public function testSameUsername(){
        $this->assertHasErrors($this->getEntity()->setUsername('admin'), 1);
    }

    public function testSameEmail(){
        $this->assertHasErrors($this->getEntity()->setEmail('admin@email.fr'), 1);
    }

    public function testBlank(){
        $this->assertHasErrors($this->getEntity()->setUsername(''), 1);
        $this->assertHasErrors($this->getEntity()->setEmail(''), 1);
        $this->assertHasErrors($this->getEntity()->setPassword(''), 1);
    }

    public function testAddTask(){
        $this->assertHasErrors($this->getEntity()->addTask($this->getTaskEntity()), 0);
    }
    public function testRemoveTask(){
        $this->assertHasErrors($this->getEntity()->removeTask($this->getTaskEntity()), 0);
    }

    // public function testGetTasks(){
    //     self::assertSame($this->getTaskEntity(), $this->getEntity()->getTasks());
    // }
    public function testGetSalt(){
        self::assertSame('', $this->getEntity()->getSalt());
    }
    public function testGetId(){
        self::assertSame(1, $this->getEntity()->getId());
    }
    public function testGetUsername(){
        self::assertSame('username', $this->getEntity()->getUsername());
    }
    public function testGetEmail(){
        self::assertSame('email@email.fr', $this->getEntity()->getEmail());
    }
    public function testGetRoles(){
        self::assertSame(['ROLE_USER'], $this->getEntity()->getRoles());
    }
    public function testGetPassword(){
        self::assertSame('mdp123', $this->getEntity()->getPassword());
    }
    public function testGetUserIdentifier(){
        self::assertSame('email@email.fr', $this->getEntity()->getUserIdentifier());
    }

}