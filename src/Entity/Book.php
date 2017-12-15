<?php

namespace Bookshelf\Entity;

use Bookshelf\Entity\Traits\Timestampable;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Book.
 *
 * @ORM\Table(name="book", indexes={@ORM\Index(name="IDX_CBE5A331699B6BAF", columns={"added_by"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Book {
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Bookshelf\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="added_by", referencedColumnName="id")
     * })
     */
    private $addedBy;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Bookshelf\Entity\Author", inversedBy="book")
     * @ORM\JoinTable(name="book_author",
     *   joinColumns={
     *     @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     *   }
     * )
     */
    private $author;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->author = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Book
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set dateCreated.
     *
     * @param \DateTime $dateCreated
     *
     * @return Book
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
     * @return Book
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
     * Set addedBy.
     *
     * @param User $addedBy
     *
     * @return Book
     */
    public function setAddedBy(User $addedBy = null) {
        $this->addedBy = $addedBy;

        return $this;
    }

    /**
     * Get addedBy.
     *
     * @return User
     */
    public function getAddedBy() {
        return $this->addedBy;
    }

    /**
     * Add author.
     *
     * @param Author $author
     *
     * @return Book
     */
    public function addAuthor(Author $author) {
        $this->author[] = $author;

        return $this;
    }

    /**
     * Remove author.
     *
     * @param Author $author
     */
    public function removeAuthor(Author $author) {
        $this->author->removeElement($author);
    }

    /**
     * Get author.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAuthor() {
        return $this->author;
    }
}
