<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ImageUploadTrait
{
   /**
    * Upload a single image with a fixed name (like avatar.jpg or banner.jpg)
    */
   public function uploadSingleImage(
      ?UploadedFile $image,
      Model $model,
      string $fileName, // e.g. avatar.jpg, banner.jpg
      string $folder = 'images'
   ): ?string {
      if (!$image || !$image->isValid()) {
         return null;
      }

      $path = $this->buildImagePath($model, $folder);

      // overwrite with a fixed filename
      $filename = $fileName;

      $storedPath = $image->storeAs($path, $filename, 'public');

      return $storedPath;
   }

   /**
    * Upload multiple images and return array of stored paths
    */
   public function uploadMultipleImages(?array $images, Model $model, string $folder = 'images'): array
   {
      if (!$images || empty($images)) {
         return [];
      }

      $storedPaths = [];
      $path = $this->buildImagePath($model, $folder);

      foreach ($images as $image) {
         if ($image instanceof UploadedFile && $image->isValid()) {
               // generate unique filename for galleries
               $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
               $storedPaths[] = $image->storeAs($path, $filename, 'public');
         }
      }

      return $storedPaths;
   }

   /**
    * Build the image path based on model type and id
    */
   private function buildImagePath(Model $model, string $folder): string
   {
      $type = strtolower(class_basename($model)); // e.g. "user", "service", "restaurant"
      return $folder . '/' . $type . 's/' . $model->id;
   }

   /**
    * Delete an image from storage
    */
   public function deleteImage(string $path): bool
   {
      if (Storage::disk('public')->exists($path)) {
         return Storage::disk('public')->delete($path);
      }
      return false;
   }
}
