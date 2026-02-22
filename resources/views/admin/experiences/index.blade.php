@extends('layouts.app')

@section('title', 'Admin - Experience Management')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 relative overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl animate-pulse"></div>
            <div
                class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl animate-pulse delay-1000">
            </div>
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl animate-pulse delay-500">
            </div>
        </div>
        <div
            class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:50px_50px]">
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header -->
            <div class="mb-12 text-center">
                <div class="inline-block">
                    <h1
                        class="text-6xl font-black bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 bg-clip-text text-transparent mb-4 tracking-tight">
                        EXPERIENCE MANAGEMENT
                    </h1>
                    <div class="h-1 w-32 bg-gradient-to-r from-cyan-400 to-purple-600 mx-auto rounded-full"></div>
                </div>
                <p class="text-cyan-300/80 text-xl mt-6 font-light tracking-wide">Manage your work experience and career
                    history</p>
            </div>

            <!-- Create Button -->
            <div class="text-center mb-12">
                <a href="{{ route('admin.experiences.create') }}"
                    class="group relative inline-flex items-center px-8 py-4 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold text-lg rounded-2xl overflow-hidden transition-all duration-500 hover:scale-105 hover:shadow-2xl hover:shadow-cyan-500/25">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-cyan-600 to-blue-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                    <div class="relative flex items-center">
                        <div
                            class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-plus text-white text-sm"></i>
                        </div>
                        <span class="tracking-wider">ADD EXPERIENCE</span>
                    </div>
                </a>
            </div>

            <!-- Filters -->
            <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-6 shadow-2xl mb-8">
                <form method="GET" action="{{ route('admin.experiences.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <label
                                class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-2">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search by title, company..."
                                class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-2">Current
                                Job</label>
                            <select name="current"
                                class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                                <option value="">All</option>
                                <option value="1" {{ request('current') == '1' ? 'selected' : '' }}>Current</option>
                                <option value="0" {{ request('current') == '0' ? 'selected' : '' }}>Past</option>
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-2">Status</label>
                            <select name="status"
                                class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                                <option value="">All Statuses</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-2">Sort
                                By</label>
                            <select name="sort_by"
                                class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                                <option value="order" {{ request('sort_by') == 'order' ? 'selected' : '' }}>Order</option>
                                <option value="start_date" {{ request('sort_by') == 'start_date' ? 'selected' : '' }}>Start
                                    Date</option>
                                <option value="company" {{ request('sort_by') == 'company' ? 'selected' : '' }}>Company
                                </option>
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Created
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <button type="submit"
                            class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 text-cyan-300 border border-cyan-400/30 rounded-xl hover:from-cyan-500/30 hover:to-blue-500/30 transition-all duration-300 hover:scale-105">
                            <i class="fas fa-search mr-3"></i><span class="font-semibold">Apply Filters</span>
                        </button>
                        <a href="{{ route('admin.experiences.index') }}"
                            class="text-cyan-300 hover:text-cyan-200 transition-colors duration-300">
                            <i class="fas fa-times mr-2"></i>Clear Filters
                        </a>
                    </div>
                </form>
            </div>

            <!-- Bulk Actions -->
            <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-6 shadow-2xl mb-8">
                <form id="bulkActionForm" method="POST" action="{{ route('admin.experiences.bulk-action') }}"
                    class="space-y-4">
                    @csrf
                    <div
                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                        <div class="flex items-center space-x-4">
                            <select id="bulkAction" name="action"
                                class="bg-white/10 border border-white/20 rounded-xl px-4 py-2 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                                <option value="">Bulk Actions</option>
                                <option value="activate">Activate Selected</option>
                                <option value="deactivate">Deactivate Selected</option>
                                <option value="delete">Delete Selected</option>
                            </select>
                            <button type="submit" id="bulkActionBtn" disabled
                                class="px-6 py-2 bg-gradient-to-r from-red-500/20 to-pink-500/20 text-red-300 border border-red-400/30 rounded-xl hover:from-red-500/30 hover:to-pink-500/30 transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                                Apply
                            </button>
                        </div>
                        <div class="text-cyan-300/70 text-sm"><span id="selectedCount">0</span> experiences selected</div>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-white/5">
                            <tr>
                                <th class="px-6 py-4 text-left">
                                    <input type="checkbox" id="selectAll"
                                        class="w-5 h-5 rounded-lg border-white/30 text-cyan-500 focus:ring-cyan-400 bg-white/10">
                                </th>
                                <th class="px-6 py-4 text-left text-cyan-300 font-bold uppercase tracking-wider">Company
                                </th>
                                <th class="px-6 py-4 text-left text-cyan-300 font-bold uppercase tracking-wider">Role</th>
                                <th class="px-6 py-4 text-left text-cyan-300 font-bold uppercase tracking-wider">Duration
                                </th>
                                <th class="px-6 py-4 text-left text-cyan-300 font-bold uppercase tracking-wider">Location
                                </th>
                                <th class="px-6 py-4 text-left text-cyan-300 font-bold uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-cyan-300 font-bold uppercase tracking-wider">Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse($experiences as $experience)
                                <tr class="group hover:bg-white/5 transition-all duration-300">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" name="selected_experiences[]" value="{{ $experience->id }}"
                                            class="exp-checkbox w-5 h-5 rounded-lg border-white/30 text-cyan-500 focus:ring-cyan-400 bg-white/10"
                                            form="bulkActionForm">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-4">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-xl overflow-hidden flex items-center justify-center flex-shrink-0">
                                                @if($experience->company_logo)
                                                    <img src="{{ $experience->company_logo }}" alt="{{ $experience->company }}"
                                                        class="w-full h-full object-contain p-1">
                                                @else
                                                    <i class="fas fa-building text-cyan-300/50 text-xl"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <h3
                                                    class="text-white font-semibold group-hover:text-cyan-300 transition-colors duration-300">
                                                    {{ $experience->company }}</h3>
                                                <p class="text-cyan-300/50 text-xs">{{ $experience->location }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="text-white font-medium">{{ $experience->title }}</p>
                                            @if($experience->is_current)
                                                <span
                                                    class="px-2 py-0.5 bg-emerald-500/20 text-emerald-300 text-xs rounded-lg mt-1 inline-block">Current</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-white text-sm">{{ $experience->duration }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-cyan-300/70 text-sm">{{ $experience->location ?? '—' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-3 py-1 border rounded-lg text-sm {{ $experience->is_active ? 'bg-green-500/20 text-green-300 border-green-400/30' : 'bg-gray-500/20 text-gray-300 border-gray-400/30' }}">
                                            {{ $experience->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('admin.experiences.edit', $experience) }}"
                                                class="text-blue-400 hover:text-blue-300 transition-colors duration-300"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button onclick="toggleExpStatus({{ $experience->id }})"
                                                class="text-{{ $experience->is_active ? 'green' : 'gray' }}-400 hover:text-{{ $experience->is_active ? 'green' : 'gray' }}-300 transition-colors duration-300"
                                                title="Toggle Status">
                                                <i class="fas fa-toggle-{{ $experience->is_active ? 'on' : 'off' }}"></i>
                                            </button>
                                            <form method="POST" action="{{ route('admin.experiences.destroy', $experience) }}"
                                                class="inline" onsubmit="return confirm('Delete this experience?')">
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
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="text-cyan-300/70">
                                            <i class="fas fa-briefcase text-4xl mb-4"></i>
                                            <p class="text-xl">No experiences found</p>
                                            <p class="text-sm mt-2">Add your first work experience to get started</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($experiences->hasPages())
                    <div class="px-6 py-4 border-t border-white/10">
                        {{ $experiences->appends(request()->query())->links('components.pagination') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            initializeBulkActions();

            gsap.fromTo('.text-6xl', { y: 100, opacity: 0, scale: 0.8 }, { y: 0, opacity: 1, scale: 1, duration: 1.5, ease: "back.out(1.7)" });
            gsap.fromTo('.h-1', { scaleX: 0 }, { scaleX: 1, duration: 1.5, delay: 0.5, ease: "power2.out" });
            gsap.fromTo('.backdrop-blur-xl', { y: 50, opacity: 0, scale: 0.95 }, { y: 0, opacity: 1, scale: 1, duration: 1.2, delay: 1, stagger: 0.2, ease: "power2.out" });
            gsap.fromTo('tbody tr', { y: 30, opacity: 0 }, { y: 0, opacity: 1, duration: 0.6, stagger: 0.05, delay: 1.5, ease: "power2.out" });

        @if(session('success')) showMessage('{{ session('success') }}', 'success'); @endif
            @if(session('error')) showMessage('{{ session('error') }}', 'error'); @endif
    });

        function initializeBulkActions() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.exp-checkbox');
            const bulkAction = document.getElementById('bulkAction');
            const bulkActionBtn = document.getElementById('bulkActionBtn');
            const selectedCount = document.getElementById('selectedCount');

            selectAll.addEventListener('change', function () {
                checkboxes.forEach(cb => { cb.checked = this.checked; });
                updateState();
            });
            checkboxes.forEach(cb => cb.addEventListener('change', updateState));
            bulkAction.addEventListener('change', updateState);

            function getCount() { return document.querySelectorAll('.exp-checkbox:checked').length; }
            function updateState() {
                const count = getCount();
                selectedCount.textContent = count;
                selectAll.indeterminate = count > 0 && count < checkboxes.length;
                selectAll.checked = count === checkboxes.length && count > 0;
                bulkActionBtn.disabled = !bulkAction.value || count === 0;
            }
        }

        function toggleExpStatus(id) {
            fetch(`/admin/experiences/${id}/toggle-status`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
            })
                .then(r => r.json())
                .then(data => {
                    if (data.success) { showMessage(data.message, 'success'); setTimeout(() => location.reload(), 800); }
                });
        }

        function showMessage(message, type = 'success') {
            let container = document.getElementById('msgContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'msgContainer';
                container.className = 'fixed top-6 right-6 z-50';
                document.body.appendChild(container);
            }
            const cls = type === 'success'
                ? 'backdrop-blur-xl bg-gradient-to-r from-green-500/20 to-emerald-500/20 border border-green-400/30 text-green-300 px-8 py-4 rounded-2xl shadow-2xl flex items-center'
                : 'backdrop-blur-xl bg-gradient-to-r from-red-500/20 to-pink-500/20 border border-red-400/30 text-red-300 px-8 py-4 rounded-2xl shadow-2xl flex items-center';
            container.innerHTML = `<div class="${cls}"><i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-3"></i><span class="font-semibold">${message}</span></div>`;
            gsap.fromTo(container, { x: 100, opacity: 0, scale: 0.8 }, { x: 0, opacity: 1, scale: 1, duration: 0.5, ease: "back.out(1.7)" });
            setTimeout(() => gsap.to(container, { x: 100, opacity: 0, scale: 0.8, duration: 0.5, ease: "power2.in", onComplete: () => container.remove() }), 3000);
        }
    </script>
@endpush