@extends('dashboard.layouts.app')

@section('title', 'تعديل بنر')

@section('content')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-l d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">تعديل بنر</h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('dashboard.index') }}" class="text-muted text-hover-primary">الرئيسية</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('dashboard.sliders.index') }}" class="text-muted text-hover-primary">بنر</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">تعديل بنر</li>
            </ul>
        </div>
    </div>
</div>

<div id="kt_app_content_container" class="app-container container-l">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">تعديل البنر</h3>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('dashboard.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data" id="kt_slider_form" dir="rtl">
                @csrf
                @method('PUT')
                
                <!--begin::Input group - Image Upload-->
                <div class="row mb-5">
                    <div class="col-12 fv-row text-center">
                        <label class="fs-5 fw-semibold mb-2">الصورة</label>
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
                                    @if ($slider->image) style="background-image: url('{{ asset($slider->image) }}')" @endif>
                                </div>
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="تغيير الصورة">
                                    <i class="ki-duotone ki-pencil fs-7">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="image_remove" />
                                </label>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="إلغاء الصورة">
                                    <i class="ki-duotone ki-cross fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="حذف الصورة">
                                    <i class="ki-duotone ki-cross fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                            </div>
                            <div class="text-muted fs-7">اختر صورة للبنر. يُسمح فقط بملفات *.png و *.jpg و *.jpeg. الأبعاد الموصى بها: 1920×1080 بكسل
                            </div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <!--end::Input group-->

                <!--begin::Input group - Publish Status-->
                <div class="row mb-5">
                    <div class="col-12 fv-row">
                        <label class="fs-5 fw-semibold mb-2">حالة النشر</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" {{ $slider->is_published ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_published">
                                نشر البنر
                            </label>
                        </div>
                        <small class="form-text text-muted">عند تفعيل هذا الخيار، سيظهر البنر في الموقع</small>
                    </div>
                </div>
                <!--end::Input group-->

                <!--begin::Submit-->
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary" id="kt_slider_submit_button">
                        <!--begin::Indicator label-->
                        <span class="indicator-label">تحديث البنر</span>
                        <!--end::Indicator label-->
                        <!--begin::Indicator progress-->
                        <span class="indicator-progress">يرجى الانتظار...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        <!--end::Indicator progress-->
                    </button>
                    <a href="{{ route('dashboard.sliders.index') }}" class="btn btn-light">إلغاء</a>
                </div>
                <!--end::Submit-->
            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submission loading state
    const form = document.getElementById('kt_slider_form');
    const submitButton = document.getElementById('kt_slider_submit_button');
    
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
@endsection
