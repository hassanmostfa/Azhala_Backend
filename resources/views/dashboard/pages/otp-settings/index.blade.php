@extends('dashboard.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">إعدادات رمز التحقق</h3>
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
                    <form action="{{ route('dashboard.otp-settings.update') }}" class="form mb-15" method="post" id="kt_otp_settings_form" dir="rtl">
                        @csrf
                        <h1 class="fw-bold text-dark mb-9">تكوين إعدادات رمز التحقق</h1>
                        
                        <!--begin::Input group - First Row-->
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="fs-5 fw-semibold mb-2">رمز التحقق التجريبي</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" 
                                       class="form-control form-control-solid @error('otp_test_code') is-invalid @enderror" 
                                       placeholder="أدخل رمز تجريبي مكون من 5 أرقام" 
                                       name="otp_test_code" 
                                       value="{{ old('otp_test_code', $settingsArray['otp_test_code'] ?? '') }}" />
                                <!--end::Input-->
                                @error('otp_test_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="fs-5 fw-semibold mb-2">وقت انتهاء الصلاحية (بالدقائق)</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="number" 
                                       class="form-control form-control-solid @error('expiry_time') is-invalid @enderror" 
                                       placeholder="أدخل وقت انتهاء الصلاحية (1-10 دقائق)" 
                                       name="expiry_time" 
                                       min="1" 
                                       max="10"
                                       value="{{ old('expiry_time', $settingsArray['expiry_time'] ?? '') }}" />
                                <!--end::Input-->
                                @error('expiry_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        
                        <!--begin::Input group - Second Row-->
                        <div class="row mb-5">
                            <!--begin::Col-->
                            <div class="col-md-6 fv-row">
                                <!--begin::Label-->
                                <label class="fs-5 fw-semibold mb-2">وضع الإنتاج</label>
                                <!--end::Label-->
                                <!--begin::Toggle-->
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input @error('is_production') is-invalid @enderror" 
                                           type="checkbox" 
                                           name="is_production" 
                                           value="1" 
                                           id="is_production_toggle"
                                           {{ old('is_production', $settingsArray['is_production'] ?? '') == '1' ? 'checked' : '' }} />
                                    <label class="form-check-label" for="is_production_toggle">
                                        <span class="form-check-sign">
                                            <span class="switch">
                                                <span class="switch-handle"></span>
                                            </span>
                                        </span>
                                        <span class="switch-label">
                                            <span class="switch-label-on">الإنتاج</span>
                                            <span class="switch-label-off">التطوير</span>
                                        </span>
                                    </label>
                                </div>
                                <!--end::Toggle-->
                                @error('is_production')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        
                        <!--begin::Submit-->
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary" id="kt_otp_settings_submit_button">
                                <!--begin::Indicator label-->
                                <span class="indicator-label">تحديث الإعدادات</span>
                                <!--end::Indicator label-->
                                <!--begin::Indicator progress-->
                                <span class="indicator-progress">يرجى الانتظار...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                <!--end::Indicator progress-->
                            </button>
                            
                            <form action="{{ route('dashboard.otp-settings.reset') }}" method="post" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-secondary" onclick="return confirm('هل أنت متأكد من إعادة تعيين القيم الافتراضية؟')">
                                    إعادة تعيين للقيم الافتراضية
                                </button>
                            </form>
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
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('kt_otp_settings_form');
    const submitButton = document.getElementById('kt_otp_settings_submit_button');
    
    form.addEventListener('submit', function() {
        // Show loading state
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;
    });
});
</script>
@endsection
