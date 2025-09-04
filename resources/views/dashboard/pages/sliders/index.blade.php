@extends('dashboard.layouts.app')
@push('css')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />

@endpush
@section('content')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">

    <div id="kt_app_toolbar_container" class="app-container container-l d-flex flex-stack">

        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">

                                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">سلايدر</h1>


            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('dashboard.index') }}" class="text-muted text-hover-primary">الرئيسية</a>
                </li>


                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>


                                        <li class="breadcrumb-item text-muted">سلايدر</li>

            </ul>

        </div>

    </div>

</div>
<div id="kt_app_content_container" class="app-container container-l">

    <div class="card card-flush">

        <div class="card-header align-items-center py-5 gap-2 gap-md-5">

                         <div class="card-title">
                 <!-- Search removed -->
             </div>


            <div class="card-toolbar">

                                        <a href="{{ route('dashboard.sliders.create') }}" class="btn btn-primary">إضافة سلايدر</a>

            </div>

        </div>


        <div class="card-body pt-0">

            <table class="table table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                <thead>
                                                    <tr class="text-gray-400 fw-bold">
                                <th class="text-start">الصورة</th>
                                <th class="text-start">حالة النشر</th>
                                <th class="text-start">تاريخ الإنشاء</th>
                                <th class="text-end min-w-70px">العمليات</th>
                            </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    @foreach ($sliders as $slider)
                        <tr>
                                                                <td>
                                    <div class="d-flex">

                                        <div class="symbol symbol-50px">
                                            <span class="symbol-label"
                                                style="background-image:url({{ $slider->image ? asset($slider->image) : asset('assets/media/avatars/blank.png') }});"></span>
                                        </div>

                                    </div>
                                </td>
                                                                <td>

                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" 
                                            data-kt-ecommerce-category-filter="toggle_publish"
                                            data-slider-id="{{ $slider->id }}"
                                            data-action="{{ route('dashboard.sliders.toggle-publish', $slider->id) }}"
                                            {{ $slider->is_published ? 'checked' : '' }}>
                                    </div>

                                </td>
                                                                                                            <td>
                                        <div class="ms-5">
                                            <span class="text-gray-800 fs-5 fw-bold mb-1">
                                                {{ $slider->created_at->format('d-m-Y') }}
                                            </span>
                                        </div>
                                    </td>
                            <td class="text-end">
                                <a href="#" class="btn btn-sm btn-light btn-active-light-primary btn-flex btn-center"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">العمليات
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>

                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                    data-kt-menu="true">

                                    <div class="menu-item px-3">
                                        <a href="{{ route('dashboard.sliders.edit', $slider->id) }}"
                                            class="menu-link px-3">تعديل</a>
                                    </div>

                                    

                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3"
                                            data-kt-ecommerce-category-filter="delete_row"
                                            data-slider-id="{{ $slider->id }}"
                                            data-action="{{ route('dashboard.sliders.destroy', $slider->id) }}">حذف</a>
                                    </div>

                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>

    </div>

</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const table = $('#kt_ecommerce_category_table').DataTable({
                "language": {
                    "url": "{{ asset('assets/js/datatables-ar.json') }}"
                },
                "searching": true,
                "paging": false,
                "info": false,
                                            "columnDefs": [
                            { "orderable": false, "targets": 3 } // Disable sorting on actions column
                        ]
            });

            // Search functionality removed

                                // Toggle publish status
                $(document).on('change', 'input[data-kt-ecommerce-category-filter="toggle_publish"]', function (e) {
                    const sliderId = $(this).data('slider-id');
                    const actionUrl = $(this).data('action');
                    const checkbox = $(this);
                    const originalState = checkbox.prop('checked');

                Swal.fire({
                    text: "هل أنت متأكد من تغيير حالة النشر؟",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "نعم، تغيير!",
                    cancelButtonText: "لا، إلغاء",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-active-light"
                    }
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: actionUrl,
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                Swal.fire({
                                    text: response.message,
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "موافق",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then(function () {
                                    location.reload();
                                });
                            },
                            error: function (xhr) {
                                // Revert checkbox state on error
                                checkbox.prop('checked', !originalState);
                                Swal.fire({
                                    text: xhr.responseJSON?.message || "فشل في تغيير حالة النشر",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "موافق",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        });
                    } else {
                        // Revert checkbox state if user cancels
                        checkbox.prop('checked', !originalState);
                    }
                });
            });

            // Delete slider
            $(document).on('click', 'a[data-kt-ecommerce-category-filter="delete_row"]', function (e) {
                e.preventDefault();
                const sliderId = $(this).data('slider-id');
                const actionUrl = $(this).data('action');

                Swal.fire({
                    text: "هل أنت متأكد من حذف هذا السلايدر؟",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "نعم، احذف!",
                    cancelButtonText: "لا، إلغاء",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-active-light"
                    }
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: actionUrl,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                Swal.fire({
                                    text: response.message,
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "موافق",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then(function () {
                                    table.row($(e.target).closest('tr')).remove().draw();
                                });
                            },
                            error: function (xhr) {
                                Swal.fire({
                                                                                text: xhr.responseJSON?.message || "فشل في حذف السلايدر",
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
@endpush
@endsection
@push('js')
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <script src="{{asset('assets/js/custom/apps/ecommerce/catalog/categories.js')}}"></script>
    <script src="{{asset('assets/js/widgets.bundle.js')}}"></script>
    <script src="{{asset('assets/js/custom/widgets.js')}}"></script>
    <script src="{{asset('assets/js/custom/apps/chat/chat.js')}}"></script>
    <script src="{{asset('assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
    <script src="{{asset('assets/js/custom/utilities/modals/create-app.js')}}"></script>
    <script src="{{asset('assets/js/custom/utilities/modals/users-search.js')}}"></script>
@endpush
