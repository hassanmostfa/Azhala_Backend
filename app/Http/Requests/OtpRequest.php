<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OtpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        \Log::info('OTP Validation failed', [
            'errors' => $validator->errors()->toArray(),
            'input' => $this->all()
        ]);
        
        // Force JSON response for API requests
        if ($this->expectsJson() || $this->is('api/*')) {
            throw new \Illuminate\Validation\ValidationException($validator, response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()
            ], 422));
        }
        
        parent::failedValidation($validator);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone_code' => 'sometimes|string|regex:/^[0-9]{1,4}$/',
            'phone' => 'sometimes|string|regex:/^5[0-9]{8}$/',
            'verification_token' => 'sometimes|string|uuid',
            'type' => 'sometimes|string|in:login,register,verification',
            'otp_code' => 'sometimes|string|regex:/^[0-9]{4}$/',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'phone_code.required' => 'The phone code is required.',
            'phone_code.string' => 'The phone code must be a string.',
            'phone_code.regex' => 'The phone code must be 1-4 digits.',
            'phone.required' => 'The phone number is required.',
            'phone.string' => 'The phone number must be a string.',
            'phone.regex' => 'The phone number must start with 5 and be 9 digits long.',
            'verification_token.required' => 'The verification token is required.',
            'verification_token.string' => 'The verification token must be a string.',
            'verification_token.uuid' => 'The verification token must be a valid UUID format.',
            'type.string' => 'The type must be a string.',
            'type.in' => 'The type must be one of: login, register, verification.',
            'otp_code.required' => 'The OTP code is required.',
            'otp_code.string' => 'The OTP code must be a string.',
            'otp_code.regex' => 'The OTP code must be 4 digits.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'phone' => 'phone number',
            'type' => 'OTP type',
            'otp_code' => 'OTP code',
        ];
    }
}
