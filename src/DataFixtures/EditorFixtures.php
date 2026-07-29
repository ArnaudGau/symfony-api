<?php

namespace App\DataFixtures;

use App\Entity\Editor;
use App\Repository\EditorRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EditorFixtures extends Fixture
{
    public function __construct(
        private EditorRepository $editorRepository,
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
            $existingEditor = $this->editorRepository->findOneBy(['name' => $value]);
            if (!$existingEditor) {
                $editor = new Editor();

                $editor->setName($value);
                $manager->persist($editor);
            }
        }

        $manager->flush();
    }
}
