<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::published();

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Filter by tag
        if ($request->filled('tag')) {
            $query->whereJsonContains('tags', $request->tag);
        }

        $blogs = $query->orderBy('published_at', 'desc')->paginate(9);
        $categories = Blog::getCategories();
        $popularPosts = Blog::getPopularPosts(5);
        $recentPosts = Blog::getRecentPosts(5);

        return view('blogs.index', compact('blogs', 'categories', 'popularPosts', 'recentPosts'));
    }

    public function show($slug)
    {
        $blog = Blog::published()->where('slug', $slug)->firstOrFail();
        
        // Increment view count
        $blog->incrementViews();
        
        // Get related posts
        $relatedPosts = $blog->getRelatedPosts(3);
        $nextPost = $blog->getNextPost();
        $prevPost = $blog->getPreviousPost();
        
        // Get popular and recent posts for sidebar
        $popularPosts = Blog::getPopularPosts(5);
        $recentPosts = Blog::getRecentPosts(5);
        $categories = Blog::getCategories();

        return view('blogs.show', compact('blog', 'relatedPosts', 'nextPost', 'prevPost', 'popularPosts', 'recentPosts', 'categories'));
    }

    public function category($category)
    {
        $blogs = Blog::published()
            ->byCategory($category)
            ->orderBy('published_at', 'desc')
            ->paginate(9);
            
        $categories = Blog::getCategories();
        $popularPosts = Blog::getPopularPosts(5);
        $recentPosts = Blog::getRecentPosts(5);

        return view('blogs.category', compact('blogs', 'category', 'categories', 'popularPosts', 'recentPosts'));
    }

    public function tag($tag)
    {
        $blogs = Blog::published()
            ->whereJsonContains('tags', $tag)
            ->orderBy('published_at', 'desc')
            ->paginate(9);
            
        $categories = Blog::getCategories();
        $popularPosts = Blog::getPopularPosts(5);
        $recentPosts = Blog::getRecentPosts(5);

        return view('blogs.tag', compact('blogs', 'tag', 'categories', 'popularPosts', 'recentPosts'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required|string|min:2'
        ]);

        $blogs = Blog::published()
            ->search($request->search)
            ->orderBy('published_at', 'desc')
            ->paginate(9);
            
        $categories = Blog::getCategories();
        $popularPosts = Blog::getPopularPosts(5);
        $recentPosts = Blog::getRecentPosts(5);

        return view('blogs.search', compact('blogs', 'categories', 'popularPosts', 'recentPosts'));
    }

    public function rss()
    {
        $blogs = Blog::published()
            ->orderBy('published_at', 'desc')
            ->limit(20)
            ->get();

        return response()->view('blogs.rss', compact('blogs'))
            ->header('Content-Type', 'application/xml');
    }

    public function sitemap()
    {
        $blogs = Blog::published()
            ->orderBy('published_at', 'desc')
            ->get();

        return response()->view('blogs.sitemap', compact('blogs'))
            ->header('Content-Type', 'application/xml');
    }
}
