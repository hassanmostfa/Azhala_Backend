@extends('dashboard.layouts.app')

@push('css')
<link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />

@endpush

@section('content')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-l d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">سلة المحذوفات</h1>
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
                <li class="breadcrumb-item text-muted">سلة المحذوفات</li>
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
                <a href="{{ route('dashboard.sliders.index') }}" class="btn btn-light-primary">
                    <i class="ki-duotone ki-arrow-left fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    العودة للسلايدر
                </a>
            </div>
        </div>

        <div class="card-body pt-0">
            @if($sliders->count() > 0)
                <table class="table table-row-dashed fs-6 gy-5" id="kt_ecommerce_category_table">
                    <thead>
                        <tr class="text-gray-400 fw-bold">
                            <th class="text-start">الصورة</th>
                            <th class="text-start">حالة النشر</th>
                            <th class="text-start">تاريخ الحذف</th>
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
                                    @if($slider->is_published)
                                        <span class="badge badge-light-success fs-7 fw-bold">منشور</span>
                                    @else
                                        <span class="badge badge-light-danger fs-7 fw-bold">غير منشور</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="ms-5">
                                        <span class="text-gray-800 fs-5 fw-bold mb-1">
                                            {{ $slider->deleted_at->format('d-m-Y') }}
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
                                            <form id="restore-form-{{ $slider->id }}" action="{{ route('dashboard.sliders.restore', $slider->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="button" class="menu-link px-3 restore-slider-btn" style="background: none; border: none; width: 100%; text-align: start; color: inherit;" data-slider-id="{{ $slider->id }}">
                                                    <i class="ki-duotone ki-arrows-circle fs-2 me-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                    استعادة
                                                </button>
                                            </form>
                                        </div>

                                        <div class="menu-item px-3">
                                            <form id="force-delete-form-{{ $slider->id }}" action="{{ route('dashboard.sliders.force-delete', $slider->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="button" class="menu-link px-3 force-delete-slider-btn" style="background: none; border: none; width: 100%; text-align: start; color: inherit;" data-slider-id="{{ $slider->id }}">
                                                    <i class="ki-duotone ki-trash fs-2 me-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                    حذف نهائي
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                @if($sliders->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            عرض {{ $sliders->firstItem() ?? 0 }} إلى {{ $sliders->lastItem() ?? 0 }} من {{ $sliders->total() }} عنصر
                        </div>
                        {{ $sliders->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            @else
                <div class="text-center py-10">
                    <div class="symbol symbol-100px mx-auto mb-5">
                        <span class="symbol-label bg-light-warning">
                            <i class="ki-duotone ki-trash fs-2x text-warning">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                            </i>
                        </span>
                    </div>
                    <h3 class="text-dark fw-bold mb-2">سلة المحذوفات فارغة</h3>
                                         <p class="text-muted fs-6">لا توجد بنرات محذوفة في الوقت الحالي.</p>
                    <a href="{{ route('dashboard.sliders.index') }}" class="btn btn-primary mt-3">
                        العودة للبنرات 
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>


@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Simple table without DataTables to avoid conflicts
            // Using server-side pagination instead

            // SweetAlert2 for restore confirmation
            $('.restore-slider-btn').on('click', function() {
                const sliderId = $(this).data('slider-id');
                
                                 Swal.fire({
                     title: 'استعادة البنر؟',
                     text: 'سيتم استعادة البنر إلى قائمة البنرات النشطة',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'نعم، استعد',
                    cancelButtonText: 'إلغاء',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('restore-form-' + sliderId).submit();
                    }
                });
            });

            // SweetAlert2 for force delete confirmation
            $('.force-delete-slider-btn').on('click', function() {
                const sliderId = $(this).data('slider-id');
                
                                 Swal.fire({
                     title: 'حذف نهائي؟',
                     text: 'هذا الإجراء لا يمكن التراجع عنه! سيتم حذف البنر نهائياً',
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'نعم، احذف نهائياً',
                    cancelButtonText: 'إلغاء',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('force-delete-form-' + sliderId).submit();
                    }
                });
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
