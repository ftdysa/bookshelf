<?php

declare(strict_types=1);

namespace Bookshelf\Form;

use Bookshelf\Entity\Author;
use Bookshelf\Entity\Book;

class CreateReadLogModel {
    private $book;
    private $author;
    private $comment;
    private $dateRead;

    public function getBook(): ?Book {
        return $this->book;
    }

    public function setBook(Book $book) {
        $this->book = $book;
    }

    public function getAuthor(): ?Author {
        return $this->author;
    }

    public function setAuthor(Author $author) {
        $this->author = $author;
    }

    public function getComment(): ?string {
        return $this->comment;
    }

    public function setComment(string $comment) {
        $this->comment = $comment;
    }

    public function getDateRead(): ?\DateTime {
        return $this->dateRead;
    }

    public function setDateRead(\DateTime $dateRead) {
        $this->dateRead = $dateRead;
    }
}
