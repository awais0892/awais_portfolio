@extends('layouts.admin')

@section('title', 'Blogs')
@section('page-title', 'Blogs')
@section('page-subtitle', 'Search, sort and maintain the blog posts shown across the site.')

@section('page-actions')
    <a href="{{ route('admin.blogs.create') }}"
        class="admin-focus inline-flex items-center gap-2 rounded-2xl bg-cyan-300 px-4 py-2.5 text-sm font-semibold text-slate-950 transition-colors duration-200 hover:bg-cyan-200">
        <i class="fa-solid fa-plus" aria-hidden="true"></i>
        <span>New Post</span>
    </a>
@endsection

@section('content')
    @php
        $sortIcon = function (string $field) use ($sort): string {
            if ($sort['field'] !== $field) {
                return 'fa-sort';
            }

            return $sort['direction'] === 'asc' ? 'fa-sort-up' : 'fa-sort-down';
        };

        $sortDirection = function (string $field) use ($sort): string {
            if ($sort['field'] === $field && $sort['direction'] === 'asc') {
                return 'desc';
            }

            return 'asc';
        };

        $sortUrl = function (string $field) use ($sortDirection): string {
            return request()->fullUrlWithQuery([
                'sort_field' => $field,
                'sort_direction' => $sortDirection($field),
                'page' => 1,
            ]);
        };
    @endphp

    <div class="space-y-6">
        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <article class="admin-surface rounded-[1.6rem] p-5">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Total</p>
                <div class="mt-3 flex items-end justify-between gap-3">
                    <p class="admin-display text-3xl font-bold text-white tabular-nums">{{ $summary['total'] }}</p>
                    <i class="fa-solid fa-newspaper text-cyan-300/80" aria-hidden="true"></i>
                </div>
            </article>
            <article class="admin-surface rounded-[1.6rem] p-5">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Published</p>
                <div class="mt-3 flex items-end justify-between gap-3">
                    <p class="admin-display text-3xl font-bold text-white tabular-nums">{{ $summary['published'] }}</p>
                    <i class="fa-solid fa-circle-check text-emerald-300/80" aria-hidden="true"></i>
                </div>
            </article>
            <article class="admin-surface rounded-[1.6rem] p-5">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Draft</p>
                <div class="mt-3 flex items-end justify-between gap-3">
                    <p class="admin-display text-3xl font-bold text-white tabular-nums">{{ $summary['draft'] }}</p>
                    <i class="fa-solid fa-file text-amber-300/80" aria-hidden="true"></i>
                </div>
            </article>
            <article class="admin-surface rounded-[1.6rem] p-5">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Archived</p>
                <div class="mt-3 flex items-end justify-between gap-3">
                    <p class="admin-display text-3xl font-bold text-white tabular-nums">{{ $summary['archived'] }}</p>
                    <i class="fa-solid fa-archive text-slate-300/80" aria-hidden="true"></i>
                </div>
            </article>
        </section>

        <form method="GET" action="{{ route('admin.blogs.index') }}" class="admin-surface rounded-[1.75rem] p-6">
            <div class="grid gap-4 xl:grid-cols-[minmax(0,1.6fr)_repeat(3,minmax(0,0.6fr))]">
                <div>
                    <label for="search" class="mb-2 block text-sm font-semibold text-slate-200">Search</label>
                    <input type="search" id="search" name="search" value="{{ $filters['search'] }}"
                        class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white placeholder:text-slate-500"
                        placeholder="Search posts..." autocomplete="off">
                </div>

                <div>
                    <label for="status" class="mb-2 block text-sm font-semibold text-slate-200">Status</label>
                    <select id="status" name="status"
                        class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white">
                        <option value="">All</option>
                        <option value="published" @selected($filters['status'] === 'published')>Published</option>
                        <option value="draft" @selected($filters['status'] === 'draft')>Draft</option>
                        <option value="archived" @selected($filters['status'] === 'archived')>Archived</option>
                    </select>
                </div>

                <div>
                    <label for="category" class="mb-2 block text-sm font-semibold text-slate-200">Category</label>
                    <select id="category" name="category"
                        class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" @selected($filters['category'] === $category)>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="per_page" class="mb-2 block text-sm font-semibold text-slate-200">Per Page</label>
                    <select id="per_page" name="per_page"
                        class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white">
                        @foreach([10, 25, 50, 100] as $size)
                            <option value="{{ $size }}" @selected($filters['per_page'] === $size)>{{ $size }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-5 flex flex-wrap items-center justify-between gap-3">
                <p class="text-sm text-slate-400">
                    {{ $blogs->total() }} result{{ $blogs->total() === 1 ? '' : 's' }} matching the current filters.
                </p>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('admin.blogs.index') }}"
                        class="admin-focus inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-semibold text-slate-200 transition-colors duration-200 hover:bg-white/10">
                        Reset
                    </a>
                    <button type="submit"
                        class="admin-focus inline-flex items-center gap-2 rounded-2xl bg-white px-4 py-2.5 text-sm font-semibold text-slate-950 transition-colors duration-200 hover:bg-slate-200">
                        Apply Filters
                    </button>
                </div>
            </div>
        </form>

        <form method="POST" action="{{ route('admin.blogs.bulk-action') }}" id="blogBulkForm" class="space-y-4"
            data-confirm-message="Are you sure you want to perform this bulk action?">
            @csrf
            <input type="hidden" name="redirect_to" value="{{ url()->full() }}">

            <section class="admin-surface rounded-[1.75rem] p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="admin-display text-xl font-bold text-white">Blog Posts</h2>
                        <p class="mt-1 text-sm text-slate-400">
                            Showing {{ $blogs->firstItem() ?? 0 }} to {{ $blogs->lastItem() ?? 0 }} of {{ $blogs->total() }}.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <span
                            class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-sm text-slate-300">
                            <span id="selectedBlogsCount" class="font-semibold text-white">0</span> selected
                        </span>
                        <select id="bulkAction" name="action"
                            class="admin-focus rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-2.5 text-sm text-white">
                            <option value="">Bulk Actions</option>
                            <option value="publish">Publish Selected</option>
                            <option value="unpublish">Unpublish Selected</option>
                            <option value="archive">Archive Selected</option>
                            <option value="delete">Delete Selected</option>
                        </select>
                        <button type="submit" id="bulkActionBtn"
                            class="admin-focus inline-flex items-center gap-2 rounded-2xl border border-rose-400/20 bg-rose-500/10 px-4 py-2.5 text-sm font-semibold text-rose-100 transition-colors duration-200 hover:bg-rose-500/20 disabled:cursor-not-allowed disabled:opacity-50"
                            disabled>
                            <i class="fa-solid fa-play" aria-hidden="true"></i>
                            <span>Apply</span>
                        </button>
                    </div>
                </div>
            </section>

            <section class="admin-surface overflow-hidden rounded-[1.75rem]">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-white/10">
                        <thead class="bg-white/5">
                            <tr class="text-left text-xs uppercase tracking-[0.22em] text-slate-400">
                                <th scope="col" class="px-5 py-4">
                                    <input type="checkbox" id="selectAllBlogs"
                                        class="admin-focus h-4 w-4 rounded border-white/20 bg-slate-950/70 text-cyan-300">
                                </th>
                                <th scope="col" class="px-5 py-4">
                                    <a href="{{ $sortUrl('id') }}"
                                        class="admin-focus inline-flex items-center gap-2 rounded-xl px-2 py-1 hover:bg-white/5">
                                        <span>ID</span>
                                        <i class="fa-solid {{ $sortIcon('id') }}" aria-hidden="true"></i>
                                    </a>
                                </th>
                                <th scope="col" class="px-5 py-4">
                                    <a href="{{ $sortUrl('title') }}"
                                        class="admin-focus inline-flex items-center gap-2 rounded-xl px-2 py-1 hover:bg-white/5">
                                        <span>Post</span>
                                        <i class="fa-solid {{ $sortIcon('title') }}" aria-hidden="true"></i>
                                    </a>
                                </th>
                                <th scope="col" class="px-5 py-4">Author</th>
                                <th scope="col" class="px-5 py-4">Category</th>
                                <th scope="col" class="px-5 py-4">
                                    <a href="{{ $sortUrl('status') }}"
                                        class="admin-focus inline-flex items-center gap-2 rounded-xl px-2 py-1 hover:bg-white/5">
                                        <span>Status</span>
                                        <i class="fa-solid {{ $sortIcon('status') }}" aria-hidden="true"></i>
                                    </a>
                                </th>
                                <th scope="col" class="px-5 py-4">
                                    <a href="{{ $sortUrl('views') }}"
                                        class="admin-focus inline-flex items-center gap-2 rounded-xl px-2 py-1 hover:bg-white/5">
                                        <span>Views</span>
                                        <i class="fa-solid {{ $sortIcon('views') }}" aria-hidden="true"></i>
                                    </a>
                                </th>
                                <th scope="col" class="px-5 py-4">
                                    <a href="{{ $sortUrl('published_at') }}"
                                        class="admin-focus inline-flex items-center gap-2 rounded-xl px-2 py-1 hover:bg-white/5">
                                        <span>Published</span>
                                        <i class="fa-solid {{ $sortIcon('published_at') }}" aria-hidden="true"></i>
                                    </a>
                                </th>
                                <th scope="col" class="px-5 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse($blogs as $blog)
                                <tr class="align-top text-sm text-slate-200">
                                    <td class="px-5 py-5">
                                        <input type="checkbox" name="selected_blogs[]" value="{{ $blog->id }}"
                                            class="blog-selector admin-focus h-4 w-4 rounded border-white/20 bg-slate-950/70 text-cyan-300">
                                    </td>
                                    <td class="px-5 py-5 font-medium text-slate-400">#{{ $blog->id }}</td>
                                    <td class="px-5 py-5">
                                        <div class="flex min-w-[18rem] items-start gap-4">
                                            <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" width="80"
                                                height="60" class="h-16 w-20 rounded-2xl object-cover" loading="lazy">
                                            <div class="min-w-0">
                                                <p class="truncate font-semibold text-white">{{ $blog->title }}</p>
                                                <p class="mt-1 max-w-md break-words text-sm leading-6 text-slate-400">
                                                    {{ \Illuminate\Support\Str::limit($blog->excerpt, 130) }}
                                                </p>
                                                @if($blog->tags)
                                                    <div class="mt-2 flex flex-wrap gap-1">
                                                        @foreach(array_slice($blog->tags, 0, 2) as $tag)
                                                            <span class="rounded-full border border-cyan-400/15 bg-cyan-400/10 px-2 py-0.5 text-xs font-medium text-cyan-100">
                                                                {{ $tag }}
                                                            </span>
                                                        @endforeach
                                                        @if(count($blog->tags) > 2)
                                                            <span class="rounded-full border border-white/10 bg-white/5 px-2 py-0.5 text-xs font-medium text-slate-300">
                                                                +{{ count($blog->tags) - 2 }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-5">
                                        <span class="text-slate-300">{{ $blog->author }}</span>
                                    </td>
                                    <td class="px-5 py-5">
                                        @if($blog->category)
                                            <span class="rounded-full border border-blue-400/15 bg-blue-400/10 px-2.5 py-1 text-xs font-medium text-blue-100">
                                                {{ $blog->category }}
                                            </span>
                                        @else
                                            <span class="text-slate-500">No category</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-5">
                                        <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold
                                            @if($blog->status === 'published') bg-emerald-400/15 text-emerald-100
                                            @elseif($blog->status === 'draft') bg-amber-400/15 text-amber-100
                                            @else bg-slate-700 text-slate-200 @endif">
                                            {{ ucfirst($blog->status) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 font-medium tabular-nums text-slate-300">{{ number_format($blog->views) }}</td>
                                    <td class="px-5 py-5 text-slate-400">
                                        @if($blog->published_at)
                                            <time datetime="{{ $blog->published_at->toDateString() }}">
                                                {{ $blog->published_at->format('M d, Y') }}
                                            </time>
                                        @else
                                            <span class="text-slate-500">Not published</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-5">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.blogs.show', $blog) }}"
                                                class="admin-focus inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-slate-200 transition-colors duration-200 hover:bg-white/10"
                                                aria-label="View {{ $blog->title }}">
                                                <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                            </a>
                                            <a href="{{ route('admin.blogs.edit', $blog) }}"
                                                class="admin-focus inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-slate-200 transition-colors duration-200 hover:bg-white/10"
                                                aria-label="Edit {{ $blog->title }}">
                                                <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.blogs.toggle-status', $blog) }}">
                                                @csrf
                                                <input type="hidden" name="redirect_to" value="{{ url()->full() }}">
                                                <button type="submit"
                                                    class="admin-focus inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-semibold
                                                    {{ $blog->status === 'published' ? 'bg-emerald-400/15 text-emerald-100' : 'bg-slate-700 text-slate-200' }}"
                                                    aria-label="{{ $blog->status === 'published' ? 'Unpublish' : 'Publish' }} {{ $blog->title }}">
                                                    <span class="h-2 w-2 rounded-full {{ $blog->status === 'published' ? 'bg-emerald-300' : 'bg-slate-400' }}"></span>
                                                    {{ $blog->status === 'published' ? 'Published' : 'Draft' }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.blogs.destroy', $blog) }}"
                                                data-confirm-message="Delete {{ $blog->title }}? This action cannot be undone.">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="redirect_to" value="{{ url()->full() }}">
                                                <button type="submit"
                                                    class="admin-focus inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-rose-400/15 bg-rose-500/10 text-rose-100 transition-colors duration-200 hover:bg-rose-500/20"
                                                    aria-label="Delete {{ $blog->title }}">
                                                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-16 text-center">
                                        <div class="mx-auto max-w-md">
                                            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl border border-white/10 bg-white/5 text-slate-300">
                                                <i class="fa-solid fa-newspaper" aria-hidden="true"></i>
                                            </div>
                                            <h3 class="admin-display mt-5 text-2xl font-bold text-white">No blog posts found</h3>
                                            <p class="mt-2 text-sm leading-6 text-slate-400">
                                                Adjust the filters or create a new blog post to populate this module.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </form>

        @if($blogs->hasPages())
            <div class="pt-2">
                {{ $blogs->links('components.pagination') }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const bulkForm = document.getElementById('blogBulkForm');
            const selectAll = document.getElementById('selectAllBlogs');
            const selectors = Array.from(document.querySelectorAll('.blog-selector'));
            const selectedCount = document.getElementById('selectedBlogsCount');
            const bulkAction = document.getElementById('bulkAction');
            const bulkActionBtn = document.getElementById('bulkActionBtn');

            const syncSelectionState = () => {
                const checked = selectors.filter((checkbox) => checkbox.checked);
                selectedCount.textContent = checked.length.toString();
                bulkActionBtn.disabled = checked.length === 0 || !bulkAction.value;

                if (selectAll) {
                    selectAll.checked = checked.length > 0 && checked.length === selectors.length;
                    selectAll.indeterminate = checked.length > 0 && checked.length < selectors.length;
                }
            };

            selectors.forEach((checkbox) => checkbox.addEventListener('change', syncSelectionState));

            if (selectAll) {
                selectAll.addEventListener('change', () => {
                    selectors.forEach((checkbox) => {
                        checkbox.checked = selectAll.checked;
                    });

                    syncSelectionState();
                });
            }

            if (bulkAction) {
                bulkAction.addEventListener('change', syncSelectionState);
            }

            document.addEventListener('submit', (event) => {
                const form = event.target;
                const message = form.getAttribute('data-confirm-message');

                if (message && !window.confirm(message)) {
                    event.preventDefault();
                }
            });

            syncSelectionState();

            if (bulkForm) {
                bulkForm.addEventListener('submit', (event) => {
                    if (bulkActionBtn.disabled) {
                        event.preventDefault();
                    }
                });
            }
        });
    </script>
@endpush