<?php
// database/seeders/ProjectsSeeder.php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    public function run()
    {
        $projects = [
            [
                'title' => 'Digital Student Diary',
                'description' => 'Final Year Project - A comprehensive app improving teacher-parent-admin communication for better student management with Firebase integration.',
                'long_description' => 'The Digital Student Diary is my final year project that revolutionizes communication between teachers, parents, and administrators. Built with Android Java and Firebase, this comprehensive application provides real-time updates on student progress, attendance tracking, assignment management, and behavioral reports. The app features role-based access control, push notifications, and offline synchronization capabilities. It significantly improved parent-teacher communication efficiency by 75% during testing phase.',
                'technologies' => ['Android Java', 'Firebase', 'SQLite', 'Material Design'],
                'featured' => true,
                'order' => 1,
                'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&h=600&fit=crop&crop=center'
            ],
            [
                'title' => 'Gmail Clone',
                'description' => 'A comprehensive email service platform with seamless communication features, built with advanced encryption for data privacy and security.',
                'long_description' => 'A full-featured Gmail clone built with the MERN stack, featuring real-time email functionality, advanced search capabilities, and secure encryption. The application includes compose, reply, forward functionality, folder management, spam filtering, and attachment handling. Implemented with Socket.IO for real-time notifications and JWT for secure authentication.',
                'technologies' => ['MongoDB', 'Express.js', 'React.js', 'Node.js', 'Socket.IO', 'JWT'],
                'github_url' => 'https://github.com/awais-ahmad-x/gmail-clone',
                'featured' => true,
                'order' => 2,
                'image' => 'https://images.unsplash.com/photo-1551650975-87deedd944c3?w=800&h=600&fit=crop&crop=center'
            ],
            [
                'title' => 'Gold\'s Gym App',
                'description' => 'Comprehensive fitness application with 120+ animated exercises and integrated YouTube tutorials. Deployed on Netlify for scalable access.',
                'long_description' => 'A feature-rich fitness application built with React.js and integrated with RapidAPI for exercise data. The app provides over 120 animated exercise demonstrations, personalized workout plans, progress tracking, and YouTube tutorial integration. Features include exercise filtering by body parts, equipment-based searches, and detailed exercise instructions with proper form guidance.',
                'technologies' => ['React.js', 'Rapid API', 'Material-UI', 'Netlify'],
                'live_url' => 'https://golds-gym-awais.netlify.app',
                'github_url' => 'https://github.com/awais-ahmad-x/fitness-app',
                'featured' => true,
                'order' => 3,
                'image' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&h=600&fit=crop&crop=center'
            ],
            [
                'title' => 'E-commerce Platform',
                'description' => 'High-performance e-commerce solution built with Laravel, featuring advanced product management, order processing, and payment integration.',
                'long_description' => 'A robust e-commerce platform developed with Laravel, supporting over 500 concurrent users. Features include advanced product catalog, inventory management, shopping cart functionality, multiple payment gateways, order tracking, and comprehensive admin dashboard. Implemented caching strategies that improved page load times by 40%.',
                'technologies' => ['Laravel', 'MySQL', 'Redis', 'Stripe API', 'Bootstrap'],
                'featured' => false,
                'order' => 4,
                'image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&h=600&fit=crop&crop=center'
            ],
            [
                'title' => 'Expense Tracker',
                'description' => 'Full-featured expense tracking application with data visualization, budget planning, and multi-currency support.',
                'long_description' => 'A comprehensive expense tracking application built with the MERN stack. Features include transaction categorization, budget setting and monitoring, data visualization with charts, multi-currency support, and export functionality. The application helped users reduce unnecessary expenses by an average of 30% through detailed spending analytics.',
                'technologies' => ['MongoDB', 'Express.js', 'React.js', 'Node.js', 'Chart.js'],
                'featured' => false,
                'order' => 5,
                'image' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=800&h=600&fit=crop&crop=center'
            ],
            [
                'title' => 'Task Management System',
                'description' => 'Collaborative task management platform with real-time updates, team collaboration features, and progress tracking.',
                'long_description' => 'A collaborative task management system built with Laravel and Vue.js. Features include project creation, task assignment, deadline tracking, team collaboration, file attachments, and real-time notifications. The system improved team productivity by 45% through better task organization and communication.',
                'technologies' => ['Laravel', 'Vue.js', 'MySQL', 'Pusher', 'Bootstrap'],
                'featured' => false,
                'order' => 6,
                'image' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800&h=600&fit=crop&crop=center'
            ]
        ];

        foreach ($projects as $projectData) {
            Project::updateOrCreate(
                ['title' => $projectData['title']],
                $projectData
            );
        }
    }
}