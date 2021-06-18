<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{

    private  $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public const PROGRAMS = [
        ['Bojack Horseman', 'Dans un monde parallèle où les humains et les animaux anthropomorphes vivent côte à côte, BoJack Horseman, un cheval acteur connu pour avoir joué dans une sitcom fictive des années 1990,
         Horsin vit à Hollywood (renommée dans la première saison "Hollywoo" après la disparition de la lettre D du panneau). 
         Après un passage à vide de 18 ans, il s efforce de retrouver la célébrité dans le monde hypercompétitif du show-business,
         et y parviendra un temps grâce à son interprétation du rôle de Secretariat dans un biopic sur la vie du célèbre cheval de course.'
        ,'https://i.ytimg.com/vi/9f1ovIps0oA/maxresdefault.jpg', 'states', 2013],
        ['Brooklyn Nine-Nine', 'Brooklyn Nine-Nine raconte la vie d un commissariat de police dans l arrondissement de Brooklyn à New York. L arrivée d un nouveau capitaine, froid et strict,
         fait rapidement regretter aux détectives son prédécesseur.', 'https://www.sortiraparis.com/images/80/66131/553687-series-brooklyn-nine-nine-s07-critique-et-bande-annonce.jpg',
        'states',2013],
        ['La casa de papel', 'Huit voleurs font une prise d otages dans la Maison royale de la Monnaie d Espagne, 
        tandis qu un génie du crime manipule la police pour mettre son plan à exécution.', 'https://images.critictoo.com/wp-content/uploads/2019/07/La-Casa-De-Papel-Saison-1-Casting.jpg',
            'spain', 2017],
        ['The Crown', 'The Crown présente la vie de la souveraine du Royaume-Uni, Élisabeth II , de son mariage en 1947 jusqu à nos jours, durant six saisons,
         chacune couvrant une décennie du règne de la souveraine britannique.', 'https://fr.web.img4.acsta.net/pictures/19/10/22/14/31/2797425.jpg',
            'British', 2017]
    ];

    public function load(ObjectManager $manager)
    {

        foreach (self::PROGRAMS as $key => $programName) {
            $program = new Program();
            $program->setTitle($programName[0]);
            $program->setSynopsis($programName[1]);
            $program->setPoster($programName[2]);
            $program->setCategory($this->getReference('category_0'));
            $program->setCountry($programName[3]);
            $program->setYear($programName[4]);
            //ici les acteurs sont insérés via une boucle pour être DRY mais ce n'est pas obligatoire (pour incrémenter)
            //for ($i=0; $i < count(ActorFixtures::ACTORS); $i++) {
            $program->addActor($this->getReference('actor_'.rand(0,9)));
            $program->addActor($this->getReference('actor_'.rand(0,9)));
            //}
            $program->setOwner($this->getReference('admin'));
            $program->setSlug($this->slugify->generate($programName[0]));
            $manager->persist($program);
            $this->addReference('program_'.$key, $program);
        }
        $manager->flush();

    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            ActorFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
