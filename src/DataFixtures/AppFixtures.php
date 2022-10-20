<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Picture;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        // User
        // $users = [];
        // for ($i = 0; $i < 10; $i++) {
        //     $user = new User();
        //     $user->setFirstname($this->faker->firstname())
        //         ->setLastname($this->faker->lastname())
        //         ->setEmail($this->faker->email())
        //         ->setRoles(['ROLE_USER'])
        //         ->setPlainPassword('password');

        //     $users[] = $user;
        //     $manager->persist($user);
        // }


        for ($i = 1; $i <= 20; $i++) {
            $picture = new Picture();
            $picture->setName($this->faker->name())
                ->setUrl('https://picsum.photos/200/300?random.jpg')
                ->setDescription($this->faker->word());
            // ->setUser($users[mt_rand(0, count($users) - 1)]);

            $manager->persist($picture);
        }

        $manager->flush();
    }
}
