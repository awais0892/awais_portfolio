<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Comments & Ratings</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-900 text-white">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Test Comments & Ratings System</h1>
        
        <div class="space-y-8">
            <!-- Test Comments -->
            <div>
                <h2 class="text-2xl font-bold mb-4">Comments Test</h2>
                @php
                    $testBlog = App\Models\Blog::first();
                @endphp
                @if($testBlog)
                    <p class="text-gray-400 mb-4">Testing with blog: "{{ $testBlog->title }}" (ID: {{ $testBlog->id }})</p>
                    @include('components.comments', ['commentableType' => 'App\Models\Blog', 'commentableId' => $testBlog->id])
                @else
                    <p class="text-red-400">No blog posts found. Please run the seeder first.</p>
                @endif
            </div>
            
            <!-- Test Ratings -->
            <div>
                <h2 class="text-2xl font-bold mb-4">Ratings Test</h2>
                @if($testBlog)
                    @include('components.rating', ['rateableType' => 'App\Models\Blog', 'rateableId' => $testBlog->id])
                @else
                    <p class="text-red-400">No blog posts found. Please run the seeder first.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
