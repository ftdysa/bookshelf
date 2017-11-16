<?php

namespace Bookshelf\Provider;

use Bookshelf\Controller\HomeController;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;

/**
 * Routes / controllers for static pages.
 *
 * Class PageControllerProvider
 * @package Bookshelf\Provider
 */
class PageControllerProvider implements ControllerProviderInterface {

    public function connect(Application $app) {
        $app['home.controller'] = function() use ($app) {
            return new HomeController($app['twig']);
        };

        $controllers = $app['controllers_factory'];
        $controllers->get('/', 'home.controller:handleAction');

        return $controllers;
    }
}