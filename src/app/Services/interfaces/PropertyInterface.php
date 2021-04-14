<?php

namespace App\Services\Interfaces;

use Carbon\Carbon;

interface PropertyInterface extends ServiceInterface
{
    public function countPropertiesNotPurchased(int $ownerId): ?int;
    public function checkPropertiesThreeMonths(object &$property, int $id): void;
}
