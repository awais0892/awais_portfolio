<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test blog post if none exists
        if (Blog::count() == 0) {
            Blog::create([
                'title' => 'Test Blog Post for Comments and Ratings',
                'slug' => 'test-blog-post',
                'excerpt' => 'This is a test blog post to demonstrate the commenting and rating system.',
                'content' => 'This is a comprehensive test blog post that demonstrates the commenting and rating system. Users can leave comments and rate this post to test the functionality.

## Features Being Tested

1. **Comment System**: Users can leave comments and replies
2. **Rating System**: Users can rate the post from 1-5 stars
3. **Real-time Updates**: Comments and ratings load dynamically
4. **Admin Moderation**: Comments and ratings require approval

## How to Test

1. Fill out the comment form below
2. Use the star rating system
3. Check the admin panel for moderation
4. Verify real-time updates

This post contains enough content to test all the features of the commenting and rating system.',
                'status' => 'published',
                'author' => 'Awais Ahmad',
                'category' => 'Testing',
                'tags' => ['testing', 'comments', 'ratings', 'demo'],
                'published_at' => now(),
                'views' => 0
            ]);
        }
    }
}