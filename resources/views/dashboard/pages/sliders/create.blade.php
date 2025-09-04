@extends('dashboard.layouts.app')

@section('title', 'إضافة صورة متحركة')

@section('content')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-l d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">إضافة صورة متحركة</h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('dashboard.index') }}" class="text-muted text-hover-primary">الرئيسية</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('dashboard.sliders.index') }}" class="text-muted text-hover-primary">الصور المتحركة</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">إضافة صورة متحركة</li>
            </ul>
        </div>
    </div>
</div>

<div id="kt_app_content_container" class="app-container container-l">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">إضافة صورة متحركة جديدة</h3>
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

            <form action="{{ route('dashboard.sliders.store') }}" method="POST" enctype="multipart/form-data" id="kt_slider_form" dir="rtl">
                @csrf
                
                <!--begin::Input group - Image Upload-->
                <div class="row mb-5">
                    <div class="col-12 fv-row text-center">
                        <label class="fs-5 fw-semibold mb-2">الصورة</label>
                        <div class="text-center">
                            <!-- Image Preview (Hidden Initially) -->
                            <div id="image-preview-container" class="position-relative d-inline-block mb-2" style="display: none;">
                                <div id="image-preview" class="border rounded overflow-hidden cursor-pointer" style="width: 150px; height: 150px;">
                                    <img id="preview-image" src="" alt="Image Preview" class="w-100 h-100 object-fit-cover">
                                    <!-- Overlay for click indication -->
                                    <div id="image-overlay" class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50 text-white"
                                         style="opacity: 0; transition: opacity 0.3s ease;">
                                        <i class="ki-duotone ki-pencil fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Button (Visible Initially) -->
                            <div id="upload-button-container" class="mb-3">
                                <button type="button" class="btn btn-light-primary" onclick="document.getElementById('image').click()">
                                    <i class="ki-duotone ki-plus fs-2 me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    اختيار صورة
                                </button>
                            </div>

                            <!-- Dimensions Text -->
                            <div class="mb-3">
                                <small class="form-text text-muted">الأبعاد الموصى بها: 1920×1080 بكسل. الحد الأقصى: 2 ميجابايت</small>
                            </div>

                            <!-- File Input - Hidden but functional -->
                            <div>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                       id="image" name="image" accept="image/*" onchange="previewImage(this)" style="display: none;" required>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Input group-->

                <!--begin::Input group - Publish Status-->
                <div class="row mb-5">
                    <div class="col-12 fv-row">
                        <label class="fs-5 fw-semibold mb-2">حالة النشر</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1">
                            <label class="form-check-label" for="is_published">
                                نشر الصورة المتحركة
                            </label>
                        </div>
                        <small class="form-text text-muted">عند تفعيل هذا الخيار، ستظهر الصورة المتحركة في الموقع</small>
                    </div>
                </div>
                <!--end::Input group-->

                <!--begin::Submit-->
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary" id="kt_slider_submit_button">
                        <!--begin::Indicator label-->
                        <span class="indicator-label">إضافة الصورة المتحركة</span>
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
function previewImage(input) {
    const previewImage = document.getElementById('preview-image');
    const previewContainer = document.getElementById('image-preview-container');
    const uploadButtonContainer = document.getElementById('upload-button-container');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            // Show preview and hide upload button
            previewContainer.style.display = 'inline-block';
            uploadButtonContainer.style.display = 'none';
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Add click handlers for image selection
document.addEventListener('DOMContentLoaded', function() {
    const imagePreview = document.getElementById('image-preview');
    const imageOverlay = document.getElementById('image-overlay');
    const imageInput = document.getElementById('image');

    // Show overlay on hover for preview (only when preview is visible)
    imagePreview.addEventListener('mouseenter', function() {
        if (document.getElementById('image-preview-container').style.display !== 'none') {
            imageOverlay.style.opacity = '1';
        }
    });

    imagePreview.addEventListener('mouseleave', function() {
        imageOverlay.style.opacity = '0';
    });

    // Click to trigger file input
    imagePreview.addEventListener('click', function() {
        imageInput.click();
    });

    // Form submission loading state
    const form = document.getElementById('kt_slider_form');
    const submitButton = document.getElementById('kt_slider_submit_button');
    
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

#image-preview {
    cursor: pointer;
    transition: all 0.3s ease;
}

#image-preview:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>
@endsection
