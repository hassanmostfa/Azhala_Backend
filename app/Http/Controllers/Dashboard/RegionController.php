<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\RegionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegionController extends Controller
{
    protected $regionService;

    public function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;
    }

    /**
     * Display a listing of regions.
     *
     * @return View
     */
    public function index(): View
    {
        $regions = $this->regionService->getAllRegions();
        return view('dashboard.pages.regions.index', compact('regions'));
    }

    /**
     * Get cities for a specific region.
     *
     * @param int $regionId
     * @return JsonResponse
     */
    public function getCities(int $regionId): JsonResponse
    {
        $cities = $this->regionService->getCitiesByRegionId($regionId);
        return response()->json($cities);
    }

    /**
     * Toggle the active status of a city.
     *
     * @param Request $request
     * @param int $cityId
     * @return JsonResponse
     */
    public function toggleCityStatus(Request $request, int $cityId): JsonResponse
    {
        $isActive = $request->input('is_active', 0) == 1;
        $success = $this->regionService->toggleCityStatus($cityId, $isActive);

        return response()->json([
            'success' => $success,
            'is_active' => $isActive,
            'message' => $success ? 'تم تحديث حالة المدينة بنجاح' : 'فشل تحديث حالة المدينة'
        ]);
    }

    /**
     * Toggle the active status of a region.
     *
     * @param Request $request
     * @param int $regionId
     * @return JsonResponse
     */
    public function toggleRegionStatus(Request $request, int $regionId): JsonResponse
    {
        $isActive = $request->input('is_active', 0) == 1;
        $success = $this->regionService->toggleRegionStatus($regionId, $isActive);
        \Log::info('Region status toggled:', ['region_id' => $regionId, 'is_active' => $isActive, 'success' => $success]);
        return response()->json([
            'success' => $success,
            'is_active' => $isActive,
            'message' => $success ? 'تم تحديث حالة المنطقة بنجاح' : 'فشل تحديث حالة المنطقة'
        ]);
    }

    public function toggleAllRegionsStatus(Request $request): JsonResponse
    {
        $isActive = $request->input('is_active', 0) == 1;
        $success = $this->regionService->toggleAllRegionsStatus($isActive);
        \Log::info('All regions status toggled:', ['is_active' => $isActive, 'success' => $success]);
        return response()->json([
            'success' => $success,
            'is_active' => $isActive,
            'message' => $success ? 'تم تحديث حالة جميع المناطق بنجاح' : 'فشل تحديث حالة جميع المناطق'
        ]);
    }

    public function toggleAllCitiesStatus(Request $request, int $regionId): JsonResponse
{
    $isActive = $request->input('is_active', 0) == 1;
    $success = $this->regionService->toggleAllCitiesStatus($regionId, $isActive);
    \Log::info('All cities status toggled for region:', ['region_id' => $regionId, 'is_active' => $isActive, 'success' => $success]);
    return response()->json([
        'success' => $success,
        'is_active' => $isActive,
        'message' => $success ? 'تم تحديث حالة جميع المدن بنجاح' : 'فشل تحديث حالة جميع المدن'
    ]);
}
/**
 * Toggle the active status of multiple selected regions.
 *
 * @param Request $request
 * @return JsonResponse
 */
public function toggleSelectedRegionsStatus(Request $request): JsonResponse
{
    $regionIds = $request->input('region_ids', []);
    $isActive = $request->input('is_active', 0) == 1;
    $success = $this->regionService->toggleSelectedRegionsStatus($regionIds, $isActive);
    \Log::info('Selected regions status toggled:', ['region_ids' => $regionIds, 'is_active' => $isActive, 'success' => $success]);
    return response()->json([
        'success' => $success,
        'is_active' => $isActive,
        'message' => $success ? 'تم تحديث حالة المناطق المختارة بنجاح' : 'فشل تحديث حالة المناطق المختارة'
    ]);
}
/**
 * Toggle the active status of multiple selected cities.
 *
 * @param Request $request
 * @return JsonResponse
 */
public function toggleSelectedCitiesStatus(Request $request): JsonResponse
{
    $cityIds = $request->input('city_ids', []);
    $isActive = $request->input('is_active', 0) == 1;
    $success = $this->regionService->toggleSelectedCitiesStatus($cityIds, $isActive);
    \Log::info('Selected cities status toggled:', ['city_ids' => $cityIds, 'is_active' => $isActive, 'success' => $success]);
    return response()->json([
        'success' => $success,
        'is_active' => $isActive,
        'message' => $success ? 'تم تحديث حالة المدن المختارة بنجاح' : 'فشل تحديث حالة المدن المختارة'
    ]);
}
}
