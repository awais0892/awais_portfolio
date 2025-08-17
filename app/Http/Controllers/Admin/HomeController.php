<?php
// app/Http/Controllers/Admin/HomeController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Project;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Education;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'projects' => Project::active()->featured()->ordered()->limit(6)->get(),
            'skills' => Skill::active()->ordered()->get(),
            'experiences' => Experience::active()->ordered()->get(),
            'education' => Education::active()->ordered()->get(),
            'settings' => $this->getSiteSettings(),
        ];

        return view('home', $data);
    }

    public function projects()
    {
        $projects = Project::active()->ordered()->paginate(12);
        return view('projects', compact('projects'));
    }

    public function project($slug)
    {
        $project = Project::active()->where('slug', $slug)->firstOrFail();
        $relatedProjects = Project::active()
            ->where('id', '!=', $project->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('project-detail', compact('project', 'relatedProjects'));
    }

    private function getSiteSettings()
    {
        return [
            'site_title' => SiteSetting::get('site_title', 'Awais Ahmad - Full-Stack Developer'),
            'site_description' => SiteSetting::get('site_description', 'Portfolio of Awais Ahmad'),
            'hero_title' => SiteSetting::get('hero_title', 'I Build Things for the Web.'),
            'hero_subtitle' => SiteSetting::get('hero_subtitle', 'Detail-oriented software engineer...'),
            'about_text' => SiteSetting::get('about_text', 'I\'m a passionate software engineer...'),
            'profile_image' => SiteSetting::get('profile_image', 'awais.jpg'),
            'cv_file' => SiteSetting::get('cv_file', 'cv.pdf'),
            'linkedin_url' => SiteSetting::get('linkedin_url', 'https://www.linkedin.com/in/awais-ahmad-dev/'),
            'github_url' => SiteSetting::get('github_url', 'https://github.com/awais-ahmad-x'),
            'email' => SiteSetting::get('email', 'awais.32525@gmail.com'),
        ];
    }
}