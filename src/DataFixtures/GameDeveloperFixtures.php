<?php

namespace App\DataFixtures;

use App\Entity\GameDeveloper;
use App\Repository\GameDeveloperRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GameDeveloperFixtures extends Fixture
{
    public function __construct(
        private GameDeveloperRepository $gameDeveloperRepository,
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
            $existingGameDeveloper = $this->gameDeveloperRepository->findOneBy(['name' => $value]);
            if (!$existingGameDeveloper) {
                $gameDeveloper = new GameDeveloper();

                $gameDeveloper->setName($value);
                $manager->persist($gameDeveloper);
            }
        }

        $manager->flush();
    }
}
