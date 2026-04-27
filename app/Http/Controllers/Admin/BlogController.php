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
        $filters = [
            'search' => trim((string) $request->query('search', '')),
            'status' => (string) $request->query('status', ''),
            'category' => (string) $request->query('category', ''),
            'per_page' => (int) $request->query('per_page', 10),
        ];

        $allowedPerPage = [10, 25, 50, 100];
        if (!in_array($filters['per_page'], $allowedPerPage, true)) {
            $filters['per_page'] = 10;
        }

        $sort = [
            'field' => (string) $request->query('sort_field', 'created_at'),
            'direction' => (string) $request->query('sort_direction', 'desc'),
        ];

        $allowedSortFields = ['id', 'title', 'status', 'category', 'views', 'published_at', 'created_at'];
        if (!in_array($sort['field'], $allowedSortFields, true)) {
            $sort['field'] = 'created_at';
        }

        if (!in_array($sort['direction'], ['asc', 'desc'], true)) {
            $sort['direction'] = 'desc';
        }

        $query = Blog::query()->select([
            'id',
            'title',
            'slug',
            'excerpt',
            'featured_image',
            'status',
            'author',
            'category',
            'tags',
            'views',
            'published_at',
            'created_at',
            'updated_at'
        ]);

        if ($filters['search'] !== '') {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        if (in_array($filters['status'], ['draft', 'published', 'archived'], true)) {
            $query->where('status', $filters['status']);
        }

        if ($filters['category'] !== '') {
            $query->where('category', $filters['category']);
        }

        $query->orderBy($sort['field'], $sort['direction']);

        if ($sort['field'] !== 'updated_at') {
            $query->orderByDesc('updated_at');
        }

        if ($sort['field'] !== 'id') {
            $query->orderByDesc('id');
        }

        $blogs = $query->paginate($filters['per_page'])->withQueryString();

        $summary = [
            'total' => Blog::count(),
            'published' => Blog::where('status', 'published')->count(),
            'draft' => Blog::where('status', 'draft')->count(),
            'archived' => Blog::where('status', 'archived')->count(),
        ];

        $categories = Blog::getCategories();

        return view('admin.blogs.index', compact('blogs', 'filters', 'sort', 'summary', 'categories'));
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
            'featured_image_url' => 'nullable|url',
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
        
        // Handle featured image URL from Cloudinary
        if ($request->filled('featured_image_url')) {
            $data['featured_image'] = $request->featured_image_url;
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
            'featured_image_url' => 'nullable|url',
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
        
        // Handle featured image URL from Cloudinary
        if ($request->filled('featured_image_url')) {
            $data['featured_image'] = $request->featured_image_url;
        } elseif ($request->has('featured_image_url') && empty($request->featured_image_url)) {
            // If the field is present but empty, remove the image
            $data['featured_image'] = null;
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
        // Note: We don't delete Cloudinary images automatically
        // as they might be used by other blog posts or content
        // Images can be managed through the Cloudinary dashboard
        
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
