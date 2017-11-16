<?php

namespace Bookshelf;

use Bookshelf\Provider\ConfigServiceProvider;
use Bookshelf\Provider\DoctrineORMProvider;
use Silex\Application as BaseApplication;

final class Application extends BaseApplication {

    public function __construct(array $values = array()) {
        parent::__construct($values);

        $this->register(new ConfigServiceProvider(
            __DIR__.'/../config/config.yml'
        ));
        $this->register(new DoctrineORMProvider());
    }
}