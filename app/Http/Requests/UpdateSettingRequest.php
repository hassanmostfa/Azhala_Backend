<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone_code' => 'required|string|max:3|regex:/^[0-9]+$/',
            'phone' => 'required|string|size:9|regex:/^5[0-9]{8}$/',
            'about' => 'required|string|max:1000',
            'whatsapp' => 'required|string|min:10|max:11|regex:/^[0-9]+$/',
            'email' => 'required|email|max:255',
            'terms_and_conditions' => 'required|string|max:1000',
            'privacy' => 'required|string|max:1000',
            'ios_version' => 'required|string|max:20',
            'android_version' => 'required|string|max:20',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'عنوان التطبيق مطلوب',
            'title.string' => 'عنوان التطبيق يجب أن يكون نص',
            'title.max' => 'عنوان التطبيق يجب أن لا يتجاوز 255 حرف',
            
            'logo.image' => 'اللوجو يجب أن يكون صورة',
            'logo.mimes' => 'اللوجو يجب أن يكون من نوع: jpeg, png, jpg, gif, svg',
            'logo.max' => 'حجم اللوجو يجب أن لا يتجاوز 2 ميجابايت',
            
            'phone_code.required' => 'رمز الهاتف مطلوب',
            'phone_code.string' => 'رمز الهاتف يجب أن يكون نص',
            'phone_code.max' => 'رمز الهاتف يجب أن لا يتجاوز 3 أرقام',
            'phone_code.regex' => 'رمز الهاتف يجب أن يحتوي على أرقام فقط بدون رموز',
            
            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.string' => 'رقم الهاتف يجب أن يكون نص',
            'phone.size' => 'رقم الهاتف يجب أن يكون 9 أرقام بالضبط',
            'phone.regex' => 'رقم الهاتف يجب أن يبدأ بـ 5 ويحتوي على 9 أرقام فقط',
            
            'about.required' => 'نبذة عن التطبيق مطلوبة',
            'about.string' => 'نبذة عن التطبيق يجب أن تكون نص',
            'about.max' => 'نبذة عن التطبيق يجب أن لا تتجاوز 1000 حرف',
            
            'whatsapp.required' => 'رقم الواتساب مطلوب',
            'whatsapp.string' => 'رقم الواتساب يجب أن يكون نص',
            'whatsapp.min' => 'رقم الواتساب يجب أن يكون 10 أرقام على الأقل',
            'whatsapp.max' => 'رقم الواتساب يجب أن لا يتجاوز 11 رقم',
            'whatsapp.regex' => 'رقم الواتساب يجب أن يحتوي على أرقام فقط بدون رموز',
            
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني يجب أن يكون صحيح',
            'email.max' => 'البريد الإلكتروني يجب أن لا يتجاوز 255 حرف',
            
            'terms_and_conditions.required' => 'الشروط والأحكام مطلوبة',
            'terms_and_conditions.string' => 'الشروط والأحكام يجب أن تكون نص',
            'terms_and_conditions.max' => 'الشروط والأحكام يجب أن لا تتجاوز 1000 حرف',
            
            'privacy.required' => 'سياسة الخصوصية مطلوبة',
            'privacy.string' => 'سياسة الخصوصية يجب أن تكون نص',
            'privacy.max' => 'سياسة الخصوصية يجب أن لا تتجاوز 1000 حرف',
            
            'ios_version.required' => 'إصدار iOS مطلوب',
            'ios_version.string' => 'إصدار iOS يجب أن يكون نص',
            'ios_version.max' => 'إصدار iOS يجب أن لا يتجاوز 20 حرف',
            
            'android_version.required' => 'إصدار Android مطلوب',
            'android_version.string' => 'إصدار Android يجب أن يكون نص',
            'android_version.max' => 'إصدار Android يجب أن لا يتجاوز 20 حرف',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'title' => 'عنوان التطبيق',
            'logo' => 'اللوجو',
            'phone_code' => 'رمز الهاتف',
            'phone' => 'رقم الهاتف',
            'about' => 'نبذة عن التطبيق',
            'whatsapp' => 'رقم الواتساب',
            'email' => 'البريد الإلكتروني',
            'terms_and_conditions' => 'الشروط والأحكام',
            'privacy' => 'سياسة الخصوصية',
            'ios_version' => 'إصدار iOS',
            'android_version' => 'إصدار Android',
        ];
    }
}
