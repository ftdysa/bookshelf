<?php

namespace Bookshelf\Fixture;

use Bookshelf\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class UserDataLoader extends AbstractFixture implements OrderedFixtureInterface {

    public function getOrder() {
        return 1;
    }

    public function load(ObjectManager $manager) {
        $user = new User();
        $user->setUsername('username');
        $user->setName('Test User');

        $hash = password_hash('password', PASSWORD_BCRYPT, ['cost' => 15]);
        $user->setPassword($hash);

        $manager->persist($user);
        $manager->flush();

        $this->addReference('user', $user);
    }
}