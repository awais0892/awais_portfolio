<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>File Upload Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #581c87 50%, #0f172a 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <div class="min-h-screen py-8">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-400 bg-clip-text text-transparent mb-4">
                    File Upload Test
                </h1>
                <p class="text-cyan-200/80">Test your Cloudinary file upload functionality</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-6xl mx-auto">
                <!-- Image Upload -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
                    <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                        <i class="fas fa-image text-cyan-400"></i>
                        Image Upload
                    </h2>
                    @include('components.file-upload', [
                        'type' => 'image',
                        'folder' => 'portfolio/test-images',
                        'title' => 'Upload Test Images',
                        'description' => 'Test image upload functionality'
                    ])
                </div>

                <!-- Document Upload -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
                    <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                        <i class="fas fa-file-alt text-purple-400"></i>
                        Document Upload
                    </h2>
                    @include('components.file-upload', [
                        'type' => 'document',
                        'folder' => 'portfolio/test-documents',
                        'title' => 'Upload Test Documents',
                        'description' => 'Test document upload functionality'
                    ])
                </div>
            </div>

            <!-- Instructions -->
            <div class="mt-8 bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 max-w-4xl mx-auto">
                <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-info-circle text-yellow-400"></i>
                    Setup Instructions
                </h3>
                <div class="text-cyan-200/80 space-y-2">
                    <p><strong>1.</strong> Sign up for a free Cloudinary account at <a href="https://cloudinary.com" target="_blank" class="text-cyan-400 hover:text-cyan-300">cloudinary.com</a></p>
                    <p><strong>2.</strong> Get your API credentials from the dashboard</p>
                    <p><strong>3.</strong> Add them to your <code class="bg-white/10 px-2 py-1 rounded">.env</code> file:</p>
                    <div class="bg-black/20 rounded-lg p-4 mt-2 font-mono text-sm">
                        <div>CLOUDINARY_CLOUD_NAME=your_cloud_name_here</div>
                        <div>CLOUDINARY_API_KEY=your_api_key_here</div>
                        <div>CLOUDINARY_API_SECRET=your_api_secret_here</div>
                        <div>CLOUDINARY_URL=cloudinary://your_api_key:your_api_secret@your_cloud_name</div>
                    </div>
                    <p><strong>4.</strong> Restart your Laravel server: <code class="bg-white/10 px-2 py-1 rounded">php artisan serve</code></p>
                    <p><strong>5.</strong> Try uploading files above!</p>
                </div>
            </div>

            <!-- Back to Admin -->
            <div class="text-center mt-8">
                <a href="/admin" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-cyan-500 to-purple-600 text-white font-semibold rounded-lg hover:from-cyan-600 hover:to-purple-700 transition-all duration-300">
                    <i class="fas fa-arrow-left"></i>
                    Back to Admin Panel
                </a>
            </div>
        </div>
    </div>
</body>
</html>
