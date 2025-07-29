<?php

declare(strict_types=1);

namespace Src\Client\usuarios\application\Profile\Command;

final class ChangePasswordCommand
{
    public function __construct(
        private int $userId,
        private string $currentPassword,
        private string $newPassword
    ) {}

    public function userId(): int
    {
        return $this->userId;
    }

    public function currentPassword(): string
    {
        return $this->currentPassword;
    }

    public function newPassword(): string
    {
        return $this->newPassword;
    }
}
