<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {

    }

    public function load(ObjectManager $manager): void
    {
        //Création du super admin
        $user = new User();
        $password = $this->passwordHasher->hashPassword($user, "azaz");
        $user->setNom("SUPER")
            ->setPrenoms("ADMIN")
            ->setMatricule("0001878")
            ->setEmail("superadmin@gmail.com")
            ->setActive(true)
            ->setFonction("Administracteur")
            ->setPassword($password)
            ->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);
        $manager->flush();
    }
}
