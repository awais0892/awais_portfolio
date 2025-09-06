<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommentManagementController extends Controller
{
    /**
     * Display comments management page
     */
    public function index()
    {
        $comments = Comment::with(['commentable'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        $ratings = Rating::with(['rateable'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.comments.index', compact('comments', 'ratings'));
    }

    /**
     * Approve a comment
     */
    public function approveComment(Comment $comment): JsonResponse
    {
        $comment->update(['is_approved' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Comment approved successfully'
        ]);
    }

    /**
     * Reject a comment
     */
    public function rejectComment(Comment $comment): JsonResponse
    {
        $comment->update(['is_approved' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Comment rejected successfully'
        ]);
    }

    /**
     * Delete a comment
     */
    public function deleteComment(Comment $comment): JsonResponse
    {
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully'
        ]);
    }

    /**
     * Approve a rating
     */
    public function approveRating(Rating $rating): JsonResponse
    {
        $rating->update(['is_approved' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Rating approved successfully'
        ]);
    }

    /**
     * Reject a rating
     */
    public function rejectRating(Rating $rating): JsonResponse
    {
        $rating->update(['is_approved' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Rating rejected successfully'
        ]);
    }

    /**
     * Delete a rating
     */
    public function deleteRating(Rating $rating): JsonResponse
    {
        $rating->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rating deleted successfully'
        ]);
    }

    /**
     * Get comment statistics
     */
    public function stats(): JsonResponse
    {
        $stats = [
            'total_comments' => Comment::count(),
            'approved_comments' => Comment::approved()->count(),
            'pending_comments' => Comment::pending()->count(),
            'total_ratings' => Rating::count(),
            'approved_ratings' => Rating::approved()->count(),
            'pending_ratings' => Rating::pending()->count(),
            'average_rating' => Rating::approved()->avg('rating') ?? 0,
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }
}