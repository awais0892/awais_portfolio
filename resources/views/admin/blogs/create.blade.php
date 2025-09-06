@extends('layouts.app')

@section('title', 'Admin - Create Blog Post')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl animate-pulse delay-500"></div>
    </div>

    <!-- Grid Pattern Overlay -->
    <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:50px_50px]"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <div class="inline-block">
                <h1 class="text-6xl font-black bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 bg-clip-text text-transparent mb-4 tracking-tight">
                    CREATE BLOG POST
                </h1>
                <div class="h-1 w-32 bg-gradient-to-r from-cyan-400 to-purple-600 mx-auto rounded-full"></div>
            </div>
            <p class="text-cyan-300/80 text-xl mt-6 font-light tracking-wide">
                Craft engaging content for your audience
            </p>
        </div>

        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('admin.blogs.index') }}" 
               class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 text-cyan-300 border border-cyan-400/30 rounded-xl hover:from-cyan-500/30 hover:to-blue-500/30 transition-all duration-300 hover:scale-105">
                <i class="fas fa-arrow-left mr-3"></i>
                <span class="font-semibold">Back to Blog Management</span>
            </a>
        </div>

        <!-- Create Form -->
        <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-8 shadow-2xl">
            <form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <!-- Basic Information -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Title *</label>
                        <input type="text" name="title" value="{{ old('title') }}" required 
                               placeholder="Enter blog post title..." 
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                        @error('title')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Slug</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" 
                               placeholder="Auto-generated from title..." 
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                        <p class="text-cyan-300/50 text-sm mt-2">Leave empty to auto-generate from title</p>
                        @error('slug')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Content and Excerpt -->
                <div>
                    <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Excerpt</label>
                    <textarea name="excerpt" rows="3" 
                              placeholder="Brief description of the blog post..." 
                              class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">{{ old('excerpt') }}</textarea>
                    <p class="text-cyan-300/50 text-sm mt-2">A short summary of your blog post (optional)</p>
                    @error('excerpt')
                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Content *</label>
                    <textarea name="content" rows="12" required 
                              placeholder="Write your blog post content here..." 
                              class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Media and Settings -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
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
                        <input type="hidden" name="featured_image_url" id="featured_image_url" value="{{ old('featured_image_url') }}">
                        
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
                        
                        @error('featured_image_url')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Status *</label>
                            <select name="status" required 
                                    class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                            </select>
                            @error('status')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Author *</label>
                            <input type="text" name="author" value="{{ old('author', 'Admin') }}" required 
                                   placeholder="Author name..." 
                                   class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                            @error('author')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Category</label>
                            <input type="text" name="category" value="{{ old('category') }}" 
                                   placeholder="e.g., Technology, Design, Tutorial..." 
                                   class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                            @error('category')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Tags</label>
                            <input type="text" name="tags" value="{{ old('tags') }}" 
                                   placeholder="tag1, tag2, tag3..." 
                                   class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                            <p class="text-cyan-300/50 text-sm mt-2">Separate tags with commas</p>
                            @error('tags')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Published Date</label>
                            <input type="datetime-local" name="published_at" value="{{ old('published_at') }}" 
                                   class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                            <p class="text-cyan-300/50 text-sm mt-2">Leave empty to publish immediately</p>
                            @error('published_at')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- SEO Section -->
                <div class="border-t border-white/10 pt-8">
                    <h3 class="text-2xl font-bold text-cyan-300 mb-6">SEO Settings</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Meta Title</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title') }}" 
                                   placeholder="SEO title for search engines..." 
                                   class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                            <p class="text-cyan-300/50 text-sm mt-2">Leave empty to use the post title</p>
                            @error('meta_title')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Meta Keywords</label>
                            <input type="text" name="meta_keywords" value="{{ old('meta_keywords') }}" 
                                   placeholder="keyword1, keyword2, keyword3..." 
                                   class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                            @error('meta_keywords')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Meta Description</label>
                        <textarea name="meta_description" rows="3" 
                                  placeholder="Brief description for search engines..." 
                                  class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">{{ old('meta_description') }}</textarea>
                        <p class="text-cyan-300/50 text-sm mt-2">Leave empty to use the post excerpt</p>
                        @error('meta_description')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4 pt-8 border-t border-white/10">
                    <button type="button" onclick="window.location.href='{{ route('admin.blogs.index') }}'" 
                            class="px-8 py-3 bg-gradient-to-r from-gray-500/20 to-gray-600/20 text-gray-300 border border-gray-400/30 rounded-xl hover:from-gray-500/30 hover:to-gray-600/30 transition-all duration-300 hover:scale-105">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="group relative px-8 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold rounded-xl overflow-hidden transition-all duration-500 hover:scale-105 hover:shadow-2xl hover:shadow-cyan-500/25">
                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-600 to-blue-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative flex items-center">
                            <i class="fas fa-save mr-3"></i>
                            <span>Create Blog Post</span>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        initializeAnimations();
    });

    function initializeAnimations() {
        // Header animation
        gsap.fromTo('.text-6xl', 
            { y: 100, opacity: 0, scale: 0.8 }, 
            { y: 0, opacity: 1, scale: 1, duration: 1.5, ease: "back.out(1.7)" }
        );
        
        gsap.fromTo('.h-1', 
            { scaleX: 0 }, 
            { scaleX: 1, duration: 1.5, delay: 0.5, ease: "power2.out" }
        );

        // Back button animation
        gsap.fromTo('a[href*="index"]', 
            { x: -50, opacity: 0 }, 
            { x: 0, opacity: 1, duration: 1, delay: 0.8, ease: "power2.out" }
        );

        // Form animation
        gsap.fromTo('.backdrop-blur-xl', 
            { y: 50, opacity: 0, scale: 0.95 }, 
            { y: 0, opacity: 1, scale: 1, duration: 1.2, delay: 1, ease: "power2.out" }
        );

        // Form fields animation
        gsap.fromTo('input, textarea, select', 
            { y: 30, opacity: 0 }, 
            { y: 0, opacity: 1, duration: 0.6, stagger: 0.05, delay: 1.5, ease: "power2.out" }
        );

        // Submit button animation
        gsap.fromTo('button[type="submit"]', 
            { y: 30, opacity: 0, rotation: -5 }, 
            { y: 0, opacity: 1, rotation: 0, duration: 1, delay: 2, ease: "elastic.out(1, 0.5)" }
        );
    }

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
        
        // Show existing image if editing
        const existingImageUrl = document.getElementById('featured_image_url').value;
        if (existingImageUrl) {
            showImagePreview(existingImageUrl);
            const uploadComponent = uploadContainer.querySelector('.file-upload-component');
            if (uploadComponent) {
                uploadComponent.style.display = 'none';
            }
        }
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
@endpush
