<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponse
{
   /**
    * Success response
    */
   protected function successResponse($data = null, string $message = 'Success', int $code = 200): JsonResponse
   {
      return response()->json([
         'success' => true,
         'message' => $message,
         'data' => $data,
         'timestamp' => now()->toISOString(),
      ], $code);
   }

   /**
    * Error response
    */
   protected function errorResponse(string $message = 'Error', int $code = 400, $errors = null): JsonResponse
   {
      $response = [
         'success' => false,
         'message' => $message,
         'timestamp' => now()->toISOString(),
      ];

      if ($errors) {
         $response['errors'] = $errors;
      }

      return response()->json($response, $code);
   }

   /**
    * Validation error response
    */
   protected function validationErrorResponse($errors, string $message = 'Validation failed'): JsonResponse
   {
      return response()->json([
         'success' => false,
         'message' => $message,
         'errors' => $errors,
         'timestamp' => now()->toISOString(),
      ], 422);
   }

   /**
    * Not found response
    */
   protected function notFoundResponse(string $message = 'Resource not found'): JsonResponse
   {
      return $this->errorResponse($message, 404);
   }

   /**
    * Unauthorized response
    */
   protected function unauthorizedResponse(string $message = 'Unauthorized'): JsonResponse
   {
      return $this->errorResponse($message, 401);
   }

   /**
    * Forbidden response
    */
   protected function forbiddenResponse(string $message = 'Forbidden'): JsonResponse
   {
      return $this->errorResponse($message, 403);
   }

   /**
    * Server error response
    */
   protected function serverErrorResponse(string $message = 'Internal server error'): JsonResponse
   {
      return $this->errorResponse($message, 500);
   }

   /**
    * Created response
    */
   protected function createdResponse($data = null, string $message = 'Resource created successfully'): JsonResponse
   {
      return $this->successResponse($data, $message, 201);
   }

   /**
    * Updated response
    */
   protected function updatedResponse($data = null, string $message = 'Resource updated successfully'): JsonResponse
   {
      return $this->successResponse($data, $message, 200);
   }

   /**
    * Deleted response
    */
   protected function deletedResponse(string $message = 'Resource deleted successfully'): JsonResponse
   {
      return $this->successResponse(null, $message, 200);
   }

   /**
    * Paginated response
    */
   protected function paginatedResponse($data, string $message = 'Data retrieved successfully'): JsonResponse
   {
      if ($data instanceof LengthAwarePaginator) {
         return response()->json([
               'success' => true,
               'message' => $message,
               'data' => $data->items(),
               'pagination' => [
                  'current_page' => $data->currentPage(),
                  'last_page' => $data->lastPage(),
                  'per_page' => $data->perPage(),
                  'total' => $data->total(),
                  'from' => $data->firstItem(),
                  'to' => $data->lastItem(),
               ],
               'timestamp' => now()->toISOString(),
         ]);
      }

      return $this->successResponse($data, $message);
   }

   /**
    * Resource response
    */
   protected function resourceResponse(JsonResource $resource, string $message = 'Data retrieved successfully'): JsonResponse
   {
      return response()->json([
         'success' => true,
         'message' => $message,
         'data' => $resource,
         'timestamp' => now()->toISOString(),
      ]);
   }

   /**
    * Resource collection response
    */
   protected function resourceCollectionResponse(ResourceCollection $collection, string $message = 'Data retrieved successfully'): JsonResponse
   {
      return response()->json([
         'success' => true,
         'message' => $message,
         'data' => $collection,
         'timestamp' => now()->toISOString(),
      ]);
   }

   /**
    * No content response
    */
   protected function noContentResponse(): JsonResponse
   {
      return response()->json(null, 204);
   }

   /**
    * Conflict response
    */
   protected function conflictResponse(string $message = 'Conflict occurred'): JsonResponse
   {
      return $this->errorResponse($message, 409);
   }

   /**
    * Too many requests response
    */
   protected function tooManyRequestsResponse(string $message = 'Too many requests'): JsonResponse
   {
      return $this->errorResponse($message, 429);
   }

   /**
    * Service unavailable response
    */
   protected function serviceUnavailableResponse(string $message = 'Service temporarily unavailable'): JsonResponse
   {
      return $this->errorResponse($message, 503);
   }
}
