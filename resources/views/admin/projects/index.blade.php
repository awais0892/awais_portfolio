@extends('layouts.app')

@section('title', 'Admin - Projects Management')

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
                        PROJECTS
                    </h1>
                    <div class="h-1 w-32 bg-gradient-to-r from-cyan-400 to-purple-600 mx-auto rounded-full"></div>
                </div>
                <p class="text-cyan-300/80 text-xl mt-6 font-light tracking-wide">
                    Manage your digital portfolio with precision and style
                </p>
            </div>

            <!-- Action Button -->
            <div class="text-center mb-12">
                <a href="{{ route('admin.projects.create') }}"
                    class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold text-lg rounded-2xl overflow-hidden transition-all duration-500 hover:scale-105 hover:shadow-2xl hover:shadow-cyan-500/25">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-cyan-600 to-blue-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div class="relative flex items-center">
                        <div
                            class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-plus text-white text-sm"></i>
                        </div>
                        <span class="tracking-wider">CREATE NEW PROJECT</span>
                    </div>
                    <div
                        class="absolute -inset-1 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-2xl blur opacity-30 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                </a>
            </div>

            <!-- Search and Filters -->
            <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-8 mb-8 shadow-2xl">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-cyan-300 uppercase tracking-wider">Search</label>
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Search projects..."
                                class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-search text-cyan-300/50"></i>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-cyan-300 uppercase tracking-wider">Status</label>
                        <select id="statusFilter"
                            class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 js-choice">
                            <option value="" class="bg-slate-800">All Status</option>
                            <option value="1" class="bg-slate-800">Active</option>
                            <option value="0" class="bg-slate-800">Inactive</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-cyan-300 uppercase tracking-wider">Featured</label>
                        <select id="featuredFilter"
                            class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 js-choice">
                            <option value="" class="bg-slate-800">All Projects</option>
                            <option value="1" class="bg-slate-800">Featured Only</option>
                            <option value="0" class="bg-slate-800">Non-Featured</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-cyan-300 uppercase tracking-wider">Per Page</label>
                        <select id="perPageFilter"
                            class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 js-choice">
                            <option value="10" class="bg-slate-800">10</option>
                            <option value="25" class="bg-slate-800">25</option>
                            <option value="50" class="bg-slate-800">50</option>
                            <option value="100" class="bg-slate-800">100</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Projects Table -->
            <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-white/10">
                        <thead class="bg-white/5 backdrop-blur-sm">
                            <tr>
                                <th class="px-8 py-6 text-left">
                                    <input type="checkbox" id="selectAllCheckbox"
                                        class="w-5 h-5 rounded-lg border-white/30 text-cyan-500 focus:ring-cyan-400 bg-white/10">
                                </th>
                                <th class="px-8 py-6 text-left text-sm font-bold text-cyan-300 uppercase tracking-wider cursor-pointer hover:bg-white/5 transition-colors duration-300"
                                    data-sort="id">
                                    <div class="flex items-center space-x-2">
                                        <span>ID</span>
                                        <i class="fas fa-sort text-cyan-400/50"></i>
                                    </div>
                                </th>
                                <th class="px-8 py-6 text-left text-sm font-bold text-cyan-300 uppercase tracking-wider cursor-pointer hover:bg-white/5 transition-colors duration-300"
                                    data-sort="title">
                                    <div class="flex items-center space-x-2">
                                        <span>Project</span>
                                        <i class="fas fa-sort text-cyan-400/50"></i>
                                    </div>
                                </th>
                                <th class="px-8 py-6 text-left text-sm font-bold text-cyan-300 uppercase tracking-wider cursor-pointer hover:bg-white/5 transition-colors duration-300"
                                    data-sort="technologies">
                                    <span>Technologies</span>
                                </th>
                                <th class="px-8 py-6 text-left text-sm font-bold text-cyan-300 uppercase tracking-wider cursor-pointer hover:bg-white/5 transition-colors duration-300"
                                    data-sort="featured">
                                    <div class="flex items-center space-x-2">
                                        <span>Featured</span>
                                        <i class="fas fa-sort text-cyan-400/50"></i>
                                    </div>
                                </th>
                                <th class="px-8 py-6 text-left text-sm font-bold text-cyan-300 uppercase tracking-wider cursor-pointer hover:bg-white/5 transition-colors duration-300"
                                    data-sort="status">
                                    <div class="flex items-center space-x-2">
                                        <span>Status</span>
                                        <i class="fas fa-sort text-cyan-400/50"></i>
                                    </div>
                                </th>
                                <th class="px-8 py-6 text-left text-sm font-bold text-cyan-300 uppercase tracking-wider cursor-pointer hover:bg-white/5 transition-colors duration-300"
                                    data-sort="order">
                                    <div class="flex items-center space-x-2">
                                        <span>Order</span>
                                        <i class="fas fa-sort text-cyan-400/50"></i>
                                    </div>
                                </th>
                                <th class="px-8 py-6 text-left text-sm font-bold text-cyan-300 uppercase tracking-wider cursor-pointer hover:bg-white/5 transition-colors duration-300"
                                    data-sort="created_at">
                                    <div class="flex items-center space-x-2">
                                        <span>Created</span>
                                        <i class="fas fa-sort text-cyan-400/50"></i>
                                    </div>
                                </th>
                                <th class="px-8 py-6 text-right text-sm font-bold text-cyan-300 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10" id="projectsTableBody">
                            @forelse($projects as $project)
                                <tr class="hover:bg-white/5 transition-all duration-300 group project-row">
                                    <td class="px-8 py-6">
                                        <input type="checkbox" name="selected_projects" value="{{ $project->id }}"
                                            class="w-5 h-5 rounded-lg border-white/30 text-cyan-500 focus:ring-cyan-400 bg-white/10 project-checkbox">
                                    </td>
                                    <td class="px-8 py-6 text-sm text-cyan-100 font-mono">
                                        #{{ $project->id }}
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center space-x-4">
                                            <div class="relative group">
                                                <div
                                                    class="w-16 h-12 rounded-xl overflow-hidden border-2 border-white/20 group-hover:border-cyan-400 transition-all duration-300">
                                                    <img class="w-full h-full object-cover" src="{{ $project->image_url }}"
                                                        alt="{{ $project->title }}"
                                                        onerror="this.src='https://via.placeholder.com/64x48/1a1a2e/16a085?text={{ urlencode(substr($project->title, 0, 1)) }}'">
                                                </div>
                                                <div
                                                    class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-xl">
                                                </div>
                                            </div>
                                            <div>
                                                <div
                                                    class="text-lg font-bold text-white group-hover:text-cyan-300 transition-colors duration-300">
                                                    {{ $project->title }}</div>
                                                <div class="text-sm text-cyan-300/70 max-w-xs">
                                                    {{ Str::limit($project->description, 60) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        @if($project->technologies && count($project->technologies) > 0)
                                            <div class="flex flex-wrap gap-2">
                                                @foreach(array_slice($project->technologies, 0, 3) as $tech)
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-cyan-500/20 to-blue-500/20 text-cyan-300 border border-cyan-400/30 backdrop-blur-sm">
                                                        {{ $tech }}
                                                    </span>
                                                @endforeach
                                                @if(count($project->technologies) > 3)
                                                    <span
                                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-purple-500/20 to-pink-500/20 text-purple-300 border border-purple-400/30 backdrop-blur-sm">
                                                        +{{ count($project->technologies) - 3 }}
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-cyan-300/50 text-sm font-light">No technologies</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6">
                                        @if($project->featured)
                                            <span
                                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-gradient-to-r from-yellow-400/20 to-orange-400/20 text-yellow-300 border border-yellow-400/30 backdrop-blur-sm">
                                                <i class="fas fa-star mr-2 text-yellow-400"></i>Featured
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-gradient-to-r from-gray-400/20 to-gray-500/20 text-gray-300 border border-gray-400/30 backdrop-blur-sm">
                                                Regular
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6">
                                        <button
                                            onclick="toggleProjectStatus({{ $project->id }}, {{ $project->is_active ? 'true' : 'false' }})"
                                            class="group relative inline-flex items-center px-4 py-2 rounded-full text-sm font-bold transition-all duration-300 {{ $project->is_active ? 'bg-gradient-to-r from-green-500/20 to-emerald-500/20 text-green-300 border border-green-400/30 hover:from-green-500/30 hover:to-emerald-500/30' : 'bg-gradient-to-r from-red-500/20 to-pink-500/20 text-red-300 border border-red-400/30 hover:from-red-500/30 hover:to-pink-500/30' }}">
                                            <div
                                                class="absolute inset-0 rounded-full bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            </div>
                                            <span class="relative">{{ $project->is_active ? 'Active' : 'Inactive' }}</span>
                                        </button>
                                    </td>
                                    <td class="px-8 py-6 text-sm text-cyan-100 font-mono">
                                        {{ $project->order }}
                                    </td>
                                    <td class="px-8 py-6 text-sm text-cyan-100 font-mono">
                                        {{ $project->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <div class="flex items-center justify-end space-x-3">
                                            <a href="{{ route('admin.projects.show', $project) }}"
                                                class="group relative p-3 rounded-xl bg-gradient-to-r from-cyan-500/20 to-blue-500/20 text-cyan-300 border border-cyan-400/30 hover:from-cyan-500/30 hover:to-blue-500/30 transition-all duration-300 hover:scale-110"
                                                title="View">
                                                <div
                                                    class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                </div>
                                                <i class="fas fa-eye relative z-10"></i>
                                            </a>
                                            <a href="{{ route('admin.projects.edit', $project) }}"
                                                class="group relative p-3 rounded-xl bg-gradient-to-r from-blue-500/20 to-purple-500/20 text-blue-300 border border-blue-400/30 hover:from-blue-500/30 hover:to-purple-500/30 transition-all duration-300 hover:scale-110"
                                                title="Edit">
                                                <div
                                                    class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                </div>
                                                <i class="fas fa-edit relative z-10"></i>
                                            </a>
                                            <button onclick="deleteProject({{ $project->id }}, '{{ $project->title }}')"
                                                class="group relative p-3 rounded-xl bg-gradient-to-r from-red-500/20 to-pink-500/20 text-red-300 border border-red-400/30 hover:from-red-500/30 hover:to-pink-500/30 transition-all duration-300 hover:scale-110"
                                                title="Delete">
                                                <div
                                                    class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                </div>
                                                <i class="fas fa-trash relative z-10"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-8 py-16 text-center">
                                        <div class="flex flex-col items-center space-y-4">
                                            <div
                                                class="w-20 h-20 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-full flex items-center justify-center border border-cyan-400/30">
                                                <i class="fas fa-folder-open text-3xl text-cyan-300"></i>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-xl font-bold text-white mb-2">No projects found</p>
                                                <p class="text-cyan-300/70">Get started by creating your first project</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($projects->hasPages())
                    <div class="bg-white/5 backdrop-blur-sm px-8 py-6 border-t border-white/10">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-cyan-300/70">
                                Showing {{ $projects->firstItem() }} to {{ $projects->lastItem() }} of {{ $projects->total() }}
                                results
                            </div>
                            <div class="flex items-center space-x-2">
                                {{ $projects->links('components.pagination') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Bulk Actions -->
            <div class="mt-8 backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-8 shadow-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <button id="selectAllBtn"
                            class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 text-cyan-300 border border-cyan-400/30 rounded-xl hover:from-cyan-500/30 hover:to-blue-500/30 transition-all duration-300 hover:scale-105">
                            <div
                                class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <i class="fas fa-check-square mr-3 relative z-10"></i>
                            <span class="relative z-10 font-semibold">Select All</span>
                        </button>
                        <button id="bulkDeleteBtn"
                            class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500/20 to-pink-500/20 text-red-300 border border-red-400/30 rounded-xl hover:from-red-500/30 hover:to-pink-500/30 transition-all duration-300 hover:scale-105 hidden">
                            <div
                                class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <i class="fas fa-trash mr-3 relative z-10"></i>
                            <span class="relative z-10 font-semibold">Delete Selected</span>
                        </button>
                    </div>
                    <div class="text-sm text-cyan-300/70 font-semibold">
                        <span id="selectedCount">0</span> projects selected
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal"
        class="fixed inset-0 bg-black/80 backdrop-blur-xl z-50 hidden flex items-center justify-center p-4">
        <div class="backdrop-blur-xl bg-slate-800/90 border border-white/20 rounded-3xl p-8 max-w-md w-full shadow-2xl">
            <div class="flex items-center mb-6">
                <div
                    class="w-16 h-16 bg-gradient-to-r from-red-500/20 to-pink-500/20 rounded-full flex items-center justify-center border border-red-400/30 mr-4">
                    <i class="fas fa-exclamation-triangle text-red-400 text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-white">Delete Project</h3>
                </div>
            </div>
            <p class="text-cyan-300/80 mb-8 text-lg leading-relaxed">Are you sure you want to delete "<span
                    id="deleteProjectName" class="text-white font-semibold"></span>"? This action cannot be undone.</p>
            <div class="flex justify-end space-x-4">
                <button onclick="closeDeleteModal()"
                    class="group relative px-6 py-3 bg-gradient-to-r from-gray-500/20 to-gray-600/20 text-gray-300 border border-gray-400/30 rounded-xl hover:from-gray-500/30 hover:to-gray-600/30 transition-all duration-300 hover:scale-105">
                    <div
                        class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <span class="relative font-semibold">Cancel</span>
                </button>
                <button id="confirmDeleteBtn"
                    class="group relative px-6 py-3 bg-gradient-to-r from-red-500/20 to-pink-500/20 text-red-300 border border-red-400/30 rounded-xl hover:from-red-500/30 hover:to-pink-500/30 transition-all duration-300 hover:scale-105">
                    <div
                        class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <span class="relative font-semibold">Delete</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    <div id="messageContainer" class="fixed top-6 right-6 z-50 hidden">
        <div
            class="backdrop-blur-xl bg-gradient-to-r from-green-500/20 to-emerald-500/20 border border-green-400/30 text-green-300 px-8 py-4 rounded-2xl shadow-2xl flex items-center">
            <i class="fas fa-check-circle mr-3 text-green-400"></i>
            <span id="messageText" class="font-semibold"></span>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        let currentSort = { field: 'id', direction: 'asc' };
        let selectedProjects = new Set();

        // Initialize animations when DOM is loaded
        document.addEventListener('DOMContentLoaded', function () {
            initializeAnimations();
            initializeDataTable();
            initializeFilters();
            initializeBulkActions();
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

            gsap.fromTo('.text-cyan-300', {
                y: 30,
                opacity: 0
            }, {
                y: 0,
                opacity: 1,
                duration: 1,
                delay: 0.8,
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
                duration: 1,
                delay: 1.2,
                ease: "power2.out"
            });

            // Table rows animation
            gsap.fromTo('.project-row', {
                x: -100,
                opacity: 0
            }, {
                x: 0,
                opacity: 1,
                duration: 0.8,
                stagger: 0.1,
                delay: 1.5,
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

        function initializeDataTable() {
            // Sort functionality
            document.querySelectorAll('[data-sort]').forEach(header => {
                header.addEventListener('click', () => {
                    const field = header.dataset.sort;
                    currentSort.direction = currentSort.field === field && currentSort.direction === 'asc' ? 'desc' : 'asc';
                    currentSort.field = field;

                    // Update sort indicators with animation
                    document.querySelectorAll('[data-sort] i').forEach(icon => {
                        gsap.to(icon, {
                            rotation: 0,
                            duration: 0.3,
                            ease: "power2.out"
                        });
                        icon.className = 'fas fa-sort text-cyan-400/50';
                    });

                    const icon = header.querySelector('i');
                    gsap.to(icon, {
                        rotation: currentSort.direction === 'asc' ? 180 : 0,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                    icon.className = `fas fa-sort-${currentSort.direction === 'asc' ? 'up' : 'down'} text-cyan-400`;

                    // Reload with new sort
                    reloadProjects();
                });
            });
        }

        function initializeFilters() {
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const featuredFilter = document.getElementById('featuredFilter');
            const perPageFilter = document.getElementById('perPageFilter');

            let searchTimeout;

            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    reloadProjects();
                }, 500);
            });

            [statusFilter, featuredFilter, perPageFilter].forEach(filter => {
                filter.addEventListener('change', reloadProjects);
            });
        }

        function initializeBulkActions() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const projectCheckboxes = document.querySelectorAll('.project-checkbox');
            const selectAllBtn = document.getElementById('selectAllBtn');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const selectedCount = document.getElementById('selectedCount');

            // Select all checkbox functionality
            selectAllCheckbox.addEventListener('change', (e) => {
                projectCheckboxes.forEach(cb => {
                    cb.checked = e.target.checked;
                    updateProjectSelection(cb.value, e.target.checked);
                });

                // Animate the change
                gsap.to(projectCheckboxes, {
                    scale: 1.1,
                    duration: 0.2,
                    yoyo: true,
                    repeat: 1,
                    ease: "power2.out"
                });
            });

            // Individual checkbox functionality
            projectCheckboxes.forEach(cb => {
                cb.addEventListener('change', (e) => {
                    updateProjectSelection(e.target.value, e.target.checked);
                    updateSelectAllCheckbox();

                    // Animate the checkbox
                    gsap.to(e.target, {
                        scale: 1.2,
                        duration: 0.2,
                        yoyo: true,
                        repeat: 1,
                        ease: "power2.out"
                    });
                });
            });

            selectAllBtn.addEventListener('click', () => {
                const allSelected = Array.from(projectCheckboxes).every(cb => cb.checked);

                projectCheckboxes.forEach(cb => {
                    cb.checked = !allSelected;
                    updateProjectSelection(cb.value, !allSelected);
                });

                selectAllCheckbox.checked = !allSelected;
                updateSelectAllCheckbox();

                // Animate the button
                gsap.to(selectAllBtn, {
                    rotation: 360,
                    duration: 0.6,
                    ease: "power2.out"
                });
            });

            bulkDeleteBtn.addEventListener('click', () => {
                if (selectedProjects.size > 0) {
                    if (confirm(`Are you sure you want to delete ${selectedProjects.size} selected projects?`)) {
                        bulkDeleteProjects();
                    }
                }
            });
        }

        function updateSelectAllCheckbox() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const projectCheckboxes = document.querySelectorAll('.project-checkbox');
            const allSelected = Array.from(projectCheckboxes).every(cb => cb.checked);
            const someSelected = Array.from(projectCheckboxes).some(cb => cb.checked);

            selectAllCheckbox.checked = allSelected;
            selectAllCheckbox.indeterminate = someSelected && !allSelected;
        }

        function updateProjectSelection(projectId, selected) {
            if (selected) {
                selectedProjects.add(projectId);
            } else {
                selectedProjects.delete(projectId);
            }

            updateBulkActions();
        }

        function updateBulkActions() {
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const selectedCount = document.getElementById('selectedCount');

            selectedCount.textContent = selectedProjects.size;

            if (selectedProjects.size > 0) {
                bulkDeleteBtn.classList.remove('hidden');
                gsap.fromTo(bulkDeleteBtn, {
                    scale: 0,
                    opacity: 0
                }, {
                    scale: 1,
                    opacity: 1,
                    duration: 0.5,
                    ease: "back.out(1.7)"
                });
            } else {
                gsap.to(bulkDeleteBtn, {
                    scale: 0,
                    opacity: 0,
                    duration: 0.3,
                    ease: "power2.in",
                    onComplete: () => bulkDeleteBtn.classList.add('hidden')
                });
            }
        }

        function reloadProjects() {
            const search = document.getElementById('searchInput').value;
            const status = document.getElementById('statusFilter').value;
            const featured = document.getElementById('featuredFilter').value;
            const perPage = document.getElementById('perPageFilter').value;

            const params = new URLSearchParams({
                search: search,
                status: status,
                featured: featured,
                per_page: perPage,
                sort_field: currentSort.field,
                sort_direction: currentSort.direction
            });

            // Animate the transition
            gsap.to('.backdrop-blur-xl', {
                opacity: 0.5,
                scale: 0.98,
                duration: 0.3,
                ease: "power2.in",
                onComplete: () => {
                    window.location.href = `${window.location.pathname}?${params.toString()}`;
                }
            });
        }

        function toggleProjectStatus(projectId, currentStatus) {
            // Animate the button
            const button = event.target.closest('button');
            gsap.to(button, {
                scale: 0.9,
                duration: 0.1,
                yoyo: true,
                repeat: 1,
                ease: "power2.out"
            });

            fetch(`/admin/projects/${projectId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showMessage(data.message, 'success');
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        showMessage('Failed to update status', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('An error occurred', 'error');
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
                            setTimeout(() => window.location.reload(), 1000);
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

        function bulkDeleteProjects() {
            const projectIds = Array.from(selectedProjects);

            // Animate the bulk delete button
            const button = event.target;
            gsap.to(button, {
                scale: 0.9,
                duration: 0.1,
                yoyo: true,
                repeat: 1,
                ease: "power2.out"
            });

            fetch('/admin/projects/bulk-delete', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ project_ids: projectIds }),
            })
                .then(response => {
                    if (response.ok) {
                        showMessage(`${projectIds.length} projects deleted successfully`, 'success');
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        showMessage('Failed to delete projects', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('An error occurred', 'error');
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

        // Add scroll-triggered animations
        if (window.ScrollTrigger) {
            ScrollTrigger.batch('.project-row', {
                onEnter: (elements) => {
                    gsap.fromTo(elements, {
                        x: -50,
                        opacity: 0
                    }, {
                        x: 0,
                        opacity: 1,
                        duration: 0.8,
                        stagger: 0.1,
                        ease: "power2.out"
                    });
                },
                start: "top 90%"
            });
        }
    </script>
@endpush