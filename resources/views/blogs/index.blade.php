@extends('layouts.app')

@section('title', 'Blog | Awais Ahmad')
@section('description', 'Explore insights, tutorials, and thoughts on web development, design, and technology by Awais Ahmad.')

@section('content')
    <section class="relative py-20">
        <div class="mx-auto max-w-6xl">
            <div class="mb-14 max-w-3xl">
                <p class="text-sm uppercase tracking-[0.28em] text-cyan-300/70 gsap-reveal">Latest Insights</p>
                <h1 class="mt-4 text-balance text-5xl font-orbitron text-white gsap-reveal sm:text-6xl">
                    Thoughts on Code, Design & Technology
                </h1>
                <p class="mt-5 max-w-2xl text-pretty text-lg leading-8 text-slate-300 gsap-reveal" data-gsap-delay="0.08">
                    A collection of articles, tutorials, and insights covering web development, software engineering,
                    and the latest trends in technology.
                </p>
            </div>

            <!-- Search and Filter Section -->
            <div class="glass-card mb-12 rounded-[1.75rem] border border-white/10 bg-slate-950/55 p-6 gsap-reveal" data-gsap-delay="0.16">
                <div class="flex flex-col gap-4 md:flex-row md:items-center">
                    <!-- Search Form -->
                    <form action="{{ route('blog.search') }}" method="GET" class="flex-1">
                        <div class="relative">
                            <input type="text" name="search" placeholder="Search articles..."
                                   value="{{ request('search', request('q')) }}"
                                   class="w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 pl-12 text-white placeholder:text-slate-500 focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400">
                            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        </div>
                    </form>

                    <!-- Category Filter -->
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('blog.index') }}"
                           class="rounded-2xl px-4 py-2 text-sm font-medium transition-colors {{ !request('category') ? 'bg-cyan-400 text-slate-950' : 'border border-white/10 bg-white/5 text-slate-300 hover:bg-white/10' }}">
                            All Posts
                        </a>
                        @foreach($categories ?? [] as $category)
                            <a href="{{ route('blog.index', ['category' => $category]) }}"
                               class="rounded-2xl px-4 py-2 text-sm font-medium transition-colors {{ request('category') === $category ? 'bg-cyan-400 text-slate-950' : 'border border-white/10 bg-white/5 text-slate-300 hover:bg-white/10' }}">
                                {{ $category }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            @if($blogs->count())
                <!-- Blog Posts Grid -->
                <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-3">
                    @foreach($blogs as $post)
                        <article class="glass-card gsap-reveal overflow-hidden rounded-[1.75rem] border border-white/10 bg-slate-950/55"
                                data-gsap-delay="{{ ($loop->index % 6) * 0.06 }}">
                            <a href="{{ route('blog.show', $post->slug) }}" class="block">
                                <div class="aspect-video overflow-hidden">
                                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}"
                                        class="h-full w-full object-cover transition-transform duration-300 hover:scale-105" loading="lazy">
                                </div>
                            </a>
                            <div class="p-6">
                                <div class="mb-4 flex flex-wrap items-center gap-2">
                                    @if($post->category)
                                        <span class="rounded-full bg-cyan-400/15 px-3 py-1 text-xs font-semibold text-cyan-200">
                                            {{ $post->category }}
                                        </span>
                                    @endif
                                    <span class="rounded-full bg-slate-700/70 px-3 py-1 text-xs font-semibold text-slate-200">
                                        {{ $post->read_time }}
                                    </span>
                                </div>

                                <div class="mb-4">
                                    <h2 class="text-xl font-orbitron text-white hover:text-cyan-400 transition-colors">
                                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                    </h2>
                                    <p class="mt-2 text-sm leading-6 text-slate-300">
                                        {{ $post->excerpt }}
                                    </p>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3 text-sm text-slate-400">
                                        <span>{{ $post->formatted_published_date }}</span>
                                        <span>•</span>
                                        <span>{{ $post->author }}</span>
                                    </div>
                                    <div class="flex items-center gap-1 text-sm text-slate-400">
                                        <i class="fa-solid fa-eye"></i>
                                        <span>{{ number_format($post->views) }}</span>
                                    </div>
                                </div>

                                @if($post->tags && count($post->tags) > 0)
                                    <div class="mt-4 flex flex-wrap gap-2">
                                        @foreach(array_slice($post->tags, 0, 3) as $tag)
                                            <a href="{{ route('blog.tag', $tag) }}"
                                               class="rounded-full bg-slate-800/70 px-3 py-1 text-xs text-slate-300 hover:bg-slate-700 transition-colors">
                                                #{{ $tag }}
                                            </a>
                                        @endforeach
                                        @if(count($post->tags) > 3)
                                            <span class="rounded-full bg-slate-800/70 px-3 py-1 text-xs text-slate-300">
                                                +{{ count($post->tags) - 3 }} more
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center gsap-reveal" data-gsap-delay="0.24">
                    {{ $blogs->links() }}
                </div>
            @else
                <!-- No Posts Found -->
                <div class="glass-card rounded-[1.75rem] border border-white/10 bg-slate-950/55 p-12 text-center gsap-reveal" data-gsap-delay="0.16">
                    <i class="fa-solid fa-newspaper text-6xl text-slate-600 mb-6"></i>
                    <h3 class="text-2xl font-orbitron text-white mb-4">No Articles Found</h3>
                    <p class="text-slate-400 mb-6">We couldn't find any blog posts matching your criteria.</p>
                    <a href="{{ route('blog.index') }}"
                       class="inline-flex items-center gap-2 rounded-2xl bg-cyan-400 px-6 py-3 text-sm font-semibold text-slate-950 transition-colors hover:bg-cyan-300">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>View All Posts</span>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Sidebar Content (Popular & Recent Posts) -->
    @if(($popularPosts->count() > 0 || $recentPosts->count() > 0) && $blogs->count() > 0)
        <section class="relative py-20">
            <div class="mx-auto max-w-6xl">
                <div class="grid gap-8 lg:grid-cols-2">
                    <!-- Popular Posts -->
                    @if($popularPosts->count() > 0)
                        <div class="glass-card rounded-[1.75rem] border border-white/10 bg-slate-950/55 p-8 gsap-reveal" data-gsap-delay="0.08">
                            <h3 class="text-xl font-orbitron text-white mb-6">Most Popular</h3>
                            <div class="space-y-4">
                                @foreach($popularPosts as $post)
                                    <article class="flex gap-4">
                                        <a href="{{ route('blog.show', $post->slug) }}" class="flex-shrink-0">
                                            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}"
                                                class="h-16 w-16 rounded-xl object-cover" loading="lazy">
                                        </a>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-semibold text-white hover:text-cyan-400 transition-colors">
                                                <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                            </h4>
                                            <div class="mt-1 flex items-center gap-2 text-xs text-slate-400">
                                                <span>{{ $post->formatted_published_date }}</span>
                                                <span>•</span>
                                                <span>{{ number_format($post->views) }} views</span>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Recent Posts -->
                    @if($recentPosts->count() > 0)
                        <div class="glass-card rounded-[1.75rem] border border-white/10 bg-slate-950/55 p-8 gsap-reveal" data-gsap-delay="0.16">
                            <h3 class="text-xl font-orbitron text-white mb-6">Recent Posts</h3>
                            <div class="space-y-4">
                                @foreach($recentPosts as $post)
                                    <article class="flex gap-4">
                                        <a href="{{ route('blog.show', $post->slug) }}" class="flex-shrink-0">
                                            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}"
                                                class="h-16 w-16 rounded-xl object-cover" loading="lazy">
                                        </a>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-semibold text-white hover:text-cyan-400 transition-colors">
                                                <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                            </h4>
                                            <div class="mt-1 flex items-center gap-2 text-xs text-slate-400">
                                                <span>{{ $post->formatted_published_date }}</span>
                                                <span>•</span>
                                                <span>{{ $post->read_time }}</span>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif
                            <option value="{{ route('blog.category', $category) }}" 
                                    {{ request()->is('blog/category/'.$category) ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

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
                        <i class="fas fa-blog"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-2">No Blog Posts Found</h3>
                    <p class="text-cyan-200/80">Check back later for new content!</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($blogs->hasPages())
            <div class="flex justify-center">
                {{ $blogs->links('components.pagination') }}
            </div>
        @endif

        <!-- Sidebar Content (if any) -->
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

        // Search and filter section animation
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
                ease: "power2.out",
                scrollTrigger: {
                    trigger: 'article',
                    start: "top 80%",
                    end: "bottom 20%",
                    toggleActions: "play none none reverse"
                }
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
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
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
