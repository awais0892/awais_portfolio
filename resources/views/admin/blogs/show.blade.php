@extends('layouts.app')

@section('title', 'Admin - View Blog Post')
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
                    BLOG POST
                </h1>
                <div class="h-1 w-32 bg-gradient-to-r from-cyan-400 to-purple-600 mx-auto rounded-full"></div>
            </div>
            <p class="text-cyan-300/80 text-xl mt-6 font-light tracking-wide">
                View and manage your blog content
            </p>
        </div>

        <!-- Navigation Buttons -->
        <div class="mb-8 flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('admin.blogs.index') }}" 
               class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 text-cyan-300 border border-cyan-400/30 rounded-xl hover:from-cyan-500/30 hover:to-blue-500/30 transition-all duration-300 hover:scale-105">
                <i class="fas fa-arrow-left mr-3"></i>
                <span class="font-semibold">Back to Blog Management</span>
            </a>
            <a href="{{ route('admin.blogs.edit', $blog) }}" 
               class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-500/20 to-orange-500/20 text-yellow-300 border border-yellow-400/30 rounded-xl hover:from-yellow-500/30 hover:to-orange-500/30 transition-all duration-300 hover:scale-105">
                <i class="fas fa-edit mr-3"></i>
                <span class="font-semibold">Edit Post</span>
            </a>
            <a href="{{ route('blog.show', $blog->slug) }}" target="_blank"
               class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500/20 to-emerald-500/20 text-green-300 border border-green-400/30 rounded-xl hover:from-green-500/30 hover:to-emerald-500/30 transition-all duration-300 hover:scale-105">
                <i class="fas fa-external-link-alt mr-3"></i>
                <span class="font-semibold">View Public</span>
            </a>
        </div>

        <!-- Blog Post Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Featured Image -->
                @if($blog->featured_image)
                    <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl overflow-hidden">
                        <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" 
                             class="w-full h-80 object-cover">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                    {{ $blog->status === 'published' ? 'bg-green-500/20 text-green-300' : 
                                       ($blog->status === 'draft' ? 'bg-yellow-500/20 text-yellow-300' : 'bg-gray-500/20 text-gray-300') }}">
                                    {{ ucfirst($blog->status) }}
                                </span>
                                <span class="text-sm text-cyan-300/70">{{ $blog->views ?? 0 }} views</span>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Post Content -->
                <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-8">
                    <h2 class="text-3xl font-bold text-white mb-6">{{ $blog->title }}</h2>
                    
                    @if($blog->excerpt)
                        <div class="bg-white/5 rounded-xl p-4 mb-6">
                            <h3 class="text-lg font-semibold text-cyan-300 mb-2">Excerpt</h3>
                            <p class="text-cyan-200/90 leading-relaxed">{{ $blog->excerpt }}</p>
                        </div>
                    @endif

                    <div class="bg-white/5 rounded-xl p-4 mb-6">
                        <h3 class="text-lg font-semibold text-cyan-300 mb-3">Content</h3>
                        <div class="text-cyan-200/90 leading-relaxed whitespace-pre-wrap">{{ $blog->content }}</div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-3 pt-6 border-t border-white/10">
                        <button onclick="toggleStatus('{{ $blog->id }}', '{{ $blog->status === 'published' ? 'draft' : 'published' }}')" 
                                class="px-4 py-2 {{ $blog->status === 'published' ? 'bg-yellow-600' : 'bg-green-600' }} text-white text-sm font-semibold rounded-lg hover:opacity-90 transition-all duration-300">
                            <i class="fas fa-{{ $blog->status === 'published' ? 'eye-slash' : 'eye' }} mr-2"></i>
                            {{ $blog->status === 'published' ? 'Unpublish' : 'Publish' }}
                        </button>
                        
                        <button onclick="deleteBlog('{{ $blog->id }}')" 
                                class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition-all duration-300">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Post
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Post Meta Card -->
                <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-6">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-cyan-400"></i>
                        Post Information
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-cyan-300/70">Status</span>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $blog->status === 'published' ? 'bg-green-500/20 text-green-300' : 
                                   ($blog->status === 'draft' ? 'bg-yellow-500/20 text-yellow-300' : 'bg-gray-500/20 text-gray-300') }}">
                                {{ ucfirst($blog->status) }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-cyan-300/70">Author</span>
                            <span class="text-white text-sm">{{ $blog->author }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-cyan-300/70">Created</span>
                            <span class="text-white text-sm">{{ $blog->created_at->format('M d, Y') }}</span>
                        </div>
                        
                        @if($blog->published_at)
                        <div class="flex justify-between items-center">
                            <span class="text-cyan-300/70">Published</span>
                            <span class="text-white text-sm">{{ $blog->published_at->format('M d, Y H:i') }}</span>
                        </div>
                        @endif

                        @if($blog->updated_at && $blog->updated_at != $blog->created_at)
                        <div class="flex justify-between items-center">
                            <span class="text-cyan-300/70">Last Updated</span>
                            <span class="text-white text-sm">{{ $blog->updated_at->diffForHumans() }}</span>
                        </div>
                        @endif

                        <div class="flex justify-between items-center">
                            <span class="text-cyan-300/70">Views</span>
                            <span class="text-white text-sm">{{ $blog->views ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <!-- Category and Tags Card -->
                <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-6">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-tags text-purple-400"></i>
                        Categories & Tags
                    </h3>
                    <div class="space-y-4">
                        @if($blog->category)
                        <div>
                            <span class="text-cyan-300/70 text-sm">Category:</span>
                            <div class="mt-1">
                                <span class="px-3 py-1 text-sm bg-purple-500/20 text-purple-300 rounded-full">
                                    {{ ucfirst($blog->category) }}
                                </span>
                            </div>
                        </div>
                        @endif

                        @if($blog->tags && count($blog->tags) > 0)
                        <div>
                            <span class="text-cyan-300/70 text-sm">Tags:</span>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach($blog->tags as $tag)
                                    <span class="px-2 py-1 text-xs bg-cyan-500/20 text-cyan-300 rounded-full">
                                        #{{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- SEO Information Card -->
                <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-6">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-search text-blue-400"></i>
                        SEO Information
                    </h3>
                    <div class="space-y-3">
                        @if($blog->meta_title)
                        <div>
                            <span class="text-cyan-300/70 text-sm">Meta Title:</span>
                            <p class="text-white text-sm mt-1">{{ $blog->meta_title }}</p>
                        </div>
                        @endif

                        @if($blog->meta_description)
                        <div>
                            <span class="text-cyan-300/70 text-sm">Meta Description:</span>
                            <p class="text-white text-sm mt-1">{{ $blog->meta_description }}</p>
                        </div>
                        @endif

                        @if($blog->meta_keywords)
                        <div>
                            <span class="text-cyan-300/70 text-sm">Meta Keywords:</span>
                            <p class="text-white text-sm mt-1">{{ $blog->meta_keywords }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-6">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-bolt text-yellow-400"></i>
                        Quick Actions
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.blogs.edit', $blog) }}" 
                           class="block w-full px-4 py-2 bg-yellow-600 text-white text-sm font-semibold rounded-lg hover:bg-yellow-700 transition-colors text-center">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Post
                        </a>
                        
                        <a href="{{ route('blog.show', $blog->slug) }}" target="_blank"
                           class="block w-full px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition-colors text-center">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            View Public
                        </a>
                        
                        <button onclick="copyUrl()" 
                                class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-copy mr-2"></i>
                            Copy URL
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 max-w-md w-full">
            <h3 class="text-lg font-bold text-white mb-4">Confirm Deletion</h3>
            <p class="text-cyan-200/80 mb-6">Are you sure you want to delete this blog post? This action cannot be undone.</p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" 
                        class="flex-1 px-4 py-2 bg-white/10 border border-white/20 text-white font-semibold rounded-lg hover:bg-white/20 transition-colors">
                    Cancel
                </button>
                <button onclick="confirmDelete()" 
                        class="flex-1 px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
                    Delete
                </button>
            </div>
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

        // Navigation buttons animation
        gsap.fromTo('a[href*="index"], a[href*="edit"], a[href*="show"]', 
            { x: -50, opacity: 0 }, 
            { x: 0, opacity: 1, duration: 1, delay: 0.8, ease: "power2.out", stagger: 0.1 }
        );

        // Content animation
        gsap.fromTo('.backdrop-blur-xl', 
            { y: 50, opacity: 0, scale: 0.95 }, 
            { y: 0, opacity: 1, scale: 1, duration: 1.2, delay: 1, ease: "power2.out" }
        );

        // Floating background elements
        gsap.to('.absolute.-top-40', { y: -20, x: 20, duration: 8, repeat: -1, yoyo: true, ease: "power1.inOut" });
        gsap.to('.absolute.-bottom-40', { y: 20, x: -20, duration: 10, repeat: -1, yoyo: true, ease: "power1.inOut" });
        gsap.to('.absolute.top-1\\/2', { y: -30, x: 30, duration: 12, repeat: -1, yoyo: true, ease: "power1.inOut" });
    }

    // Blog management functionality
    let blogToDelete = null;

    // Toggle blog status
    function toggleStatus(blogId, newStatus) {
        fetch(`/admin/blogs/${blogId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error updating status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating status');
        });
    }

    // Delete blog
    function deleteBlog(blogId) {
        blogToDelete = blogId;
        document.getElementById('delete-modal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
        blogToDelete = null;
    }

    function confirmDelete() {
        if (!blogToDelete) return;

        fetch(`/admin/blogs/${blogToDelete}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '{{ route("admin.blogs.index") }}';
            } else {
                alert('Error deleting blog');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting blog');
        });
    }

    // Utility functions
    function copyUrl() {
        const url = '{{ route("blog.show", $blog->slug) }}';
        navigator.clipboard.writeText(url).then(() => {
            alert('Blog URL copied to clipboard!');
        }).catch(() => {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = url;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            alert('Blog URL copied to clipboard!');
        });
    }
</script>
@endpush
