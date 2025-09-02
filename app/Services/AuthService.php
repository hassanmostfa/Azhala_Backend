<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * Register a new user
     */
    public function register(array $data): array
    {
        try {
            // Check if user already exists
            $existingUser = User::where('phone', $data['phone'])
                ->where('phone_code', $data['phone_code'])
                ->first();

            if ($existingUser) {
                return [
                    'success' => false,
                    'message' => 'User already exists with this phone number'
                ];
            }

            // Get default user type if not provided
            $userTypeId = $data['user_type_id'] ?? 1;

            // Create new user
            $user = User::create([
                'name' => $data['name'],
                'phone_code' => $data['phone_code'],
                'phone' => $data['phone'],
                'address' => $data['address'] ?? null,
                'latitude' => $data['latitude'] ?? null,
                'longitude' => $data['longitude'] ?? null,
                'photo' => $data['photo'] ?? null,
                'is_approved' => true, // Auto approve for now
                'user_type_id' => $userTypeId,
                'is_active' => true
            ]);

            // Generate Sanctum token
            $token = $user->createToken('auth-token', ['*'], now()->addDays(30));

            return [
                'success' => true,
                'message' => 'User registered successfully',
                'token' => $token->plainTextToken,
                'user' => $user->only(['id', 'name', 'phone', 'phone_code', 'address', 'latitude', 'longitude', 'photo', 'is_approved', 'user_type_id', 'is_active']),
                'token_type' => 'Bearer',
                'expires_at' => $token->accessToken->expires_at->toISOString()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Logout user (revoke all tokens)
     */
    public function logout(): array
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'No authenticated user found'
                ];
            }

            // Revoke all tokens for the user
            $user->tokens()->delete();

            return [
                'success' => true,
                'message' => 'Logged out successfully'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Logout failed: ' . $e->getMessage()
            ];
        }
    }

}
