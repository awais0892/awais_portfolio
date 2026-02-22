<?php
// database/seeders/BlogSeeder.php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run()
    {
        $blogs = [
            [
                'title' => 'Getting Started with Artificial Intelligence in 2024',
                'excerpt' => 'A comprehensive guide on how to start your journey into Artificial Intelligence and Machine Learning.',
                'content' => 'Artificial Intelligence (AI) is no longer just a buzzword; it is reshaping industries worldwide. In this comprehensive guide, we will explore the foundational concepts of Machine Learning, Neural Networks, and Natural Language Processing. Whether you are a student or a seasoned developer, understanding AI is crucial for the future. We will discuss Python libraries such as TensorFlow and PyTorch, and how you can leverage them to build simple, effective models.',
                'featured_image' => 'https://images.unsplash.com/photo-1620712943543-bcc4688e7485?w=800&h=600&fit=crop&crop=center',
                'status' => 'published',
                'author' => 'Awais Ahmad',
                'category' => 'Artificial Intelligence',
                'tags' => ['AI', 'Machine Learning', 'Python', 'Future Tech'],
                'views' => 150,
                'published_at' => now()->subDays(5)
            ],
            [
                'title' => 'Mastering MERN Stack: Front to Back',
                'excerpt' => 'Deep dive into MongoDB, Express.js, React, and Node.js for building scalable modern web applications.',
                'content' => 'The MERN stack has become one of the most popular technology combinations for building robust web applications. This post breaks down how MongoDBs document-based database seamlessly connects with Node.js and Express to create powerful RESTful APIs. Furthermore, we explore how Reacts component-based architecture consumes these APIs to deliver highly interactive user interfaces. Real-world examples and best practices for scaling MERN applications are also discussed.',
                'featured_image' => 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?w=800&h=600&fit=crop&crop=center',
                'status' => 'published',
                'author' => 'Awais Ahmad',
                'category' => 'Web Development',
                'tags' => ['MERN', 'React', 'Nodejs', 'MongoDB'],
                'views' => 230,
                'published_at' => now()->subDays(12)
            ],
            [
                'title' => 'Laravel 11: What is New and Why You Should Upgrade',
                'excerpt' => 'An overview of the exciting new features and performance improvements introduced in the latest Laravel release.',
                'content' => 'Laravel continues to be the PHP framework of choice for artisans. With the release of Laravel 11, the ecosystem has become leaner, faster, and more developer-friendly. In this article, we cover the streamlined directory structure, the new Reverb package for WebSocket communication, and the simplified configuration files. We also provide a step-by-step upgrade guide to migrate your existing applications with minimal downtime.',
                'featured_image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=800&h=600&fit=crop&crop=center',
                'status' => 'published',
                'author' => 'Awais Ahmad',
                'category' => 'Backend Development',
                'tags' => ['Laravel', 'PHP', 'Backend', 'Web'],
                'views' => 310,
                'published_at' => now()->subDays(2)
            ]
        ];

        foreach ($blogs as $blogData) {
            $blogData['slug'] = Str::slug($blogData['title']);
            Blog::updateOrCreate(
                ['slug' => $blogData['slug']],
                $blogData
            );
        }
    }
}
