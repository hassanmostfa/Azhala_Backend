<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function getAllUsers();
    public function getAllUserTypes();
    public function getUserById($id);
    public function createUser(array $data);
    public function updateUser($id, array $data);
    public function deleteUser($id);
    public function getTrashedUsers();
    public function restoreUser($id);
    public function forceDeleteUser($id);
    public function getTrashedUserById($id);
}
