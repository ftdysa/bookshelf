<?php

declare(strict_types=1);

namespace Bookshelf\Entity;

use Bookshelf\Entity\Traits\Timestampable;
use Bookshelf\Search\Searchable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Book.
 *
 * @ORM\Table(name="book", indexes={@ORM\Index(name="IDX_CBE5A331699B6BAF", columns={"added_by"})})
 * @ORM\Entity(repositoryClass="Bookshelf\Repository\BookRepository")
 * @ORM\HasLifecycleCallbacks()
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
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="date_updated", type="datetime", nullable=false)
     */
    private $dateUpdated;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Bookshelf\Entity\User", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="added_by", referencedColumnName="id")
     * })
     */
    private $addedBy;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Bookshelf\Entity\Author", inversedBy="books", cascade={"persist"})
     * @ORM\JoinTable(name="book_author",
     *   joinColumns={
     *     @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     *   }
     * )
     */
    private $authors;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->authors = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int {
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
        $this->authors[] = $author;

        return $this;
    }

    /**
     * Remove author.
     *
     * @param Author $author
     */
    public function removeAuthor(Author $author) {
        $this->authors->removeElement($author);
    }

    public function clearAuthors() {
        $this->authors->clear();
    }

    /**
     * Get author.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAuthors() {
        return $this->authors;
    }

    public function getIndexName(): string {
        return 'book';
    }

    public function getSearchableData(): array {
        $authors = array_map(
            function(Author $author) { return $author->getName(); },
            $this->getAuthors()->getValues()
        );

        return [
            'name' => $this->getName(),
            'authors' => $authors,
        ];
    }


}
