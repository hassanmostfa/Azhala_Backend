@extends('dashboard.layouts.app')

@section('content')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xl">
                    <div class="row g-5 g-xl-8">
                        <!-- Regions Section -->
                        <div class="col-xl-6">
                            <div class="card card-xl-stretch mb-xl-8">
                                <div class="card-header border-0 pt-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold fs-3 mb-1">المناطق</span>
                                        <span class="text-muted mt-1 fw-semibold fs-7">اختر منطقة لرؤية المدن التابعة لها</span>
                                    </h3>
                                </div>
                                <div class="card-body py-3">
                                    <div class="table-responsive">
                                        <table class="table align-middle gs-0 gy-3">
                                            <tbody>
                                                @forelse($regions as $region)
                                                    <tr>
                                                        <td>
                                                            <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6 region-link" data-region-id="{{ $region->id }}">{{ $region->name }}</a>
                                                        </td>
                                                        <td class="text-muted fw-bold">
                                                            <div class="form-check form-switch form-check-custom form-check-solid">
                                                                <input class="form-check-input region-toggle" type="checkbox" name="is_active" value="1" id="region_{{ $region->id }}" {{ $region->is_active ? 'checked' : '' }} data-region-id="{{ $region->id }}" />
                                                                <label class="form-check-label" for="region_{{ $region->id }}"></label>
                                                            </div>
                                                        </td>
                                                        <td class="text-end text-dark fw-bold fs-6 pe-0">
                                                            <button class="btn btn-primary view-cities" data-region-id="{{ $region->id }}">عرض</button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr><td colspan="3">لا توجد مناطق</td></tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cities Section -->
                        <div class="col-xl-6">
                            <div class="card card-xl-stretch mb-xl-8">
                                <div class="card-header border-0 pt-5">
                                    <h3 class="card-title align-items-start flex-column">
                                        <span class="card-label fw-bold fs-3 mb-1">المدن التابعة لـ <span id="region-name">اختر منطقة</span></span>
                                    </h3>
                                </div>
                                <div class="card-body py-3">
                                    <div class="table-responsive">
                                        <table class="table align-middle gs-0 gy-3" id="cities-table">
                                            <tbody>
                                                <tr><td colspan="2">اختر منطقة لعرض المدن</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function() {
                console.log('jQuery loaded and script running');

                // Load cities when clicking a region link or view button
                $('.region-link, .view-cities').on('click', function(e) {
                    e.preventDefault();
                    let regionId = $(this).data('region-id');
                    let regionName = $(this).hasClass('region-link') ? $(this).text() : $(this).closest('tr').find('.region-link').text();
                    console.log('Fetching cities for region ID:', regionId);

                    $.ajax({
                        url: '{{ route("dashboard.regions.cities", ":regionId") }}'.replace(':regionId', regionId),
                        method: 'GET',
                        success: function(response) {
                            console.log('Cities response:', response);
                            $('#region-name').text(regionName);
                            let citiesTable = $('#cities-table tbody');
                            citiesTable.empty();

                            if (response.length === 0) {
                                citiesTable.append('<tr><td colspan="2">لا توجد مدن لهذه المنطقة</td></tr>');
                                return;
                            }

                            response.forEach(function(city) {
                                let row = `
                                    <tr>
                                        <td>
                                            <a href="#" class="text-dark fw-bold text-hover-primary mb-1 fs-6">${city.name}</a>
                                        </td>
                                        <td class="text-muted fw-bold fs-6 pe-0">
                                            <div class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input city-toggle" type="checkbox" name="is_active" value="1"
                                                       id="city_${city.id}" ${city.is_active ? 'checked' : ''} data-city-id="${city.id}" />
                                                <label class="form-check-label" for="city_${city.id}"></label>
                                            </div>
                                        </td>
                                    </tr>
                                `;
                                citiesTable.append(row);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching cities:', status, error, xhr.responseText);
                            Swal.fire({
                                text: 'حدث خطأ أثناء جلب المدن',
                                icon: 'error',
                                buttonsStyling: false,
                                confirmButtonText: 'موافق',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                }
                            });
                        }
                    });
                });

                // Toggle city status
                $(document).on('change', '.city-toggle', function() {
                    let cityId = $(this).data('city-id');
                    let isActive = $(this).is(':checked') ? 1 : 0;
                    let $checkbox = $(this);
                    console.log('Toggling city ID:', cityId, 'is_active:', isActive);

                    Swal.fire({
                        text: 'هل أنت متأكد من تحديث حالة هذه المدينة؟',
                        icon: 'warning',
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: 'نعم، حدث!',
                        cancelButtonText: 'لا، إلغاء',
                        customClass: {
                            confirmButton: 'btn btn-primary',
                            cancelButton: 'btn btn-active-light'
                        }
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route("dashboard.cities.toggle", ":cityId") }}'.replace(':cityId', cityId),
                                method: 'POST',
                                data: {
                                    is_active: isActive,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    console.log('Toggle city response:', response);
                                    Swal.fire({
                                        text: response.message || 'تم تحديث حالة المدينة بنجاح',
                                        icon: 'success',
                                        buttonsStyling: false,
                                        confirmButtonText: 'موافق',
                                        customClass: {
                                            confirmButton: 'btn btn-primary'
                                        }
                                    });
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error toggling city:', status, error, xhr.responseText);
                                    $checkbox.prop('checked', !isActive); // Revert on error
                                    Swal.fire({
                                        text: xhr.responseJSON?.message || 'حدث خطأ أثناء تحديث حالة المدينة',
                                        icon: 'error',
                                        buttonsStyling: false,
                                        confirmButtonText: 'موافق',
                                        customClass: {
                                            confirmButton: 'btn btn-primary'
                                        }
                                    });
                                }
                            });
                        } else {
                            $checkbox.prop('checked', !isActive); // Revert on cancel
                        }
                    });
                });

                // Toggle region status
                $(document).on('change', '.region-toggle', function() {
                    let regionId = $(this).data('region-id');
                    let isActive = $(this).is(':checked') ? 1 : 0;
                    let $checkbox = $(this);
                    console.log('Toggling region ID:', regionId, 'is_active:', isActive);

                    Swal.fire({
                        text: 'هل أنت متأكد من تحديث حالة هذه المنطقة؟',
                        icon: 'warning',
                        showCancelButton: true,
                        buttonsStyling: false,
                        confirmButtonText: 'نعم، حدث!',
                        cancelButtonText: 'لا، إلغاء',
                        customClass: {
                            confirmButton: 'btn btn-primary',
                            cancelButton: 'btn btn-active-light'
                        }
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route("dashboard.regions.toggle", ":regionId") }}'.replace(':regionId', regionId),
                                method: 'POST',
                                data: {
                                    is_active: isActive,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    console.log('Toggle region response:', response);
                                    Swal.fire({
                                        text: response.message || 'تم تحديث حالة المنطقة بنجاح',
                                        icon: 'success',
                                        buttonsStyling: false,
                                        confirmButtonText: 'موافق',
                                        customClass: {
                                            confirmButton: 'btn btn-primary'
                                        }
                                    });
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error toggling region:', status, error, xhr.responseText);
                                    $checkbox.prop('checked', !isActive); // Revert on error
                                    Swal.fire({
                                        text: xhr.responseJSON?.message || 'حدث خطأ أثناء تحديث حالة المنطقة',
                                        icon: 'error',
                                        buttonsStyling: false,
                                        confirmButtonText: 'موافق',
                                        customClass: {
                                            confirmButton: 'btn btn-primary'
                                        }
                                    });
                                }
                            });
                        } else {
                            $checkbox.prop('checked', !isActive); // Revert on cancel
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
