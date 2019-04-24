<?php

namespace App\DataFixtures;

use App\Entity\Shop;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ShopFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();
        // create shops!
        for ($i = 0; $i < 20; $i++) {
          $shop = new Shop();
          $shop
            ->setName($faker->company)
            ->setImage($faker->imageUrl())
            ->setLatitude($faker->latitude)
            ->setLongitude($faker->longitude)
          ;
          $manager->persist($shop);
        }

        $manager->flush();
    }
}
