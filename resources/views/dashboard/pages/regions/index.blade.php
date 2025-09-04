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
                                    <div class="card-toolbar d-flex align-items-center gap-3">
                                        <div class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input toggle-all-regions" type="checkbox" name="toggle_all_regions" value="1" id="toggle_all_regions" data-is-active="1" />
                                            <label class="form-check-label fw-bold text-muted" for="toggle_all_regions" id="toggle-all-regions-label">تفعيل الكل</label>
                                        </div>
                                        <button class="btn btn-primary toggle-selected-regions" disabled>تفعيل/إيقاف المختارة</button>
                                    </div>
                                </div>
                                <div class="card-body py-3">
                                    <div class="table-responsive">
                                        <table class="table align-middle gs-0 gy-3">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">
                                                        <input class="form-check-input select-all-regions" type="checkbox" id="select_all_regions" />
                                                    </th>
                                                    <th>المنطقة</th>
                                                    <th>الحالة</th>
                                                    <th class="text-end">عرض</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($regions as $region)
                                                    <tr>
                                                        <td>
                                                            <input class="form-check-input region-select" type="checkbox" data-region-id="{{ $region->id }}" />
                                                        </td>
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
                                                    <tr><td colspan="4">لا توجد مناطق</td></tr>
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
                                    <div class="card-toolbar d-flex align-items-center gap-3">
                                        <div class="form-check form-switch form-check-custom form-check-solid">
                                            <input class="form-check-input toggle-all-cities" type="checkbox" name="toggle_all_cities" value="1" id="toggle_all_cities" data-is-active="1" disabled />
                                            <label class="form-check-label fw-bold text-muted" for="toggle_all_cities" id="toggle-all-cities-label">تفعيل الكل</label>
                                        </div>
                                        <button class="btn btn-primary toggle-selected-cities" disabled>تفعيل/إيقاف المختارة</button>
                                    </div>
                                </div>
                                <div class="card-body py-3">
                                    <div class="table-responsive">
                                        <table class="table align-middle gs-0 gy-3" id="cities-table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">
                                                        <input class="form-check-input select-all-cities" type="checkbox" id="select_all_cities" />
                                                    </th>
                                                    <th>المدينة</th>
                                                    <th>الحالة</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr><td colspan="3">اختر منطقة لعرض المدن</td></tr>
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

                // Initialize Toast configuration
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });

                // Track the currently selected region
                let currentRegionId = null;

                // Load cities when clicking a region link or view button
                $('.region-link, .view-cities').on('click', function(e) {
                    e.preventDefault();
                    let regionId = $(this).data('region-id');
                    let regionName = $(this).hasClass('region-link') ? $(this).text() : $(this).closest('tr').find('.region-link').text();
                    currentRegionId = regionId; // Update current region
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
                                citiesTable.append('<tr><td colspan="3">لا توجد مدن لهذه المنطقة</td></tr>');
                                $('.toggle-all-cities').prop('disabled', true);
                                $('.toggle-selected-cities').prop('disabled', true);
                                $('#toggle-all-cities-label').text('تفعيل الكل');
                                return;
                            }

                            // Enable the toggle-all-cities and toggle-selected-cities
                            $('.toggle-all-cities').prop('disabled', false);
                            $('.toggle-selected-cities').prop('disabled', true); // Enable only when cities are selected

                            response.forEach(function(city) {
                                let row = `
                                    <tr>
                                        <td>
                                            <input class="form-check-input city-select" type="checkbox" data-city-id="${city.id}" />
                                        </td>
                                        <td>
                                            <span  class="text-dark fw-bold text-hover-primary mb-1 fs-6">${city.name}</span>
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

                            // Update toggle-all-cities switch state based on cities
                            let allActive = response.every(city => city.is_active);
                            $('.toggle-all-cities').prop('checked', allActive).data('is-active', allActive ? 1 : 0);
                            $('#toggle-all-cities-label').text(allActive ? 'إيقاف الكل' : 'تفعيل الكل');
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching cities:', status, error, xhr.responseText);
                            $('.toggle-all-cities').prop('disabled', true);
                            $('.toggle-selected-cities').prop('disabled', true);
                            $('#toggle-all-cities-label').text('تفعيل الكل');
                            Toast.fire({
                                text: xhr.responseJSON?.message || 'حدث خطأ أثناء جلب المدن',
                                icon: 'error'
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

                    $.ajax({
                        url: '{{ route("dashboard.cities.toggle", ":cityId") }}'.replace(':cityId', cityId),
                        method: 'POST',
                        data: {
                            is_active: isActive,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log('Toggle city response:', response);
                            Toast.fire({
                                text: response.message || 'تم تحديث حالة المدينة بنجاح',
                                icon: 'success'
                            });
                            // Update toggle-all-cities switch state
                            let allActive = $('.city-toggle').toArray().every(checkbox => $(checkbox).is(':checked'));
                            $('.toggle-all-cities').prop('checked', allActive).data('is-active', allActive ? 1 : 0);
                            $('#toggle-all-cities-label').text(allActive ? 'إيقاف الكل' : 'تفعيل الكل');
                        },
                        error: function(xhr, status, error) {
                            console.error('Error toggling city:', status, error, xhr.responseText);
                            $checkbox.prop('checked', !isActive); // Revert on error
                            Toast.fire({
                                text: xhr.responseJSON?.message || 'حدث خطأ أثناء تحديث حالة المدينة',
                                icon: 'error'
                            });
                        }
                    });
                });

                // Toggle region status
                $(document).on('change', '.region-toggle', function() {
                    let regionId = $(this).data('region-id');
                    let isActive = $(this).is(':checked') ? 1 : 0;
                    let $checkbox = $(this);
                    console.log('Toggling region ID:', regionId, 'is_active:', isActive);

                    $.ajax({
                        url: '{{ route("dashboard.regions.toggle", ":regionId") }}'.replace(':regionId', regionId),
                        method: 'POST',
                        data: {
                            is_active: isActive,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log('Toggle region response:', response);
                            Toast.fire({
                                text: response.message || 'تم تحديث حالة المنطقة بنجاح',
                                icon: 'success'
                            });
                            // Update toggle-all-regions switch state
                            let allRegionsActive = $('.region-toggle').toArray().every(checkbox => $(checkbox).is(':checked'));
                            $('.toggle-all-regions').prop('checked', allRegionsActive).data('is-active', allRegionsActive ? 1 : 0);
                            $('#toggle-all-regions-label').text(allRegionsActive ? 'إيقاف الكل' : 'تفعيل الكل');
                        },
                        error: function(xhr, status, error) {
                            console.error('Error toggling region:', status, error, xhr.responseText);
                            $checkbox.prop('checked', !isActive); // Revert on error
                            Toast.fire({
                                text: xhr.responseJSON?.message || 'حدث خطأ أثناء تحديث حالة المنطقة',
                                icon: 'error'
                            });
                        }
                    });
                });

                // Toggle all regions status
                $(document).on('change', '.toggle-all-regions', function() {
                    let isActive = $(this).is(':checked') ? 1 : 0;
                    let $checkbox = $(this);
                    let labelText = isActive ? 'إيقاف الكل' : 'تفعيل الكل';
                    console.log('Toggling all regions, is_active:', isActive);

                    $.ajax({
                        url: '{{ route("dashboard.regions.toggle-all") }}',
                        method: 'POST',
                        data: {
                            is_active: isActive,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log('Toggle all regions response:', response);
                            $('.region-toggle').prop('checked', isActive);
                            $('#toggle-all-regions-label').text(labelText);
                            Toast.fire({
                                text: response.message || `تم ${isActive ? 'تفعيل' : 'إيقاف'} جميع المناطق بنجاح`,
                                icon: 'success'
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error toggling all regions:', status, error, xhr.responseText);
                            $checkbox.prop('checked', !isActive); // Revert on error
                            $('#toggle-all-regions-label').text(isActive ? 'تفعيل الكل' : 'إيقاف الكل');
                            Toast.fire({
                                text: xhr.responseJSON?.message || 'حدث خطأ أثناء تحديث حالة جميع المناطق',
                                icon: 'error'
                            });
                        }
                    });
                });

                // Toggle all cities status for the selected region
                $(document).on('change', '.toggle-all-cities', function() {
                    if (!currentRegionId) {
                        $(this).prop('checked', false);
                        $('#toggle-all-cities-label').text('تفعيل الكل');
                        Toast.fire({
                            text: 'يرجى اختيار منطقة أولاً',
                            icon: 'warning'
                        });
                        return;
                    }

                    let isActive = $(this).is(':checked') ? 1 : 0;
                    let $checkbox = $(this);
                    let labelText = isActive ? 'إيقاف الكل' : 'تفعيل الكل';
                    console.log('Toggling all cities for region ID:', currentRegionId, 'is_active:', isActive);

                    $.ajax({
                        url: '{{ route("dashboard.cities.toggle-all", ":regionId") }}'.replace(':regionId', currentRegionId),
                        method: 'POST',
                        data: {
                            is_active: isActive,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log('Toggle all cities response:', response);
                            $('.city-toggle').prop('checked', isActive);
                            $('#toggle-all-cities-label').text(labelText);
                            Toast.fire({
                                text: response.message || `تم ${isActive ? 'تفعيل' : 'إيقاف'} جميع المدن بنجاح`,
                                icon: 'success'
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error toggling all cities:', status, error, xhr.responseText);
                            $checkbox.prop('checked', !isActive); // Revert on error
                            $('#toggle-all-cities-label').text(isActive ? 'تفعيل الكل' : 'إيقاف الكل');
                            Toast.fire({
                                text: xhr.responseJSON?.message || 'حدث خطأ أثناء تحديث حالة جميع المدن',
                                icon: 'error'
                            });
                        }
                    });
                });

                // Handle select all regions checkbox
                $(document).on('change', '.select-all-regions', function() {
                    let isChecked = $(this).is(':checked');
                    $('.region-select').prop('checked', isChecked);
                    $('.toggle-selected-regions').prop('disabled', !$('.region-select:checked').length);
                });

                // Handle individual region selection
                $(document).on('change', '.region-select', function() {
                    $('.toggle-selected-regions').prop('disabled', !$('.region-select:checked').length);
                    let allChecked = $('.region-select').toArray().every(checkbox => $(checkbox).is(':checked'));
                    $('.select-all-regions').prop('checked', allChecked);
                });

                // Toggle selected regions status
                $(document).on('click', '.toggle-selected-regions', function() {
                    let selectedRegionIds = $('.region-select:checked').map(function() {
                        return $(this).data('region-id');
                    }).get();
                    let isActive = $('.region-toggle:checked').length > $('.region-toggle:not(:checked)').length ? 0 : 1;
                    console.log('Toggling selected regions:', selectedRegionIds, 'is_active:', isActive);

                    if (selectedRegionIds.length === 0) {
                        Toast.fire({
                            text: 'يرجى اختيار منطقة واحدة على الأقل',
                            icon: 'warning'
                        });
                        return;
                    }

                    $.ajax({
                        url: '{{ route("dashboard.regions.toggle-selected") }}',
                        method: 'POST',
                        data: {
                            region_ids: selectedRegionIds,
                            is_active: isActive,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log('Toggle selected regions response:', response);
                            selectedRegionIds.forEach(function(id) {
                                $('#region_' + id).prop('checked', isActive);
                            });
                            $('.region-select').prop('checked', false);
                            $('.select-all-regions').prop('checked', false);
                            $('.toggle-selected-regions').prop('disabled', true);
                            let allRegionsActive = $('.region-toggle').toArray().every(checkbox => $(checkbox).is(':checked'));
                            $('.toggle-all-regions').prop('checked', allRegionsActive).data('is-active', allRegionsActive ? 1 : 0);
                            $('#toggle-all-regions-label').text(allRegionsActive ? 'إيقاف الكل' : 'تفعيل الكل');
                            Toast.fire({
                                text: response.message || `تم ${isActive ? 'تفعيل' : 'إيقاف'} المناطق المختارة بنجاح`,
                                icon: 'success'
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error toggling selected regions:', status, error, xhr.responseText);
                            Toast.fire({
                                text: xhr.responseJSON?.message || 'حدث خطأ أثناء تحديث حالة المناطق المختارة',
                                icon: 'error'
                            });
                        }
                    });
                });

                // Handle select all cities checkbox
                $(document).on('change', '.select-all-cities', function() {
                    let isChecked = $(this).is(':checked');
                    $('.city-select').prop('checked', isChecked);
                    $('.toggle-selected-cities').prop('disabled', !$('.city-select:checked').length);
                });

                // Handle individual city selection
                $(document).on('change', '.city-select', function() {
                    $('.toggle-selected-cities').prop('disabled', !$('.city-select:checked').length);
                    let allChecked = $('.city-select').toArray().every(checkbox => $(checkbox).is(':checked'));
                    $('.select-all-cities').prop('checked', allChecked);
                });

                // Toggle selected cities status
                $(document).on('click', '.toggle-selected-cities', function() {
                    let selectedCityIds = $('.city-select:checked').map(function() {
                        return $(this).data('city-id');
                    }).get();
                    let isActive = $('.city-toggle:checked').length > $('.city-toggle:not(:checked)').length ? 0 : 1;
                    console.log('Toggling selected cities:', selectedCityIds, 'is_active:', isActive);

                    if (selectedCityIds.length === 0) {
                        Toast.fire({
                            text: 'يرجى اختيار مدينة واحدة على الأقل',
                            icon: 'warning'
                        });
                        return;
                    }

                    $.ajax({
                        url: '{{ route("dashboard.cities.toggle-selected") }}',
                        method: 'POST',
                        data: {
                            city_ids: selectedCityIds,
                            is_active: isActive,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log('Toggle selected cities response:', response);
                            selectedCityIds.forEach(function(id) {
                                $('#city_' + id).prop('checked', isActive);
                            });
                            $('.city-select').prop('checked', false);
                            $('.select-all-cities').prop('checked', false);
                            $('.toggle-selected-cities').prop('disabled', true);
                            let allCitiesActive = $('.city-toggle').toArray().every(checkbox => $(checkbox).is(':checked'));
                            $('.toggle-all-cities').prop('checked', allCitiesActive).data('is-active', allCitiesActive ? 1 : 0);
                            $('#toggle-all-cities-label').text(allCitiesActive ? 'إيقاف الكل' : 'تفعيل الكل');
                            Toast.fire({
                                text: response.message || `تم ${isActive ? 'تفعيل' : 'إيقاف'} المدن المختارة بنجاح`,
                                icon: 'success'
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('Error toggling selected cities:', status, error, xhr.responseText);
                            Toast.fire({
                                text: xhr.responseJSON?.message || 'حدث خطأ أثناء تحديث حالة المدن المختارة',
                                icon: 'error'
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
