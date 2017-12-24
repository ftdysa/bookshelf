<?php

declare(strict_types=1);

namespace Bookshelf\Search\EventListener;

use Bookshelf\Search\IndexManager;
use Bookshelf\Search\Searchable;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

class SearchIndexerSubscriber implements EventSubscriber {
    private $manager;

    public function __construct(IndexManager $manager) {
        $this->manager = $manager;
    }

    public function getSubscribedEvents() {
        return [
            'postPersist',
            'postUpdate',
            'preRemove',
        ];
    }

    public function postUpdate(LifecycleEventArgs $args) {
        $this->index($args);
    }

    public function postPersist(LifecycleEventArgs $args) {
        $this->index($args);
    }

    public function preRemove(LifecycleEventArgs $args) {
        $obj = $args->getObject();

        if ($obj instanceof Searchable) {
            $this->manager->remove($obj);
        }
    }

    private function index(LifecycleEventArgs $args) {
        $obj = $args->getObject();

        if ($obj instanceof Searchable) {
            $this->manager->index($obj);
        }
    }
}
