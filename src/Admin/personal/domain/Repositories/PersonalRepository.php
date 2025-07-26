<?php

namespace Src\Admin\personal\domain\Repositories;

use Src\Admin\personal\domain\Entities\Personal;

interface PersonalRepository
{
    public function findById(int $id): ?Personal;
    public function findAll(): array;
    public function save(Personal $personal): void;
    public function update(int $id, Personal $personal): void;
    public function delete(int $id): void;
}