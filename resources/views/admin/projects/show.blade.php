@extends('layouts.app')

@section('title', 'Admin - View Project')

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
                            PROJECT DETAILS
                        </h1>
                        <div class="h-1 w-32 bg-gradient-to-r from-cyan-400 to-purple-600 rounded-full"></div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('admin.projects.edit', $project) }}" 
                       class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500/20 to-purple-500/20 text-blue-300 border border-blue-400/30 rounded-xl hover:from-blue-500/30 hover:to-purple-500/30 transition-all duration-300 hover:scale-105">
                        <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="fas fa-edit mr-3 relative z-10"></i>
                        <span class="relative z-10 font-semibold">Edit Project</span>
                    </a>
                    <button onclick="deleteProject({{ $project->id }}, '{{ $project->title }}')" 
                            class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500/20 to-pink-500/20 text-red-300 border border-red-400/30 rounded-xl hover:from-red-500/30 hover:to-pink-500/30 transition-all duration-300 hover:scale-105">
                        <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="fas fa-trash mr-3 relative z-10"></i>
                        <span class="relative z-10 font-semibold">Delete Project</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Project Details -->
        <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
            @if($project->image_url)
                <div class="relative group">
                    <img src="{{ $project->image_url }}" 
                         alt="{{ $project->title }}" 
                         class="w-full h-64 md:h-96 object-cover group-hover:scale-105 transition-transform duration-700"
                         onerror="this.onerror=null; this.src='https://via.placeholder.com/800x400/1a1a2e/16a085?text={{ urlencode($project->title) }}';">
                    
                    <!-- Project badges overlay -->
                    @if($project->featured || $project->is_active)
                        <div class="absolute top-6 right-6 flex flex-col gap-3">
                            @if($project->featured)
                                <span class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-yellow-400/20 to-orange-400/20 text-yellow-300 border border-yellow-400/30 rounded-full text-sm font-bold backdrop-blur-sm">
                                    <i class="fas fa-star mr-2 text-yellow-400"></i>Featured
                                </span>
                            @endif
                            @if($project->is_active)
                                <span class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500/20 to-emerald-500/20 text-green-300 border border-green-400/30 rounded-full text-sm font-bold backdrop-blur-sm">
                                    <i class="fas fa-check-circle mr-2 text-green-400"></i>Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-500/20 to-pink-500/20 text-red-300 border border-red-400/30 rounded-full text-sm font-bold backdrop-blur-sm">
                                    <i class="fas fa-times-circle mr-2 text-red-400"></i>Inactive
                                </span>
                            @endif
                        </div>
                    @endif
                    
                    <!-- Gradient overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>
            @endif
            
            <div class="p-8">
                <h2 class="text-4xl font-black text-white mb-8 tracking-tight">{{ $project->title }}</h2>
                
                <!-- Project Meta Information -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="backdrop-blur-sm bg-white/5 border border-white/10 p-6 rounded-2xl hover:bg-white/10 transition-all duration-300 group">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-full flex items-center justify-center border border-cyan-400/30">
                                <i class="fas fa-sort-numeric-up text-cyan-300"></i>
                            </div>
                            <h4 class="text-cyan-300 font-bold uppercase tracking-wider text-sm">Order</h4>
                        </div>
                        <p class="text-2xl font-bold text-white">{{ $project->order }}</p>
                    </div>
                    <div class="backdrop-blur-sm bg-white/5 border border-white/10 p-6 rounded-2xl hover:bg-white/10 transition-all duration-300 group">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-full flex items-center justify-center border border-blue-400/30">
                                <i class="fas fa-calendar-plus text-blue-300"></i>
                            </div>
                            <h4 class="text-blue-300 font-bold uppercase tracking-wider text-sm">Created</h4>
                        </div>
                        <p class="text-2xl font-bold text-white">{{ $project->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="backdrop-blur-sm bg-white/5 border border-white/10 p-6 rounded-2xl hover:bg-white/10 transition-all duration-300 group">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-purple-500/20 to-pink-500/20 rounded-full flex items-center justify-center border border-purple-400/30">
                                <i class="fas fa-clock text-purple-300"></i>
                    </div>
                            <h4 class="text-purple-300 font-bold uppercase tracking-wider text-sm">Updated</h4>
                    </div>
                        <p class="text-2xl font-bold text-white">{{ $project->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
                
                <!-- Project URLs -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    @if($project->live_url)
                        <div class="backdrop-blur-sm bg-white/5 border border-white/10 p-6 rounded-2xl hover:bg-white/10 transition-all duration-300 group">
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-green-500/20 to-emerald-500/20 rounded-full flex items-center justify-center border border-green-400/30">
                                    <i class="fas fa-external-link-alt text-green-300"></i>
                                </div>
                                <h4 class="text-green-300 font-bold uppercase tracking-wider text-sm">Live Demo</h4>
                            </div>
                            <a href="{{ $project->live_url }}" target="_blank" 
                               class="text-cyan-300 hover:text-cyan-200 break-all font-mono text-sm group-hover:text-cyan-200 transition-colors duration-300">
                                {{ $project->live_url }}
                            </a>
                        </div>
                    @endif
                    
                    @if($project->github_url)
                        <div class="backdrop-blur-sm bg-white/5 border border-white/10 p-6 rounded-2xl hover:bg-white/10 transition-all duration-300 group">
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-gray-500/20 to-slate-500/20 rounded-full flex items-center justify-center border border-gray-400/30">
                                    <i class="fab fa-github text-gray-300"></i>
                                </div>
                                <h4 class="text-gray-300 font-bold uppercase tracking-wider text-sm">Source Code</h4>
                            </div>
                            <a href="{{ $project->github_url }}" target="_blank" 
                               class="text-cyan-300 hover:text-cyan-200 break-all font-mono text-sm group-hover:text-cyan-200 transition-colors duration-300">
                                {{ $project->github_url }}
                            </a>
                        </div>
                    @endif
                </div>
                
                <!-- Technologies -->
                @if($project->technologies && count($project->technologies) > 0)
                    <div class="mb-8">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-full flex items-center justify-center border border-cyan-400/30">
                                <i class="fas fa-code text-cyan-300"></i>
                            </div>
                            <h4 class="text-cyan-300 font-bold uppercase tracking-wider text-lg">Technologies</h4>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            @foreach($project->technologies as $tech)
                                <span class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 text-cyan-300 border border-cyan-400/30 rounded-full text-sm font-bold backdrop-blur-sm hover:from-cyan-500/30 hover:to-blue-500/30 transition-all duration-300 hover:scale-105">
                                    {{ $tech }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Description -->
                <div class="mb-8">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-full flex items-center justify-center border border-blue-400/30">
                            <i class="fas fa-info-circle text-blue-300"></i>
                        </div>
                        <h4 class="text-blue-300 font-bold uppercase tracking-wider text-lg">Description</h4>
                    </div>
                    <div class="backdrop-blur-sm bg-white/5 border border-white/10 p-6 rounded-2xl">
                        <p class="text-gray-200 leading-relaxed text-lg">{{ $project->description }}</p>
                    </div>
                </div>
                
                <!-- Long Description -->
                @if($project->long_description)
                    <div class="mb-8">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-r from-purple-500/20 to-pink-500/20 rounded-full flex items-center justify-center border border-purple-400/30">
                                <i class="fas fa-file-alt text-purple-300"></i>
                            </div>
                            <h4 class="text-purple-300 font-bold uppercase tracking-wider text-lg">Detailed Description</h4>
                        </div>
                        <div class="backdrop-blur-sm bg-white/5 border border-white/10 p-6 rounded-2xl">
                        <div class="prose prose-invert max-w-none">
                                <p class="text-gray-200 leading-relaxed text-lg">{{ $project->long_description }}</p>
                            </div>
                        </div>
                    </div>
                @endif
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
                <h3 class="text-2xl font-bold text-white">Delete Project</h3>
            </div>
        </div>
        <p class="text-cyan-300/80 mb-8 text-lg leading-relaxed">Are you sure you want to delete "<span id="deleteProjectName" class="text-white font-semibold"></span>"? This action cannot be undone.</p>
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

    // Project details animation
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
    gsap.fromTo('.grid.grid-cols-1.md\\:grid-cols-3 > div', {
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

    // URL cards animation
    gsap.fromTo('.grid.grid-cols-1.md\\:grid-cols-2 > div', {
        x: -50,
        opacity: 0
    }, {
        x: 0,
        opacity: 1,
        duration: 0.8,
        stagger: 0.1,
        delay: 1.8,
        ease: "power2.out"
    });

    // Technologies animation
    gsap.fromTo('.flex.flex-wrap.gap-3 > span', {
        scale: 0,
        opacity: 0
    }, {
        scale: 1,
        opacity: 1,
        duration: 0.6,
        stagger: 0.05,
        delay: 2.1,
        ease: "back.out(1.7)"
    });

    // Description sections animation
    gsap.fromTo('.mb-8:not(.grid)', {
        y: 30,
        opacity: 0
    }, {
        y: 0,
        opacity: 1,
        duration: 0.8,
        stagger: 0.2,
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

function deleteProject(projectId, projectName) {
    document.getElementById('deleteProjectName').textContent = projectName;
    
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

        fetch(`/admin/projects/${projectId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
        .then(response => {
            if (response.ok) {
                showMessage('Project deleted successfully', 'success');
                setTimeout(() => window.location.href = '{{ route("admin.projects.index") }}', 1000);
            } else {
                showMessage('Failed to delete project', 'error');
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
