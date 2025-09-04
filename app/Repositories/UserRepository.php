<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Models\UserType;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getAllUsers()
    {
        return $this->model->with(['userType', 'businessInfo'])->get();
    }

    public function getAllUserTypes()
    {
        return UserType::all();
    }

    public function getUserById($id): ?User
    {
        return $this->model->with(['userType', 'businessInfo'])->find($id);
    }

    public function getTrashedUserById($id)
    {
        return $this->model->onlyTrashed()->with(['userType', 'businessInfo'])->find($id);
    }

    public function createUser(array $data): User
    {
        return $this->model->create($data);
    }

    public function updateUser($id, array $data): User
    {
        $user = $this->model->findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function deleteUser($id): bool
    {
        $user = $this->model->findOrFail($id);
        return $user->delete();
    }

    public function getTrashedUsers()
    {
        return $this->model->onlyTrashed()->with(['userType', 'businessInfo'])->get();
    }

    public function restoreUser($id)
    {
        $user = $this->model->onlyTrashed()->findOrFail($id);
        $user->restore();
        return $user;
    }

    public function forceDeleteUser($id)
{
    $user = $this->model->onlyTrashed()->find($id);
    return $user->forceDelete();
}
}
