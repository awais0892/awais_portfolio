@extends('layouts.app')

@section('title','Site Settings')
@section('page-title','Settings')

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

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header Section -->
        <div class="mb-12 text-center">
            <div class="inline-block">
                <h1 class="text-6xl font-black bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 bg-clip-text text-transparent mb-4 tracking-tight">
                    SITE SETTINGS
                </h1>
                <div class="h-1 w-32 bg-gradient-to-r from-cyan-400 to-purple-600 mx-auto rounded-full"></div>
            </div>
            <p class="text-cyan-300/80 text-xl mt-6 font-light tracking-wide">
                Manage your website configuration and preferences
            </p>
        </div>

        <!-- Action Button -->
        <div class="text-center mb-12">
            <a href="{{ route('admin.settings.create') }}" 
               class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold text-lg rounded-2xl overflow-hidden transition-all duration-500 hover:scale-105 hover:shadow-2xl hover:shadow-cyan-500/25">
                <div class="absolute inset-0 bg-gradient-to-r from-cyan-600 to-blue-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="relative flex items-center">
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-plus text-white text-sm"></i>
                    </div>
                    <span class="tracking-wider">CREATE NEW SETTING</span>
                </div>
                <div class="absolute -inset-1 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-2xl blur opacity-30 group-hover:opacity-100 transition-opacity duration-300"></div>
            </a>
        </div>

        <!-- Settings Form -->
        <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-8 shadow-2xl">
            <form method="POST" action="{{ route('admin.settings.bulk-update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        @foreach($settings as $group => $items)
                    <div class="mb-8">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-full flex items-center justify-center border border-cyan-400/30">
                                @php
                                    $groupIcon = match($group) {
                                        'general' => 'fas fa-cog',
                                        'social' => 'fas fa-share-alt',
                                        'contact' => 'fas fa-envelope',
                                        'seo' => 'fas fa-search',
                                        'appearance' => 'fas fa-palette',
                                        'security' => 'fas fa-shield-alt',
                                        default => 'fas fa-folder'
                                    };
                                @endphp
                                <i class="{{ $groupIcon }} text-cyan-300"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-cyan-300 uppercase tracking-wider">{{ ucwords(str_replace('_',' ', $group)) }}</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($items as $item)
                                <div class="backdrop-blur-sm bg-white/5 border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all duration-300">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex-1">
                                            <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-2">
                                                {{ $item->label ?? $item->key }}
                                            </label>
                                            @if($item->description)
                                                <p class="text-cyan-300/70 text-sm mb-3">{{ $item->description }}</p>
                                            @endif
                                        </div>
                                        <div class="flex items-center space-x-2 ml-4">
                                            <a href="{{ route('admin.settings.show', $item) }}" 
                                               class="text-cyan-400 hover:text-cyan-300 transition-colors duration-300" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.settings.edit', $item) }}" 
                                               class="text-blue-400 hover:text-blue-300 transition-colors duration-300" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                    
                            @if($item->type === 'text')
                                        <input name="{{ $item->key }}" value="{{ old($item->key, $item->value) }}" 
                                               class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300" />
                                    @elseif($item->type === 'textarea')
                                        <textarea name="{{ $item->key }}" rows="3" 
                                                  class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">{{ old($item->key, $item->value) }}</textarea>
                            @elseif($item->type === 'image')
                                        <div class="space-y-3">
                                    @if($item->value)
                                                <div class="flex items-center space-x-3">
                                                    <img src="{{ asset('storage/' . $item->value) }}" alt="" class="h-16 w-16 object-cover rounded-lg border border-white/20" />
                                                    <span class="text-cyan-300/70 text-sm">{{ basename($item->value) }}</span>
                                </div>
                            @endif
                                            <input type="file" name="{{ $item->key }}" accept="image/*" 
                                                   class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gradient-to-r file:from-cyan-500 file:to-blue-600 file:text-white hover:file:from-cyan-600 hover:file:to-blue-700 transition-all duration-300" />
                                        </div>
                                    @elseif($item->type === 'boolean')
                                        <div class="flex items-center space-x-3">
                                            <input type="checkbox" name="{{ $item->key }}" value="1" {{ $item->value ? 'checked' : '' }}
                                                   class="w-5 h-5 rounded-lg border-white/30 text-cyan-500 focus:ring-cyan-400 bg-white/10">
                                            <span class="text-cyan-300">{{ $item->value ? 'Enabled' : 'Disabled' }}</span>
                                        </div>
                                    @elseif($item->type === 'json')
                                        <textarea name="{{ $item->key }}" rows="3" 
                                                  class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 font-mono text-sm">{{ old($item->key, is_array($item->value) ? json_encode($item->value, JSON_PRETTY_PRINT) : $item->value) }}</textarea>
                                    @else
                                        <input type="{{ $item->type === 'number' ? 'number' : 'text' }}" name="{{ $item->key }}" 
                                               value="{{ old($item->key, $item->value) }}" 
                                               class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300" />
                                    @endif
                                    
                                    <div class="flex items-center justify-between mt-3">
                                        <span class="text-xs text-cyan-300/50 font-mono">{{ $item->key }}</span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-cyan-500/20 to-blue-500/20 text-cyan-300 border border-cyan-400/30">
                                            <i class="{{ $item->type_icon }} mr-1"></i>{{ ucfirst($item->type) }}
                                        </span>
                                    </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="flex justify-end">
                    <button type="submit" 
                            class="group relative inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 text-cyan-300 border border-cyan-400/30 rounded-xl hover:from-cyan-500/30 hover:to-blue-500/30 transition-all duration-300 hover:scale-105">
                        <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="fas fa-save mr-3 relative z-10"></i>
                        <span class="relative z-10 font-semibold text-lg">Save All Settings</span>
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

    // Action button animation
    gsap.fromTo('a[href*="create"]', {
        y: 50,
        opacity: 0,
        rotation: -5
    }, {
        y: 0,
        opacity: 1,
        rotation: 0,
        duration: 1.2,
        delay: 1,
        ease: "elastic.out(1, 0.5)"
    });

    // Settings form animation
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

    // Group sections animation
    gsap.fromTo('.mb-8', {
        y: 30,
        opacity: 0
    }, {
        y: 0,
        opacity: 1,
        duration: 0.8,
        stagger: 0.2,
        delay: 1.5,
        ease: "power2.out"
    });

    // Setting items animation
    gsap.fromTo('.backdrop-blur-sm', {
        y: 30,
        opacity: 0
    }, {
        y: 0,
        opacity: 1,
        duration: 0.6,
        stagger: 0.05,
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
        delay: 2.5,
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
    document.querySelectorAll('button, a, input, textarea').forEach(element => {
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
    // Create message container if it doesn't exist
    let container = document.getElementById('messageContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'messageContainer';
        container.className = 'fixed top-6 right-6 z-50';
        document.body.appendChild(container);
    }
    
    const messageClass = type === 'success' 
        ? 'backdrop-blur-xl bg-gradient-to-r from-green-500/20 to-emerald-500/20 border border-green-400/30 text-green-300 px-8 py-4 rounded-2xl shadow-2xl flex items-center'
        : 'backdrop-blur-xl bg-gradient-to-r from-red-500/20 to-pink-500/20 border border-red-400/30 text-red-300 px-8 py-4 rounded-2xl shadow-2xl flex items-center';
    
    container.innerHTML = `
        <div class="${messageClass}">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-3 text-${type === 'success' ? 'green' : 'red'}-400"></i>
            <span class="font-semibold">${message}</span>
        </div>
    `;
    
    // Animate message appearance
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
            onComplete: () => container.remove()
        });
    }, 3000);
}
</script>
@endpush
