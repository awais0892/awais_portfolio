<?php
// app/Http/Controllers/Admin/ProjectController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    private const ALLOWED_SORT_FIELDS = ['id', 'title', 'featured', 'is_active', 'order', 'created_at'];
    private const ALLOWED_PER_PAGE = [10, 25, 50, 100];

    public function index(Request $request)
    {
        $filters = [
            'search' => trim((string) $request->query('search', '')),
            'status' => (string) $request->query('status', ''),
            'featured' => (string) $request->query('featured', ''),
            'per_page' => (int) $request->query('per_page', 10),
        ];

        if (!in_array($filters['per_page'], self::ALLOWED_PER_PAGE, true)) {
            $filters['per_page'] = 10;
        }

        $sort = [
            'field' => (string) $request->query('sort_field', 'order'),
            'direction' => (string) $request->query('sort_direction', 'asc'),
        ];

        if (!in_array($sort['field'], self::ALLOWED_SORT_FIELDS, true)) {
            $sort['field'] = 'order';
        }

        if (!in_array($sort['direction'], ['asc', 'desc'], true)) {
            $sort['direction'] = 'asc';
        }

        $query = Project::query()->select([
            'id',
            'title',
            'slug',
            'description',
            'image',
            'image_url',
            'fallback_image_url',
            'technologies',
            'featured',
            'order',
            'is_active',
            'created_at',
            'updated_at',
        ]);

        if ($filters['search'] !== '') {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('long_description', 'like', "%{$search}%");
            });
        }

        if (in_array($filters['status'], ['0', '1'], true)) {
            $query->where('is_active', $filters['status'] === '1');
        }

        if (in_array($filters['featured'], ['0', '1'], true)) {
            $query->where('featured', $filters['featured'] === '1');
        }

        $query->orderBy($sort['field'], $sort['direction']);

        if ($sort['field'] !== 'order') {
            $query->orderBy('order');
        }

        if ($sort['field'] !== 'updated_at') {
            $query->orderByDesc('updated_at');
        }

        if ($sort['field'] !== 'id') {
            $query->orderByDesc('id');
        }

        $projects = $query->paginate($filters['per_page'])->withQueryString();

        $summary = [
            'total' => Project::count(),
            'active' => Project::where('is_active', true)->count(),
            'featured' => Project::where('featured', true)->count(),
            'inactive' => Project::where('is_active', false)->count(),
        ];

        return view('admin.projects.index', compact('projects', 'filters', 'sort', 'summary'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        Project::create($this->validatedProjectData($request));

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
        $project->update($this->validatedProjectData($request, $project));

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully!');
    }

    public function destroy(Request $request, Project $project)
    {
        $this->deleteProjectImage($project);

        $project->delete();

        return $this->responseAfterAction(
            $request,
            'Project deleted successfully!',
            route('admin.projects.index')
        );
    }

    public function toggleStatus(Request $request, Project $project)
    {
        $project->update(['is_active' => !$project->is_active]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Project status updated successfully!',
                'is_active' => $project->is_active,
            ]);
        }

        return $this->responseAfterAction(
            $request,
            $project->is_active ? 'Project is now active.' : 'Project is now inactive.',
            route('admin.projects.index')
        );
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'project_ids' => 'required|array|min:1',
            'project_ids.*' => 'exists:projects,id',
        ]);

        $projects = Project::whereIn('id', $request->project_ids)->get();

        foreach ($projects as $project) {
            $this->deleteProjectImage($project);
        }

        $deletedCount = $projects->count();
        Project::whereIn('id', $projects->pluck('id'))->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "{$deletedCount} projects deleted successfully!",
            ]);
        }

        return $this->responseAfterAction(
            $request,
            "{$deletedCount} projects deleted successfully!",
            route('admin.projects.index')
        );
    }

    private function validatedProjectData(Request $request, ?Project $project = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'long_description' => ['nullable', 'string'],
            'technologies' => ['nullable', 'string'],
            'live_url' => ['nullable', 'url'],
            'github_url' => ['nullable', 'url'],
            'featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:2048'],
            'image_url' => ['nullable', 'url'],
            'fallback_image_url' => ['nullable', 'url'],
        ]);

        $data = [
            'title' => Str::squish($validated['title']),
            'description' => trim($validated['description']),
            'long_description' => $this->nullableTrim($validated['long_description'] ?? null),
            'technologies' => $this->parseTechnologies($validated['technologies'] ?? null),
            'live_url' => $this->nullableTrim($validated['live_url'] ?? null),
            'github_url' => $this->nullableTrim($validated['github_url'] ?? null),
            'image_url' => $this->nullableTrim($validated['image_url'] ?? null),
            'fallback_image_url' => $this->nullableTrim($validated['fallback_image_url'] ?? null),
            'featured' => $request->boolean('featured'),
            'is_active' => $request->boolean('is_active', true),
            'order' => $validated['order'] ?? 0,
        ];

        if ($request->hasFile('image')) {
            $this->deleteProjectImage($project);
            $data['image'] = $request->file('image')->store('projects', 'public');
        } elseif ($project && !empty($data['image_url'])) {
            $this->deleteProjectImage($project);
            $data['image'] = null;
        } elseif (!$project) {
            $data['image'] = null;
        }

        return $data;
    }

    private function parseTechnologies(?string $technologies): array
    {
        if (blank($technologies)) {
            return [];
        }

        return array_values(array_unique(array_filter(array_map(
            static fn ($item) => Str::of($item)->trim()->toString(),
            explode(',', $technologies)
        ))));
    }

    private function nullableTrim(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim($value);

        return $value === '' ? null : $value;
    }

    private function deleteProjectImage(?Project $project): void
    {
        if (!$project || empty($project->image) || filter_var($project->image, FILTER_VALIDATE_URL)) {
            return;
        }

        if (Storage::disk('public')->exists($project->image)) {
            Storage::disk('public')->delete($project->image);
        }
    }

    private function responseAfterAction(Request $request, string $message, string $fallbackUrl)
    {
        $redirectTo = (string) $request->input('redirect_to', '');

        if ($redirectTo !== '' && (Str::startsWith($redirectTo, url('/')) || Str::startsWith($redirectTo, '/'))) {
            return redirect($redirectTo)->with('success', $message);
        }

        return redirect($fallbackUrl)->with('success', $message);
    }
}
