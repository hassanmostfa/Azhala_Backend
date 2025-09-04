<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UserRequest extends FormRequest
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
        \Log::info('Validation failed', [
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
        $userId = $this->route('user') ?? $this->route('id');

        $rules = [
            'name' => 'required|string|max:255|regex:/^[\p{L}\s]+$/u',
            'phone_code' => 'required|string|regex:/^\+[0-9]{1,4}$/',
            'phone' => 'required|string|regex:/^5[0-9]{8}$/|unique:users,phone,NULL,id,phone_code,' . $this->phone_code,
            'is_active' => 'boolean',
            'is_approved' => 'boolean',
            'user_type_id' => 'required|exists:user_types,id',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'commercial_register' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:255',
        ];

        if ($this->isMethod('PATCH') || $this->isMethod('PUT')) {
            $rules['name'] = 'sometimes|required|string|max:255|regex:/^[\p{L}\s]+$/u';
            $rules['phone'] = [
                'sometimes',
                'required',
                'string',
                'regex:/^5[0-9]{8}$/',
                'unique:users,phone,' . $userId . ',id,phone_code,' . $this->phone_code,
            ];
            $rules['user_type_id'] = 'sometimes|required|exists:user_types,id';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'name.regex' => 'The name can only contain letters and spaces (Arabic or English).',
            'phone_code.required' => 'The phone code is required.',
            'phone_code.string' => 'The phone code must be a string.',
            'phone_code.regex' => 'The phone code must be 1-4 digits.',
            'phone.required' => 'The phone number is required.',
            'phone.string' => 'The phone number must be a string.',
            'phone.regex' => 'The phone number must start with 5 and be 9 digits long.',
            'phone.unique' => 'A user with this phone number already exists.',
            'is_active.boolean' => 'The is_active field must be true or false.',
            'user_type_id.required' => 'نوع المستخدم مطلوب.',
            'user_type_id.exists' => 'نوع المستخدم غير موجود.',
            'address.string' => 'العنوان يجب أن يكون نصًا.',
            'address.max' => 'العنوان لا يمكن أن يتجاوز 255 حرفًا.',
            'photo.image' => 'الصورة يجب أن تكون صورة صالحة.',
            'photo.mimes' => 'الصورة يجب أن تكون من نوع jpeg, png, jpg.',
            'photo.max' => 'حجم الصورة لا يمكن أن يتجاوز 2MB.',
            'commercial_register.string' => 'السجل التجاري يجب أن يكون نصًا.',
            'commercial_register.max' => 'السجل التجاري لا يمكن أن يتجاوز 255 حرفًا.',
            'tax_number.string' => 'رقم الضريبة يجب أن يكون نصًا.',
            'tax_number.max' => 'رقم الضريبة لا يمكن أن يتجاوز 255 حرفًا.',
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
            'name' => 'name',
            'phone' => 'phone number',
            'is_active' => 'active status',
        ];
    }
}
