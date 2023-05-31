<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;
use Symfony\Component\Validator\Constraints\Date;

class AppFixtures extends Fixture
{
    public const USER_REF = 'user-ref_%s';
    

    private $userPasswordHasherInterface;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager): void
    {

        $this->userLoad($manager);
        $this->taskLoad($manager);

    }

    public function userLoad(ObjectManager $manager): void{
        for ($i = 0; $i < 10; $i++) {
            $faker = Factory::create('fr_FR');

            $user = new User();
            $user->setUsername($faker->text(10));
            $user->setPassword($this->userPasswordHasherInterface->hashPassword($user, "mdp123"));
            $user->setEmail($faker->email());
            $user->setRoles(["ROLE_USER"]);
            $manager->persist($user);
            $this->addReference(sprintf(self::USER_REF, $i), $user);
        }

        $user = new User();
        $user->setUsername("admin");
        $user->setPassword($this->userPasswordHasherInterface->hashPassword($user, "mdp123"));
        $user->setEmail('admin@email.fr');
        $user->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);
        $this->addReference(sprintf(self::USER_REF, 10), $user);
        $manager->flush();

    }

    public function taskLoad(ObjectManager $manager): void{

        for ($i = 0; $i < 20; $i++) {
            $j = rand(0,20);
            $faker = Factory::create('fr_FR');

            $task = new Task();
            $task->setTitle($faker->title());
            $task->setContent($faker->text(100));
            $task->setIsDone(rand(0, 1));
            $task->setCreatedAt(new DateTime());
            if($j <= 10){
                $task->setUserId($this->getReference('user-ref_'.$j));
            }else {
                $task->setUserId(null);
            }
            $manager->persist($task);
            
        }
        $manager->flush();

    }

    
}
