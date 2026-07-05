<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Repository\CategoryRepository;

class CategoryFixtures extends Fixture
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {}

    public function load(ObjectManager $manager): void
    {
        $array = ['Alphabet', 'Food', 'Welcome'];

        foreach ($array as $key => $value) {
            $existingCategory = $this->categoryRepository->findOneBy(['name'
            => $value]);
            if (!$existingCategory) {
                $category = new Category();

                $category->setName($value);
                $manager->persist($category);
            }
        }

        $manager->flush();
    }
}
