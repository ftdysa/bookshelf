<?php

namespace Bookshelf\Fixture;

use Bookshelf\Entity\Author;
use Bookshelf\Entity\Book;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class BookDataLoader extends AbstractFixture implements OrderedFixtureInterface {

    public function getOrder() {
        return 2;
    }

    public function load(ObjectManager $manager) {
        $book = new Book();
        $book->setName('Design Patterns');
        
        $author_names = [
            'Erich Gamma',
            'Richard Helm',
            'Ralph Johnson',
            'John Vlissides'
        ];
        
        foreach ($author_names as $author_name) {
            $author = new Author();
            $author->setName($author_name);

            $book->addAuthor($author);
            $manager->persist($author);
        }

        $book->setAddedBy($this->getReference('user'));

        $manager->persist($book);
        $manager->flush();

        $this->addReference('gof-book', $book);
    }
}