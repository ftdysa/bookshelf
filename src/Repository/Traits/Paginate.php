<?php

declare(strict_types=1);

namespace Bookshelf\Repository\Traits;

use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

trait Paginate {
    private function createPager(Query $query, int $page): Pagerfanta {
        $pager = new Pagerfanta(new DoctrineORMAdapter($query));
        $pager->setMaxPerPage(25);
        $pager->setCurrentPage($page);

        return $pager;
    }
}
