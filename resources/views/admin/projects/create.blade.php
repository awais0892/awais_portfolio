@extends('layouts.app')

@section('title','Create Project')
@section('page-title','New Project')

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
        <div class="mb-12 text-center">
            <div class="inline-block">
                <h1 class="text-6xl font-black bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 bg-clip-text text-transparent mb-4 tracking-tight">
                    CREATE PROJECT
                </h1>
                <div class="h-1 w-32 bg-gradient-to-r from-cyan-400 to-purple-600 mx-auto rounded-full"></div>
            </div>
            <p class="text-cyan-300/80 text-xl mt-6 font-light tracking-wide">
                Build something amazing for your portfolio
            </p>
        </div>

        <!-- Create Form -->
        <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-8 shadow-2xl">
            <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Project Title *</label>
                        <input name="title" value="{{ old('title') }}" required 
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg"
                               placeholder="Enter project title">
                        @error('title')
                            <p class="text-red-400 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-fuchsia-300 uppercase tracking-wider mb-3">Featured Project</label>
                        <select name="featured" class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white focus:ring-2 focus:ring-fuchsia-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg">
                            <option value="0" class="bg-slate-800">No</option>
                            <option value="1" class="bg-slate-800">Yes</option>
                        </select>
                        @error('featured')
                            <p class="text-red-400 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Short Description *</label>
                    <textarea name="description" rows="3" required 
                              class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg"
                              placeholder="Brief description of your project">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-400 text-sm mt-2 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Detailed Description</label>
                    <textarea name="long_description" rows="6" 
                              class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg"
                              placeholder="Comprehensive description of your project">{{ old('long_description') }}</textarea>
                    @error('long_description')
                        <p class="text-red-400 text-sm mt-2 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Technologies</label>
                        <input name="technologies" value="{{ old('technologies') }}" 
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg"
                               placeholder="Laravel, React, MySQL">
                        @error('technologies')
                            <p class="text-red-400 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Live Demo URL</label>
                        <input name="live_url" value="{{ old('live_url') }}" 
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg"
                               placeholder="https://example.com">
                        @error('live_url')
                            <p class="text-red-400 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">GitHub URL</label>
                        <input name="github_url" value="{{ old('github_url') }}" 
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg"
                               placeholder="https://github.com/user/repo">
                        @error('github_url')
                            <p class="text-red-400 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="p-6 backdrop-blur-sm bg-white/5 border border-white/10 rounded-2xl">
                    <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-4">Project Image</label>
                    <input type="file" name="image" accept="image/*" 
                           class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gradient-to-r file:from-cyan-500 file:to-blue-600 file:text-white hover:file:from-cyan-600 hover:file:to-blue-700 transition-all duration-300">
                    <p class="text-sm text-cyan-300/70 mt-3">Max size: 2MB. Supported formats: JPG, PNG, GIF</p>
                    @error('image')
                        <p class="text-red-400 text-sm mt-2 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" 
                            class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 text-cyan-300 border border-cyan-400/30 rounded-xl hover:from-cyan-500/30 hover:to-blue-500/30 transition-all duration-300 hover:scale-105">
                        <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="fas fa-plus mr-3 relative z-10"></i>
                        <span class="relative z-10 font-semibold text-lg">Create Project</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// GSAP Animations (plugins already registered in app.js)

document.addEventListener('DOMContentLoaded', function() {
    initializeAnimations();
});

function initializeAnimations() {
    // Header animation
    gsap.fromTo('.text-6xl', {
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

    gsap.fromTo('.text-cyan-300', {
        y: 30,
        opacity: 0
    }, {
        y: 0,
        opacity: 1,
        duration: 1,
        delay: 0.8,
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
        delay: 1,
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

    // Image upload section animation
    gsap.fromTo('.backdrop-blur-sm', {
        y: 30,
        opacity: 0
    }, {
        y: 0,
        opacity: 1,
        duration: 0.8,
        delay: 2,
        ease: "power2.out"
    });

    // Submit button animation
    gsap.fromTo('button[type="submit"]', {
        y: 30,
        opacity: 0
    }, {
        y: 0,
        opacity: 1,
        duration: 0.8,
        delay: 2.2,
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
    document.querySelectorAll('button, input, textarea, select').forEach(element => {
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
</script>
@endpush
