<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index(Request $request)
    {
        $query = Experience::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('current')) {
            $query->where('is_current', $request->current === '1');
        }

        $sortBy = $request->get('sort_by', 'order');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder)->orderBy('start_date', 'desc');

        $experiences = $query->paginate(15);

        return view('admin.experiences.index', compact('experiences'));
    }

    public function create()
    {
        return view('admin.experiences.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
            'achievements' => 'nullable|string',
            'technologies' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'company_logo' => 'nullable|url',
        ]);

        $data = $request->only([
            'title',
            'company',
            'location',
            'start_date',
            'end_date',
            'description',
            'order'
        ]);
        $data['is_current'] = $request->boolean('is_current');
        $data['is_active'] = $request->boolean('is_active', true);

        if ($data['is_current']) {
            $data['end_date'] = null;
        }

        // Parse achievements from textarea (one per line)
        if ($request->filled('achievements')) {
            $data['achievements'] = array_filter(
                array_map('trim', explode("\n", $request->achievements))
            );
        }

        // Parse technologies from comma-separated input
        if ($request->filled('technologies')) {
            $data['technologies'] = array_filter(
                array_map('trim', explode(',', $request->technologies))
            );
        }

        if ($request->filled('company_logo')) {
            $data['company_logo'] = $request->company_logo;
        }

        Experience::create($data);

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Experience created successfully!');
    }

    public function show(Experience $experience)
    {
        return view('admin.experiences.show', compact('experience'));
    }

    public function edit(Experience $experience)
    {
        return view('admin.experiences.edit', compact('experience'));
    }

    public function update(Request $request, Experience $experience)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'is_current' => 'boolean',
            'description' => 'nullable|string',
            'achievements' => 'nullable|string',
            'technologies' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'company_logo' => 'nullable|url',
        ]);

        $data = $request->only([
            'title',
            'company',
            'location',
            'start_date',
            'end_date',
            'description',
            'order'
        ]);
        $data['is_current'] = $request->boolean('is_current');
        $data['is_active'] = $request->boolean('is_active', true);

        if ($data['is_current']) {
            $data['end_date'] = null;
        }

        if ($request->filled('achievements')) {
            $data['achievements'] = array_filter(
                array_map('trim', explode("\n", $request->achievements))
            );
        } else {
            $data['achievements'] = [];
        }

        if ($request->filled('technologies')) {
            $data['technologies'] = array_filter(
                array_map('trim', explode(',', $request->technologies))
            );
        } else {
            $data['technologies'] = [];
        }

        if ($request->filled('company_logo')) {
            $data['company_logo'] = $request->company_logo;
        } elseif ($request->has('clear_logo')) {
            $data['company_logo'] = null;
        }

        $experience->update($data);

        return redirect()->route('admin.experiences.index')
            ->with('success', 'Experience updated successfully!');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();
        return redirect()->route('admin.experiences.index')
            ->with('success', 'Experience deleted successfully!');
    }

    public function toggleStatus(Experience $experience)
    {
        $experience->update(['is_active' => !$experience->is_active]);
        return response()->json([
            'success' => true,
            'message' => 'Experience status updated!',
            'is_active' => $experience->is_active,
        ]);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate',
            'selected_experiences' => 'required|array|min:1',
            'selected_experiences.*' => 'exists:experiences,id',
        ]);

        $query = Experience::whereIn('id', $request->selected_experiences);

        switch ($request->action) {
            case 'delete':
                $query->delete();
                $message = 'Selected experiences deleted successfully!';
                break;
            case 'activate':
                $query->update(['is_active' => true]);
                $message = 'Selected experiences activated successfully!';
                break;
            case 'deactivate':
                $query->update(['is_active' => false]);
                $message = 'Selected experiences deactivated successfully!';
                break;
        }

        return redirect()->route('admin.experiences.index')->with('success', $message);
    }
}
