@extends('layouts.app')

@section('title', 'Admin - Blog Management')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 relative overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl animate-pulse"></div>
            <div
                class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl animate-pulse delay-1000">
            </div>
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl animate-pulse delay-500">
            </div>
        </div>

        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=" 60" height="60" viewBox="0 0 60 60"
            xmlns="http://www.w3.org/2000/svg" %3E%3Cg fill="none" fill-rule="evenodd" %3E%3Cg fill="%23ffffff"
            fill-opacity="0.02" %3E%3Cpath
            d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"
            /%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header Section -->
            <div class="mb-12 text-center">
                <div class="inline-block">
                    <h1
                        class="text-6xl font-black bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 bg-clip-text text-transparent mb-4 tracking-tight">
                        BLOG MANAGEMENT
                    </h1>
                    <div class="h-1 w-32 bg-gradient-to-r from-cyan-400 to-purple-600 mx-auto rounded-full"></div>
                </div>
                <p class="text-cyan-300/80 text-xl mt-6 font-light tracking-wide">
                    Manage your blog posts, articles, and content
                </p>
            </div>

            <!-- Action Button -->
            <div class="text-center mb-12">
                <a href="{{ route('admin.blogs.create') }}"
                    class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold text-lg rounded-2xl overflow-hidden transition-all duration-500 hover:scale-105 hover:shadow-2xl hover:shadow-cyan-500/25">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-cyan-600 to-blue-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div class="relative flex items-center">
                        <div
                            class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-plus text-white text-sm"></i>
                        </div>
                        <span class="tracking-wider">CREATE NEW POST</span>
                    </div>
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-2xl blur opacity-30 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                </a>
            </div>

            <!-- Filters and Search -->
            <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-6 shadow-2xl mb-8">
                <form method="GET" action="{{ route('admin.blogs.index') }}" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Search -->
                        <div>
                            <label
                                class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-2">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search posts..."
                                class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label
                                class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-2">Status</label>
                            <select name="status"
                                class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 js-choice">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <label
                                class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-2">Category</label>
                            <select name="category"
                                class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 js-choice">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                        {{ $category }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sort -->
                        <div>
                            <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-2">Sort
                                By</label>
                            <select name="sort_by"
                                class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 js-choice">
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Created
                                    Date</option>
                                <option value="updated_at" {{ request('sort_by') == 'updated_at' ? 'selected' : '' }}>Updated
                                    Date</option>
                                <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Title</option>
                                <option value="views" {{ request('sort_by') == 'views' ? 'selected' : '' }}>Views</option>
                                <option value="published_at" {{ request('sort_by') == 'published_at' ? 'selected' : '' }}>
                                    Published Date</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-between items-center">
                        <button type="submit"
                            class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 text-cyan-300 border border-cyan-400/30 rounded-xl hover:from-cyan-500/30 hover:to-blue-500/30 transition-all duration-300 hover:scale-105">
                            <div
                                class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <i class="fas fa-search mr-3 relative z-10"></i>
                            <span class="relative z-10 font-semibold">Apply Filters</span>
                        </button>

                        <a href="{{ route('admin.blogs.index') }}"
                            class="text-cyan-300 hover:text-cyan-200 transition-colors duration-300">
                            <i class="fas fa-times mr-2"></i>Clear Filters
                        </a>
                    </div>
                </form>
            </div>

            <!-- Bulk Actions -->
            <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-6 shadow-2xl mb-8">
                <form id="bulkActionForm" method="POST" action="{{ route('admin.blogs.bulk-action') }}" class="space-y-4">
                    @csrf
                    <div
                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                        <div class="flex items-center space-x-4">
                            <select id="bulkAction" name="action"
                                class="bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 js-choice">
                                <option value="">Bulk Actions</option>
                                <option value="publish">Publish Selected</option>
                                <option value="unpublish">Unpublish Selected</option>
                                <option value="archive">Archive Selected</option>
                                <option value="delete">Delete Selected</option>
                            </select>
                            <button type="submit" id="bulkActionBtn" disabled
                                class="px-6 py-2 bg-gradient-to-r from-red-500/20 to-pink-500/20 text-red-300 border border-red-400/30 rounded-xl hover:from-red-500/30 hover:to-pink-500/30 transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                                Apply
                            </button>
                        </div>
                        <div class="text-cyan-300/70 text-sm">
                            <span id="selectedCount">0</span> posts selected
                        </div>
                    </div>
                </form>
            </div>

            <!-- Blog Posts Table -->
            <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-white/5">
                            <tr>
                                <th class="px-6 py-4 text-left">
                                    <input type="checkbox" id="selectAll"
                                        class="w-5 h-5 rounded-lg border-white/30 text-cyan-500 focus:ring-cyan-400 bg-white/10">
                                </th>
                                <th class="px-6 py-4 text-left text-cyan-300 font-bold uppercase tracking-wider">Post</th>
                                <th class="px-6 py-4 text-left text-cyan-300 font-bold uppercase tracking-wider">Author</th>
                                <th class="px-6 py-4 text-left text-cyan-300 font-bold uppercase tracking-wider">Category
                                </th>
                                <th class="px-6 py-4 text-left text-cyan-300 font-bold uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-cyan-300 font-bold uppercase tracking-wider">Views</th>
                                <th class="px-6 py-4 text-left text-cyan-300 font-bold uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 text-left text-cyan-300 font-bold uppercase tracking-wider">Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse($blogs as $blog)
                                <tr class="group hover:bg-white/5 transition-all duration-300">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" name="selected_blogs[]" value="{{ $blog->id }}"
                                            class="blog-checkbox w-5 h-5 rounded-lg border-white/30 text-cyan-500 focus:ring-cyan-400 bg-white/10">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-4">
                                            <div
                                                class="w-16 h-12 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-xl overflow-hidden">
                                                @if($blog->featured_image)
                                                    @if(str_starts_with($blog->featured_image, 'http'))
                                                        {{-- Cloudinary URL --}}
                                                        <img src="{{ $blog->featured_image }}" alt="{{ $blog->title }}"
                                                            class="w-full h-full object-cover">
                                                    @else
                                                        {{-- Local storage URL --}}
                                                        <img src="{{ asset('storage/' . $blog->featured_image) }}"
                                                            alt="{{ $blog->title }}" class="w-full h-full object-cover">
                                                    @endif
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <i class="fas fa-image text-cyan-300/50"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <h3
                                                    class="text-white font-semibold text-lg group-hover:text-cyan-300 transition-colors duration-300">
                                                    {{ $blog->title }}
                                                </h3>
                                                <p class="text-cyan-300/70 text-sm">{{ Str::limit($blog->excerpt, 60) }}</p>
                                                <div class="flex items-center space-x-2 mt-2">
                                                    @if($blog->tags)
                                                        @foreach(array_slice($blog->tags, 0, 2) as $tag)
                                                            <span
                                                                class="px-2 py-1 bg-cyan-500/20 text-cyan-300 text-xs rounded-lg">{{ $tag }}</span>
                                                        @endforeach
                                                        @if(count($blog->tags) > 2)
                                                            <span class="text-cyan-300/50 text-xs">+{{ count($blog->tags) - 2 }}
                                                                more</span>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-white">{{ $blog->author }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($blog->category)
                                            <span
                                                class="px-3 py-1 bg-blue-500/20 text-blue-300 text-sm rounded-lg">{{ $blog->category }}</span>
                                        @else
                                            <span class="text-cyan-300/50 text-sm">No category</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColors = [
                                                'published' => 'bg-green-500/20 text-green-300 border-green-400/30',
                                                'draft' => 'bg-yellow-500/20 text-yellow-300 border-yellow-400/30',
                                                'archived' => 'bg-gray-500/20 text-gray-300 border-gray-400/30'
                                            ];
                                            $statusColor = $statusColors[$blog->status] ?? 'bg-gray-500/20 text-gray-300 border-gray-400/30';
                                        @endphp
                                        <span class="px-3 py-1 border rounded-lg text-sm {{ $statusColor }}">
                                            {{ ucfirst($blog->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-white font-mono">{{ number_format($blog->views) }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm">
                                            <div class="text-white">{{ $blog->formatted_published_date }}</div>
                                            @if($blog->status === 'published')
                                                <div class="text-cyan-300/70">{{ $blog->read_time }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.blogs.show', $blog) }}"
                                                class="text-cyan-400 hover:text-cyan-300 transition-colors duration-300"
                                                title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.blogs.edit', $blog) }}"
                                                class="text-blue-400 hover:text-blue-300 transition-colors duration-300"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button onclick="toggleStatus({{ $blog->id }}, '{{ $blog->status }}')"
                                                class="text-green-400 hover:text-green-300 transition-colors duration-300"
                                                title="Toggle Status">
                                                <i class="fas fa-toggle-{{ $blog->status === 'published' ? 'on' : 'off' }}"></i>
                                            </button>
                                            <form method="POST" action="{{ route('admin.blogs.destroy', $blog) }}"
                                                class="inline"
                                                onsubmit="return confirm('Are you sure you want to delete this post?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-400 hover:text-red-300 transition-colors duration-300"
                                                    title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="text-cyan-300/70">
                                            <i class="fas fa-newspaper text-4xl mb-4"></i>
                                            <p class="text-xl">No blog posts found</p>
                                            <p class="text-sm mt-2">Create your first blog post to get started</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($blogs->hasPages())
                    <div class="px-6 py-4 border-t border-white/10">
                        {{ $blogs->appends(request()->query())->links('components.pagination') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>

        document.addEventListener('DOMContentLoaded', function () {
            initializeAnimations();
            initializeBulkActions();

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

            // Filters animation
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

            // Table animation
            gsap.fromTo('tbody tr', {
                y: 30,
                opacity: 0
            }, {
                y: 0,
                opacity: 1,
                duration: 0.6,
                stagger: 0.05,
                delay: 1.5,
                ease: "power2.out"
            });
        }

        function initializeBulkActions() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.blog-checkbox');
            const bulkAction = document.getElementById('bulkAction');
            const bulkActionBtn = document.getElementById('bulkActionBtn');
            const selectedCount = document.getElementById('selectedCount');

            // Select all functionality
            selectAll.addEventListener('change', function () {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkActionState();
            });

            // Individual checkbox functionality
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkActionState);
            });

            // Bulk action change
            bulkAction.addEventListener('change', function () {
                bulkActionBtn.disabled = !this.value || getSelectedCount() === 0;
            });

            function updateBulkActionState() {
                const count = getSelectedCount();
                selectedCount.textContent = count;

                // Update select all state
                if (count === 0) {
                    selectAll.indeterminate = false;
                    selectAll.checked = false;
                } else if (count === checkboxes.length) {
                    selectAll.indeterminate = false;
                    selectAll.checked = true;
                } else {
                    selectAll.indeterminate = true;
                }

                // Update bulk action button state
                bulkActionBtn.disabled = !bulkAction.value || count === 0;
            }

            function getSelectedCount() {
                return document.querySelectorAll('.blog-checkbox:checked').length;
            }
        }

        function toggleStatus(blogId, currentStatus) {
            fetch(`/admin/blogs/${blogId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showMessage(data.message, 'success');
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        showMessage('Failed to toggle status', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('An error occurred', 'error');
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