<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function create($dto): Category
    {
        $category = new Category();
        $category->setName($dto->name);

        $this->getEntityManager()->persist($category);
        $this->getEntityManager()->flush();

        return $category;
    }

    public function update(Category $category, $dto): Category
    {
        $category->setName($dto->name);

        $this->getEntityManager()->flush();

        return $category;
    }
}
