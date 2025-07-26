<?php

namespace Src\Admin\personal\application;

use Src\Admin\personal\domain\Repositories\PersonalRepository;
use Src\Admin\personal\domain\Entities\Personal;

final class PersonalService
{
    public function __construct(private readonly PersonalRepository $repository)
    {
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findById(int $id): ?Personal
    {
        return $this->repository->findById($id);
    }

    public function save(Personal $personal): void
    {
        $this->repository->save($personal);
    }

    public function update(int $id, Personal $personal): void
    {
        $this->repository->update($id, $personal);
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }
}