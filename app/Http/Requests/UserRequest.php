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
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'phone_code' => 'required|string|regex:/^[0-9]{1,4}$/',
            'phone' => 'required|string|regex:/^5[0-9]{8}$/|unique:users,phone,NULL,id,phone_code,' . $this->phone_code,
            'is_active' => 'boolean',
        ];

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
            'name.regex' => 'The name can only contain letters and spaces.',
            'phone_code.required' => 'The phone code is required.',
            'phone_code.string' => 'The phone code must be a string.',
            'phone_code.regex' => 'The phone code must be 1-4 digits.',
            'phone.required' => 'The phone number is required.',
            'phone.string' => 'The phone number must be a string.',
            'phone.regex' => 'The phone number must start with 5 and be 9 digits long.',
            'phone.unique' => 'A user with this phone number already exists.',
            'is_active.boolean' => 'The is_active field must be true or false.',
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
