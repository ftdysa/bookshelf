<?php

namespace Bookshelf\Search;

use AlgoliaSearch\Client;
use AlgoliaSearch\Version;
use Bookshelf\Entity\Author;
use Bookshelf\Entity\Book;
use Bookshelf\Entity\ReadLog;
use Bookshelf\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class IndexManager {
    private $client;

    public function __construct(Client $client) {
        Version::addSuffixUserAgentSegment('Bookshelf', '0.0.1');

        $this->client = $client;
    }

    public function index($objects) {
        if (!is_array($objects)) {
            $objects = [$objects];
        }

        $this->batchUpdate(...$objects);
    }

    public function remove($objects) {
        if (!is_array($objects)) {
            $objects = [$objects];
        }

        $this->batchDelete(...$objects);
    }

    public function getSearchableEntities(): array {
        // Maybe move this to a service config later?
        $allEntities = [
            Author::class,
            Book::class,
            ReadLog::class,
            User::class,
        ];

        return array_filter($allEntities, function($className) {
            $obj = new $className();

            return $obj instanceof Searchable;
        });
    }

    private function batchUpdate(Searchable ...$objects) {
        foreach (array_chunk($objects, 500) as $chunk) {
            $data = [];

            foreach ($chunk as $obj) {
                $indexName = $obj->getIndexName();
                if (!isset($data[$indexName])) {
                    $data[$indexName] = [];
                }

                $data[$indexName][] = $obj->getSearchableData() + [
                        'objectID' => $obj->getId(),
                    ];
            }

            foreach ($data as $indexName => $objects) {
                $this->client
                    ->initIndex($indexName)
                    ->addObjects($objects);
            }
        }
    }

    private function batchDelete(Searchable ...$objects) {
        foreach (array_chunk($objects, 500) as $chunk) {
            $data = [];
            foreach ($chunk as $obj) {
                $indexName = $obj->getIndexName();
                if (!isset($data[$indexName])) {
                    $data[$indexName] = [];
                }

                $data[$indexName][] = $obj->getId();
            }

            foreach ($data as $indexName => $objects) {
                $this->client
                    ->initIndex($indexName)
                    ->deleteObjects($objects);
            }
        }
    }
}
