<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Album;
use App\Entity\User;
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
        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setFirstname($this->faker->firstname())
                ->setLastname($this->faker->lastname())
                ->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password');

            $users[] = $user;
            $manager->persist($user);
        }


        // picture
        $pictures = [];
        for ($i = 1; $i <= 30; $i++) {
            $picture = new Picture();
            $picture->setName($this->faker->name())
                ->setUrl('https://picsum.photos/200/300?random.jpg')
                ->setDescription($this->faker->text(20))
                ->setUser($users[mt_rand(0, count($users) - 1)]);

            $pictures[] = $picture;
            $manager->persist($picture);
        }

        // album
        $albums = [];
        for ($i = 0; $i < 10; $i++) {
            $album = new Album();
            $album->setName($this->faker->name())
                ->setDescription($this->faker->text(30));

            for ($j = 0; $j < mt_rand(2, 5); $j++) {
                $album->addPicture($pictures[mt_rand(0, count($pictures) - 1)]);
            }

            $albums[] = $album;
            $manager->persist($album);
        }

        $manager->flush();
    }
}
