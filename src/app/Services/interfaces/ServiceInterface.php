<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ServiceInterface
{
    public function getAll(): Collection;
    public function getOne(int $id): ?object;
    public function save(array $data, int $id = null): int;
    public function delete(int $int): int;
}