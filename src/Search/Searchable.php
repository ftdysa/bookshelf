<?php

declare(strict_types=1);

namespace Bookshelf\Search;

interface Searchable {
    public function getIndexName(): string;

    public function getSearchableData(): array;

    public function getId(): int;
}
