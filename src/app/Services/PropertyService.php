<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Property;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Interfaces\PropertyInterface;

class PropertyService implements PropertyInterface
{
    private Property $model;

    public function __construct(Property $property)
    {
        $this->model = $property;
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function getOne(int $id): ?object
    {
        $property = $this->model->find($id);
        $this->checkPropertiesThreeMonths($property, $id);

        return $property;
    }

    public function save(array $data, int $id = null): int
    {
        $data['updated_at'] = Carbon::now();
        
        if(!$id) {
            $data['created_at'] = Carbon::now();
            $data['purchased'] = false;
            $data['expired'] = false;

            $property = $this->model->create($data);
            $return = $property['id'];
        } else {
            $return = $this->model->where('id', $id)->update($data);
        }

        return $return;
    }

    public function delete($id): int
    {
        return $this->model->destroy($id);
    }

    public function countPropertiesNotPurchased(int $ownerId): ?int
    {
        $query = $this->model->where(['owner_id' => $ownerId, 'purchased' => false])->get()->count();
        
        return $query === 3 ? $query : null;
    }

    public function checkPropertiesThreeMonths(object &$property, int $id): void
    {
        if(!$property['expired'] && Carbon::now()->subMonths(3)->gt(Carbon::parse($property['created_at']))){
            $property['expired'] = 1;
            $this->save(['expired' => true], $id);
        }
    }
}