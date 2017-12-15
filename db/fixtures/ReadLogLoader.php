<?php

namespace Bookshelf\Fixture;

use Bookshelf\Entity\ReadLog;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ReadLogLoader extends AbstractFixture implements OrderedFixtureInterface {

    public function getOrder() {
        return 3;
    }
    
    public function load(ObjectManager $manager) {
        $log = new ReadLog();
        $log->setDateRead(new \DateTime('2017-01-24'));
        $log->setNote('This was a great book.');
        $log->setBook($this->getReference('gof-book'));
        $log->setUser($this->getReference('user'));

        $manager->persist($log);
        $manager->flush();
    }
}