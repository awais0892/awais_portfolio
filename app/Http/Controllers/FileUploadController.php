<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FileUploadController extends Controller
{
    /**
     * Upload image to Cloudinary
     */
    public function uploadImage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB max
            'folder' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $folder = $request->folder ?? 'portfolio';

            // Check if Cloudinary is configured
            if (config('cloudinary.cloud_url')) {
                $publicId = $folder . '/' . uniqid();
                $result = Cloudinary::uploadApi()->upload($request->file('image')->getRealPath(), [
                    'public_id' => $publicId,
                    'folder' => $folder,
                    'resource_type' => 'image',
                    'transformation' => [
                        'quality' => 'auto',
                        'fetch_format' => 'auto'
                    ]
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Image uploaded successfully to Cloudinary',
                    'data' => [
                        'public_id' => $result['public_id'],
                        'secure_url' => $result['secure_url'],
                        'url' => $result['url'],
                        'width' => $result['width'],
                        'height' => $result['height'],
                        'format' => $result['format'],
                        'bytes' => $result['bytes']
                    ]
                ]);
            } else {
                // Fallback to local storage
                $file = $request->file('image');
                $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs($folder, $filename, 'public');
                $url = asset('storage/' . $path);

                return response()->json([
                    'success' => true,
                    'message' => 'Image uploaded successfully to local storage',
                    'data' => [
                        'public_id' => $path, // Use path as pseudo public_id for local files
                        'secure_url' => $url,
                        'url' => $url,
                        'format' => $file->getClientOriginalExtension(),
                        'bytes' => $file->getSize()
                    ]
                ]);
            }

        } catch (\Exception $e) {
            \Log::error('Image upload failed: ' . $e->getMessage() . "\n" . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload document to Cloudinary
     */
    public function uploadDocument(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'document' => 'required|file|mimes:pdf,doc,docx,txt|max:10240', // 10MB max
            'folder' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $folder = $request->folder ?? 'portfolio/documents';

            // Check if Cloudinary is configured
            if (config('cloudinary.cloud_url')) {
                $publicId = $folder . '/' . uniqid();
                $result = Cloudinary::uploadApi()->upload($request->file('document')->getRealPath(), [
                    'public_id' => $publicId,
                    'folder' => $folder,
                    'resource_type' => 'raw'
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Document uploaded successfully to Cloudinary',
                    'data' => [
                        'public_id' => $result['public_id'],
                        'secure_url' => $result['secure_url'],
                        'url' => $result['url'],
                        'format' => $result['format'],
                        'bytes' => $result['bytes']
                    ]
                ]);
            } else {
                // Fallback to local storage
                $file = $request->file('document');
                $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs($folder, $filename, 'public');
                $url = asset('storage/' . $path);

                return response()->json([
                    'success' => true,
                    'message' => 'Document uploaded successfully to local storage',
                    'data' => [
                        'public_id' => $path,
                        'secure_url' => $url,
                        'url' => $url,
                        'format' => $file->getClientOriginalExtension(),
                        'bytes' => $file->getSize()
                    ]
                ]);
            }

        } catch (\Exception $e) {
            \Log::error('Document upload failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to upload document: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete file from Cloudinary
     */
    public function deleteFile(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'public_id' => 'required|string',
            'resource_type' => 'nullable|string|in:image,raw,video'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            if (config('cloudinary.cloud_url') && !str_starts_with($request->public_id, 'portfolio/')) {
                // Typical Cloudinary ID or if Cloudinary is forced
                $resourceType = $request->resource_type ?? 'image';
                $result = Cloudinary::destroy($request->public_id, [
                    'resource_type' => $resourceType
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'File deleted successfully from Cloudinary',
                    'data' => $result
                ]);
            } else {
                // Fallback to delete from local disk if public_id looks like our local path
                // Also handles the case when CLOUDINARY_URL is not set entirely
                if (Storage::disk('public')->exists($request->public_id)) {
                    Storage::disk('public')->delete($request->public_id);
                    return response()->json([
                        'success' => true,
                        'message' => 'File deleted successfully from local storage'
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'File not found in local storage'
                ], 404);
            }

        } catch (\Exception $e) {
            \Log::error('File deletion failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete file: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get file information
     */
    public function getFileInfo(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'public_id' => 'required|string',
            'resource_type' => 'nullable|string|in:image,raw,video'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            if (config('cloudinary.cloud_url')) {
                $resourceType = $request->resource_type ?? 'image';

                $result = Cloudinary::adminApi()->resource($request->public_id, [
                    'resource_type' => $resourceType
                ]);

                return response()->json([
                    'success' => true,
                    'data' => $result
                ]);
            } else {
                // Local Fallback
                if (Storage::disk('public')->exists($request->public_id)) {
                    $url = asset('storage/' . $request->public_id);
                    $size = Storage::disk('public')->size($request->public_id);
                    return response()->json([
                        'success' => true,
                        'data' => [
                            'public_id' => $request->public_id,
                            'secure_url' => $url,
                            'url' => $url,
                            'bytes' => $size
                        ]
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'File not found locally'
                ], 404);
            }

        } catch (\Exception $e) {
            \Log::error('Get file info failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to get file info: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate image transformations
     */
    public function transformImage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'public_id' => 'required|string',
            'width' => 'nullable|integer|min:1|max:2000',
            'height' => 'nullable|integer|min:1|max:2000',
            'quality' => 'nullable|string|in:auto,eco,good,better,best',
            'format' => 'nullable|string|in:auto,webp,jpg,png,gif'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            if (config('cloudinary.cloud_url')) {
                $transformations = [];

                if ($request->input('width'))
                    $transformations['width'] = $request->input('width');
                if ($request->input('height'))
                    $transformations['height'] = $request->input('height');
                if ($request->input('quality'))
                    $transformations['quality'] = $request->input('quality');
                if ($request->input('format'))
                    $transformations['fetch_format'] = $request->input('format');

                // Build URL using the Cloudinary URL generator
                $cloudinary = new \Cloudinary\Cloudinary(config('cloudinary.cloud_url'));
                $url = $cloudinary->image($request->input('public_id'))->toUrl();

                return response()->json([
                    'success' => true,
                    'data' => [
                        'url' => $url,
                        'transformations' => $transformations
                    ]
                ]);
            } else {
                // Return original local image URL, ignoring transformations
                $url = asset('storage/' . $request->public_id);
                return response()->json([
                    'success' => true,
                    'data' => [
                        'url' => $url,
                        'transformations' => []
                    ]
                ]);
            }

        } catch (\Exception $e) {
            \Log::error('Image transformation failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to transform image: ' . $e->getMessage()
            ], 500);
        }
    }
}