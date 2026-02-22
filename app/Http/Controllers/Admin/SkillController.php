<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class SkillController extends Controller
{
    public function index(Request $request)
    {
        $query = Skill::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $sortBy = $request->get('sort_by', 'order');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $skills = $query->paginate(15);
        $categories = ['Frontend', 'Backend', 'Tools', 'Database', 'DevOps', 'Other'];

        return view('admin.skills.index', compact('skills', 'categories'));
    }

    public function create()
    {
        $categories = ['Frontend', 'Backend', 'Tools', 'Database', 'DevOps', 'Other'];
        return view('admin.skills.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'proficiency' => 'nullable|integer|min:1|max:100',
            'order' => 'nullable|integer|min:0',
            'icon_url' => 'nullable|url',
        ]);

        $data = $request->only(['name', 'category', 'proficiency', 'order']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->filled('icon_url')) {
            $data['icon_url'] = $request->icon_url;
        }

        Skill::create($data);

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill created successfully!');
    }

    public function show(Skill $skill)
    {
        return view('admin.skills.show', compact('skill'));
    }

    public function edit(Skill $skill)
    {
        $categories = ['Frontend', 'Backend', 'Tools', 'Database', 'DevOps', 'Other'];
        return view('admin.skills.edit', compact('skill', 'categories'));
    }

    public function update(Request $request, Skill $skill)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'proficiency' => 'nullable|integer|min:1|max:100',
            'order' => 'nullable|integer|min:0',
            'icon_url' => 'nullable|url',
        ]);

        $data = $request->only(['name', 'category', 'proficiency', 'order']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->filled('icon_url')) {
            $data['icon_url'] = $request->icon_url;
        } elseif ($request->has('clear_icon')) {
            $data['icon_url'] = null;
        }

        $skill->update($data);

        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill updated successfully!');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return redirect()->route('admin.skills.index')
            ->with('success', 'Skill deleted successfully!');
    }

    public function toggleStatus(Skill $skill)
    {
        $skill->update(['is_active' => !$skill->is_active]);
        return response()->json([
            'success' => true,
            'message' => 'Skill status updated successfully!',
            'is_active' => $skill->is_active,
        ]);
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate',
            'selected_skills' => 'required|array|min:1',
            'selected_skills.*' => 'exists:skills,id',
        ]);

        $skills = Skill::whereIn('id', $request->selected_skills);

        switch ($request->action) {
            case 'delete':
                $skills->delete();
                $message = 'Selected skills deleted successfully!';
                break;
            case 'activate':
                $skills->update(['is_active' => true]);
                $message = 'Selected skills activated successfully!';
                break;
            case 'deactivate':
                $skills->update(['is_active' => false]);
                $message = 'Selected skills deactivated successfully!';
                break;
        }

        return redirect()->route('admin.skills.index')->with('success', $message);
    }
}
