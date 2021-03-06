<?php

declare(strict_types=1);

namespace Bookshelf\Entity;

use Bookshelf\Entity\Traits\Timestampable;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * User.
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_8D93D649F85E0677", columns={"username"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class User implements AdvancedUserInterface, Serializable {
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
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=64, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

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
     * @return User
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
     * Set username.
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set dateCreated.
     *
     * @param \DateTime $dateCreated
     *
     * @return User
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
     * @return User
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

    /*
     * AdvancedUserInterface methods.
     */

    public function isAccountNonExpired() {
        return true;
    }

    public function isAccountNonLocked() {
        return true;
    }

    public function isCredentialsNonExpired() {
        return true;
    }

    public function isEnabled() {
        return true;
    }

    public function getRoles() {
        return ['ROLE_USER', 'ROLE_ADMIN'];
    }

    public function getSalt() {
        return null;
    }

    public function eraseCredentials() {
    }

    /*
     * Serializable
     */

    public function serialize() {
        return serialize([
            $this->id,
            $this->name,
            $this->username,
            $this->password,
            $this->dateCreated,
            $this->dateUpdated,
        ]);
    }

    public function unserialize($serialized) {
        list(
            $this->id,
            $this->name,
            $this->username,
            $this->password,
            $this->dateCreated,
            $this->dateUpdated) = unserialize($serialized);
    }
}
