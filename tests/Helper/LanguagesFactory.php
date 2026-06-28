<?php

namespace App\Tests\Helper;

use App\Entity\Languages;
use Doctrine\ORM\EntityManagerInterface;

final class LanguagesFactory
{
    public static function create(EntityManagerInterface $entityManager, string $name, string $code): Languages
    {
        $language = new Languages();
        $language->setName($name);
        $language->setCode($code);

        $entityManager->persist($language);
        $entityManager->flush();

        return $language;
    }
}
