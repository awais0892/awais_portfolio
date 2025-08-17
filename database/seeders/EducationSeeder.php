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
                'location' => 'Abbottabad Campus',
                'start_date' => '2019-01-01',
                'end_date' => '2023-06-30',
                'grade' => '3.2 CGPA',
                'description' => 'Comprehensive computer science program covering software engineering, algorithms, data structures, database systems, and web development.',
                'type' => 'degree',
                'order' => 1
            ],
            [
                'degree' => 'MERN STACK Training',
                'institution' => 'Knowledge Stream',
                'location' => 'Islamabad',
                'start_date' => '2024-01-01',
                'end_date' => '2024-04-30',
                'description' => 'Intensive training program focusing on MongoDB, Express.js, React.js, and Node.js development.',
                'achievements' => [
                    'Front-End' => [
                        'Developed a React-based front-end with various functional components.',
                        'Implemented Formik and Yup for form creation and validation.',
                        'Utilized React Router, props, useState, and useEffect hooks.'
                    ],
                    'Back-End' => [
                        'Built a Node.js and Express.js backend connected to a PostgreSQL database.',
                        'Implemented REST APIs, Sequelize ORM, and different relationships.',
                        'Implemented authentication with JWT token for enhanced security.'
                    ]
                ],
                'type' => 'training',
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