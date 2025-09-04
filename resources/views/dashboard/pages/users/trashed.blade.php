@extends('dashboard.layouts.app')
@push('css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-l d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">المستخدمين
                    المحذوفين</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard.index') }}" class="text-muted text-hover-primary">الرئيسية</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">المستخدمين المحذوفين</li>
                </ul>
            </div>
            <div class="card-toolbar">
                <a href="{{ route('dashboard.users.index') }}" class="btn btn-secondary">عرض المستخدمين</a>
            </div>
        </div>
    </div>
    <div id="kt_app_content_container" class="app-container container-l">
        <div class="card card-flush">
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" data-kt-ecommerce-category-filter="search"
                            class="form-control form-control-solid w-250px ps-12" placeholder="البحث عن مستخدم" />
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <table class="table table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                    <thead>
                        <tr class="text-gray-400 fw-bold">
                            <th class="text-start">اسم المستخدم</th>
                            <th class="text-start">نوع المستخدم</th>
                            <th class="text-start">رقم الهاتف</th>
                            <th class="text-start">عنوان المستخدم</th>
                            <th class="text-start">تاريخ الحذف</th>
                            <th class="text-start">حالة المستخدم</th>
                            <th class="text-end min-w-70px">العمليات</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex">
                                        <div class="symbol symbol-50px">
                                            <span class="symbol-label"
                                                style="background-image:url({{ $user->photo ? asset('storage/' . $user->photo) : asset('assets/media/avatars/blank.png') }});"></span>
                                        </div>
                                        <div class="ms-5">
                                            <span class="text-gray-800 fs-5 fw-bold mb-1">{{ $user->name }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="ms-5">
                                        <span class="text-gray-800 fs-5 fw-bold mb-1">
                                            {{ $user->userType->name ?? 'غير محدد' }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="ms-5">
                                        <span class="text-gray-800 fs-5 fw-bold mb-1" dir="ltr">
                                            {{ $user->phone_code . ' ' . $user->phone }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="ms-5">
                                        <span class="text-gray-800 fs-5 fw-bold mb-1">
                                            {{ $user->address ?? 'غير محدد' }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="ms-5">
                                        <span class="text-gray-800 fs-5 fw-bold mb-1">
                                            {{ $user->deleted_at->format('d-m-Y') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="text-4xl text-center">
                                    <div
                                        class="px-5 py-3 badge {{ $user->is_active ? 'badge-light-success' : 'badge-light-danger' }}">
                                        {{ $user->is_active ? 'مفعل' : 'غير مفعل' }}
                                    </div>
                                </td>
                                <td class="text-end">
                                    <a href="#"
                                        class="btn btn-sm btn-light btn-active-light-primary btn-flex btn-center"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">العمليات
                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                        data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3"
                                                data-kt-ecommerce-category-filter="restore_row"
                                                data-user-id="{{ $user->id }}"
                                                data-action="{{ route('dashboard.users.restore', $user->id) }}">استعادة</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a href="#" class="menu-link px-3"
                                                data-kt-ecommerce-category-filter="force_delete_row"
                                                data-user-id="{{ $user->id }}"
                                                data-action="{{ route('dashboard.users.forceDelete', $user->id) }}">حذف
                                                نهائي</a>
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
            document.addEventListener('DOMContentLoaded', function() {
                const table = $('#kt_ecommerce_category_table').DataTable({
                    "searching": true,
                    "paging": false,
                    "info": false,
                    "columnDefs": [{
                            "orderable": false,
                            "targets": 6
                        } // Disable sorting on actions column
                    ]
                });

                // Search functionality
                $('input[data-kt-ecommerce-category-filter="search"]').on('keyup', function() {
                    table.search(this.value).draw();
                });

                // Restore user
                $(document).on('click', 'a[data-kt-ecommerce-category-filter="restore_row"]', function(e) {
                    e.preventDefault();
                    const userId = $(this).data('user-id');
                    const actionUrl = $(this).data('action');

                    Swal.fire({
                        text: "هل أنت متأكد من استعادة هذا المستخدم؟",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "نعم، استعادة!",
                        cancelButtonText: "لا، إلغاء",
                        customClass: {
                            confirmButton: "btn btn-primary",
                            cancelButton: "btn btn-active-light"
                        }
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: actionUrl,
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {
                                    _method: 'PATCH'
                                },
                                success: function(response) {
                                    Swal.fire({
                                        text: response.message,
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "موافق",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(function() {
                                        table.row($(e.target).closest('tr'))
                                        .remove().draw();
                                    });
                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        text: xhr.responseJSON?.message ||
                                            "فشل في استعادة المستخدم",
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

                // Force delete user
                $(document).on('click', 'a[data-kt-ecommerce-category-filter="force_delete_row"]', function(e) {
                    e.preventDefault();
                    const userId = $(this).data('user-id');
                    const actionUrl = $(this).data('action');

                    Swal.fire({
                        text: "هل أنت متأكد من الحذف النهائي لهذا المستخدم؟",
                        icon: "warning",
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: "نعم، احذف نهائيًا!",
                        cancelButtonText: "لا، إلغاء",
                        customClass: {
                            confirmButton: "btn btn-danger",
                            cancelButton: "btn btn-active-light"
                        }
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: actionUrl,
                                type: 'POST',
                                data: {
                                    _method: 'DELETE'
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    Swal.fire({
                                        text: response.message,
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "موافق",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(function() {
                                        table.row($(e.target).closest('tr'))
                                        .remove().draw();
                                    });
                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        text: xhr.responseJSON?.message ||
                                            "فشل في الحذف النهائي للمستخدم",
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
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/ecommerce/catalog/categories.js') }}"></script>
    <script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/create-app.js') }}"></script>
    <script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"></script>
@endpush
