<?php

declare(strict_types=1);

namespace Bookshelf\Repository;

use Bookshelf\Entity\ReadLog;
use Bookshelf\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ReadLogRepository extends ServiceEntityRepository {
    /**
     * The current user.
     *
     * @var User
     */
    private $user;

    public function __construct(RegistryInterface $registry, TokenStorageInterface $storage) {
        parent::__construct($registry, ReadLog::class);

        $this->user = $storage->getToken()->getUser();
    }

    /**
     * @return array
     */
    public function findLogsForUser(): array {
        $qb = $this->createQueryBuilder('l')
            ->select(['l', 'b', 'a'])
            ->join('l.book', 'b')
            ->join('b.authors', 'a')
            ->where('l.user = :user')
            ->setParameter('user', $this->user);

        return $qb->getQuery()->getResult();
    }

    public function findLog(int $id): ?ReadLog {
        $qb = $this->createQueryBuilder('l')
            ->select(['l', 'b', 'a'])
            ->join('l.book', 'b')
            ->join('b.authors', 'a')
            ->where('l.user = :user')
            ->andWhere('l.id = :id')
            ->setParameter('user', $this->user)
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * A terrible search function.
     *
     * @param $term
     * @return array
     */
    public function findLogsMatching($term): array {
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
            ->setParameter('user', $this->user)
            ->setParameter('term', "%$term%");

        return $qb->getQuery()->getResult();
    }
}
