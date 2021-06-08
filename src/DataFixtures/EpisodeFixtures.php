<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public const EPISODES = [
        ['L histoire de Bojack Horseman',
            1,
            'BoJack engage un prête-plume dans l espoir de publier son autobiographie 
        et de retrouver le chemin de la gloire.' ],
        ['BoJack crache sur l armée',
            2,
           'BoJack se retrouve au centre d une polémique dans les médias après avoir insulté les soldats américains.']
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::EPISODES as $key => $episodeName) {

            $episode = new Episode();
            $episode->setTitle($episodeName[0]);
            $episode->setNumber($episodeName[1]);
            $episode->setSynopsis($episodeName[2]);

            $manager->persist($episode);
            $episode->setSeason($this->getReference('season_0'));
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont EpisodeFixtures dépend
        return [
            SeasonFixtures::class,
        ];
    }
}
