<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;

class RatingController extends Controller
{
    /**
     * Store a newly created rating
     */
    public function store(Request $request): JsonResponse
    {
        // Rate limiting
        $key = 'rating:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'success' => false,
                'message' => "Too many attempts. Please try again in {$seconds} seconds."
            ], 429);
        }

        RateLimiter::hit($key, 300); // 5 minutes

        // Debug: Log request data
        \Log::info('Rating request data:', $request->all());

        $validator = Validator::make($request->all(), [
            'rateable_type' => 'required|string',
            'rateable_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000'
        ]);

        // Additional validation for rating
        if ($request->rating == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Please select a rating',
                'errors' => ['rating' => ['Please select a rating']]
            ], 422);
        }

        if ($validator->fails()) {
            \Log::info('Rating validation failed:', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Verify the rateable model exists
        $rateableType = $request->rateable_type;
        $rateableId = $request->rateable_id;

        if (!class_exists($rateableType)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid rateable type'
            ], 400);
        }

        $rateable = $rateableType::find($rateableId);
        if (!$rateable) {
            return response()->json([
                'success' => false,
                'message' => 'Rateable item not found'
            ], 404);
        }

        // Check if user has already rated this item
        $existingRating = Rating::where('rateable_type', $rateableType)
            ->where('rateable_id', $rateableId)
            ->where('email', $request->email)
            ->first();

        if ($existingRating) {
            // Update existing rating instead of creating new one
            $existingRating->update([
                'name' => $request->name,
                'rating' => $request->rating,
                'review' => $request->review,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'is_approved' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Rating updated successfully!',
                'rating' => [
                    'id' => $existingRating->id,
                    'name' => $existingRating->name,
                    'rating' => $existingRating->rating,
                    'review' => $existingRating->review,
                    'formatted_date' => $existingRating->formatted_date,
                    'initials' => $existingRating->initials,
                    'stars_html' => $existingRating->stars_html
                ]
            ], 200);
        }

        $rating = Rating::create([
            'rateable_type' => $rateableType,
            'rateable_id' => $rateableId,
            'name' => $request->name,
            'email' => $request->email,
            'rating' => $request->rating,
            'review' => $request->review,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'is_approved' => true // Auto-approve for testing
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rating submitted successfully!',
            'rating' => [
                'id' => $rating->id,
                'name' => $rating->name,
                'rating' => $rating->rating,
                'review' => $rating->review,
                'formatted_date' => $rating->formatted_date,
                'initials' => $rating->initials,
                'stars_html' => $rating->stars_html
            ]
        ], 201);
    }

    /**
     * Get ratings for a specific rateable item
     */
    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'rateable_type' => 'required|string',
            'rateable_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $ratings = Rating::where('rateable_type', $request->rateable_type)
            ->where('rateable_id', $request->rateable_id)
            ->approved()
            ->orderBy('created_at', 'desc')
            ->get();

        $ratingsData = $ratings->map(function($rating) {
            return [
                'id' => $rating->id,
                'name' => $rating->name,
                'rating' => $rating->rating,
                'review' => $rating->review,
                'formatted_date' => $rating->formatted_date,
                'initials' => $rating->initials,
                'stars_html' => $rating->stars_html
            ];
        });

        return response()->json([
            'success' => true,
            'ratings' => $ratingsData,
            'total' => $ratings->count()
        ]);
    }

    /**
     * Get rating statistics for a specific rateable item
     */
    public function stats(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'rateable_type' => 'required|string',
            'rateable_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $rateableType = $request->rateable_type;
        $rateableId = $request->rateable_id;

        if (!class_exists($rateableType)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid rateable type'
            ], 400);
        }

        $rateable = $rateableType::find($rateableId);
        if (!$rateable) {
            return response()->json([
                'success' => false,
                'message' => 'Rateable item not found'
            ], 404);
        }

        $ratings = $rateable->approvedRatings;
        $totalRatings = $ratings->count();
        $averageRating = $totalRatings > 0 ? round($ratings->avg('rating'), 1) : 0;

        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $distribution[$i] = $ratings->where('rating', $i)->count();
        }

        return response()->json([
            'success' => true,
            'stats' => [
                'total_ratings' => $totalRatings,
                'average_rating' => $averageRating,
                'distribution' => $distribution,
                'stars_html' => $rateable->stars_html
            ]
        ]);
    }

    /**
     * Update a rating (for admin use)
     */
    public function update(Request $request, Rating $rating): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'sometimes|integer|min:1|max:5',
            'review' => 'sometimes|string|max:1000',
            'is_approved' => 'sometimes|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $rating->update($request->only(['rating', 'review', 'is_approved']));

        return response()->json([
            'success' => true,
            'message' => 'Rating updated successfully',
            'rating' => $rating
        ]);
    }

    /**
     * Delete a rating (for admin use)
     */
    public function destroy(Rating $rating): JsonResponse
    {
        $rating->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rating deleted successfully'
        ]);
    }
}