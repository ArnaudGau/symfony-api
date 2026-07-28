<?php

namespace App\DataFixtures;

use App\Entity\GameEditor;
use App\Repository\GameEditorRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GameEditorFixtures extends Fixture
{
    public function __construct(
        private GameEditorRepository $gameEditorRepository,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $array = [
            'Nintendo',
            'Sony Interactive Entertainment',
            'Microsoft Gaming',
            'Electronic Arts',
            'Ubisoft',
            'Activision',
            'Blizzard Entertainment',
            'Bethesda Softworks',
            'Take-Two Interactive',
            'Rockstar Games',
            '2K Games',
            'Square Enix',
            'Bandai Namco Entertainment',
            'Capcom',
            'Sega',
            'Konami',
            'Tencent Games',
            'NetEase Games',
            'Paradox Interactive',
            'THQ Nordic',
        ];

        foreach ($array as $key => $value) {
            $existingGameEditor = $this->gameEditorRepository->findOneBy(['name' => $value]);
            if (!$existingGameEditor) {
                $gameEditor = new GameEditor();

                $gameEditor->setName($value);
                $manager->persist($gameEditor);
            }
        }

        $manager->flush();
    }
}
