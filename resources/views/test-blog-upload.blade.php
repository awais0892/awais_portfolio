<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Blog Image Upload Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
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
                    Blog Image Upload Test
                </h1>
                <p class="text-cyan-200/80">Test the Cloudinary image upload integration for blog posts</p>
            </div>

            <div class="max-w-4xl mx-auto">
                <!-- Test Blog Creation Form -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-8 mb-8">
                    <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                        <i class="fas fa-blog text-cyan-400"></i>
                        Test Blog Creation
                    </h2>
                    
                    <form id="testBlogForm" class="space-y-6">
                        @csrf
                        
                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Title</label>
                            <input type="text" name="title" required 
                                   placeholder="Enter blog post title..." 
                                   class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                        </div>

                        <!-- Content -->
                        <div>
                            <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Content</label>
                            <textarea name="content" rows="4" required 
                                      placeholder="Write your blog post content here..." 
                                      class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300"></textarea>
                        </div>

                        <!-- Featured Image Upload -->
                        <div>
                            <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Featured Image</label>
                            
                            <!-- Cloudinary Upload Component -->
                            <div id="cloudinary-upload-container">
                                @include('components.file-upload', [
                                    'type' => 'image',
                                    'folder' => 'portfolio/blog-images',
                                    'title' => 'Upload Featured Image',
                                    'description' => 'Upload a featured image for your blog post'
                                ])
                            </div>
                            
                            <!-- Hidden input to store Cloudinary URL -->
                            <input type="hidden" name="featured_image_url" id="featured_image_url">
                            
                            <!-- Image Preview -->
                            <div id="imagePreview" class="hidden mt-4">
                                <div class="relative">
                                    <img id="previewImg" src="" alt="Preview" class="w-full h-48 object-cover rounded-xl">
                                    <button type="button" onclick="removeImage()" 
                                            class="absolute top-2 right-2 bg-red-500/80 hover:bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center transition-colors">
                                        <i class="fas fa-times text-sm"></i>
                                    </button>
                                </div>
                                <p class="text-cyan-300/70 text-sm mt-2">Click the X to remove this image</p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" 
                                    class="px-8 py-3 bg-gradient-to-r from-cyan-500 to-purple-600 text-white font-semibold rounded-xl hover:from-cyan-600 hover:to-purple-700 transition-all duration-300 hover:scale-105">
                                <i class="fas fa-save mr-2"></i>
                                Test Blog Creation
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Instructions -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-yellow-400"></i>
                        Setup Instructions
                    </h3>
                    <div class="text-cyan-200/80 space-y-2">
                        <p><strong>1.</strong> Make sure you have Cloudinary configured in your <code class="bg-white/10 px-2 py-1 rounded">.env</code> file</p>
                        <p><strong>2.</strong> Upload an image using the component above</p>
                        <p><strong>3.</strong> Fill in the title and content</p>
                        <p><strong>4.</strong> Click "Test Blog Creation" to see the form data</p>
                        <p><strong>5.</strong> Check the admin panel at <code class="bg-white/10 px-2 py-1 rounded">/admin/blogs</code> to see your blog posts</p>
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
    </div>

    <script>
    // Cloudinary upload integration
    document.addEventListener('DOMContentLoaded', function() {
        // Listen for file upload events from the Cloudinary component
        const uploadContainer = document.getElementById('cloudinary-upload-container');
        if (uploadContainer) {
            uploadContainer.addEventListener('fileUploaded', function(event) {
                const fileData = event.detail;
                showImagePreview(fileData.secure_url);
                document.getElementById('featured_image_url').value = fileData.secure_url;
                
                // Hide the upload component and show preview
                const uploadComponent = uploadContainer.querySelector('.file-upload-component');
                if (uploadComponent) {
                    uploadComponent.style.display = 'none';
                }
            });
        }
        
        // Form submission
        document.getElementById('testBlogForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            console.log('Blog Form Data:', data);
            alert('Form data logged to console! Check the browser console to see the data structure.');
        });
    });

    function showImagePreview(imageUrl) {
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        
        previewImg.src = imageUrl;
        preview.classList.remove('hidden');
        
        // Animate preview appearance
        gsap.fromTo(preview, 
            { scale: 0.8, opacity: 0 }, 
            { scale: 1, opacity: 1, duration: 0.5, ease: "back.out(1.7)" }
        );
    }

    function removeImage() {
        const preview = document.getElementById('imagePreview');
        const uploadContainer = document.getElementById('cloudinary-upload-container');
        const uploadComponent = uploadContainer.querySelector('.file-upload-component');
        
        // Clear the hidden input
        document.getElementById('featured_image_url').value = '';
        
        // Hide preview
        preview.classList.add('hidden');
        
        // Show upload component again
        if (uploadComponent) {
            uploadComponent.style.display = 'block';
        }
        
        // Clear any uploaded files list
        const filesList = uploadContainer.querySelector('#files-list-image');
        if (filesList) {
            filesList.innerHTML = '';
        }
        
        const uploadedFiles = uploadContainer.querySelector('#uploaded-files-image');
        if (uploadedFiles) {
            uploadedFiles.classList.add('hidden');
        }
    }
    </script>
</body>
</html>
