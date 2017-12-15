<?php

declare(strict_types=1);

namespace Bookshelf\Repository;

use Bookshelf\Entity\Book;
use Bookshelf\Repository\Traits\Paginate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Pagerfanta\Pagerfanta;
use Symfony\Bridge\Doctrine\RegistryInterface;

class BookRepository extends ServiceEntityRepository {
    use Paginate;

    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Book::class);
    }

    public function findBooks(int $page = 1): Pagerfanta {
        $qb = $this->createQueryBuilder('b')
            ->select(['b', 'a'])
            ->join('b.authors', 'a');

        return $this->createPager($qb->getQuery(), $page);
    }
}
