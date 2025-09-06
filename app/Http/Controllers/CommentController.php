<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\RateLimiter;

class CommentController extends Controller
{
    /**
     * Store a newly created comment
     */
    public function store(Request $request): JsonResponse
    {
        // Rate limiting
        $key = 'comment:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'success' => false,
                'message' => "Too many attempts. Please try again in {$seconds} seconds."
            ], 429);
        }

        RateLimiter::hit($key, 300); // 5 minutes

        // Debug: Log request data
        \Log::info('Comment request data:', $request->all());
        \Log::info('Comment content length:', ['length' => strlen($request->content ?? '')]);
        \Log::info('Comment content value:', ['content' => $request->content]);

        $validator = Validator::make($request->all(), [
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'content' => 'required|string|min:3|max:2000',
            'parent_id' => 'nullable|integer|exists:comments,id'
        ]);

        if ($validator->fails()) {
            \Log::info('Comment validation failed:', $validator->errors()->toArray());
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Verify the commentable model exists
        $commentableType = $request->commentable_type;
        $commentableId = $request->commentable_id;

        if (!class_exists($commentableType)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid commentable type'
            ], 400);
        }

        $commentable = $commentableType::find($commentableId);
        if (!$commentable) {
            return response()->json([
                'success' => false,
                'message' => 'Commentable item not found'
            ], 404);
        }

        // Check if parent comment exists and belongs to same commentable
        if ($request->parent_id) {
            $parentComment = Comment::where('id', $request->parent_id)
                ->where('commentable_type', $commentableType)
                ->where('commentable_id', $commentableId)
                ->first();

            if (!$parentComment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parent comment not found'
                ], 404);
            }
        }

        $comment = Comment::create([
            'commentable_type' => $commentableType,
            'commentable_id' => $commentableId,
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->content,
            'parent_id' => $request->parent_id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'is_approved' => true // Auto-approve for testing
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comment submitted successfully!',
            'comment' => [
                'id' => $comment->id,
                'name' => $comment->name,
                'content' => $comment->content,
                'formatted_date' => $comment->formatted_date,
                'initials' => $comment->initials,
                'parent_id' => $comment->parent_id
            ]
        ], 201);
    }

    /**
     * Get comments for a specific commentable item
     */
    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $comments = Comment::where('commentable_type', $request->commentable_type)
            ->where('commentable_id', $request->commentable_id)
            ->approved()
            ->topLevel()
            ->with(['replies' => function($query) {
                $query->approved()->orderBy('created_at', 'asc');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        $commentsData = $comments->map(function($comment) {
            return [
                'id' => $comment->id,
                'name' => $comment->name,
                'content' => $comment->content,
                'formatted_date' => $comment->formatted_date,
                'initials' => $comment->initials,
                'parent_id' => $comment->parent_id,
                'replies' => $comment->replies->map(function($reply) {
                    return [
                        'id' => $reply->id,
                        'name' => $reply->name,
                        'content' => $reply->content,
                        'formatted_date' => $reply->formatted_date,
                        'initials' => $reply->initials,
                        'parent_id' => $reply->parent_id
                    ];
                })
            ];
        });

        return response()->json([
            'success' => true,
            'comments' => $commentsData,
            'total' => $comments->count()
        ]);
    }

    /**
     * Get comment count for a specific commentable item
     */
    public function count(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $count = Comment::where('commentable_type', $request->commentable_type)
            ->where('commentable_id', $request->commentable_id)
            ->approved()
            ->count();

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }

    /**
     * Update a comment (for admin use)
     */
    public function update(Request $request, Comment $comment): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'content' => 'sometimes|string|min:10|max:2000',
            'is_approved' => 'sometimes|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $comment->update($request->only(['content', 'is_approved']));

        return response()->json([
            'success' => true,
            'message' => 'Comment updated successfully',
            'comment' => $comment
        ]);
    }

    /**
     * Delete a comment (for admin use)
     */
    public function destroy(Comment $comment): JsonResponse
    {
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully'
        ]);
    }
}