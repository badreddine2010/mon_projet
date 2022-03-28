<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
// use App\Entity\Faker\Factory;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
// use Doctrine\DBAL\Driver\IBMDB2\Exception\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

        // $product = new Product();
        // $manager->persist($product);
        // create 5 categories! Bam!
        for ($cat = 0; $cat <3; $cat++) {
            $category = new Category();
            $category->setName($faker->word());
            $manager->persist($category);
        
        // create 20 products! Bam!
        for ($i = 0; $i <mt_rand(1,3); $i++) {
            $product = new Product();
            $product->setName($faker->word());
            $product->setCategory($category);
            $product->setQuantity($faker->numberBetween($min = 2, $max = 4));
            $product->setPrice($faker->numberBetween($min = 1, $max = 3));
            // $product->setPrice(mt_rand(10, 100));
            $manager->persist($product);
        }
    }

        $manager->flush();
    }
}
