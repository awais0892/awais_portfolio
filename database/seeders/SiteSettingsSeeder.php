<?php
// database/seeders/SiteSettingsSeeder.php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            ['key' => 'site_title', 'value' => 'Awais Ahmad - Full-Stack Developer Portfolio', 'type' => 'text'],
            ['key' => 'site_description', 'value' => 'Portfolio of Awais Ahmad, a skilled full-stack developer specializing in Laravel and MERN stack technologies.', 'type' => 'text'],
            ['key' => 'hero_title', 'value' => 'I Build Things <br class="hidden md:block" /> for the <span class="gradient-text">Web.</span>', 'type' => 'text'],
            ['key' => 'hero_subtitle', 'value' => "I'm a detail-oriented software engineer with over a year of hands-on experience in Laravel and the MERN stack. I specialize in building robust web applications, scalable backend architectures, and delivering exceptional user experiences.", 'type' => 'textarea'],
            ['key' => 'about_text', 'value' => "I'm a passionate software engineer from Islamabad with a strong command of both Laravel and the MERN stack (MongoDB, Express.js, React, Node.js). My expertise lies in building robust web applications, from managing database migrations and RESTful APIs in Laravel to developing scalable backend architectures.\n\nCurrently working at Pixako Technologies, I've had the opportunity to contribute to a variety of impactful projects, including a U.S. SEC-compliant government application, high-performance e-commerce platforms, and feature-rich expense tracking systems. I'm committed to translating business requirements into efficient, user-friendly solutions with a focus on performance and maintainability.\n\nAs a graduate of COMSATS University Islamabad with a BS in Computer Science, I believe in continuous learning and staying updated with the latest technologies to deliver cutting-edge digital products.", 'type' => 'textarea'],
            ['key' => 'profile_image', 'value' => 'awais.jpg', 'type' => 'image'],
            ['key' => 'cv_file', 'value' => 'cv.pdf', 'type' => 'image'],
            ['key' => 'linkedin_url', 'value' => 'https://www.linkedin.com/in/awaisahmads/', 'type' => 'text'],
            ['key' => 'github_url', 'value' => 'https://github.com/awais0892', 'type' => 'text'],
            ['key' => 'email', 'value' => 'awais.32525@gmail.com', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}