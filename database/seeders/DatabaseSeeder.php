<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            SiteSettingsSeeder::class,
            SkillsSeeder::class,
            ProjectsSeeder::class,
            ExperiencesSeeder::class,
            EducationSeeder::class,
            BlogSeeder::class,
        ]);
    }
}
