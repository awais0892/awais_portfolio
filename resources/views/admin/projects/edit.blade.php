@extends('layouts.app')

@section('title', 'Admin - Edit Project')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl animate-pulse delay-500"></div>
    </div>

    <!-- Grid Pattern Overlay -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.02"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="mb-12">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-6 lg:space-y-0">
                <div class="space-y-4">
                    <a href="{{ route('admin.projects.index') }}" 
                       class="group inline-flex items-center text-cyan-300 hover:text-cyan-200 transition-colors duration-300">
                        <div class="w-8 h-8 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-full flex items-center justify-center border border-cyan-400/30 mr-3 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-arrow-left text-cyan-300"></i>
                        </div>
                        <span class="font-semibold">Back to Projects</span>
                    </a>
                    <div>
                        <h1 class="text-5xl font-black bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 bg-clip-text text-transparent mb-4 tracking-tight">
                            EDIT PROJECT
                        </h1>
                        <div class="h-1 w-32 bg-gradient-to-r from-cyan-400 to-purple-600 rounded-full"></div>
                    </div>
                </div>
                <a href="{{ route('admin.projects.show', $project) }}" 
                   class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-500/20 to-gray-600/20 text-gray-300 border border-gray-400/30 rounded-xl hover:from-gray-500/30 hover:to-gray-600/30 transition-all duration-300 hover:scale-105">
                    <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="fas fa-eye mr-3 relative z-10"></i>
                    <span class="relative z-10 font-semibold">View Project</span>
                </a>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-8 shadow-2xl">
            <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Project Title *</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $project->title) }}" required
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg">
                        @error('title')
                            <p class="text-red-400 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Short Description *</label>
                        <textarea id="description" name="description" rows="3" required
                                  class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg">{{ old('description', $project->description) }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-400 mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Long Description -->
                    <div class="md:col-span-2">
                        <label for="long_description" class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Detailed Description</label>
                        <textarea id="long_description" name="long_description" rows="5"
                                  class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg">{{ old('long_description', $project->long_description) }}</textarea>
                        @error('long_description')
                            <p class="text-sm text-red-400 mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Technologies -->
                    <div class="md:col-span-2">
                        <label for="technologies" class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Technologies (comma-separated)</label>
                        <input type="text" id="technologies" name="technologies" 
                               value="{{ old('technologies', $project->technologies ? implode(', ', $project->technologies) : '') }}"
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg"
                               placeholder="e.g., Laravel, React, MySQL, Redis">
                        @error('technologies')
                            <p class="text-sm text-red-400 mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Live URL -->
                    <div>
                        <label for="live_url" class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Live Demo URL</label>
                        <input type="url" id="live_url" name="live_url" value="{{ old('live_url', $project->live_url) }}"
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg"
                               placeholder="https://example.com">
                        @error('live_url')
                            <p class="text-sm text-red-400 mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- GitHub URL -->
                    <div>
                        <label for="github_url" class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">GitHub Repository URL</label>
                        <input type="url" id="github_url" name="github_url" value="{{ old('github_url', $project->github_url) }}"
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg"
                               placeholder="https://github.com/username/repo">
                        @error('github_url')
                            <p class="text-sm text-red-400 mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Order -->
                    <div>
                        <label for="order" class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Display Order</label>
                        <input type="number" id="order" name="order" value="{{ old('order', $project->order) }}" min="0"
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg">
                        @error('order')
                            <p class="text-sm text-red-400 mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Image URL -->
                    <div>
                        <label for="image_url" class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Image URL</label>
                        <input type="url" id="image_url" name="image_url" value="{{ old('image_url', $project->image_url) }}"
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg"
                               placeholder="https://example.com/image.jpg">
                        @error('image_url')
                            <p class="text-sm text-red-400 mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Featured -->
                    <div>
                        <label class="flex items-center space-x-3 p-4 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 transition-all duration-300">
                            <input type="checkbox" name="featured" value="1" {{ old('featured', $project->featured) ? 'checked' : '' }}
                                   class="w-5 h-5 rounded-lg border-white/30 text-cyan-500 focus:ring-cyan-400 bg-white/10">
                            <span class="text-cyan-300 font-semibold">Featured Project</span>
                        </label>
                    </div>

                    <!-- Active Status -->
                    <div>
                        <label class="flex items-center space-x-3 p-4 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 transition-all duration-300">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $project->is_active) ? 'checked' : '' }}
                                   class="w-5 h-5 rounded-lg border-white/30 text-cyan-500 focus:ring-cyan-400 bg-white/10">
                            <span class="text-cyan-300 font-semibold">Active</span>
                        </label>
                    </div>
                </div>

                <!-- Current Image Preview -->
                @if($project->image_url)
                    <div class="mt-8 p-6 backdrop-blur-sm bg-white/5 border border-white/10 rounded-2xl">
                        <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-4">Current Image</label>
                        <div class="flex items-center space-x-6">
                            <img src="{{ $project->image_url }}" alt="{{ $project->title }}" 
                                 class="w-40 h-32 object-cover rounded-2xl border-2 border-white/20 hover:border-cyan-400/50 transition-all duration-300">
                            <div class="text-cyan-300/80">
                                <p class="text-lg font-semibold">Current project image</p>
                                <p class="text-sm">Upload a new image below to replace it</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Image Upload -->
                <div class="mt-8 p-6 backdrop-blur-sm bg-white/5 border border-white/10 rounded-2xl">
                    <label for="image" class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-4">Upload New Image</label>
                    <input type="file" id="image" name="image" accept="image/*"
                           class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gradient-to-r file:from-cyan-500 file:to-blue-600 file:text-white hover:file:from-cyan-600 hover:file:to-blue-700 transition-all duration-300">
                    <p class="text-sm text-cyan-300/70 mt-3">Max size: 2MB. Supported formats: JPG, PNG, GIF</p>
                    @error('image')
                        <p class="text-sm text-red-400 mt-2 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4 mt-8">
                    <a href="{{ route('admin.projects.show', $project) }}" 
                       class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-gray-500/20 to-gray-600/20 text-gray-300 border border-gray-400/30 rounded-xl hover:from-gray-500/30 hover:to-gray-600/30 transition-all duration-300 hover:scale-105">
                        <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <span class="relative font-semibold text-lg">Cancel</span>
                    </a>
                    <button type="submit" 
                            class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 text-cyan-300 border border-cyan-400/30 rounded-xl hover:from-cyan-500/30 hover:to-blue-500/30 transition-all duration-300 hover:scale-105">
                        <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="fas fa-save mr-3 relative z-10"></i>
                        <span class="relative z-10 font-semibold text-lg">Update Project</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
<div id="messageContainer" class="fixed top-6 right-6 z-50 hidden">
    <div class="backdrop-blur-xl bg-gradient-to-r from-green-500/20 to-emerald-500/20 border border-green-400/30 text-green-300 px-8 py-4 rounded-2xl shadow-2xl flex items-center">
        <i class="fas fa-check-circle mr-3 text-green-400"></i>
        <span id="messageText" class="font-semibold"></span>
    </div>
</div>

@endsection

@push('scripts')
<script>
// GSAP Animations (plugins already registered in app.js)

document.addEventListener('DOMContentLoaded', function() {
    initializeAnimations();
    
    // Show success message if there's a flash message
    @if(session('success'))
        showMessage('{{ session('success') }}', 'success');
    @endif

    @if(session('error'))
        showMessage('{{ session('error') }}', 'error');
    @endif
});

function initializeAnimations() {
    // Header animation
    gsap.fromTo('.text-5xl', {
        y: 100,
        opacity: 0,
        scale: 0.8
    }, {
        y: 0,
        opacity: 1,
        scale: 1,
        duration: 1.5,
        ease: "back.out(1.7)"
    });

    gsap.fromTo('.h-1', {
        scaleX: 0
    }, {
        scaleX: 1,
        duration: 1.5,
        delay: 0.5,
        ease: "power2.out"
    });

    // Back button animation
    gsap.fromTo('a[href*="index"]', {
        x: -50,
        opacity: 0
    }, {
        x: 0,
        opacity: 1,
        duration: 1,
        delay: 0.8,
        ease: "power2.out"
    });

    // View button animation
    gsap.fromTo('a[href*="show"]', {
        y: 50,
        opacity: 0
    }, {
        y: 0,
        opacity: 1,
        duration: 1,
        delay: 1,
        ease: "power2.out"
    });

    // Form animation
    gsap.fromTo('.backdrop-blur-xl', {
        y: 50,
        opacity: 0,
        scale: 0.95
    }, {
        y: 0,
        opacity: 1,
        scale: 1,
        duration: 1.2,
        delay: 1.2,
        ease: "power2.out"
    });

    // Form fields animation
    gsap.fromTo('input, textarea, select', {
        y: 30,
        opacity: 0
    }, {
        y: 0,
        opacity: 1,
        duration: 0.8,
        stagger: 0.05,
        delay: 1.5,
        ease: "power2.out"
    });

    // Checkbox labels animation
    gsap.fromTo('label.flex', {
        x: -30,
        opacity: 0
    }, {
        x: 0,
        opacity: 1,
        duration: 0.8,
        stagger: 0.1,
        delay: 2,
        ease: "power2.out"
    });

    // Image preview animation
    gsap.fromTo('.backdrop-blur-sm', {
        y: 30,
        opacity: 0
    }, {
        y: 0,
        opacity: 1,
        duration: 0.8,
        stagger: 0.2,
        delay: 2.2,
        ease: "power2.out"
    });

    // Submit buttons animation
    gsap.fromTo('.flex.flex-col.sm\\:flex-row', {
        y: 30,
        opacity: 0
    }, {
        y: 0,
        opacity: 1,
        duration: 0.8,
        delay: 2.4,
        ease: "power2.out"
    });

    // Floating background elements
    gsap.to('.absolute.-top-40', {
        y: -20,
        x: 20,
        duration: 8,
        repeat: -1,
        yoyo: true,
        ease: "power1.inOut"
    });

    gsap.to('.absolute.-bottom-40', {
        y: 20,
        x: -20,
        duration: 10,
        repeat: -1,
        yoyo: true,
        ease: "power1.inOut"
    });

    gsap.to('.absolute.top-1\\/2', {
        y: -30,
        x: 30,
        duration: 12,
        repeat: -1,
        yoyo: true,
        ease: "power1.inOut"
    });

    // Hover animations for interactive elements
    document.querySelectorAll('button, a, input, textarea, select').forEach(element => {
        element.addEventListener('mouseenter', () => {
            gsap.to(element, {
                scale: 1.02,
                duration: 0.3,
                ease: "power2.out"
            });
        });

        element.addEventListener('mouseleave', () => {
            gsap.to(element, {
                scale: 1,
                duration: 0.3,
                ease: "power2.out"
            });
        });
    });
}

function showMessage(message, type = 'success') {
    const container = document.getElementById('messageContainer');
    const messageText = document.getElementById('messageText');
    
    messageText.textContent = message;
    
    if (type === 'success') {
        container.className = 'fixed top-6 right-6 z-50 backdrop-blur-xl bg-gradient-to-r from-green-500/20 to-emerald-500/20 border border-green-400/30 text-green-300 px-8 py-4 rounded-2xl shadow-2xl flex items-center';
    } else {
        container.className = 'fixed top-6 right-6 z-50 backdrop-blur-xl bg-gradient-to-r from-red-500/20 to-pink-500/20 border border-red-400/30 text-red-300 px-8 py-4 rounded-2xl shadow-2xl flex items-center';
    }
    
    // Animate message appearance
    container.classList.remove('hidden');
    gsap.fromTo(container, {
        x: 100,
        opacity: 0,
        scale: 0.8
    }, {
        x: 0,
        opacity: 1,
        scale: 1,
        duration: 0.5,
        ease: "back.out(1.7)"
    });
    
    setTimeout(() => {
        gsap.to(container, {
            x: 100,
            opacity: 0,
            scale: 0.8,
            duration: 0.5,
            ease: "power2.in",
            onComplete: () => container.classList.add('hidden')
        });
    }, 3000);
}
</script>
@endpush
