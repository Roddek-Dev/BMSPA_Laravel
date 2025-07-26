<?php

namespace Src\Client\recordatorios\domain\Repositories;

use Src\Client\recordatorios\domain\Entities\Recordatorio;

interface RecordatorioRepository
{
    public function findById(int $id): ?Recordatorio;
    public function findAll(): array;
    public function save(Recordatorio $recordatorio): void;
    public function update(int $id, Recordatorio $recordatorio): void;
    public function delete(int $id): void;
}