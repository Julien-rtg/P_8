<?php

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskRepositoryTest extends KernelTestCase{


    public function testCount(){
        self::bootKernel();
        $tasks = self::getContainer()->get(TaskRepository::class)->count([]);
        $this->assertEquals(20, $tasks);
    }



}