<?php
// app/Http/Controllers/Admin/SettingsController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function create()
    {
        return view('admin.settings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255|unique:site_settings,key',
            'value' => 'required|string',
            'type' => 'required|string|in:text,textarea,image,json,boolean,number',
            'group' => 'required|string|max:255',
            'label' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'key' => $request->key,
            'type' => $request->type,
            'group' => $request->group,
            'label' => $request->label,
            'description' => $request->description,
        ];

        // Handle different types
        if ($request->type === 'image' && $request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('settings', $filename, 'public');
            $data['value'] = $path;
        } elseif ($request->type === 'json') {
            $data['value'] = json_encode($request->value);
        } elseif ($request->type === 'boolean') {
            $data['value'] = $request->boolean('value') ? 1 : 0;
        } else {
            $data['value'] = $request->value;
        }

        SiteSetting::create($data);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting created successfully!');
    }

    public function show(SiteSetting $setting)
    {
        return view('admin.settings.show', compact('setting'));
    }

    public function edit(SiteSetting $setting)
    {
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request, SiteSetting $setting)
    {
        $request->validate([
            'key' => ['required', 'string', 'max:255', Rule::unique('site_settings')->ignore($setting->id)],
            'value' => 'required|string',
            'type' => 'required|string|in:text,textarea,image,json,boolean,number',
            'group' => 'required|string|max:255',
            'label' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'key' => $request->key,
            'type' => $request->type,
            'group' => $request->group,
            'label' => $request->label,
            'description' => $request->description,
        ];

        // Handle different types
        if ($request->type === 'image' && $request->hasFile('image')) {
            // Delete old file if exists
            if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                Storage::disk('public')->delete($setting->value);
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('settings', $filename, 'public');
            $data['value'] = $path;
        } elseif ($request->type === 'json') {
            $data['value'] = json_encode($request->value);
        } elseif ($request->type === 'boolean') {
            $data['value'] = $request->boolean('value') ? 1 : 0;
        } else {
            $data['value'] = $request->value;
        }

        $setting->update($data);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting updated successfully!');
    }

    public function destroy(SiteSetting $setting)
    {
        // Delete associated image if exists
        if ($setting->type === 'image' && $setting->value && Storage::disk('public')->exists($setting->value)) {
            Storage::disk('public')->delete($setting->value);
        }

        $setting->delete();

        return redirect()->route('admin.settings.index')
            ->with('success', 'Setting deleted successfully!');
    }

    public function bulkUpdate(Request $request)
    {
        foreach ($request->except('_token', '_method') as $key => $value) {
            $setting = SiteSetting::where('key', $key)->first();
            
            if ($setting) {
                if ($setting->type === 'image' && $request->hasFile($key)) {
                    // Delete old file if exists
                    if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                        Storage::disk('public')->delete($setting->value);
                    }

                    // Store new file
                    $file = $request->file($key);
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('settings', $filename, 'public');
                    $value = $path;
                } elseif ($setting->type === 'image' && !$request->hasFile($key)) {
                    // Skip if no new file uploaded for image type
                    continue;
                }

                $setting->update(['value' => $value]);
            }
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully!');
    }

    public function toggleStatus(SiteSetting $setting)
    {
        if ($setting->type === 'boolean') {
            $setting->update(['value' => !$setting->value]);
            return response()->json([
                'success' => true,
                'message' => 'Setting status toggled successfully!',
                'new_value' => $setting->value
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'This setting type does not support toggling.'
        ]);
    }
}