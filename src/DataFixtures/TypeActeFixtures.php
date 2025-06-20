<?php

namespace App\DataFixtures;

use App\Entity\TypeActe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeActeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $values = ['Acte e naissance', 'Acte de mariage'];
        foreach ($values as $value) {
            $typeActe = new TypeActe();
            $typeActe->setLibelle($value);
            $manager->persist($typeActe);
        }

        $manager->flush();
    }
}
