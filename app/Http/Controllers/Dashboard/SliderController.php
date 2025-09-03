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
      $sliders = $this->sliderRepository->getAll();
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
    * Remove the specified slider
    */
   public function destroy($id)
   {
      $slider = $this->sliderRepository->findById($id);
      
      if (!$slider) {
         return redirect()->route('dashboard.sliders.index')
               ->with('error', 'الصورة غير موجودة');
      }

      // Delete image file if exists
      if ($slider->image) {
         $this->deleteImage(str_replace('/storage/', '', $slider->image));
      }

      $this->sliderRepository->delete($id);

      return redirect()->route('dashboard.sliders.index')
         ->with('success', 'تم حذف الصورة بنجاح');
   }

   /**
    * Toggle publish status
    */
   public function togglePublish($id)
   {
      $result = $this->sliderRepository->togglePublish($id);
      
      if ($result) {
         return redirect()->route('dashboard.sliders.index')
               ->with('success', 'تم تغيير حالة النشر بنجاح');
      }

      return redirect()->route('dashboard.sliders.index')
         ->with('error', 'حدث خطأ أثناء تغيير حالة النشر');
   }

   /**
    * Display the specified slider
    */
   public function show($id)
   {
      $slider = $this->sliderRepository->findById($id);
      
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
      $sliders = $this->sliderRepository->getTrashed();
      return view('dashboard.pages.sliders.trashed', compact('sliders'));
   }

   /**
    * Restore soft deleted slider
    */
   public function restore($id)
   {
      $result = $this->sliderRepository->restore($id);
      
      if ($result) {
         return redirect()->route('dashboard.sliders.index')
               ->with('success', 'تم استعادة الصورة بنجاح');
      }

      return redirect()->route('dashboard.sliders.index')
         ->with('error', 'حدث خطأ أثناء استعادة الصورة');
   }

   /**
    * Force delete slider permanently
    */
   public function forceDelete($id)
   {
      $slider = $this->sliderRepository->findTrashedById($id);
      
      if (!$slider) {
         return redirect()->route('dashboard.sliders.trashed')
               ->with('error', 'الصورة غير موجودة');
      }

      // Delete image file if exists
      if ($slider->image) {
         $this->deleteImage(str_replace('/storage/', '', $slider->image));
      }

      $result = $this->sliderRepository->forceDelete($id);
      
      if ($result) {
         return redirect()->route('dashboard.sliders.trashed')
               ->with('success', 'تم حذف الصورة نهائياً بنجاح');
      }

      return redirect()->route('dashboard.sliders.trashed')
         ->with('error', 'حدث خطأ أثناء حذف الصورة نهائياً');
   }

}
