<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $statuses = [
            [
                'reference' => 'STATUS_DEMANDE_SOUMISE',
                'libelle' => 'En attente de traitement'
            ],
            [
                'reference' => 'STATUS_DEMANDE_EN_COURS_TRAITEMENT',
                'libelle' => 'En cours de traitement'
            ],
            [
                'reference' => 'STATUS_DEMANDE_VALIDEE',
                'libelle' => 'Validée'
            ],
            [
                'reference' => 'STATUS_DEMANDE_ANNULEE',
                'libelle' => 'Annulée'
            ],
            [
                'reference' => 'STATUS_DEMANDE_REJETEE',
                'libelle' => 'Rejetée'
            ]
        ];

        foreach ($statuses as $value) {
            $status = new Status();
            $status->setReference($value['reference']);
            $status->setLibelle($value['libelle']);
            $manager->persist($status);
        }
        $manager->flush();
    }
}
