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
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

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
                                    <!-- Single Square for Preview and Change -->
                                    <div class="position-relative d-inline-block mb-2">
                                        <div id="logo-preview" class="border rounded overflow-hidden cursor-pointer" style="width: 100px; height: 100px;">
                                            <img id="preview-image" src="{{ !empty($settingsArray['logo']) ? asset($settingsArray['logo']) : '' }}" 
                                                 alt="Logo Preview" class="w-100 h-100 object-fit-cover">
                                            <!-- Overlay for click indication -->
                                            <div id="logo-overlay" class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50 text-white" 
                                                 style="opacity: 0; transition: opacity 0.3s ease;">
                                                <i class="ki-duotone ki-pencil fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Dimensions Text -->
                                    <div class="mb-3">
                                        <small class="form-text text-muted">الأبعاد الموصى بها: 200×200 بكسل. الحد الأقصى: 2 ميجابايت</small>
                                    </div>
                                    
                                    <!-- File Input - Hidden but functional -->
                                    <div>
                                        <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                               id="logo" name="logo" accept="image/*" onchange="previewLogo(this)" style="display: none;">
                                        @error('logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
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
function previewLogo(input) {
    const previewImage = document.getElementById('preview-image');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImage.src = e.target.result;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

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

// Add click handler to make the preview clickable to trigger file input
document.addEventListener('DOMContentLoaded', function() {
    const logoPreview = document.getElementById('logo-preview');
    const logoOverlay = document.getElementById('logo-overlay');
    const logoInput = document.getElementById('logo');

    // Show overlay on hover
    logoPreview.addEventListener('mouseenter', function() {
        logoOverlay.style.opacity = '1';
    });

    logoPreview.addEventListener('mouseleave', function() {
        logoOverlay.style.opacity = '0';
    });

    // Click to trigger file input
    logoPreview.addEventListener('click', function() {
        logoInput.click();
    });

    // Form submission loading state
    const form = document.getElementById('kt_settings_form');
    const submitButton = document.getElementById('kt_settings_submit_button');
    
    form.addEventListener('submit', function() {
        // Show loading state
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
    });
});
</script>

<style>
.object-fit-cover {
    object-fit: cover;
}

#logo-preview {
    cursor: pointer;
    transition: all 0.3s ease;
}

#logo-preview:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>
@endsection
