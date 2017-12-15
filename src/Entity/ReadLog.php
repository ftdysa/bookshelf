<?php

declare(strict_types=1);

namespace Bookshelf\Entity;

use Bookshelf\Entity\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;

/**
 * ReadLog.
 *
 * @ORM\Table(name="read_log", indexes={@ORM\Index(name="IDX_1ED38997A76ED395", columns={"user_id"}), @ORM\Index(name="IDX_1ED3899716A2B381", columns={"book_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class ReadLog {
    use Timestampable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", nullable=false)
     */
    private $note;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_read", type="datetime", nullable=false)
     */
    private $dateRead;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_updated", type="datetime", nullable=false)
     */
    private $dateUpdated;

    /**
     * @var Book
     *
     * @ORM\ManyToOne(targetEntity="Bookshelf\Entity\Book", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     * })
     */
    private $book;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Bookshelf\Entity\User", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set note.
     *
     * @param string $note
     *
     * @return ReadLog
     */
    public function setNote($note) {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note.
     *
     * @return string
     */
    public function getNote() {
        return $this->note;
    }

    /**
     * Set dateRead.
     *
     * @param \DateTime $dateRead
     *
     * @return ReadLog
     */
    public function setDateRead($dateRead) {
        $this->dateRead = $dateRead;

        return $this;
    }

    /**
     * Get dateRead.
     *
     * @return \DateTime
     */
    public function getDateRead() {
        return $this->dateRead;
    }

    /**
     * Set dateCreated.
     *
     * @param \DateTime $dateCreated
     *
     * @return ReadLog
     */
    public function setDateCreated($dateCreated) {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated.
     *
     * @return \DateTime
     */
    public function getDateCreated() {
        return $this->dateCreated;
    }

    /**
     * Set dateUpdated.
     *
     * @param \DateTime $dateUpdated
     *
     * @return ReadLog
     */
    public function setDateUpdated($dateUpdated) {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * Get dateUpdated.
     *
     * @return \DateTime
     */
    public function getDateUpdated() {
        return $this->dateUpdated;
    }

    /**
     * Set book.
     *
     * @param Book $book
     *
     * @return ReadLog
     */
    public function setBook(Book $book = null) {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book.
     *
     * @return Book
     */
    public function getBook() {
        return $this->book;
    }

    /**
     * Set user.
     *
     * @param User $user
     *
     * @return ReadLog
     */
    public function setUser(User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return User
     */
    public function getUser() {
        return $this->user;
    }
}
