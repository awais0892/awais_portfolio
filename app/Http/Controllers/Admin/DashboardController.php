<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Contact;
use App\Models\Blog;
use App\Models\Education;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'projects' => Project::count(),
            'skills' => Skill::count(),
            'experiences' => Experience::count(),
            'education' => Education::count(),
            'unread_contacts' => Contact::unread()->count(),
            'total_contacts' => Contact::count(),
            'blogs' => Blog::count(),
            'published_blogs' => Blog::published()->count(),
        ];

        $recent_contacts = Contact::latest()->limit(5)->get();
        $recent_projects = Project::latest()->limit(5)->get();
        $recent_blogs = Blog::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_contacts', 'recent_projects', 'recent_blogs'));
    }
}