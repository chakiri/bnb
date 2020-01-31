<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');

        for($i = 1; $i <= 30; $i++){
            $ad = new Ad();

            $ad->setTitle($title = $faker->sentence())
                ->setCoverImage("https://i.picsum.photos/id/442/1000/350.jpg?grayscale")
                ->setIntroduction($faker->paragraph(2))
                ->setContent('<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>')
                ->setPrice(mt_rand(30, 300))
                ->setRooms(mt_rand(1,5))
            ;

            for ($j = 1; $j<= mt_rand(2,5); $j++){
                $image = new Image();

                $image->setUrl("")
                    ->setCaption($faker->sentence())
                    ->setAd($ad)
                ;

                $manager->persist($image);
            }

            $manager->persist($ad);
        }

        $manager->flush();
    }
}
