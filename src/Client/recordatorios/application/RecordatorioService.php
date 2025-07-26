<?php

namespace Src\Client\recordatorios\application;

use Src\Client\recordatorios\domain\Repositories\RecordatorioRepository;
use Src\Client\recordatorios\domain\Entities\Recordatorio;

final class RecordatorioService
{
    public function __construct(private readonly RecordatorioRepository $repository)
    {
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findById(int $id): ?Recordatorio
    {
        return $this->repository->findById($id);
    }

    public function save(Recordatorio $recordatorio): void
    {
        $this->repository->save($recordatorio);
    }

    public function update(int $id, Recordatorio $recordatorio): void
    {
        $this->repository->update($id, $recordatorio);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}