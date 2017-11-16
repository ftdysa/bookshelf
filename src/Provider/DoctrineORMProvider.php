<?php

namespace Bookshelf\Provider;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Cache\ApcuCache;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Very barebones Doctrine ORM provider.
 *
 * Class DoctrineORMProvider
 * @package Bookshelf\Provider
 */
class DoctrineORMProvider implements ServiceProviderInterface {

    public function register(Container $app) {
        $app['doctrine.orm.entity_manager'] = function() use ($app) {
           $config = $this->createConfig($app);

           return EntityManager::create($app['doctrine.connection'], $config);
        };
    }

    private function createConfig(Container $app) {
        $is_dev = $app['env'] === 'dev';
        $entities_path = __DIR__.'/../Entity';

        if ($is_dev) {
            $cache = new ArrayCache();
        } else {
            $cache = new ApcuCache();
        }

        $config = new Configuration();
        $config->setMetadataCacheImpl($cache);

        AnnotationRegistry::registerLoader('class_exists');
        $reader = new CachedReader(
            new AnnotationReader(),
            $cache,
            $is_dev
        );

        $driver = new AnnotationDriver($reader, [$entities_path]);

        $config->setMetadataDriverImpl($driver);
        $config->setQueryCacheImpl($cache);
        $config->setProxyDir(__DIR__.'/../../var/cache/doctrine/orm/Proxies');
        $config->setProxyNamespace('Proxies');

        if ($is_dev) {
            $config->setAutoGenerateProxyClasses(true);
        } else {
            $config->setAutoGenerateProxyClasses(false);
        }

        return $config;
    }
}