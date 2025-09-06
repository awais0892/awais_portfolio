<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
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
            $publicId = $folder . '/' . uniqid();
            
            $result = Cloudinary::upload($request->file('image')->getRealPath(), [
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
                'message' => 'Image uploaded successfully',
                'data' => [
                    'public_id' => $result->getPublicId(),
                    'secure_url' => $result->getSecurePath(),
                    'url' => $result->getPath(),
                    'width' => $result->getWidth(),
                    'height' => $result->getHeight(),
                    'format' => $result->getExtension(),
                    'bytes' => $result->getSize()
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Image upload failed: ' . $e->getMessage());
            
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
            $publicId = $folder . '/' . uniqid();
            
            $result = Cloudinary::upload($request->file('document')->getRealPath(), [
                'public_id' => $publicId,
                'folder' => $folder,
                'resource_type' => 'raw'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Document uploaded successfully',
                'data' => [
                    'public_id' => $result->getPublicId(),
                    'secure_url' => $result->getSecurePath(),
                    'url' => $result->getPath(),
                    'format' => $result->getExtension(),
                    'bytes' => $result->getSize()
                ]
            ]);

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
            $resourceType = $request->resource_type ?? 'image';
            
            $result = Cloudinary::destroy($request->public_id, [
                'resource_type' => $resourceType
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully',
                'data' => $result
            ]);

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
            $resourceType = $request->resource_type ?? 'image';
            
            $result = Cloudinary::adminApi()->resource($request->public_id, [
                'resource_type' => $resourceType
            ]);

            return response()->json([
                'success' => true,
                'data' => $result
            ]);

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
            $transformations = [];
            
            if ($request->width) $transformations['width'] = $request->width;
            if ($request->height) $transformations['height'] = $request->height;
            if ($request->quality) $transformations['quality'] = $request->quality;
            if ($request->format) $transformations['fetch_format'] = $request->format;
            
            $url = Cloudinary::getUrl($request->public_id, $transformations);

            return response()->json([
                'success' => true,
                'data' => [
                    'url' => $url,
                    'transformations' => $transformations
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Image transformation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to transform image: ' . $e->getMessage()
            ], 500);
        }
    }
}