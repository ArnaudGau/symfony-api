<?php

namespace App\DataFixtures;

use App\Entity\Developer;
use App\Repository\DeveloperRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DeveloperFixtures extends Fixture
{
    public function __construct(
        private DeveloperRepository $developerRepository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $array = [
            'Nintendo',
            'Naughty Dog',
            'Santa Monica Studio',
            'Insomniac Games',
            'Rockstar North',
            'Rockstar San Diego',
            'CD Projekt Red',
            'Larian Studios',
            'FromSoftware',
            'Guerrilla Games',
            'Remedy Entertainment',
            'Arkane Studios',
            'id Software',
            'MachineGames',
            'Obsidian Entertainment',
            'BioWare',
            'Respawn Entertainment',
            'Valve',
            'Bungie',
            'Playground Games',
        ];

        foreach ($array as $key => $value) {
            $existingDeveloper = $this->developerRepository->findOneBy(['name' => $value]);
            if (!$existingDeveloper) {
                $developer = new Developer();

                $developer->setName($value);
                $manager->persist($developer);
            }
        }

        $manager->flush();
    }
}
