@extends('layouts.app')

@section('title', 'Search Results - Blog - Awais Ahmad')
@section('page-title', 'Search Results')

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

    <!-- Content Container -->
    <div class="relative z-10 container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-6xl font-bold bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-400 bg-clip-text text-transparent mb-6">
                Search Results
            </h1>
            <p class="text-xl text-cyan-200/80 max-w-2xl mx-auto">
                Find the content you're looking for
            </p>
        </div>

        <!-- Breadcrumb Navigation -->
        <nav class="mb-8">
            <div class="flex items-center space-x-2 text-cyan-300/70">
                <a href="{{ route('home') }}" class="hover:text-cyan-300 transition-colors">Home</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ route('blog.index') }}" class="hover:text-cyan-300 transition-colors">Blog</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-white">Search Results</span>
            </div>
        </nav>

        <!-- Search Form -->
        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 mb-8">
            <form action="{{ route('blog.search') }}" method="GET" class="relative">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" placeholder="Search blog posts..." 
                               value="{{ request('search') }}"
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-6 py-4 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-lg">
                    </div>
                    <button type="submit" class="px-8 py-4 bg-gradient-to-r from-cyan-500 to-purple-600 text-white font-semibold rounded-xl hover:from-cyan-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-search mr-2"></i>
                        Search
                    </button>
                </div>
            </form>
        </div>

        <!-- Search Results -->
        @if(request('search'))
            <div class="mb-6">
                <p class="text-cyan-200/80">
                    Found {{ $blogs->total() }} result{{ $blogs->total() !== 1 ? 's' : '' }} for 
                    <span class="text-cyan-300 font-semibold">"{{ request('search') }}"</span>
                </p>
            </div>
        @endif

        <!-- Blog Posts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @forelse($blogs as $blog)
                <article class="group bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden hover:bg-white/10 transition-all duration-500 hover:scale-105 hover:shadow-2xl hover:shadow-purple-500/25">
                    <!-- Featured Image -->
                    @if($blog->featured_image)
                        <div class="relative overflow-hidden h-48">
                            <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $blog->status === 'published' ? 'bg-green-500/90 text-white' : 'bg-yellow-500/90 text-black' }}">
                                    {{ ucfirst($blog->status) }}
                                </span>
                            </div>
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="p-6">
                        <!-- Category and Date -->
                        <div class="flex items-center gap-3 mb-3">
                            @if($blog->category)
                                <span class="px-3 py-1 text-xs font-semibold bg-purple-500/20 text-purple-300 rounded-full">
                                    {{ ucfirst($blog->category) }}
                                </span>
                            @endif
                            <span class="text-sm text-cyan-300/70">{{ $blog->formatted_published_date }}</span>
                        </div>

                        <!-- Title -->
                        <h2 class="text-xl font-bold text-white mb-3 group-hover:text-cyan-300 transition-colors duration-300">
                            <a href="{{ route('blog.show', $blog->slug) }}" class="hover:text-cyan-300 transition-colors">
                                {{ $blog->title }}
                            </a>
                        </h2>

                        <!-- Excerpt -->
                        <p class="text-cyan-200/80 mb-4 line-clamp-3">
                            {{ $blog->excerpt }}
                        </p>

                        <!-- Meta Information -->
                        <div class="flex items-center justify-between text-sm text-cyan-300/70">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-user"></i>
                                <span>{{ $blog->author ?? 'Anonymous' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-eye"></i>
                                <span>{{ $blog->views ?? 0 }}</span>
                            </div>
                        </div>

                        <!-- Tags -->
                        @if($blog->tags && count($blog->tags) > 0)
                            <div class="flex flex-wrap gap-2 mt-4">
                                @foreach(array_slice($blog->tags, 0, 3) as $tag)
                                    <a href="{{ route('blog.tag', $tag) }}" 
                                       class="px-2 py-1 text-xs bg-white/10 text-cyan-300 rounded-full hover:bg-cyan-500/20 transition-colors">
                                        #{{ $tag }}
                                    </a>
                                @endforeach
                                @if(count($blog->tags) > 3)
                                    <span class="px-2 py-1 text-xs text-cyan-300/50">+{{ count($blog->tags) - 3 }} more</span>
                                @endif
                            </div>
                        @endif

                        <!-- Read More Button -->
                        <div class="mt-6">
                            <a href="{{ route('blog.show', $blog->slug) }}" 
                               class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-cyan-500 to-purple-600 text-white font-semibold rounded-xl hover:from-cyan-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
                                Read More
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="text-6xl text-purple-400/50 mb-4">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">No Results Found</h3>
                    <p class="text-cyan-200/80 mb-6">
                        @if(request('search'))
                            No posts found for "{{ request('search') }}". Try a different search term.
                        @else
                            Enter a search term to find blog posts.
                        @endif
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('blog.index') }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-cyan-500 to-purple-600 text-white font-semibold rounded-xl hover:from-cyan-600 hover:to-purple-700 transition-all duration-300">
                            <i class="fas fa-arrow-left"></i>
                            Back to Blog
                        </a>
                        @if(request('search'))
                            <button onclick="document.querySelector('input[name=search]').focus()" 
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 text-white font-semibold rounded-xl hover:bg-white/20 transition-all duration-300">
                                <i class="fas fa-search"></i>
                                Try Again
                            </button>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($blogs->hasPages())
            <div class="flex justify-center">
                {{ $blogs->links('components.pagination') }}
            </div>
        @endif

        <!-- Sidebar Content -->
        @if(isset($popularPosts) || isset($recentPosts))
            <div class="mt-16 grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Popular Posts -->
                @if(isset($popularPosts) && $popularPosts->count() > 0)
                    <div class="lg:col-span-1">
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
                            <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                                <i class="fas fa-fire text-orange-400"></i>
                                Popular Posts
                            </h3>
                            <div class="space-y-4">
                                @foreach($popularPosts as $post)
                                    <a href="{{ route('blog.show', $post->slug) }}" 
                                       class="block p-3 rounded-xl bg-white/5 hover:bg-white/10 transition-colors">
                                        <h4 class="font-semibold text-white mb-1 line-clamp-2">{{ $post->title }}</h4>
                                        <div class="flex items-center gap-2 text-sm text-cyan-300/70">
                                            <i class="fas fa-eye"></i>
                                            <span>{{ $post->views ?? 0 }} views</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Recent Posts -->
                @if(isset($recentPosts) && $recentPosts->count() > 0)
                    <div class="lg:col-span-1">
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
                            <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                                <i class="fas fa-clock text-blue-400"></i>
                                Recent Posts
                            </h3>
                            <div class="space-y-4">
                                @foreach($recentPosts as $post)
                                    <a href="{{ route('blog.show', $post->slug) }}" 
                                       class="block p-3 rounded-xl bg-white/5 hover:bg-white/10 transition-colors">
                                        <h4 class="font-semibold text-white mb-1 line-clamp-2">{{ $post->title }}</h4>
                                        <div class="text-sm text-cyan-300/70">{{ $post->formatted_published_date }}</div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Categories -->
                @if(isset($categories) && count($categories) > 0)
                    <div class="lg:col-span-1">
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
                            <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                                <i class="fas fa-tags text-green-400"></i>
                                Categories
                            </h3>
                            <div class="space-y-2">
                                @foreach($categories as $category)
                                    <a href="{{ route('blog.category', $category) }}" 
                                       class="block p-3 rounded-xl bg-white/5 hover:bg-white/10 transition-colors">
                                        <span class="text-white font-medium">{{ ucfirst($category) }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const { gsap } = window;
        if (!gsap) return;

        // Header animations
        gsap.fromTo('.text-6xl', 
            { y: 100, opacity: 0, scale: 0.8 }, 
            { y: 0, opacity: 1, scale: 1, duration: 1.5, ease: "back.out(1.7)" }
        );

        gsap.fromTo('.text-xl', 
            { y: 50, opacity: 0 }, 
            { y: 0, opacity: 1, duration: 1, delay: 0.3, ease: "power2.out" }
        );

        // Search form animation
        gsap.fromTo('.bg-white\\/5', 
            { y: 30, opacity: 0 }, 
            { y: 0, opacity: 1, duration: 0.8, delay: 0.5, ease: "power2.out" }
        );

        // Blog post cards staggered animation
        gsap.fromTo('article', 
            { y: 50, opacity: 0, scale: 0.9 }, 
            { 
                y: 0, 
                opacity: 1, 
                scale: 1, 
                duration: 0.8, 
                stagger: 0.1, 
                delay: 0.8,
                ease: "power2.out"
            }
        );

        // Floating background elements
        gsap.to('.absolute.-top-40', { y: -20, x: 20, duration: 8, repeat: -1, yoyo: true, ease: "power1.inOut" });
        gsap.to('.absolute.-bottom-40', { y: 20, x: -20, duration: 10, repeat: -1, yoyo: true, ease: "power1.inOut" });
        gsap.to('.absolute.top-1\\/2', { y: -30, x: 30, duration: 12, repeat: -1, yoyo: true, ease: "power1.inOut" });

        // Hover effects for blog cards
        document.querySelectorAll('article').forEach(card => {
            card.addEventListener('mouseenter', () => {
                gsap.to(card, { scale: 1.02, duration: 0.3, ease: "power2.out" });
            });
            
            card.addEventListener('mouseleave', () => {
                gsap.to(card, { scale: 1, duration: 0.3, ease: "power2.out" });
            });
        });

        // Auto-focus search input if empty
        const searchInput = document.querySelector('input[name=search]');
        if (searchInput && !searchInput.value) {
            searchInput.focus();
        }
    });
</script>
@endpush

@push('styles')
<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: linear-gradient(45deg, #06b6d4, #8b5cf6);
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(45deg, #0891b2, #7c3aed);
    }
</style>
@endpush
