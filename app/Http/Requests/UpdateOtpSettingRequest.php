<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOtpSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // You can add authorization logic here if needed
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'otp_test_code' => 'required|string|size:5',
            'is_production' => 'nullable|in:1',
            'expiry_time' => 'required|integer|min:1|max:10',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'otp_test_code.required' => 'رمز التحقق التجريبي مطلوب.',
            'otp_test_code.string' => 'رمز التحقق التجريبي يجب أن يكون نصاً.',
            'otp_test_code.size' => 'رمز التحقق التجريبي يجب أن يكون مكون من 5 أرقام بالضبط.',
            'is_production.in' => 'وضع الإنتاج يجب أن يكون صحيحاً.',
            'expiry_time.required' => 'وقت انتهاء الصلاحية مطلوب.',
            'expiry_time.integer' => 'وقت انتهاء الصلاحية يجب أن يكون رقماً.',
            'expiry_time.min' => 'وقت انتهاء الصلاحية يجب أن يكون على الأقل دقيقة واحدة.',
            'expiry_time.max' => 'وقت انتهاء الصلاحية لا يمكن أن يتجاوز 10 دقائق.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'otp_test_code' => 'رمز التحقق التجريبي',
            'is_production' => 'وضع الإنتاج',
            'expiry_time' => 'وقت انتهاء الصلاحية',
        ];
    }
}
