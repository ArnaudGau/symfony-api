<?php

namespace App\Repository;

use App\Entity\Languages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Languages>
 */
class LanguagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Languages::class);
    }

    public function create($dto): Languages
    {
        $language = new Languages();
        $language->setName($dto->name);
        $language->setCode($dto->code);

        $this->getEntityManager()->persist($language);
        $this->getEntityManager()->flush();

        return $language;
    }

    public function update(Languages $language, $dto): Languages
    {
        $language->setName($dto->name);
        $language->setCode($dto->code);

        $this->getEntityManager()->flush();

        return $language;
    }
//    /**
//     * @return Languages[] Returns an array of Languages objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Languages
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
