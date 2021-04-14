<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Services\Interfaces\UserInterface;
use Illuminate\Database\Eloquent\Collection;

class UserService implements UserInterface
{
    private User $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function getOne(int $id): ?object
    {
        return $this->model->find($id);
    }

    public function save(array $data, int $id = null): int
    {
        $data['updated_at'] = Carbon::now();
        
        if(!$id) {
            $data['created_at'] = Carbon::now();
            $user = $this->model->create($data);
            $return = $user['id'];
        } else {
            $return = $this->model->where('id', $id)->update($data);
        }

        return $return;
    }

    public function delete($id): int
    {
        return $this->model->destroy($id);
    }

    public function getProperties(int $id): ?object
    {
        return $this->model->where(['id' => $id])->with('properties')->get();
    }
}