<?php

declare(strict_types=1);

namespace Bookshelf\Form;

use Symfony\Component\Validator\Constraints as Assert;

class CreateReadLogModel {
    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    private $book;

    private $authors = [];

    /**
     * @Assert\NotBlank()
     */
    private $comment;

    /**
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    private $dateRead;

    public function getBook(): ?string {
        return $this->book;
    }

    public function setBook(string $book) {
        $this->book = $book;
    }

    public function getAuthors(): array {
        return $this->authors;
    }

    public function setAuthor(array $authors) {
        $this->authors = $authors;
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

    public function setDateRead(\DateTime $dateRead = null) {
        $this->dateRead = $dateRead;
    }
}
