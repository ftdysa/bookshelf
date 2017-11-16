<?php

namespace Bookshelf;

use Bookshelf\Provider\ConfigServiceProvider;
use Bookshelf\Provider\DoctrineORMProvider;
use Bookshelf\Provider\PageControllerProvider;
use Silex\Application as BaseApplication;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\TwigServiceProvider;

final class Application extends BaseApplication {

    public function __construct(array $values = array()) {
        parent::__construct($values);

        $this->registerServiceProviders();
        $this->registerControllerProviders();
    }

    final private function registerServiceProviders() {
        $this->register(new ConfigServiceProvider(
            __DIR__.'/../config/config.yml'
        ));
        $this->register(new TwigServiceProvider(), [
            'twig.path' => __DIR__.'/../views',
        ]);
        $this->register(new ServiceControllerServiceProvider());
        $this->register(new DoctrineORMProvider());
    }

    final private function registerControllerProviders() {
        $this->mount('/', new PageControllerProvider());
    }
}