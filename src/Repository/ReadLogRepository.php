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

    /**
     * Ghetto fab search function.
     *
     * @param User $user
     * @param $term
     * @return array
     */
    public function findLogsMatching(User $user, $term): array {
        $qb = $this->createQueryBuilder('l');

        $qb
            ->select(['l', 'b', 'a'])
            ->join('l.book', 'b')
            // Join twice on authors. Use the "s" alias for the search so that the "a" alias
            // will still contain every author for that book.
            ->join('b.authors', 'a')
            ->join('b.authors', 's')
            ->where('l.user = :user')
            ->andWhere($qb->expr()
                ->orX(
                    $qb->expr()->like('b.name', ':term'),
                    $qb->expr()->like('s.name', ':term')
                )
            )
            ->setParameter('user', $user)
            ->setParameter('term', "%$term%");

        return $qb->getQuery()->getResult();
    }
}
