<?php

namespace Bookshelf\Repository;

use Bookshelf\Entity\Author;
use Bookshelf\Repository\Traits\Paginate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Pagerfanta\Pagerfanta;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AuthorRepository extends ServiceEntityRepository {
    use Paginate;

    public function __construct(RegistryInterface $registry) {
        parent::__construct($registry, Author::class);
    }

    public function findAuthors(int $page = 1): Pagerfanta {
        $qb = $this->createQueryBuilder('a')
            ->select(['a']);

        return $this->createPager($qb->getQuery(), $page);
    }
}