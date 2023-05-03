<?php

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase{


    public function testCount(){
        self::bootKernel();
        $users = self::getContainer()->get(UserRepository::class)->count([]);
        $this->assertEquals(11, $users);
    }



}