<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\SoilMoisture;

/**
 * @codeCoverageIgnore
 */
class SoilMoistureFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $soilMoisture = new SoilMoisture();
            $soilMoisture->setTimeStamp($faker->dateTimeInInterval('-10 days', '+ 1 hours'));
            $soilMoisture->setValue($faker->randomFloat(4, 0, 100));
            $soilMoisture->setSensor($faker->randomElement(['temperature01', 'humidity01']));
            $manager->persist($soilMoisture);
        }

        $manager->flush();
    }
}
