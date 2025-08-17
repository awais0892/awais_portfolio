<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::query();

        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Sort options
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $blogs = $query->paginate(10);
        $categories = Blog::getCategories();
        $statuses = ['all', 'draft', 'published', 'archived'];

        return view('admin.blogs.index', compact('blogs', 'categories', 'statuses'));
    }

    public function create()
    {
        $categories = Blog::getCategories();
        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:draft,published,archived',
            'author' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'published_at' => 'nullable|date'
        ]);

        $data = $request->except(['featured_image', 'tags']);
        
        // Handle featured image
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('blogs', $filename, 'public');
            $data['featured_image'] = $path;
        }

        // Handle tags
        if ($request->filled('tags')) {
            $data['tags'] = array_filter(array_map('trim', explode(',', $request->tags)));
        }

        // Set published_at if status is published
        if ($request->status === 'published' && !$request->filled('published_at')) {
            $data['published_at'] = now();
        }

        Blog::create($data);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post created successfully!');
    }

    public function show(Blog $blog)
    {
        return view('admin.blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        $categories = Blog::getCategories();
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('blogs')->ignore($blog->id)],
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:draft,published,archived',
            'author' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'published_at' => 'nullable|date'
        ]);

        $data = $request->except(['featured_image', 'tags']);
        
        // Handle featured image
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
                Storage::disk('public')->delete($blog->featured_image);
            }

            $file = $request->file('featured_image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('blogs', $filename, 'public');
            $data['featured_image'] = $path;
        }

        // Handle tags
        if ($request->filled('tags')) {
            $data['tags'] = array_filter(array_map('trim', explode(',', $request->tags)));
        }

        // Set published_at if status is published
        if ($request->status === 'published' && !$request->filled('published_at')) {
            $data['published_at'] = now();
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post updated successfully!');
    }

    public function destroy(Blog $blog)
    {
        // Delete featured image if exists
        if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted successfully!');
    }

    public function updateStatus(Request $request, Blog $blog)
    {
        $request->validate([
            'status' => 'required|in:draft,published,archived'
        ]);
        
        $blog->update(['status' => $request->status]);
        
        // Set published_at if status is published
        if ($request->status === 'published' && !$blog->published_at) {
            $blog->update(['published_at' => now()]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Blog status updated successfully'
        ]);
    }

    public function toggleStatus(Blog $blog)
    {
        if ($blog->status === 'published') {
            $blog->unpublish();
            $message = 'Blog post unpublished successfully!';
        } else {
            $blog->publish();
            $message = 'Blog post published successfully!';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'new_status' => $blog->status
        ]);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,publish,unpublish,archive',
            'selected_blogs' => 'required|array|min:1',
            'selected_blogs.*' => 'exists:blogs,id'
        ]);

        $blogs = Blog::whereIn('id', $request->selected_blogs);

        switch ($request->action) {
            case 'delete':
                // Delete featured images
                $blogs->get()->each(function($blog) {
                    if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
                        Storage::disk('public')->delete($blog->featured_image);
                    }
                });
                $blogs->delete();
                $message = 'Selected blog posts deleted successfully!';
                break;

            case 'publish':
                $blogs->update([
                    'status' => 'published',
                    'published_at' => now()
                ]);
                $message = 'Selected blog posts published successfully!';
                break;

            case 'unpublish':
                $blogs->update([
                    'status' => 'draft',
                    'published_at' => null
                ]);
                $message = 'Selected blog posts unpublished successfully!';
                break;

            case 'archive':
                $blogs->update(['status' => 'archived']);
                $message = 'Selected blog posts archived successfully!';
                break;
        }

        return redirect()->route('admin.blogs.index')
            ->with('success', $message);
    }

    public function duplicate(Blog $blog)
    {
        $newBlog = $blog->replicate();
        $newBlog->title = $blog->title . ' (Copy)';
        $newBlog->slug = Str::slug($blog->title . '-copy-' . time());
        $newBlog->status = 'draft';
        $newBlog->published_at = null;
        $newBlog->views = 0;
        $newBlog->save();

        return redirect()->route('admin.blogs.edit', $newBlog)
            ->with('success', 'Blog post duplicated successfully!');
    }
}
