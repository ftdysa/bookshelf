<?php

declare(strict_types=1);

namespace Bookshelf\Form;

use Bookshelf\Entity\ReadLog;
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

    public function setBook(string $book): CreateReadLogModel {
        $this->book = $book;

        return $this;
    }

    public function getAuthors(): array {
        return $this->authors;
    }

    public function setAuthors(array $authors): CreateReadLogModel {
        $this->authors = $authors;

        return $this;
    }

    public function getComment(): ?string {
        return $this->comment;
    }

    public function setComment(string $comment): CreateReadLogModel {
        $this->comment = $comment;

        return $this;
    }

    public function getDateRead(): ?\DateTime {
        return $this->dateRead;
    }

    public function setDateRead(\DateTime $dateRead = null): CreateReadLogModel {
        $this->dateRead = $dateRead;

        return $this;
    }

    public static function createFromEntity(ReadLog $log) {
        $model = new self();
        $model
            ->setAuthors($log->getBook()->getAuthors()->getValues())
            ->setBook($log->getBook()->getName())
            ->setComment($log->getNote())
            ->setDateRead($log->getDateRead());

        return $model;
    }
}
