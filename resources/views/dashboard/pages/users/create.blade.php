@extends('dashboard.layouts.app')

@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">إضافة مستخدم
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard.index') }}" class="text-muted text-hover-primary">الرئيسية</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">المستخدمين</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <form id="kt_user_add_form" class="form d-flex flex-column flex-lg-row"
                action="{{ route('dashboard.users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10">
                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>الصورة الشخصية</h2>
                            </div>
                        </div>
                        <div class="card-body text-center pt-0">
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
                                <div class="image-input-wrapper w-150px h-150px"></div>
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip" title="تغيير الصورة">
                                    <i class="ki-duotone ki-pencil fs-7">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <input type="file" name="photo" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="photo_remove" />
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
                            <div class="text-muted fs-7">اختر صورة شخصية للمستخدم. يُسمح فقط بملفات *.png و *.jpg و *.jpeg
                            </div>
                        </div>
                    </div>
                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>حالة النشاط</h2>
                            </div>
                            <div class="card-toolbar">
                                <div class="rounded-circle bg-success w-15px h-15px" id="kt_user_add_status"></div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <select class="form-select mb-2" data-control="select2" data-hide-search="true"
                                data-placeholder="اختر حالة النشاط" id="kt_user_add_status_select" name="is_active">
                                <option value=""></option>
                                <option value="1">نشط</option>
                                <option value="0">غير نشط</option>
                            </select>
                            <div class="text-muted fs-7">حدد حالة النشاط للمستخدم.</div>
                        </div>
                        <div class="card-body pt-0">
                            <select class="form-select mb-2" data-control="select2" data-hide-search="true"
                                data-placeholder="اختر حالة التحقق" id="kt_user_add_approved_select" name="is_approved">
                                <option value=""></option>
                                <option value="1">موثق</option>
                                <option value="0">غير موثق</option>
                            </select>
                            <div class="text-muted fs-7">حدد حالة التحقق للمستخدم.</div>
                        </div>
                    </div>

                </div>
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>معلومات المستخدم</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="mb-10 fv-row">
                                <label class="required form-label">الاسم</label>
                                <input type="text" name="name"
                                    class="form-control mb-2 @error('name') is-invalid @enderror" placeholder="اسم المستخدم"
                                    value="{{ old('name') }}" />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="text-muted fs-7">اسم المستخدم مطلوب ويُفضل أن يكون فريدًا.</div>
                            </div>
                            <div class="mb-10 fv-row">
                                <label class="required form-label">نوع المستخدم</label>
                                <select class="form-select mb-2 @error('user_type_id') is-invalid @enderror"
                                    data-placeholder="اختر نوع المستخدم" name="user_type_id" id="user_type_select">
                                    <option value=""></option>
                                    @foreach ($userTypes as $userType)
                                        <option value="{{ $userType->id }}" data-type="{{ $userType->type }}"
                                            {{ old('user_type_id') == $userType->id ? 'selected' : '' }}>
                                            {{ $userType->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="text-muted fs-6">اختر نوع المستخدم.</div>
                            </div>
                            <div class="mb-10 fv-row">
                                <label class="required form-label">رقم الهاتف</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background-color: #f5f8fa;">
                                        <input type="hidden" name="phone_code" value="+966" />
                                        +966
                                    </span>
                                    <input type="text" name="phone"
                                        class="form-control mb-2 @error('phone') is-invalid @enderror"
                                        placeholder="رقم الهاتف" value="{{ old('phone') }}" />
                                </div>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="text-muted fs-7">رقم الهاتف يجب أن يبدأ بـ 5 ويكون 9 أرقام.</div>
                            </div>
                            <div class="mb-10 fv-row">
                                <label class="form-label">العنوان</label>
                                <input type="text" name="address"
                                    class="form-control mb-2 @error('address') is-invalid @enderror" placeholder="العنوان"
                                    value="{{ old('address') }}" />
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="text-muted fs-7">أدخل عنوان المستخدم (اختياري).</div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-flush py-4 d-none" id="business_info_section">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>معلومات الأعمال</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="mb-10 fv-row">
                                <label class="form-label">السجل التجاري</label>
                                <input type="text" name="commercial_register"
                                    class="form-control mb-2 @error('commercial_register') is-invalid @enderror"
                                    placeholder="السجل التجاري" value="{{ old('commercial_register') }}" />
                                @error('commercial_register')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="text-muted fs-7">أدخل رقم السجل التجاري (اختياري).</div>
                            </div>
                            <div class="mb-10 fv-row">
                                <label class="form-label">رقم الضريبة</label>
                                <input type="text" name="tax_number"
                                    class="form-control mb-2 @error('tax_number') is-invalid @enderror"
                                    placeholder="رقم الضريبة" value="{{ old('tax_number') }}" />
                                @error('tax_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="text-muted fs-7">أدخل رقم الضريبة (اختياري).</div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('dashboard.users.index') }}" id="kt_user_add_cancel"
                            class="btn btn-light me-5">إلغاء</a>
                        <button type="submit" id="kt_user_add_submit" class="btn btn-primary">
                            <span class="indicator-label">حفظ التغييرات</span>
                            <span class="indicator-progress">يرجى الانتظار...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userTypeSelect = document.getElementById('user_type_select');
            const businessInfoSection = document.getElementById('business_info_section');
            const form = document.getElementById('kt_user_add_form');
            const submitButton = document.getElementById('kt_user_add_submit');

            if (!userTypeSelect) {
                console.error('Element with ID user_type_select not found');
                return;
            }
            if (!businessInfoSection) {
                console.error('Element with ID business_info_section not found');
                return;
            }

            // Hide business info section by default
            businessInfoSection.classList.add('d-none');

            function toggleBusinessInfo() {
                const selectedIndex = userTypeSelect.selectedIndex;
                const selectedOption = userTypeSelect.options[selectedIndex];
                const selectedType = selectedOption ? selectedOption.getAttribute('data-type') : '';

                console.log('Selected User Type:', selectedType);

                if (selectedType && selectedType !== 'customer') {
                    console.log('Showing business info section');
                    businessInfoSection.classList.remove('d-none');
                } else {
                    console.log('Hiding business info section');
                    businessInfoSection.classList.add('d-none');
                }
            }

            userTypeSelect.addEventListener('change', toggleBusinessInfo);
            toggleBusinessInfo(); // Run on page load

            // Handle form submission with SweetAlert2
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    text: "هل أنت متأكد من إضافة هذا المستخدم؟",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "نعم، أضف!",
                    cancelButtonText: "لا، إلغاء",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-active-light"
                    }
                }).then(function(result) {
                    if (result.isConfirmed) {
                        const formData = new FormData(form);
                        submitButton.setAttribute('data-kt-indicator',
                        'on'); // Show loading spinner

                        $.ajax({
                            url: form.action,
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                submitButton.removeAttribute(
                                'data-kt-indicator'); // Hide loading spinner
                                Swal.fire({
                                    text: response.message ||
                                        "تم إضافة المستخدم بنجاح",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "موافق",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then(function() {
                                    window.location.href =
                                        "{{ route('dashboard.users.index') }}";
                                });
                            },
                            error: function(xhr) {
                                submitButton.removeAttribute(
                                'data-kt-indicator'); // Hide loading spinner
                                Swal.fire({
                                    text: xhr.responseJSON?.message ||
                                        "فشل في إضافة المستخدم",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "موافق",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/save-category.js') }}"></script>
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/create-app.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
@endpush
