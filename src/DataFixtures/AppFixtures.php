<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Flight;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // alimenter la table City avec l'entité City
        $cities= ['Londres', 'Paris', 'Berlin', 'Lisbonne', 'Bruxelles', 'Rome', 'Madrid', 'Amsterdam', 'Dublin'];
        $tabObjCity = [];
        foreach ($cities as $name)
        {
            $city= new City();
            $city -> setName($name);
            $tabObjCity[] = $city;
            $manager->persist($city);
        }

        $flight = new Flight();
        $flight
            ->setNumber($this->getFlightNumber())
            ->setSchedule(\DateTime::createFromFormat('H:i','08:00'))
            ->setSeat(28)
            ->setPrice(210)
            ->setReduction(false)
            ->setDeparture($tabObjCity[0])
            ->setArrival($tabObjCity[4]);
        $manager->persist($flight);
        $manager->flush();
    }
    /**
     * Get a random flight number
     *
     * @return string
     */
    public function getFlightNumber():string
    {
        // Tableau de lettres en maj
        $lettres=range('A', 'Z');
        // mélange
        shuffle($lettres);
        // extraire le premier item du tableau
        $lettre= array_shift($lettres);
        // Je recommence
        shuffle($lettres);
        $lettre = array_shift($lettres);
        // Je veux un nombre sur 4 digit au hasard
        $nombre = mt_rand(1000, 9999);
        return $lettre.$nombre;
    }
}
