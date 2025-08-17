@extends('layouts.app')

@section('title', 'Admin - Create Setting')

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

    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="mb-12">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-6 lg:space-y-0">
                <div class="space-y-4">
                    <a href="{{ route('admin.settings.index') }}" 
                       class="group inline-flex items-center text-cyan-300 hover:text-cyan-200 transition-colors duration-300">
                        <div class="w-8 h-8 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-full flex items-center justify-center border border-cyan-400/30 mr-3 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-arrow-left text-cyan-300"></i>
                        </div>
                        <span class="font-semibold">Back to Settings</span>
                    </a>
                    <div>
                        <h1 class="text-5xl font-black bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 bg-clip-text text-transparent mb-4 tracking-tight">
                            CREATE SETTING
                        </h1>
                        <div class="h-1 w-32 bg-gradient-to-r from-cyan-400 to-purple-600 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Form -->
        <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-8 shadow-2xl">
            <form method="POST" action="{{ route('admin.settings.store') }}" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label for="key" class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Setting Key *</label>
                        <input type="text" id="key" name="key" value="{{ old('key') }}" required 
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg"
                               placeholder="e.g., site_name, logo_url">
                        @error('key')
                            <p class="text-red-400 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="type" class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Setting Type *</label>
                        <select id="type" name="type" required 
                                class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg">
                            <option value="" class="bg-slate-800">Select Type</option>
                            <option value="text" class="bg-slate-800" {{ old('type') == 'text' ? 'selected' : '' }}>Text</option>
                            <option value="textarea" class="bg-slate-800" {{ old('type') == 'textarea' ? 'selected' : '' }}>Textarea</option>
                            <option value="image" class="bg-slate-800" {{ old('type') == 'image' ? 'selected' : '' }}>Image</option>
                            <option value="json" class="bg-slate-800" {{ old('type') == 'json' ? 'selected' : '' }}>JSON</option>
                            <option value="boolean" class="bg-slate-800" {{ old('type') == 'boolean' ? 'selected' : '' }}>Boolean</option>
                            <option value="number" class="bg-slate-800" {{ old('type') == 'number' ? 'selected' : '' }}>Number</option>
                        </select>
                        @error('type')
                            <p class="text-red-400 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label for="group" class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Group *</label>
                        <select id="group" name="group" required 
                                class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg">
                            <option value="" class="bg-slate-800">Select Group</option>
                            <option value="general" class="bg-slate-800" {{ old('group') == 'general' ? 'selected' : '' }}>General</option>
                            <option value="social" class="bg-slate-800" {{ old('group') == 'social' ? 'selected' : '' }}>Social</option>
                            <option value="contact" class="bg-slate-800" {{ old('group') == 'contact' ? 'selected' : '' }}>Contact</option>
                            <option value="seo" class="bg-slate-800" {{ old('group') == 'seo' ? 'selected' : '' }}>SEO</option>
                            <option value="appearance" class="bg-slate-800" {{ old('group') == 'appearance' ? 'selected' : '' }}>Appearance</option>
                            <option value="security" class="bg-slate-800" {{ old('group') == 'security' ? 'selected' : '' }}>Security</option>
                        </select>
                        @error('group')
                            <p class="text-red-400 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="label" class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Display Label</label>
                        <input type="text" id="label" name="label" value="{{ old('label') }}" 
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg"
                               placeholder="e.g., Site Name, Logo">
                        @error('label')
                            <p class="text-red-400 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Description</label>
                    <textarea id="description" name="description" rows="3" 
                              class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg"
                              placeholder="Brief description of what this setting controls">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-400 text-sm mt-2 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div id="valueField">
                    <label for="value" class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Value *</label>
                    <input type="text" id="value" name="value" value="{{ old('value') }}" required 
                           class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg"
                           placeholder="Enter setting value">
                    @error('value')
                        <p class="text-red-400 text-sm mt-2 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div id="imageField" class="hidden">
                    <label for="image" class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Image File</label>
                    <input type="file" id="image" name="image" accept="image/*" 
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
                        <span class="relative z-10 font-semibold text-lg">Create Setting</span>
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
    initializeFormLogic();
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

    // Submit button animation
    gsap.fromTo('button[type="submit"]', {
        y: 30,
        opacity: 0
    }, {
        y: 0,
        opacity: 1,
        duration: 0.8,
        delay: 2,
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

function initializeFormLogic() {
    const typeSelect = document.getElementById('type');
    const valueField = document.getElementById('valueField');
    const imageField = document.getElementById('imageField');

    function toggleFields() {
        const selectedType = typeSelect.value;
        
        if (selectedType === 'image') {
            valueField.classList.add('hidden');
            imageField.classList.remove('hidden');
        } else {
            valueField.classList.remove('hidden');
            imageField.classList.add('hidden');
        }
    }

    typeSelect.addEventListener('change', toggleFields);
    toggleFields(); // Initial state
}
</script>
@endpush
