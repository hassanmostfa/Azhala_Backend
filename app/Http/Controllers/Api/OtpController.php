<?php

namespace App\Http\Controllers\Api;

use App\Services\OtpService;
use App\Http\Requests\OtpRequest;

class OtpController extends BaseApiController
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Send OTP
     */
    public function sendOtp(OtpRequest $request)
    {
        $phone = $request->phone;
        $phoneCode = $request->phone_code;
        $otpType = $request->type;

        // Check rate limiting
        if (!$this->otpService->canRequestOtp($phone, $phoneCode)) {
            return $this->tooManyRequestsResponse('Please wait before requesting a new OTP');
        }

        $result = $this->otpService->sendOtp($phone, $phoneCode, $otpType);

        if ($result['success']) {
            return $this->successResponse($result, $result['message']);
        }

        return $this->errorResponse($result['message']);
    }

    /**
     * Verify OTP using verification token
     */
    public function verifyOtp(OtpRequest $request)
    {
        $verificationToken = $request->verification_token;
        $otpCode = $request->otp_code;

        $result = $this->otpService->verifyOtp($verificationToken, $otpCode);

        if ($result['success']) {
            return $this->successResponse($result, $result['message']);
        }

        return $this->errorResponse($result['message']);
    }

    /**
     * Resend OTP
     */
    public function resendOtp(OtpRequest $request)
    {
        $phone = $request->phone;
        $phoneCode = $request->phone_code ?? '+966';
        $otpType = $request->type ?? 'login';

        $result = $this->otpService->resendOtp($phone, $phoneCode, $otpType);

        if ($result['success']) {
            return $this->successResponse($result, $result['message']);
        }

        return $this->errorResponse($result['message']);
    }
}
