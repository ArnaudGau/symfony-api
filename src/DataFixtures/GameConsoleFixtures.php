<?php

namespace App\DataFixtures;

use App\Entity\GameConsole;
use App\Repository\GameConsoleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GameConsoleFixtures extends Fixture
{
    public function __construct(
        private GameConsoleRepository $gameConsoleRepository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $array = [
            'NES',
            'Super Nintendo Entertainment System',
            'Nintendo 64',
            'GameCube',
            'Wii',
            'Wii U',
            'Nintendo Switch',
            'Nintendo Switch 2',
            'Game Boy',
            'Game Boy Color',
            'Game Boy Advance',
            'Nintendo DS',
            'Nintendo 3DS',
            'PlayStation',
            'PlayStation 2',
            'PlayStation 3',
            'PlayStation 4',
            'PlayStation 5',
            'PSP',
            'PlayStation Vita',
            'Xbox',
            'Xbox 360',
            'Xbox One',
            'Xbox Series S',
            'Xbox Series X',
            'Sega Master System',
            'Mega Drive',
            'Sega Saturn',
            'Dreamcast',
            'Game Gear',
            'Atari 2600',
            'Atari Jaguar',
            'Neo Geo AES',
            'Neo Geo Pocket',
            'PC Engine',
            'TurboGrafx-16',
            'Steam Deck',
            'PC',
        ];

        foreach ($array as $key => $value) {
            $existingGameConsole = $this->gameConsoleRepository->findOneBy(['name' => $value]);
            if (!$existingGameConsole) {
                $gameConsole = new GameConsole();

                $gameConsole->setName($value);
                $manager->persist($gameConsole);
            }
        }

        $manager->flush();
    }
}
