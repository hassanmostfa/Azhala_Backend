<?php

namespace App\Services;

use App\Models\Otp;
use App\Models\User;
use App\Models\OtpSetting;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\NewAccessToken;

class OtpService
{
    /**
     * Send OTP to user
     */
    public function sendOtp(string $phone, string $phoneCode = '+966', string $otpType = 'login'): array
    {
        // Check if there's an existing unused OTP for this phone
        $existingOtp = Otp::where('phone', $phone)
            ->where('phone_code', $phoneCode)
            ->where('otp_type', $otpType)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();

        if ($existingOtp) {
            return [
                'success' => false,
                'message' => 'OTP already sent. Please wait before requesting a new one.',
                'remaining_time' => $existingOtp->expires_at->diffInSeconds(now())
            ];
        }

        // For login type, check if user exists and is active
        if ($otpType === 'login') {
            $user = User::where('phone', $phone)
                ->where('phone_code', $phoneCode)
                ->first();

            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'User not found. Please register first.'
                ];
            }

            if (!$user->is_active) {
                return [
                    'success' => false,
                    'message' => 'Your account is inactive. Please contact support.'
                ];
            }
        }

        // Get OTP settings
        $otpExpiry = $this->getOtpSetting('otp_expiry_minutes', 5);
        $testMode = $this->getOtpSetting('test_mode', true);

        // Generate OTP code
        $otpCode = $testMode ? '1234' : $this->generateOtpCode();

        // Create OTP record (store plain OTP code)
        $otp = Otp::create([
            'otp_code' => $otpCode, // Store plain OTP code without hashing
            'otp_type' => $otpType,
            'otp_mode' => 'sms',
            'user_identifier' => $phone,
            'phone_code' => $phoneCode,
            'phone' => $phone,
            'expires_at' => now()->addMinutes($otpExpiry),
            'is_used' => false,
            'generated_by_ip' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        // In a real application, you would send SMS here
        // For now, we'll just return the OTP code in test mode
        if ($testMode) {
            return [
                'success' => true,
                'message' => 'OTP sent successfully',
                'otp_code' => $otpCode, // Only in test mode
                'verification_token' => $otp->id, // Use OTP's UUID as verification token
                'expires_at' => $otp->expires_at->toISOString()
            ];
        }

        // TODO: Integrate with SMS service
        // $this->sendSms($phone, $phoneCode, $otpCode);

        return [
            'success' => true,
            'message' => 'OTP sent successfully',
            'verification_token' => $otp->id, // Use OTP's UUID as verification token
            'expires_at' => $otp->expires_at->toISOString()
        ];
    }

    /**
     * Verify OTP using verification token (OTP UUID)
     */
    public function verifyOtp(string $verificationToken, string $otpCode): array
    {
        // Find the OTP record by UUID (verification token)
        $otp = Otp::where('id', $verificationToken)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            return [
                'success' => false,
                'message' => 'Invalid or expired verification token'
            ];
        }

        // Verify OTP code (compare plain text)
        if ($otp->otp_code !== $otpCode) {
            return [
                'success' => false,
                'message' => 'Invalid OTP code'
            ];
        }

        // Find or create user before deleting OTP
        $user = User::where('phone', $otp->phone)
            ->where('phone_code', $otp->phone_code)
            ->first();

        if (!$user) {
            // Create new user if not exists
            $user = User::create([
                'name' => 'User ' . Str::random(6),
                'phone_code' => $otp->phone_code,
                'phone' => $otp->phone,
                'is_active' => true,
                'is_approved' => true,
                'user_type_id' => 1 // Default user type
            ]);
        }

        // Delete OTP record after successful verification
        $otp->delete();

        // Prepare response data
        $responseData = [
            'user' => $user->only(['id', 'name', 'phone', 'phone_code'])
        ];

        // Add token only for login type
        if ($otp->otp_type === 'login') {
            // Generate Sanctum token for login
            $token = $user->createToken('auth-token', ['*'], Carbon::now()->addDays(30));
            $responseData['token'] = $token->plainTextToken;
            $responseData['token_type'] = 'Bearer';
            $responseData['expires_at'] = $token->accessToken->expires_at->toISOString();
        }

        return [
            'success' => true,
            'message' => 'OTP verified successfully',
            'data' => $responseData
        ];
    }

    /**
     * Resend OTP
     */
    public function resendOtp(string $phone, string $phoneCode = '+966', string $otpType = 'login'): array
    {
        // Delete any existing unused OTPs for this phone
        Otp::where('phone', $phone)
            ->where('phone_code', $phoneCode)
            ->where('otp_type', $otpType)
            ->where('is_used', false)
            ->delete();

        // Send new OTP
        return $this->sendOtp($phone, $phoneCode, $otpType);
    }

    /**
     * Generate random OTP code
     */
    private function generateOtpCode(): string
    {
        return str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get OTP setting value
     */
    private function getOtpSetting(string $key, $default = null)
    {
        $setting = OtpSetting::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Check if user can request new OTP (rate limiting)
     */
    public function canRequestOtp(string $phone, string $phoneCode = '+966'): bool
    {
        $lastOtp = Otp::where('phone', $phone)
            ->where('phone_code', $phoneCode)
            ->latest()
            ->first();

        if (!$lastOtp) {
            return true;
        }

        // Allow new OTP request after 1 minute
        return $lastOtp->created_at->addMinute()->isPast();
    }
}
