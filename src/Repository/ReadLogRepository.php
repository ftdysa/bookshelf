<?php

declare(strict_types=1);

namespace Bookshelf\Repository;

use Bookshelf\Entity\ReadLog;
use Bookshelf\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ReadLogRepository extends ServiceEntityRepository {
    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, ReadLog::class);
    }

    /**
     * @param User $user
     *
     * @return ReadLog[]
     */
    public function findLogsForUser(User $user): array {
        $qb = $this->createQueryBuilder('l')
            ->select(['l', 'b', 'a'])
            ->join('l.book', 'b')
            ->join('b.authors', 'a')
            ->where('l.user = :user')
            ->setParameter('user', $user);

        return $qb->getQuery()->getResult();
    }
}
