<?php

namespace App\Repository;

use App\Entity\GameEditor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GameEditor>
 */
class GameEditorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameEditor::class);
    }

    public function create($dto): GameEditor
    {
        $gameEditor = new GameEditor();
        $gameEditor->setName($dto->name);
        $this->getEntityManager()->persist($gameEditor);
        $this->getEntityManager()->flush();

        return $gameEditor;
    }

    public function update(GameEditor $gameEditor, $dto): GameEditor
    {
        $gameEditor->setName($dto->name);
        $this->getEntityManager()->flush();

        return $gameEditor;
    }
    //    /**
    //     * @return GameEditor[] Returns an array of GameEditor objects
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

    //    public function findOneBySomeField($value): ?GameEditor
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
