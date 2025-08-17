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
            ['name' => 'HTML5', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg', 'category' => 'frontend', 'proficiency' => 95, 'order' => 1],
            ['name' => 'CSS3', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg', 'category' => 'frontend', 'proficiency' => 90, 'order' => 2],
            ['name' => 'JavaScript', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg', 'category' => 'frontend', 'proficiency' => 85, 'order' => 3],
            ['name' => 'PHP', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg', 'category' => 'backend', 'proficiency' => 88, 'order' => 4],
            ['name' => 'Laravel', 'icon_url' => 'https://cdn.worldvectorlogo.com/logos/laravel-2.svg', 'category' => 'backend', 'proficiency' => 85, 'order' => 5],
            ['name' => 'React.js', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg', 'category' => 'frontend', 'proficiency' => 80, 'order' => 6],
            ['name' => 'Node.js', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/nodejs/nodejs-original.svg', 'category' => 'backend', 'proficiency' => 82, 'order' => 7],
            ['name' => 'Express.js', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/express/express-original.svg', 'category' => 'backend', 'proficiency' => 78, 'order' => 8],
            ['name' => 'MongoDB', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mongodb/mongodb-original.svg', 'category' => 'database', 'proficiency' => 75, 'order' => 9],
            ['name' => 'MySQL', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg', 'category' => 'database', 'proficiency' => 85, 'order' => 10],
            ['name' => 'PostgreSQL', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/postgresql/postgresql-original.svg', 'category' => 'database', 'proficiency' => 70, 'order' => 11],
            ['name' => 'Tailwind CSS', 'icon_url' => 'https://www.vectorlogo.zone/logos/tailwindcss/tailwindcss-icon.svg', 'category' => 'frontend', 'proficiency' => 90, 'order' => 12],
            ['name' => 'Bootstrap', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/bootstrap/bootstrap-original.svg', 'category' => 'frontend', 'proficiency' => 85, 'order' => 13],
            ['name' => 'Git & GitHub', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/git/git-original.svg', 'category' => 'tools', 'proficiency' => 80, 'order' => 14],
            ['name' => 'WordPress', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/wordpress/wordpress-original.svg', 'category' => 'cms', 'proficiency' => 75, 'order' => 15],
            ['name' => 'Firebase', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/firebase/firebase-plain.svg', 'category' => 'backend', 'proficiency' => 70, 'order' => 16],
        ];

        foreach ($skills as $skillData) {
            Skill::updateOrCreate(
                ['name' => $skillData['name']],
                $skillData
            );
        }
    }
}