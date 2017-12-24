<?php

declare(strict_types=1);

namespace Bookshelf\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait Timestampable {
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps() {
        $this->setDateUpdated(new \DateTime());

        if ($this->getDateCreated() === null) {
            $this->setDateCreated(new \DateTime());
        }
    }
}
