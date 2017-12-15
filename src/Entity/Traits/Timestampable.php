<?php

namespace Bookshelf\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait Timestampable {
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps() {
        $this->setDateUpdated(new \DateTime());

        if (null == $this->getDateCreated()) {
            $this->setDateCreated(new \DateTime());
        }
    }
}
