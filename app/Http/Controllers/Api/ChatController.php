<?php
// app/Http/Controllers/Api/ChatController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Experience;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function respond(Request $request)
    {
        $message = strtolower($request->input('message', ''));
        
        $response = $this->generateResponse($message);
        
        return response()->json([
            'response' => $response
        ]);
    }

    private function generateResponse($message)
    {
        if (strpos($message, 'projects') !== false || strpos($message, 'portfolio') !== false) {
            $projectCount = Project::active()->count();
            return "I have {$projectCount} projects in my portfolio, including web applications, APIs, and mobile apps. Check out the Projects section to see them all!";
        }

        if (strpos($message, 'skills') !== false || strpos($message, 'tech') !== false) {
            $skills = Skill::active()->limit(5)->pluck('name')->toArray();
            return "My main skills include: " . implode(', ', $skills) . " and many more. See the Skills section for the complete list!";
        }

        if (strpos($message, 'contact') !== false || strpos($message, 'hire') !== false) {
            return "You can contact me using the form at the bottom of the page, or email me directly at awais.32525@gmail.com. I'm always open to new opportunities!";
        }

        if (strpos($message, 'experience') !== false || strpos($message, 'work') !== false) {
            $experience = Experience::active()->first();
            if ($experience) {
                return "I currently work as a {$experience->title} at {$experience->company}. I have experience in full-stack development, focusing on Laravel and MERN stack technologies.";
            }
        }

        if (strpos($message, 'hello') !== false || strpos($message, 'hi') !== false) {
            return "Hello! 👋 I'm Awais's AI assistant. I can help you learn about his projects, skills, experience, or contact information. What would you like to know?";
        }

        return "I'm here to help! Ask me about Awais's projects, skills, work experience, or how to get in touch with him.";
    }
}