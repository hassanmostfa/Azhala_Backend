@extends('dashboard.layouts.app')

@section('title', 'إعدادات التطبيق')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">إعدادات التطبيق</h3>
                </div>
                <div class="card-body">
                    <!--begin::Form-->
                    <form action="{{ route('dashboard.settings.update') }}" class="form mb-15" method="post" enctype="multipart/form-data" id="kt_settings_form" dir="rtl">
                        @csrf
                        <h1 class="fw-bold text-dark mb-9">تكوين إعدادات التطبيق</h1>
                        
                        <!--begin::Input group - Logo (First Row - Centered)-->
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-12 fv-row text-center">
                                <!--begin::Label-->
                                <label class="fs-5 fw-semibold mb-2">اللوجو</label>
                                <!--end::Label-->
                                <!--begin::Logo Upload-->
                                <div class="text-center">
                                    <style>
                                        .image-input-placeholder {
                                            background-image: url('{{ asset('assets/media/svg/files/blank-image.svg') }}');
                                        }

                                        [data-bs-theme="dark"] .image-input-placeholder {
                                            background-image: url('{{ asset('assets/media/svg/files/blank-image-dark.svg') }}');
                                        }
                                    </style>
                                    <div class="image-input image-input-empty image-input-outline image-input-placeholder mb-3"
                                        data-kt-image-input="true">
                                        <div class="image-input-wrapper w-150px h-150px"
                                            @if (!empty($settingsArray['logo'])) style="background-image: url('{{ asset($settingsArray['logo']) }}')" @endif>
                                        </div>
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="change" data-bs-toggle="tooltip" title="تغيير اللوجو">
                                            <i class="ki-duotone ki-pencil fs-7">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <input type="file" name="logo" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="logo_remove" />
                                        </label>
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="إلغاء اللوجو">
                                            <i class="ki-duotone ki-cross fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                            data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="حذف اللوجو">
                                            <i class="ki-duotone ki-cross fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                        </span>
                                            </div>
                                    <div class="text-muted fs-7">اختر لوجو للتطبيق. يُسمح فقط بملفات *.png و *.jpg و *.jpeg
                                    </div>
                                        @error('logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                </div>
                                <!--end::Logo Upload-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        
                        <!--begin::Input group - Basic Information-->
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-12 fv-row">
                                <!--begin::Label-->
                                <label class="fs-5 fw-semibold mb-2">عنوان التطبيق</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" 
                                       class="form-control form-control-solid @error('title') is-invalid @enderror" 
                                       placeholder="أدخل عنوان التطبيق" 
                                       name="title" 
                                       value="{{ old('title', $settingsArray['title'] ?? '') }}" />
                                <!--end::Input-->
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        
                        <!--begin::Input group - Contact Information-->
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-3 fv-row">
                                <!--begin::Label-->
                                <label class="fs-5 fw-semibold mb-2">رمز الهاتف</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="tel" 
                                       class="form-control form-control-solid @error('phone_code') is-invalid @enderror" 
                                       placeholder="مثال: 966" 
                                       name="phone_code" 
                                       value="{{ old('phone_code', $settingsArray['phone_code'] ?? '') }}"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                                <!--end::Input-->
                                @error('phone_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-3 fv-row">
                                <!--begin::Label-->
                                <label class="fs-5 fw-semibold mb-2">رقم الهاتف</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="tel" 
                                       class="form-control form-control-solid @error('phone') is-invalid @enderror" 
                                       placeholder="مثال: 501234567" 
                                       name="phone" 
                                       value="{{ old('phone', $settingsArray['phone'] ?? '') }}"
                                       oninput="validatePhone(this)" />
                                <!--end::Input-->
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-3 fv-row">
                                <!--begin::Label-->
                                <label class="fs-5 fw-semibold mb-2">رقم الواتساب</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="tel" 
                                       class="form-control form-control-solid @error('whatsapp') is-invalid @enderror" 
                                       placeholder="مثال: 966501234567" 
                                       name="whatsapp" 
                                       value="{{ old('whatsapp', $settingsArray['whatsapp'] ?? '') }}"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                                <!--end::Input-->
                                @error('whatsapp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-3 fv-row">
                                <!--begin::Label-->
                                <label class="fs-5 fw-semibold mb-2">البريد الإلكتروني</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="email" 
                                       class="form-control form-control-solid @error('email') is-invalid @enderror" 
                                       placeholder="مثال: info@example.com" 
                                       name="email" 
                                       value="{{ old('email', $settingsArray['email'] ?? '') }}" />
                                <!--end::Input-->
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        
                        <!--begin::Input group - About-->
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-12 fv-row">
                                <!--begin::Label-->
                                <label class="fs-5 fw-semibold mb-2">نبذة عن التطبيق</label>
                                <!--end::Label-->
                                <!--begin::Textarea-->
                                <textarea class="form-control form-control-solid @error('about') is-invalid @enderror" 
                                          placeholder="أدخل نبذة مختصرة عن التطبيق" 
                                          name="about" 
                                          rows="4">{{ old('about', $settingsArray['about'] ?? '') }}</textarea>
                                <!--end::Textarea-->
                                @error('about')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        
                        <!--begin::Input group - App Versions-->
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="fs-5 fw-semibold mb-2">إصدار iOS</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" 
                                       class="form-control form-control-solid @error('ios_version') is-invalid @enderror" 
                                       placeholder="مثال: 1.0.0" 
                                       name="ios_version" 
                                       value="{{ old('ios_version', $settingsArray['ios_version'] ?? '') }}" />
                                <!--end::Input-->
                                @error('ios_version')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="fs-5 fw-semibold mb-2">إصدار Android</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" 
                                       class="form-control form-control-solid @error('android_version') is-invalid @enderror" 
                                       placeholder="مثال: 1.0.0" 
                                       name="android_version" 
                                       value="{{ old('android_version', $settingsArray['android_version'] ?? '') }}" />
                                <!--end::Input-->
                                @error('android_version')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        
                        <!--begin::Input group - Terms and Privacy-->
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="fs-5 fw-semibold mb-2">الشروط والأحكام</label>
                                <!--end::Label-->
                                <!--begin::Textarea-->
                                <textarea class="form-control form-control-solid @error('terms_and_conditions') is-invalid @enderror" 
                                          placeholder="أدخل الشروط والأحكام" 
                                          name="terms_and_conditions" 
                                          rows="6">{{ old('terms_and_conditions', $settingsArray['terms_and_conditions'] ?? '') }}</textarea>
                                <!--end::Textarea-->
                                @error('terms_and_conditions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="fs-5 fw-semibold mb-2">سياسة الخصوصية</label>
                                <!--end::Label-->
                                <!--begin::Textarea-->
                                <textarea class="form-control form-control-solid @error('privacy') is-invalid @enderror" 
                                          placeholder="أدخل سياسة الخصوصية" 
                                          name="privacy" 
                                          rows="6">{{ old('privacy', $settingsArray['privacy'] ?? '') }}</textarea>
                                <!--end::Textarea-->
                                @error('privacy')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        
                        <!--begin::Submit-->
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary" id="kt_settings_submit_button">
                                <!--begin::Indicator label-->
                                <span class="indicator-label">حفظ الإعدادات</span>
                                <!--end::Indicator label-->
                                <!--begin::Indicator progress-->
                                <span class="indicator-progress">يرجى الانتظار...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                <!--end::Indicator progress-->
                            </button>
                        </div>
                        <!--end::Submit-->
                    </form>
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function validatePhone(input) {
    let value = input.value;
    // Remove any non-digit characters
    value = value.replace(/[^0-9]/g, '');
    
    // Limit to 9 digits
    if (value.length > 9) {
        value = value.substring(0, 9);
    }
    
    // Only allow if it starts with 5 or is empty (for typing)
    if (value === '' || value.startsWith('5')) {
        input.value = value;
    } else {
        // If it doesn't start with 5, clear it
        input.value = '';
    }
}

document.addEventListener('DOMContentLoaded', function() {

    // Form submission loading state
    const form = document.getElementById('kt_settings_form');
    const submitButton = document.getElementById('kt_settings_submit_button');
    
    form.addEventListener('submit', function() {
        // Show loading state
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
    });

    // Show success message if exists
    @if(session('success'))
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        
        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        });
    @endif

    // Show error message if exists
    @if(session('error'))
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        
        Toast.fire({
            icon: 'error',
            title: '{{ session('error') }}'
        });
    @endif
});
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* Danger border styling for inputs with errors */
.form-control.is-invalid {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
}

.form-control.is-invalid:focus {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
}

/* Textarea danger border */
textarea.form-control.is-invalid {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
}

/* Image input danger border */
.image-input.is-invalid .image-input-wrapper {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
}
</style>
@endsection
