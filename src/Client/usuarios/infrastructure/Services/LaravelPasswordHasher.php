<?php

declare(strict_types=1);

namespace Src\Client\usuarios\infrastructure\Services;

use Src\Client\usuarios\domain\Services\PasswordHasherInterface;
use Illuminate\Support\Facades\Hash;

class LaravelPasswordHasher implements PasswordHasherInterface
{
    public function hash(string $password): string
    {
        return Hash::make($password);
    }

    public function verify(string $password, string $hash): bool
    {
        return Hash::check($password, $hash);
    }
} 