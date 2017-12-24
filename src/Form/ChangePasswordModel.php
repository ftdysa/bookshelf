<?php

declare(strict_types=1);

namespace Bookshelf\Form;

class ChangePasswordModel {
    private $oldPassword;
    private $newPassword;

    public function setNewPassword(string $newPassword): self {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function getNewPassword(): ?string {
        return $this->newPassword;
    }

    public function setOldPassword(string $oldPassword): self {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    public function getOldPassword(): ?string {
        return $this->oldPassword;
    }
}
