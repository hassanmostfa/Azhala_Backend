<?php

namespace App\Services;

use App\Interfaces\UserRepositoryInterface;
use App\Traits\ImageUploadTrait;
use App\Models\UserType;
use App\Models\UserBusinessInfo;

class UserService
{
    use ImageUploadTrait;

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }

    public function getUserById($id)
    {
        return $this->userRepository->getUserById($id);
    }

    public function getAllUserTypes()
    {
        return $this->userRepository->getAllUserTypes();
    }

    public function createUser(array $data)
    {

        $user = $this->userRepository->createUser($data);

        // Handle photo upload
        if (isset($data['photo'])) {
            $photoPath = $this->uploadSingleImage($data['photo'], $user, 'avatar.jpg', 'users');
            if ($photoPath) {
                $user->update(['photo' => $photoPath]);
            }
        }

        // Handle business info if not customer
        $customerType = UserType::where('type', 'customer')->first();
        if (isset($data['user_type_id']) && $data['user_type_id'] != ($customerType->id ?? null)) {

            UserBusinessInfo::create([
                'user_id' => $user->id,
                'commercial_register' => $data['commercial_register'] ?? null,
                'tax_number' => $data['tax_number'] ?? null,
            ]);
        }

        return $user;
    }

    public function updateUser($id, array $data)
    {

        $user = $this->userRepository->updateUser($id, $data);

        // Handle photo upload
        if (isset($data['photo'])) {
            if ($user->photo) {
                $this->deleteImage($user->photo);
            }
            $photoPath = $this->uploadSingleImage($data['photo'], $user, 'avatar.jpg', 'users');
            if ($photoPath) {
                $user->update(['photo' => $photoPath]);
            }
        }

        // Handle business info if not customer
        $customerType = UserType::where('type', 'customer')->first();
        if (isset($data['user_type_id']) && $data['user_type_id'] != ($customerType->id ?? null)) {
            $businessInfo = $user->businessInfo ?? new UserBusinessInfo(['user_id' => $user->id]);

            $businessInfo->fill([
                'commercial_register' => $data['commercial_register'] ?? null,
                'tax_number' => $data['tax_number'] ?? null,
            ])->save();
        } elseif ($user->businessInfo) {

            $user->businessInfo->delete();
        }

        return $user;
    }

    public function deleteUser($id)
    {
        $user = $this->userRepository->getUserById($id);
        if ($user->photo) {
            $this->deleteImage($user->photo);
        }
        return $this->userRepository->deleteUser($id);
    }
}
