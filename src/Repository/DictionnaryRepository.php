<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Dictionnary;
use App\Entity\Languages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dictionnary>
 */
class DictionnaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dictionnary::class);
    }

    public function create($dto): Dictionnary
    {
        $dictionnary = new Dictionnary();
        $dictionnary->setWord($dto->word);
        $dictionnary->setTranslation($dto->translation);
        $language = $this->getEntityManager()->getRepository(Languages::class)->find($dto->language_id);

        if (!$language) {
            throw new \InvalidArgumentException("La langue avec l'ID {$dto->language_id} n'existe pas.");
        }

        // 2. On l'associe
        $dictionnary->setLanguage($language);
        $category = $this->getEntityManager()->getRepository(Category::class)->find($dto->category_id);

        if (!$category) {
            throw new \InvalidArgumentException("La categorie avec l'ID {$dto->category_id} n'existe pas.");
        }

        $dictionnary->setCategory($category);

        $this->getEntityManager()->persist($dictionnary);
        $this->getEntityManager()->flush();

        return $dictionnary;
    }

    public function update(Dictionnary $dictionnary, $dto): Dictionnary
    {
        $dictionnary->setWord($dto->word);
        $dictionnary->setTranslation($dto->translation);
        $language = $this->getEntityManager()->getRepository(Languages::class)->find($dto->language_id);

        if (!$language) {
            throw new \InvalidArgumentException("La langue avec l'ID {$dto->language_id} n'existe pas.");
        }

        // 2. On l'associe
        $dictionnary->setLanguage($language);
        $category = $this->getEntityManager()->getRepository(Category::class)->find($dto->category_id);

        if (!$category) {
            throw new \InvalidArgumentException("La categorie avec l'ID {$dto->category_id} n'existe pas.");
        }

        $dictionnary->setCategory($category);

        $this->getEntityManager()->flush();

        return $dictionnary;
    }

    //    /**
    //     * @return Dictionnary[] Returns an array of Dictionnary objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Dictionnary
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
