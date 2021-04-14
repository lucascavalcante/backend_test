<?php

namespace App\Services\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface UserInterface extends ServiceInterface
{
    public function getProperties(int $id): ?object;
}