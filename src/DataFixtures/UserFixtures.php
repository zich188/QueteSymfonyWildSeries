<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture
{
    private $passwordEncode;

    public function __construct(UserPasswordEncoderInterface $passwordEncode)
    {
        $this->passwordEncode = $passwordEncode;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setPassword($this->passwordEncode->EncodePassword
        (
            $user,
            'the_new_password'
        ));

        // Création d’un utilisateur de type “contributeur” (= auteur)
        $contributor = new User();
        $contributor->setEmail('contributor@monsite.com');
        $contributor->setRoles(['ROLE_CONTRIBUTOR']);
        $this->addReference('contributor', $contributor);
        $contributor->setPassword($this->passwordEncode->encodePassword(
            $contributor,
            'cp'
        ));
        $manager->persist($contributor);

        // Création d’un utilisateur de type “administrateur”
        $admin = new User();
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $this->addReference('admin', $admin);
        $admin->setPassword($this->passwordEncode->encodePassword(
            $admin,
            'ap'
        ));

        $manager->persist($admin);

        // Sauvegarde des 2 nouveaux utilisateurs :
        $manager->flush();
    }
}
