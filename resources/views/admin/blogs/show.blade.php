@extends('layouts.admin')

@section('title', 'View Blog Post')
@section('page-title', 'Blog Post Details')
@section('page-subtitle', 'View and manage your blog content.')

@section('page-actions')
    <div class="flex items-center gap-3">
        <a href="{{ route('blog.show', $blog->slug) }}" target="_blank"
            class="admin-focus inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-semibold text-slate-200 transition-colors duration-200 hover:bg-white/10">
            <i class="fa-solid fa-external-link" aria-hidden="true"></i>
            <span>View Public</span>
        </a>
        <a href="{{ route('admin.blogs.edit', $blog) }}"
            class="admin-focus inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-semibold text-slate-200 transition-colors duration-200 hover:bg-white/10">
            <i class="fa-solid fa-edit" aria-hidden="true"></i>
            <span>Edit Post</span>
        </a>
        <a href="{{ route('admin.blogs.index') }}"
            class="admin-focus inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-semibold text-slate-200 transition-colors duration-200 hover:bg-white/10">
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
            <span>Back to Blogs</span>
        </a>
    </div>
@endsection

@section('content')
    <div class="grid gap-8 lg:grid-cols-3">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Post Content -->
            <div class="admin-surface rounded-[1.75rem] p-8">
                <div class="space-y-6">
                    <!-- Featured Image -->
                    @if($blog->featured_image_url)
                        <div class="aspect-video rounded-2xl overflow-hidden bg-slate-800">
                            <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}"
                                class="w-full h-full object-cover">
                        </div>
                    @endif

                    <!-- Title -->
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">{{ $blog->title }}</h1>
                        <div class="flex flex-wrap items-center gap-4 text-sm text-slate-400">
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-user"></i>
                                {{ $blog->author }}
                            </span>
                            @if($blog->category)
                                <span class="flex items-center gap-1">
                                    <i class="fa-solid fa-tag"></i>
                                    {{ $blog->category }}
                                </span>
                            @endif
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-calendar"></i>
                                {{ $blog->published_at ? $blog->published_at->format('M j, Y') : $blog->created_at->format('M j, Y') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-clock"></i>
                                {{ $blog->published_at ? $blog->published_at->diffForHumans() : $blog->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>

                    <!-- Excerpt -->
                    @if($blog->excerpt)
                        <div class="border-l-4 border-cyan-400 pl-6">
                            <p class="text-slate-300 italic">{{ $blog->excerpt }}</p>
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="prose prose-invert max-w-none">
                        {!! nl2br(e($blog->content)) !!}
                    </div>

                    <!-- Tags -->
                    @if($blog->tags && is_array($blog->tags))
                        <div class="flex flex-wrap gap-2">
                            @foreach($blog->tags as $tag)
                                <span class="inline-flex items-center gap-1 rounded-full bg-cyan-500/10 px-3 py-1 text-sm text-cyan-300 border border-cyan-500/20">
                                    <i class="fa-solid fa-hashtag"></i>
                                    {{ trim($tag) }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Post Status -->
            <div class="admin-surface rounded-[1.75rem] p-6">
                <h3 class="text-lg font-semibold text-white mb-4">Post Status</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Status</span>
                        <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-sm font-medium
                            @if($blog->status === 'published') bg-green-500/10 text-green-400 border border-green-500/20
                            @elseif($blog->status === 'draft') bg-yellow-500/10 text-yellow-400 border border-yellow-500/20
                            @else bg-slate-500/10 text-slate-400 border border-slate-500/20 @endif">
                            <i class="fa-solid fa-circle text-xs"></i>
                            {{ ucfirst($blog->status) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Created</span>
                        <span class="text-white">{{ $blog->created_at->format('M j, Y') }}</span>
                    </div>
                    @if($blog->published_at)
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Published</span>
                            <span class="text-white">{{ $blog->published_at->format('M j, Y H:i') }}</span>
                        </div>
                    @endif
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Updated</span>
                        <span class="text-white">{{ $blog->updated_at->format('M j, Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- SEO Information -->
            @if($blog->meta_title || $blog->meta_description || $blog->meta_keywords)
                <div class="admin-surface rounded-[1.75rem] p-6">
                    <h3 class="text-lg font-semibold text-white mb-4">SEO Information</h3>
                    <div class="space-y-3">
                        @if($blog->meta_title)
                            <div>
                                <span class="text-slate-400 text-sm">Meta Title</span>
                                <p class="text-white text-sm mt-1">{{ $blog->meta_title }}</p>
                            </div>
                        @endif
                        @if($blog->meta_description)
                            <div>
                                <span class="text-slate-400 text-sm">Meta Description</span>
                                <p class="text-white text-sm mt-1">{{ $blog->meta_description }}</p>
                            </div>
                        @endif
                        @if($blog->meta_keywords)
                            <div>
                                <span class="text-slate-400 text-sm">Meta Keywords</span>
                                <p class="text-white text-sm mt-1">{{ $blog->meta_keywords }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="admin-surface rounded-[1.75rem] p-6">
                <h3 class="text-lg font-semibold text-white mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <form method="POST" action="{{ route('admin.blogs.toggle-status', $blog) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full admin-focus inline-flex items-center justify-center gap-2 rounded-2xl px-4 py-2 text-sm font-semibold transition-colors duration-200
                            @if($blog->status === 'published') bg-yellow-500/10 text-yellow-400 hover:bg-yellow-500/20 border border-yellow-500/20
                            @else bg-green-500/10 text-green-400 hover:bg-green-500/20 border border-green-500/20 @endif">
                            <i class="fa-solid @if($blog->status === 'published') fa-eye-slash @else fa-eye @endif"></i>
                            {{ $blog->status === 'published' ? 'Unpublish' : 'Publish' }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.blogs.duplicate', $blog) }}" class="inline">
                        @csrf
                        <button type="submit" class="w-full admin-focus inline-flex items-center justify-center gap-2 rounded-2xl bg-blue-500/10 px-4 py-2 text-sm font-semibold text-blue-400 transition-colors duration-200 hover:bg-blue-500/20 border border-blue-500/20">
                            <i class="fa-solid fa-copy"></i>
                            Duplicate
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.blogs.destroy', $blog) }}"
                        onsubmit="return confirm('Are you sure you want to delete this blog post? This action cannot be undone.')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full admin-focus inline-flex items-center justify-center gap-2 rounded-2xl bg-rose-500/10 px-4 py-2 text-sm font-semibold text-rose-400 transition-colors duration-200 hover:bg-rose-500/20 border border-rose-500/20">
                            <i class="fa-solid fa-trash"></i>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection