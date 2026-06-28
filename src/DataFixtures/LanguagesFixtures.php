<?php

namespace App\DataFixtures;

use App\Entity\Languages;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LanguagesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $lang = [
            [
                'name' => 'Korean',
                'code' => 'kr',
            ],
            [
                'name' => 'English',
                'code' => 'en',
            ],
        ];

        $languagesRepository = $manager->getRepository(Languages::class);
        foreach ($lang as $data) {
            $languages = $languagesRepository->findOneBy(['code' => $data['code']]) ?? new Languages();
            $languages->setCode($data['code']);
            $languages->setName($data['name']);
            $manager->persist($languages);
        }
        $manager->flush();
    }
}
