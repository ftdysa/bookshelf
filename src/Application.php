<?php

namespace Bookshelf;

use Bookshelf\Provider\DoctrineORMProvider;
use Silex\Application as BaseApplication;

final class Application extends BaseApplication {

    public function __construct(array $values = array()) {
        parent::__construct($values);

        $this->register(new DoctrineORMProvider(), [
            'env' => 'dev',
            'doctrine.connection' => [
                'driver' => 'pdo_mysql',
                'dbname' => 'bookshelf',
                'user' => 'bookshelf',
                'host' => 'localhost',
                'password' => 'password',
            ]
        ]);
    }
}