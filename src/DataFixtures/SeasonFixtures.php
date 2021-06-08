<?php

namespace App\DataFixtures;


use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public const SEASONS= [
      [ 1,
        2013,
            'BoJack est une ancienne star de sitcom ayant aujourd hui 50 ans essayant d écrire son autobiographie. 
        Son éditeur l incite à engager un nègre, qui s avèrera être la petite amie de M. Peanutbutter, 
        un acteur ayant joué dans une sitcom concurrente à celle de BoJack.'],
        [2, 2014, 'Bojack a décidé de changer de personnalité et consacre une grande partie de ses journées
         à écouter un livre audio pour changer sa vie et son comportement. 
         Il fait redécorer son intérieur, forçant Todd à choisir sa voiture pour y dormir, 
         faute d aimer le nouveau canapé.'],
        [3, 2015, 'De retour à Los Angeles, BoJack doit assister à des fêtes d écoles insupportables mais dont
         les enfants ont des parents votant aux Oscars. 
         Jill lui rappelle sa promesse et lui demande, si Cuddle a disparu pour de bon,
         de retrouver une lettre cachée chez lui pour elle.']
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::SEASONS as $key => $seasonName) {
        $season = new Season();
        $season->setNumber($seasonName[0]);
        $season->setYear($seasonName[1]);
        $season->setDescription($seasonName[2]);
        $this->setReference('season_' .$key,$season);

            $manager->persist($season);
            $season->setProgram($this->getReference('program_0'));
        }

        $manager->flush();


    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            ProgramFixtures::class,
        ];
    }
}
