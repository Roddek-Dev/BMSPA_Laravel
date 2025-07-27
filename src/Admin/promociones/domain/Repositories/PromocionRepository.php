<?php

namespace Src\Admin\promociones\domain\Repositories;

use Src\Admin\promociones\domain\Entities\Promocion;

interface PromocionRepository
{
    public function findById(int $id): ?Promocion;
    public function findAll(): array;
    public function save(Promocion $promocion): void;
    public function update(int $id, Promocion $promocion): void;
    public function delete(int $id): void;
}