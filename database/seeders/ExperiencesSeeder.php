<?php
// database/seeders/ExperiencesSeeder.php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Seeder;

class ExperiencesSeeder extends Seeder
{
    public function run()
    {
        $experiences = [
            [
                'title' => 'Software Engineer',
                'company' => 'Pixako Technologies',
                'location' => 'Islamabad',
                'start_date' => '2023-09-01',
                'end_date' => null,
                'is_current' => true,
                'description' => 'Working as a full-stack developer specializing in Laravel and MERN stack technologies. Contributing to various high-impact projects including government applications and e-commerce platforms.',
                'achievements' => [
                    'Developed a fully featured expense tracker application using the MERN stack, achieving a 40% increase in project efficiency through optimized data management and seamless API integration.',
                    'Designed and built a high-performance e-commerce platform in Laravel, reducing load times by 25% and enhancing backend functionality to support over 500 concurrent users effectively.',
                    'Contributed to FilerLink, a U.S. SEC-compliant government application for electronic form submission via EDGAR; implemented layouts and full CRUD operations for multiple SEC forms.',
                    'Developed functionalities such as PDF generation utilizing DomPDF and XML generation to ensure compliance with SEC filing standards.',
                    'Translated Figma designs into responsive layouts using HTML, CSS, and Bootstrap; enhanced mobile responsiveness by 50% while ensuring consistent WordPress design integration.',
                    'Collaborated with cross-functional teams to improve task delivery timelines and streamline workflows by 20%.'
                ],
                'technologies' => ['Laravel', 'MERN Stack', 'React.js', 'Node.js', 'WordPress', 'DomPDF', 'XML'],
                'order' => 1
            ]
        ];

        foreach ($experiences as $experienceData) {
            Experience::updateOrCreate(
                ['title' => $experienceData['title'], 'company' => $experienceData['company']],
                $experienceData
            );
        }
    }
}