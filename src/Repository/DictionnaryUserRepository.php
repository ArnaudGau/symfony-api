<?php

namespace App\Repository;

use App\Entity\Dictionnary;
use App\Entity\DictionnaryUser;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DictionnaryUser>
 */
class DictionnaryUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DictionnaryUser::class);
    }

    public function create($dto, User $user, bool $isCorrect = true): DictionnaryUser
    {
        $dictionnary = $this->getEntityManager()
            ->getRepository(Dictionnary::class)
            ->find($dto->dictionnary_id);

        if (null === $dictionnary) {
            throw new \InvalidArgumentException("La dictionnary avec l'ID {$dto->dictionnary_id} n'existe pas.");
        }

        $dictionnaryUser = $this->findOneBy([
            'dictionnary' => $dictionnary,
            'user' => $user,
        ]);

        if (null === $dictionnaryUser) {
            $dictionnaryUser = new DictionnaryUser();
            $dictionnaryUser->setUser($user);
            $dictionnaryUser->setDictionnary($dictionnary);
        }

        $completion = $dictionnaryUser->getCompletion();

        if ($isCorrect && $completion < 10) {
            ++$completion;
        }

        if (!$isCorrect && $completion > 0) {
            --$completion;
        }

        $dictionnaryUser->setCompletion($completion);

        $this->getEntityManager()->persist($dictionnaryUser);
        $this->getEntityManager()->flush();

        return $dictionnaryUser;
    }

    public function udpate(DictionnaryUser $dictionnaryUser, User $user, bool $isCorrect = true): DictionnaryUser
    {
        $completion = $dictionnaryUser->getCompletion();

        if ($isCorrect && $completion < 10) {
            ++$completion;
        }

        if (!$isCorrect && $completion > 0) {
            --$completion;
        }

        $dictionnaryUser->setCompletion($completion);

        $this->getEntityManager()->persist($dictionnaryUser);
        $this->getEntityManager()->flush();

        return $dictionnaryUser;
    }
}
