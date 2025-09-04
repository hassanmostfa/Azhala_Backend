<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Interfaces\SliderRepositoryInterface;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class SliderController extends Controller
{
   use ImageUploadTrait;

   protected $sliderRepository;

   public function __construct(SliderRepositoryInterface $sliderRepository)
   {
      $this->sliderRepository = $sliderRepository;
   }

   /**
    * Display a listing of sliders
    */
   public function index()
   {
      $sliders = $this->sliderRepository->getAllPaginated(10);
      return view('dashboard.pages.sliders.index', compact('sliders'));
   }

   /**
    * Show the form for creating a new slider
    */
   public function create()
   {
      return view('dashboard.pages.sliders.create');
   }

   /**
    * Store a newly created slider
    */
   public function store(SliderRequest $request)
   {
      // Handle image upload
      $imageFile = $request->file('image');
      
             // Create a temporary model for image upload
       $tempModel = new \App\Models\Admin();
       $tempModel->id = 1; // Use Admin model with ID 1
      
      // Upload the image first
      $imagePath = $this->uploadSingleImage($imageFile, $tempModel, 'slider.jpg', 'images');
      
      if (!$imagePath) {
         return redirect()->back()
            ->with('error', 'فشل في رفع الصورة')
            ->withInput();
      }
      
      // Create slider with image path
      $slider = $this->sliderRepository->create([
         'image' => '/storage/' . $imagePath,
         'is_published' => $request->has('is_published')
      ]);
      
             // Update the image path with the correct slider ID
       $correctImagePath = str_replace('/images/admins/1/', '/images/sliders/' . $slider->id . '/', $imagePath);
       $slider->update(['image' => '/storage/' . $correctImagePath]);

      return redirect()->route('dashboard.sliders.index')
         ->with('success', 'تم إضافة الصورة بنجاح');
   }

   /**
    * Show the form for editing the specified slider
    */
   public function edit($id)
   {
      $slider = $this->sliderRepository->findById($id);
      
      if (!$slider) {
         return redirect()->route('dashboard.sliders.index')
               ->with('error', 'الصورة غير موجودة');
      }

      return view('dashboard.pages.sliders.edit', compact('slider'));
   }

   /**
    * Update the specified slider
    */
   public function update(SliderRequest $request, $id)
   {
      $slider = $this->sliderRepository->findById($id);
      
      if (!$slider) {
         return redirect()->route('dashboard.sliders.index')
               ->with('error', 'الصورة غير موجودة');
      }

      $data = [
         'is_published' => $request->has('is_published')
      ];

      // Handle image upload if provided
      if ($request->hasFile('image')) {
         $imageFile = $request->file('image');
         
         // Delete old image if exists
         if ($slider->image) {
               $this->deleteImage(str_replace('/storage/', '', $slider->image));
         }
         
         // Upload new image
         $imagePath = $this->uploadSingleImage($imageFile, $slider, 'slider.jpg', 'images');
         
         if ($imagePath) {
               $data['image'] = '/storage/' . $imagePath;
         }
      }

      $this->sliderRepository->update($id, $data);

      return redirect()->route('dashboard.sliders.index')
         ->with('success', 'تم تحديث الصورة بنجاح');
   }

   /**
    * Remove the specified slider (soft delete - move to trash)
    */
   public function destroy($id)
   {
      $slider = $this->sliderRepository->findById((int) $id);
      
      if (!$slider) {
         return redirect()->route('dashboard.sliders.index')
               ->with('error', 'السلايدر غير موجود');
      }

      // Don't delete image file on soft delete, only on force delete
      // The image should remain so it can be restored later

      $result = $this->sliderRepository->delete((int) $id);
      
      if ($result) {
         return redirect()->route('dashboard.sliders.index')
               ->with('success', 'تم نقل السلايدر إلى سلة المحذوفات بنجاح');
      }

      return redirect()->route('dashboard.sliders.index')
         ->with('error', 'حدث خطأ أثناء نقل السلايدر إلى سلة المحذوفات');
   }

   /**
    * Toggle publish status
    */
   public function togglePublish($id)
   {
      $slider = $this->sliderRepository->findById((int) $id);
      
      if (!$slider) {
         return response()->json([
            'success' => false,
            'message' => 'السلايدر غير موجود'
         ], 404);
      }

      $result = $this->sliderRepository->togglePublish((int) $id);
      
      if ($result) {
         return response()->json([
            'success' => true,
            'message' => 'تم تغيير حالة النشر بنجاح',
            'is_published' => $slider->fresh()->is_published
         ]);
      }

      return response()->json([
         'success' => false,
         'message' => 'حدث خطأ أثناء تغيير حالة النشر'
      ], 500);
   }

   /**
    * Display the specified slider
    */
   public function show($id)
   {
      $slider = $this->sliderRepository->findById((int) $id);
      
      if (!$slider) {
         return redirect()->route('dashboard.sliders.index')
               ->with('error', 'الصورة غير موجودة');
      }

      return view('dashboard.pages.sliders.show', compact('slider'));
   }

   /**
    * Display a listing of trashed sliders
    */
   public function trashed()
   {
      $sliders = $this->sliderRepository->getTrashedPaginated(10);
      return view('dashboard.pages.sliders.trashed', compact('sliders'));
   }

   /**
    * Restore soft deleted slider
    */
   public function restore($id)
   {
      $slider = $this->sliderRepository->findTrashedById((int) $id);
      
      if (!$slider) {
         return redirect()->route('dashboard.sliders.trashed')
               ->with('error', 'السلايدر غير موجود في سلة المحذوفات');
      }

      $result = $this->sliderRepository->restore((int) $id);
      
      if ($result) {
         return redirect()->route('dashboard.sliders.trashed')
               ->with('success', 'تم استعادة السلايدر بنجاح');
      }

      return redirect()->route('dashboard.sliders.trashed')
         ->with('error', 'حدث خطأ أثناء استعادة السلايدر');
   }

   /**
    * Force delete slider permanently
    */
   public function forceDelete($id)
   {
      $slider = $this->sliderRepository->findTrashedById((int) $id);
      
      if (!$slider) {
         return redirect()->route('dashboard.sliders.trashed')
               ->with('error', 'السلايدر غير موجود في سلة المحذوفات');
      }

      // Delete image file if exists
      if ($slider->image) {
         $this->deleteImage(str_replace('/storage/', '', $slider->image));
      }

      $result = $this->sliderRepository->forceDelete((int) $id);
      
      if ($result) {
         return redirect()->route('dashboard.sliders.trashed')
               ->with('success', 'تم حذف السلايدر نهائياً بنجاح');
      }

      return redirect()->route('dashboard.sliders.trashed')
         ->with('error', 'حدث خطأ أثناء حذف السلايدر نهائياً');
   }

}
