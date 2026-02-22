<?php
// database/seeders/SkillsSeeder.php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillsSeeder extends Seeder
{
    public function run()
    {
        $skills = [
            ['name' => 'MongoDB', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mongodb/mongodb-original.svg', 'category' => 'database', 'proficiency' => 85, 'order' => 1],
            ['name' => 'Express.js', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/express/express-original.svg', 'category' => 'backend', 'proficiency' => 80, 'order' => 2],
            ['name' => 'React.js', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg', 'category' => 'frontend', 'proficiency' => 85, 'order' => 3],
            ['name' => 'Node.js', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/nodejs/nodejs-original.svg', 'category' => 'backend', 'proficiency' => 85, 'order' => 4],
            ['name' => 'PHP', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg', 'category' => 'backend', 'proficiency' => 90, 'order' => 5],
            ['name' => 'Laravel', 'icon_url' => 'https://cdn.worldvectorlogo.com/logos/laravel-2.svg', 'category' => 'backend', 'proficiency' => 90, 'order' => 6],
            ['name' => 'MySQL', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg', 'category' => 'database', 'proficiency' => 85, 'order' => 7],
            ['name' => 'PostgreSQL', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/postgresql/postgresql-original.svg', 'category' => 'database', 'proficiency' => 80, 'order' => 8],
            ['name' => 'AWS', 'icon_url' => 'https://upload.wikimedia.org/wikipedia/commons/9/93/Amazon_Web_Services_Logo.svg', 'category' => 'tools', 'proficiency' => 75, 'order' => 9],
            ['name' => 'Git', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/git/git-original.svg', 'category' => 'tools', 'proficiency' => 85, 'order' => 10],
            ['name' => 'Tailwind CSS', 'icon_url' => 'https://www.vectorlogo.zone/logos/tailwindcss/tailwindcss-icon.svg', 'category' => 'frontend', 'proficiency' => 90, 'order' => 11],
            ['name' => 'Bootstrap', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/bootstrap/bootstrap-original.svg', 'category' => 'frontend', 'proficiency' => 85, 'order' => 12],
        ];

        foreach ($skills as $skillData) {
            Skill::updateOrCreate(
                ['name' => $skillData['name']],
                $skillData
            );
        }
    }
}