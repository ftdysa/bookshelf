<?php

namespace Bookshelf\Form;

class ChangePasswordModel {
    private $oldPassword;
    private $newPassword;

    public function setNewPassword(string $newPassword): ChangePasswordModel {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function getNewPassword(): ?string {
        return $this->newPassword;
    }

    public function setOldPassword(string $oldPassword): ChangePasswordModel {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    public function getOldPassword(): ?string {
        return $this->oldPassword;
    }
}
