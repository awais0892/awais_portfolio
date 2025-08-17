<?php
// app/Http/Controllers/Admin/ProjectController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('long_description', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        // Featured filter
        if ($request->filled('featured')) {
            $query->where('featured', $request->featured);
        }

        // Sorting
        $sortField = $request->get('sort_field', 'id');
        $sortDirection = $request->get('sort_direction', 'asc');
        
        // Validate sort field
        $allowedSortFields = ['id', 'title', 'featured', 'is_active', 'order', 'created_at'];
        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'id';
        }
        
        $query->orderBy($sortField, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 10);
        $allowedPerPage = [10, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $projects = $query->paginate($perPage);

        // Preserve search parameters in pagination links
        $projects->appends($request->except('page'));

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'long_description' => 'nullable|string',
            'technologies' => 'nullable|string',
            'live_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'featured' => 'boolean',
            'order' => 'integer|min:0',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url',
            'fallback_image_url' => 'nullable|url',
        ]);

        // Convert technologies from comma-separated string to array
        if ($request->filled('technologies')) {
            $validated['technologies'] = array_map('trim', explode(',', $request->technologies));
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'projects/' . $imageName;
            
            // Resize and save image
            $img = Image::make($image)->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            Storage::disk('public')->put($imagePath, $img->encode());
            $validated['image'] = $imagePath;
        }

        Project::create($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully!');
    }

    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'long_description' => 'nullable|string',
            'technologies' => 'nullable|string',
            'live_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'featured' => 'boolean',
            'order' => 'integer|min:0',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url',
            'fallback_image_url' => 'nullable|url',
        ]);

        // Convert technologies from comma-separated string to array
        if ($request->filled('technologies')) {
            $validated['technologies'] = array_map('trim', explode(',', $request->technologies));
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($project->image && Storage::disk('public')->exists($project->image)) {
                Storage::disk('public')->delete($project->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'projects/' . $imageName;
            
            $img = Image::make($image)->resize(800, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            Storage::disk('public')->put($imagePath, $img->encode());
            $validated['image'] = $imagePath;
        }

        $project->update($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully!');
    }

    public function destroy(Project $project)
    {
        // Delete image if exists
        if ($project->image && Storage::disk('public')->exists($project->image)) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully!');
    }

    public function toggleStatus(Project $project)
    {
        $project->update(['is_active' => !$project->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Project status updated successfully!',
            'status' => $project->is_active
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'project_ids' => 'required|array',
            'project_ids.*' => 'exists:projects,id'
        ]);

        $projectIds = $request->project_ids;
        $deletedCount = 0;

        foreach ($projectIds as $projectId) {
            $project = Project::find($projectId);
            if ($project) {
                // Delete image if exists
                if ($project->image && Storage::disk('public')->exists($project->image)) {
                    Storage::disk('public')->delete($project->image);
                }
                $project->delete();
                $deletedCount++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "{$deletedCount} projects deleted successfully!"
        ]);
    }
}
