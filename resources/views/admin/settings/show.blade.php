@extends('layouts.app')

@section('title', 'Admin - View Setting')

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
                            SETTING DETAILS
                        </h1>
                        <div class="h-1 w-32 bg-gradient-to-r from-cyan-400 to-purple-600 rounded-full"></div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('admin.settings.edit', $setting) }}" 
                       class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500/20 to-purple-500/20 text-blue-300 border border-blue-400/30 rounded-xl hover:from-blue-500/30 hover:to-purple-500/30 transition-all duration-300 hover:scale-105">
                        <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="fas fa-edit mr-3 relative z-10"></i>
                        <span class="relative z-10 font-semibold">Edit Setting</span>
                    </a>
                    <button onclick="deleteSetting({{ $setting->id }}, '{{ $setting->key }}')" 
                            class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500/20 to-pink-500/20 text-red-300 border border-red-400/30 rounded-xl hover:from-red-500/30 hover:to-pink-500/30 transition-all duration-300 hover:scale-105">
                        <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="fas fa-trash mr-3 relative z-10"></i>
                        <span class="relative z-10 font-semibold">Delete Setting</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Setting Details -->
        <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
            <div class="p-8">
                <div class="flex items-center space-x-4 mb-8">
                    <div class="w-16 h-16 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-full flex items-center justify-center border border-cyan-400/30">
                        <i class="{{ $setting->type_icon }} text-2xl text-cyan-300"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-black text-white mb-2">{{ $setting->label ?? $setting->key }}</h2>
                        <p class="text-cyan-300/70 text-lg">{{ $setting->description ?? 'No description provided' }}</p>
                    </div>
                </div>
                
                <!-- Setting Meta Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="backdrop-blur-sm bg-white/5 border border-white/10 p-6 rounded-2xl hover:bg-white/10 transition-all duration-300 group">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-full flex items-center justify-center border border-cyan-400/30">
                                <i class="fas fa-key text-cyan-300"></i>
                            </div>
                            <h4 class="text-cyan-300 font-bold uppercase tracking-wider text-sm">Key</h4>
                        </div>
                        <p class="text-xl font-mono text-white">{{ $setting->key }}</p>
                    </div>
                    
                    <div class="backdrop-blur-sm bg-white/5 border border-white/10 p-6 rounded-2xl hover:bg-white/10 transition-all duration-300 group">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-full flex items-center justify-center border border-blue-400/30">
                                <i class="{{ $setting->type_icon }} text-blue-300"></i>
                            </div>
                            <h4 class="text-blue-300 font-bold uppercase tracking-wider text-sm">Type</h4>
                        </div>
                        <p class="text-xl font-bold text-white capitalize">{{ $setting->type }}</p>
                    </div>
                    
                    <div class="backdrop-blur-sm bg-white/5 border border-white/10 p-6 rounded-2xl hover:bg-white/10 transition-all duration-300 group">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-purple-500/20 to-pink-500/20 rounded-full flex items-center justify-center border border-purple-400/30">
                                <i class="{{ $setting->group_icon }} text-purple-300"></i>
                            </div>
                            <h4 class="text-purple-300 font-bold uppercase tracking-wider text-sm">Group</h4>
                        </div>
                        <p class="text-xl font-bold text-white capitalize">{{ $setting->group }}</p>
                    </div>
                    
                    <div class="backdrop-blur-sm bg-white/5 border border-white/10 p-6 rounded-2xl hover:bg-white/10 transition-all duration-300 group">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-green-500/20 to-emerald-500/20 rounded-full flex items-center justify-center border border-green-400/30">
                                <i class="fas fa-calendar-plus text-green-300"></i>
                            </div>
                            <h4 class="text-green-300 font-bold uppercase tracking-wider text-sm">Created</h4>
                        </div>
                        <p class="text-xl font-bold text-white">{{ $setting->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
                
                <!-- Setting Value -->
                <div class="mb-8">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-gradient-to-r from-yellow-500/20 to-orange-500/20 rounded-full flex items-center justify-center border border-yellow-400/30">
                            <i class="fas fa-value text-yellow-300"></i>
                        </div>
                        <h4 class="text-yellow-300 font-bold uppercase tracking-wider text-lg">Current Value</h4>
                    </div>
                    
                    <div class="backdrop-blur-sm bg-white/5 border border-white/10 p-6 rounded-2xl">
                        @if($setting->type === 'image')
                            @if($setting->value)
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $setting->value) }}" 
                                         alt="{{ $setting->label ?? $setting->key }}" 
                                         class="max-w-full h-auto max-h-96 rounded-2xl border-2 border-white/20 hover:border-cyan-400/50 transition-all duration-300">
                                    <p class="text-cyan-300/70 mt-3 text-sm">Image stored at: {{ $setting->value }}</p>
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <div class="w-32 h-32 bg-white/5 border-2 border-dashed border-white/20 rounded-2xl mx-auto flex items-center justify-center mb-4">
                                        <i class="fas fa-image text-4xl text-cyan-300/50"></i>
                                    </div>
                                    <p class="text-cyan-300/70">No image uploaded</p>
                                </div>
                            @endif
                        @elseif($setting->type === 'boolean')
                            <div class="text-center">
                                <span class="inline-flex items-center px-6 py-3 rounded-full text-2xl font-bold {{ $setting->value ? 'bg-green-500/20 text-green-300 border border-green-400/30' : 'bg-red-500/20 text-red-300 border border-red-400/30' }}">
                                    <i class="fas {{ $setting->value ? 'fa-check-circle' : 'fa-times-circle' }} mr-3"></i>
                                    {{ $setting->value ? 'Yes' : 'No' }}
                                </span>
                            </div>
                        @elseif($setting->type === 'json')
                            <div class="bg-slate-800/50 p-4 rounded-xl border border-white/10">
                                <pre class="text-cyan-300 font-mono text-sm overflow-x-auto">{{ $setting->display_value }}</pre>
                            </div>
                        @else
                            <div class="text-center">
                                <p class="text-3xl font-bold text-white break-all">{{ $setting->value }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Timestamps -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="backdrop-blur-sm bg-white/5 border border-white/10 p-6 rounded-2xl">
                        <h4 class="text-cyan-300 font-bold uppercase tracking-wider text-sm mb-3">Created At</h4>
                        <p class="text-white font-mono">{{ $setting->created_at->format('M d, Y \a\t g:i A') }}</p>
                    </div>
                    
                    <div class="backdrop-blur-sm bg-white/5 border border-white/10 p-6 rounded-2xl">
                        <h4 class="text-cyan-300 font-bold uppercase tracking-wider text-sm mb-3">Last Updated</h4>
                        <p class="text-white font-mono">{{ $setting->updated_at->format('M d, Y \a\t g:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black/80 backdrop-blur-xl z-50 hidden flex items-center justify-center p-4">
    <div class="backdrop-blur-xl bg-slate-800/90 border border-white/20 rounded-3xl p-8 max-w-md w-full shadow-2xl">
        <div class="flex items-center mb-6">
            <div class="w-16 h-16 bg-gradient-to-r from-red-500/20 to-pink-500/20 rounded-full flex items-center justify-center border border-red-400/30 mr-4">
                <i class="fas fa-exclamation-triangle text-red-400 text-2xl"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-white">Delete Setting</h3>
            </div>
        </div>
        <p class="text-cyan-300/80 mb-8 text-lg leading-relaxed">Are you sure you want to delete "<span id="deleteSettingKey" class="text-white font-semibold"></span>"? This action cannot be undone.</p>
        <div class="flex justify-end space-x-4">
            <button onclick="closeDeleteModal()" class="group relative px-6 py-3 bg-gradient-to-r from-gray-500/20 to-gray-600/20 text-gray-300 border border-gray-400/30 rounded-xl hover:from-gray-500/30 hover:to-gray-600/30 transition-all duration-300 hover:scale-105">
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <span class="relative font-semibold">Cancel</span>
            </button>
            <button id="confirmDeleteBtn" class="group relative px-6 py-3 bg-gradient-to-r from-red-500/20 to-pink-500/20 text-red-300 border border-red-400/30 rounded-xl hover:from-red-500/30 hover:to-pink-500/30 transition-all duration-300 hover:scale-105">
                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <span class="relative font-semibold">Delete</span>
            </button>
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

document.addEventListener('DOMContentLoaded', function() {
    initializeAnimations();
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

    // Action buttons animation
    gsap.fromTo('.flex.flex-col.sm\\:flex-row', {
        y: 50,
        opacity: 0
    }, {
        y: 0,
        opacity: 1,
        duration: 1,
        delay: 1,
        ease: "power2.out"
    });

    // Setting details animation
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

    // Meta cards animation
    gsap.fromTo('.grid.grid-cols-1.md\\:grid-cols-2 > div', {
        y: 30,
        opacity: 0
    }, {
        y: 0,
        opacity: 1,
        duration: 0.8,
        stagger: 0.1,
        delay: 1.5,
        ease: "power2.out"
    });

    // Value section animation
    gsap.fromTo('.mb-8', {
        y: 30,
        opacity: 0
    }, {
        y: 0,
        opacity: 1,
        duration: 0.8,
        delay: 1.8,
        ease: "power2.out"
    });

    // Timestamps animation
    gsap.fromTo('.grid.grid-cols-1.md\\:grid-cols-2:last-child', {
        y: 30,
        opacity: 0
    }, {
        y: 0,
        opacity: 1,
        duration: 0.8,
        delay: 2.1,
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
    document.querySelectorAll('button, a, .cursor-pointer').forEach(element => {
        element.addEventListener('mouseenter', () => {
            gsap.to(element, {
                scale: 1.05,
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

function deleteSetting(settingId, settingKey) {
    document.getElementById('deleteSettingKey').textContent = settingKey;
    
    // Animate modal appearance
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
    
    gsap.fromTo(modal, {
        scale: 0.8,
        opacity: 0,
        y: 50
    }, {
        scale: 1,
        opacity: 1,
        y: 0,
        duration: 0.5,
        ease: "back.out(1.7)"
    });
    
    document.getElementById('confirmDeleteBtn').onclick = () => {
        // Animate button click
        gsap.to(event.target, {
            scale: 0.95,
            duration: 0.1,
            yoyo: true,
            repeat: 1,
            ease: "power2.out"
        });

        fetch(`/admin/settings/${settingId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
        .then(response => {
            if (response.ok) {
                showMessage('Setting deleted successfully', 'success');
                setTimeout(() => window.location.href = '{{ route("admin.settings.index") }}', 1000);
            } else {
                showMessage('Failed to delete setting', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('An error occurred', 'error');
        });
        
        closeDeleteModal();
    };
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    gsap.to(modal, {
        scale: 0.8,
        opacity: 0,
        y: 50,
        duration: 0.3,
        ease: "power2.in",
        onComplete: () => modal.classList.add('hidden')
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
