@extends('layouts.app')

@section('title', $blog->title . ' - Awais Ahmad')
@section('description', $blog->excerpt)

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
        <!-- Breadcrumb Navigation -->
        <nav class="mb-8">
            <div class="flex items-center space-x-2 text-cyan-300/70">
                <a href="{{ route('home') }}" class="hover:text-cyan-300 transition-colors">Home</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <a href="{{ route('blog.index') }}" class="hover:text-cyan-300 transition-colors">Blog</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-white">{{ $blog->title }}</span>
            </div>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <article class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden">
                    <!-- Featured Image -->
                    @if($blog->featured_image)
                        <div class="relative overflow-hidden h-64 md:h-80">
                            <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" 
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $blog->status === 'published' ? 'bg-green-500/90 text-white' : 'bg-yellow-500/90 text-black' }}">
                                    {{ ucfirst($blog->status) }}
                                </span>
                            </div>
                        </div>
                    @endif

                    <!-- Article Header -->
                    <div class="p-6 md:p-8">
                        <!-- Category and Date -->
                        <div class="flex items-center gap-4 mb-4">
                            @if($blog->category)
                                <span class="px-3 py-1 text-sm font-semibold bg-purple-500/20 text-purple-300 rounded-full">
                                    {{ ucfirst($blog->category) }}
                                </span>
                            @endif
                            <span class="text-cyan-300/70">{{ $blog->formatted_published_date }}</span>
                            <div class="flex items-center gap-2 text-cyan-300/70">
                                <i class="fas fa-eye"></i>
                                <span>{{ $blog->views ?? 0 }} views</span>
                            </div>
                        </div>

                        <!-- Title -->
                        <h1 class="text-3xl md:text-4xl font-bold text-white mb-6 leading-tight">
                            {{ $blog->title }}
                        </h1>

                        <!-- Excerpt -->
                        @if($blog->excerpt)
                            <p class="text-xl text-cyan-200/80 mb-6 leading-relaxed">
                                {{ $blog->excerpt }}
                            </p>
                        @endif

                        <!-- Author Info -->
                        <div class="flex items-center gap-4 mb-8 p-4 bg-white/5 rounded-xl">
                            <div class="w-12 h-12 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white text-lg"></i>
                            </div>
                            <div>
                                <div class="text-white font-semibold">{{ $blog->author ?? 'Awais Ahmad' }}</div>
                                <div class="text-cyan-300/70 text-sm">Published {{ $blog->formatted_published_date }}</div>
                            </div>
                        </div>

                        <!-- Article Content -->
                        <div class="prose prose-lg prose-invert max-w-none">
                            <div class="text-cyan-200/90 leading-relaxed space-y-6">
                                {!! nl2br(e($blog->content)) !!}
                            </div>
                        </div>

                        <!-- Tags -->
                        @if($blog->tags && count($blog->tags) > 0)
                            <div class="mt-8 pt-6 border-t border-white/10">
                                <h3 class="text-lg font-semibold text-white mb-4">Tags</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($blog->tags as $tag)
                                        <a href="{{ route('blog.tag', $tag) }}" 
                                           class="px-3 py-1 text-sm bg-white/10 text-cyan-300 rounded-full hover:bg-cyan-500/20 transition-colors">
                                            #{{ $tag }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </article>

                <!-- Navigation -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($prevPost)
                        <a href="{{ route('blog.show', $prevPost->slug) }}" 
                           class="group bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-4 hover:bg-white/10 transition-all duration-300">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-chevron-left text-cyan-400 group-hover:text-cyan-300 transition-colors"></i>
                                <div>
                                    <div class="text-sm text-cyan-300/70 mb-1">Previous Post</div>
                                    <div class="text-white font-semibold group-hover:text-cyan-300 transition-colors line-clamp-2">
                                        {{ $prevPost->title }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif

                    @if($nextPost)
                        <a href="{{ route('blog.show', $nextPost->slug) }}" 
                           class="group bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-4 hover:bg-white/10 transition-all duration-300">
                            <div class="flex items-center gap-3">
                                <div class="text-right flex-1">
                                    <div class="text-sm text-cyan-300/70 mb-1">Next Post</div>
                                    <div class="text-white font-semibold group-hover:text-cyan-300 transition-colors line-clamp-2">
                                        {{ $nextPost->title }}
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-cyan-400 group-hover:text-cyan-300 transition-colors"></i>
                            </div>
                        </a>
                    @endif
                </div>

                <!-- Rating Section -->
                <div class="mt-12">
                    @include('components.rating', ['rateableType' => 'App\Models\Blog', 'rateableId' => $blog->id])
                </div>

                <!-- Comments Section -->
                <div class="mt-12">
                    @include('components.comments', ['commentableType' => 'App\Models\Blog', 'commentableId' => $blog->id])
                </div>

                <!-- Related Posts -->
                @if($relatedPosts && $relatedPosts->count() > 0)
                    <div class="mt-12">
                        <h2 class="text-2xl font-bold text-white mb-6">Related Posts</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($relatedPosts as $relatedPost)
                                <article class="group bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl overflow-hidden hover:bg-white/10 transition-all duration-500 hover:scale-105">
                                    @if($relatedPost->featured_image)
                                        <div class="relative overflow-hidden h-40">
                                            <img src="{{ $relatedPost->featured_image_url }}" alt="{{ $relatedPost->title }}" 
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                        </div>
                                    @endif

                                    <div class="p-4">
                                        <div class="flex items-center gap-2 mb-2">
                                            @if($relatedPost->category)
                                                <span class="px-2 py-1 text-xs font-semibold bg-purple-500/20 text-purple-300 rounded-full">
                                                    {{ ucfirst($relatedPost->category) }}
                                                </span>
                                            @endif
                                            <span class="text-xs text-cyan-300/70">{{ $relatedPost->formatted_published_date }}</span>
                                        </div>

                                        <h3 class="text-lg font-semibold text-white mb-2 group-hover:text-cyan-300 transition-colors line-clamp-2">
                                            <a href="{{ route('blog.show', $relatedPost->slug) }}">
                                                {{ $relatedPost->title }}
                                            </a>
                                        </h3>

                                        <p class="text-cyan-200/80 text-sm line-clamp-2 mb-3">
                                            {{ $relatedPost->excerpt }}
                                        </p>

                                        <div class="flex items-center justify-between text-xs text-cyan-300/70">
                                            <div class="flex items-center gap-1">
                                                <i class="fas fa-eye"></i>
                                                <span>{{ $relatedPost->views ?? 0 }}</span>
                                            </div>
                                            <a href="{{ route('blog.show', $relatedPost->slug) }}" 
                                               class="text-cyan-400 hover:text-cyan-300 transition-colors">
                                                Read More <i class="fas fa-arrow-right ml-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Popular Posts -->
                @if(isset($popularPosts) && $popularPosts->count() > 0)
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
                @endif

                <!-- Recent Posts -->
                @if(isset($recentPosts) && $recentPosts->count() > 0)
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
                @endif

                <!-- Categories -->
                @if(isset($categories) && count($categories) > 0)
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
                @endif

                <!-- Back to Blog -->
                <div class="bg-gradient-to-r from-cyan-500/10 to-purple-600/10 backdrop-blur-sm border border-cyan-500/20 rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-white mb-3">Explore More</h3>
                    <p class="text-cyan-200/80 text-sm mb-4">Discover more insights and tutorials in our blog.</p>
                    <a href="{{ route('blog.index') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-cyan-500 to-purple-600 text-white font-semibold rounded-xl hover:from-cyan-600 hover:to-purple-700 transition-all duration-300">
                        <i class="fas fa-arrow-left"></i>
                        Back to Blog
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const { gsap } = window;
        if (!gsap) return;

        // Header animations
        gsap.fromTo('article', 
            { y: 50, opacity: 0, scale: 0.95 }, 
            { y: 0, opacity: 1, scale: 1, duration: 1, ease: "power2.out" }
        );

        // Sidebar animations
        gsap.fromTo('.bg-white\\/5', 
            { x: 30, opacity: 0 }, 
            { x: 0, opacity: 1, duration: 0.8, stagger: 0.1, delay: 0.3, ease: "power2.out" }
        );

        // Floating background elements
        gsap.to('.absolute.-top-40', { y: -20, x: 20, duration: 8, repeat: -1, yoyo: true, ease: "power1.inOut" });
        gsap.to('.absolute.-bottom-40', { y: 20, x: -20, duration: 10, repeat: -1, yoyo: true, ease: "power1.inOut" });
        gsap.to('.absolute.top-1\\/2', { y: -30, x: 30, duration: 12, repeat: -1, yoyo: true, ease: "power1.inOut" });

        // Hover effects for cards
        document.querySelectorAll('.group').forEach(card => {
            card.addEventListener('mouseenter', () => {
                gsap.to(card, { scale: 1.02, duration: 0.3, ease: "power2.out" });
            });
            
            card.addEventListener('mouseleave', () => {
                gsap.to(card, { scale: 1, duration: 0.3, ease: "power2.out" });
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    gsap.to(window, { duration: 1, scrollTo: target, ease: "power2.inOut" });
                }
            });
        });
    });
</script>
@endpush

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .prose {
        color: #E0E0E0;
    }
    
    .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
        color: #FFFFFF;
        font-weight: 600;
    }
    
    .prose a {
        color: #06b6d4;
        text-decoration: none;
    }
    
    .prose a:hover {
        color: #0891b2;
        text-decoration: underline;
    }
    
    .prose code {
        background: rgba(0, 245, 255, 0.1);
        color: #06b6d4;
        padding: 0.2rem 0.4rem;
        border-radius: 0.25rem;
        font-size: 0.875em;
    }
    
    .prose pre {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(0, 245, 255, 0.2);
        border-radius: 0.5rem;
        padding: 1rem;
        overflow-x: auto;
    }
    
    .prose blockquote {
        border-left: 4px solid #06b6d4;
        background: rgba(0, 245, 255, 0.05);
        padding: 1rem;
        margin: 1rem 0;
        border-radius: 0 0.5rem 0.5rem 0;
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
