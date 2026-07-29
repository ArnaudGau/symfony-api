<?php

namespace App\Repository;

use App\Entity\GameConsole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GameConsole>
 */
class GameConsoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameConsole::class);
    }

    public function create($dto): GameConsole
    {
        $gameConsole = new GameConsole();
        $gameConsole->setName($dto->name);
        $this->getEntityManager()->persist($gameConsole);
        $this->getEntityManager()->flush();

        return $gameConsole;
    }

    public function update(GameConsole $gameConsole, $dto): GameConsole
    {
        $gameConsole->setName($dto->name);
        $this->getEntityManager()->flush();

        return $gameConsole;
    }
    //    /**
    //     * @return GameConsole[] Returns an array of GameConsole objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('g.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?GameConsole
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
