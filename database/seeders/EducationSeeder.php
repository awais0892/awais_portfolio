<?php
// database/seeders/EducationSeeder.php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    public function run()
    {
        $education = [
            [
                'degree' => 'BS Computer Science',
                'institution' => 'COMSATS University Islamabad',
                'location' => 'Islamabad Campus',
                'start_date' => '2019-01-01',
                'end_date' => '2023-12-31',
                'description' => 'Comprehensive computer science program covering software engineering, algorithms, data structures, database systems, and web development.',
                'type' => 'degree',
                'order' => 1
            ],
            [
                'degree' => 'MSc Artificial Intelligence',
                'institution' => 'University of Dundee',
                'location' => 'United Kingdom',
                'start_date' => '2024-01-01',
                'end_date' => '2025-12-31',
                'description' => 'Advanced Master\'s program focusing on machine learning, neutral networks, natural language processing, and ethical AI systems.',
                'type' => 'degree',
                'order' => 2
            ]
        ];

        foreach ($education as $eduData) {
            Education::updateOrCreate(
                ['degree' => $eduData['degree'], 'institution' => $eduData['institution']],
                $eduData
            );
        }
    }
}