@extends('layouts.admin')

@section('title', 'Edit Blog Post')
@section('page-title', 'Edit Blog Post')
@section('page-subtitle', 'Update and refine your blog content.')

@section('page-actions')
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.blogs.show', $blog) }}"
            class="admin-focus inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-semibold text-slate-200 transition-colors duration-200 hover:bg-white/10">
            <i class="fa-solid fa-eye" aria-hidden="true"></i>
            <span>View Post</span>
        </a>
        <a href="{{ route('admin.blogs.index') }}"
            class="admin-focus inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-semibold text-slate-200 transition-colors duration-200 hover:bg-white/10">
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
            <span>Back to Blogs</span>
        </a>
    </div>
@endsection

@section('content')
    <div class="space-y-6">
        <form method="POST" action="{{ route('admin.blogs.update', $blog) }}" enctype="multipart/form-data" class="admin-surface rounded-[1.75rem] p-8">
            @csrf
            @method('PUT')

            <div class="grid gap-8 lg:grid-cols-2">
                <div class="space-y-6">
                    <div>
                        <label for="title" class="mb-2 block text-sm font-semibold text-slate-200">Title <span class="text-rose-400">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $blog->title) }}" required
                            class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white placeholder:text-slate-500"
                            placeholder="Enter blog post title...">
                        @error('title')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="slug" class="mb-2 block text-sm font-semibold text-slate-200">Slug</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $blog->slug) }}"
                            class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white placeholder:text-slate-500"
                            placeholder="auto-generated-from-title">
                        @error('slug')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="author" class="mb-2 block text-sm font-semibold text-slate-200">Author <span class="text-rose-400">*</span></label>
                        <input type="text" id="author" name="author" value="{{ old('author', $blog->author) }}" required
                            class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white placeholder:text-slate-500"
                            placeholder="Post author">
                        @error('author')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category" class="mb-2 block text-sm font-semibold text-slate-200">Category</label>
                        <select id="category" name="category"
                            class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" @selected(old('category', $blog->category) === $category)>{{ $category }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="mb-2 block text-sm font-semibold text-slate-200">Status <span class="text-rose-400">*</span></label>
                        <select id="status" name="status" required
                            class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white">
                            <option value="draft" @selected(old('status', $blog->status) === 'draft')>Draft</option>
                            <option value="published" @selected(old('status', $blog->status) === 'published')>Published</option>
                            <option value="archived" @selected(old('status', $blog->status) === 'archived')>Archived</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="published_at" class="mb-2 block text-sm font-semibold text-slate-200">Publish Date</label>
                        <input type="datetime-local" id="published_at" name="published_at" value="{{ old('published_at', $blog->published_at ? \Carbon\Carbon::parse($blog->published_at)->format('Y-m-d\TH:i') : '') }}"
                            class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white">
                        @error('published_at')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="featured_image_url" class="mb-2 block text-sm font-semibold text-slate-200">Featured Image URL</label>
                        <input type="url" id="featured_image_url" name="featured_image_url" value="{{ old('featured_image_url', $blog->featured_image_url) }}"
                            class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white placeholder:text-slate-500"
                            placeholder="https://example.com/image.jpg">
                        @error('featured_image_url')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="excerpt" class="mb-2 block text-sm font-semibold text-slate-200">Excerpt</label>
                        <textarea id="excerpt" name="excerpt" rows="3"
                            class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white placeholder:text-slate-500"
                            placeholder="Brief description of the post...">{{ old('excerpt', $blog->excerpt) }}</textarea>
                        @error('excerpt')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tags" class="mb-2 block text-sm font-semibold text-slate-200">Tags</label>
                        <input type="text" id="tags" name="tags" value="{{ old('tags', is_array($blog->tags) ? implode(', ', $blog->tags) : $blog->tags) }}"
                            class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white placeholder:text-slate-500"
                            placeholder="laravel, php, tutorial (comma-separated)">
                        @error('tags')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="meta_title" class="mb-2 block text-sm font-semibold text-slate-200">Meta Title</label>
                        <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $blog->meta_title) }}"
                            class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white placeholder:text-slate-500"
                            placeholder="SEO title">
                        @error('meta_title')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="meta_description" class="mb-2 block text-sm font-semibold text-slate-200">Meta Description</label>
                        <textarea id="meta_description" name="meta_description" rows="2"
                            class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white placeholder:text-slate-500"
                            placeholder="SEO description...">{{ old('meta_description', $blog->meta_description) }}</textarea>
                        @error('meta_description')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="meta_keywords" class="mb-2 block text-sm font-semibold text-slate-200">Meta Keywords</label>
                        <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $blog->meta_keywords) }}"
                            class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white placeholder:text-slate-500"
                            placeholder="keyword1, keyword2, keyword3">
                        @error('meta_keywords')
                            <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div>
                <label for="content" class="mb-2 block text-sm font-semibold text-slate-200">Content <span class="text-rose-400">*</span></label>
                <textarea id="content" name="content" rows="15" required
                    class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white placeholder:text-slate-500"
                    placeholder="Write your blog post content here...">{{ old('content', $blog->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-rose-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-wrap items-center justify-end gap-3 pt-6 border-t border-white/10">
                <a href="{{ route('admin.blogs.index') }}"
                    class="admin-focus inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-6 py-3 text-sm font-semibold text-slate-200 transition-colors duration-200 hover:bg-white/10">
                    Cancel
                </a>
                <button type="submit"
                    class="admin-focus inline-flex items-center gap-2 rounded-2xl bg-cyan-300 px-6 py-3 text-sm font-semibold text-slate-950 transition-colors duration-200 hover:bg-cyan-200">
                    <i class="fa-solid fa-save" aria-hidden="true"></i>
                    <span>Update Post</span>
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Auto-generate slug from title
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');

            if (titleInput && slugInput) {
                titleInput.addEventListener('input', () => {
                    if (!slugInput.value || slugInput.dataset.autoGenerated) {
                        const slug = titleInput.value
                            .toLowerCase()
                            .replace(/[^a-z0-9\s-]/g, '')
                            .replace(/\s+/g, '-')
                            .replace(/-+/g, '-')
                            .trim('-');
                        slugInput.value = slug;
                        slugInput.dataset.autoGenerated = 'true';
                    }
                });

                slugInput.addEventListener('input', () => {
                    slugInput.dataset.autoGenerated = 'false';
                });
            }
        });
    </script>
@endpush