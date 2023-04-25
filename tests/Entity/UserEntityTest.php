<?php

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserEntityTest extends KernelTestCase{

    public function getEntity() : User
    {
        $user = new User();
        return $user
            ->setUsername('username')
            ->setEmail('email@email.fr')
            ->setPassword("mdp123")
            ->setRoles(["ROLE_USER"]);
    }

    public function assertHasErrors(User $user, int $number = 0){
        self::bootKernel();
        $error = self::getContainer()->get('validator')->validate($user);
        $this->assertCount($number, $error);

    }

    public function testSameUsername(){
        $this->assertHasErrors($this->getEntity()->setUsername('admin'), 1);
    }

}