@extends('layouts.admin')

@section('title', 'Projects')
@section('page-title', 'Projects')
@section('page-subtitle', 'Search, sort and maintain the portfolio entries shown across the site.')

@section('page-actions')
    <a href="{{ route('admin.projects.create') }}"
        class="admin-focus inline-flex items-center gap-2 rounded-2xl bg-cyan-300 px-4 py-2.5 text-sm font-semibold text-slate-950 transition-colors duration-200 hover:bg-cyan-200">
        <i class="fa-solid fa-plus" aria-hidden="true"></i>
        <span>New Project</span>
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
                    <i class="fa-solid fa-diagram-project text-cyan-300/80" aria-hidden="true"></i>
                </div>
            </article>
            <article class="admin-surface rounded-[1.6rem] p-5">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Active</p>
                <div class="mt-3 flex items-end justify-between gap-3">
                    <p class="admin-display text-3xl font-bold text-white tabular-nums">{{ $summary['active'] }}</p>
                    <i class="fa-solid fa-circle-check text-emerald-300/80" aria-hidden="true"></i>
                </div>
            </article>
            <article class="admin-surface rounded-[1.6rem] p-5">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Featured</p>
                <div class="mt-3 flex items-end justify-between gap-3">
                    <p class="admin-display text-3xl font-bold text-white tabular-nums">{{ $summary['featured'] }}</p>
                    <i class="fa-solid fa-star text-amber-300/80" aria-hidden="true"></i>
                </div>
            </article>
            <article class="admin-surface rounded-[1.6rem] p-5">
                <p class="text-xs uppercase tracking-[0.24em] text-slate-400">Hidden</p>
                <div class="mt-3 flex items-end justify-between gap-3">
                    <p class="admin-display text-3xl font-bold text-white tabular-nums">{{ $summary['inactive'] }}</p>
                    <i class="fa-solid fa-eye-slash text-slate-300/80" aria-hidden="true"></i>
                </div>
            </article>
        </section>

        <form method="GET" action="{{ route('admin.projects.index') }}" class="admin-surface rounded-[1.75rem] p-6">
            <div class="grid gap-4 xl:grid-cols-[minmax(0,1.6fr)_repeat(3,minmax(0,0.6fr))]">
                <div>
                    <label for="search" class="mb-2 block text-sm font-semibold text-slate-200">Search</label>
                    <input type="search" id="search" name="search" value="{{ $filters['search'] }}"
                        class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white placeholder:text-slate-500"
                        placeholder="Search projects..." autocomplete="off">
                </div>

                <div>
                    <label for="status" class="mb-2 block text-sm font-semibold text-slate-200">Status</label>
                    <select id="status" name="status"
                        class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white">
                        <option value="">All</option>
                        <option value="1" @selected($filters['status'] === '1')>Active</option>
                        <option value="0" @selected($filters['status'] === '0')>Hidden</option>
                    </select>
                </div>

                <div>
                    <label for="featured" class="mb-2 block text-sm font-semibold text-slate-200">Featured</label>
                    <select id="featured" name="featured"
                        class="admin-focus w-full rounded-2xl border border-white/10 bg-slate-950/70 px-4 py-3 text-white">
                        <option value="">All</option>
                        <option value="1" @selected($filters['featured'] === '1')>Featured</option>
                        <option value="0" @selected($filters['featured'] === '0')>Standard</option>
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
                    {{ $projects->total() }} result{{ $projects->total() === 1 ? '' : 's' }} matching the current filters.
                </p>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('admin.projects.index') }}"
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

        <form method="POST" action="{{ route('admin.projects.bulk-delete') }}" id="projectBulkForm" class="space-y-4"
            data-confirm-message="Delete the selected projects? This action cannot be undone.">
            @csrf
            @method('DELETE')
            <input type="hidden" name="redirect_to" value="{{ url()->full() }}">

            <section class="admin-surface rounded-[1.75rem] p-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <h2 class="admin-display text-xl font-bold text-white">Project Inventory</h2>
                        <p class="mt-1 text-sm text-slate-400">
                            Showing {{ $projects->firstItem() ?? 0 }} to {{ $projects->lastItem() ?? 0 }} of {{ $projects->total() }}.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <span
                            class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-sm text-slate-300">
                            <span id="selectedProjectsCount" class="font-semibold text-white">0</span> selected
                        </span>
                        <button type="submit" id="bulkDeleteButton"
                            class="admin-focus inline-flex items-center gap-2 rounded-2xl border border-rose-400/20 bg-rose-500/10 px-4 py-2.5 text-sm font-semibold text-rose-100 transition-colors duration-200 hover:bg-rose-500/20 disabled:cursor-not-allowed disabled:opacity-50"
                            disabled>
                            <i class="fa-solid fa-trash" aria-hidden="true"></i>
                            <span>Delete Selected</span>
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
                                    <input type="checkbox" id="selectAllProjects"
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
                                        <span>Project</span>
                                        <i class="fa-solid {{ $sortIcon('title') }}" aria-hidden="true"></i>
                                    </a>
                                </th>
                                <th scope="col" class="px-5 py-4">Stack</th>
                                <th scope="col" class="px-5 py-4">
                                    <a href="{{ $sortUrl('featured') }}"
                                        class="admin-focus inline-flex items-center gap-2 rounded-xl px-2 py-1 hover:bg-white/5">
                                        <span>Featured</span>
                                        <i class="fa-solid {{ $sortIcon('featured') }}" aria-hidden="true"></i>
                                    </a>
                                </th>
                                <th scope="col" class="px-5 py-4">
                                    <a href="{{ $sortUrl('is_active') }}"
                                        class="admin-focus inline-flex items-center gap-2 rounded-xl px-2 py-1 hover:bg-white/5">
                                        <span>Status</span>
                                        <i class="fa-solid {{ $sortIcon('is_active') }}" aria-hidden="true"></i>
                                    </a>
                                </th>
                                <th scope="col" class="px-5 py-4">
                                    <a href="{{ $sortUrl('order') }}"
                                        class="admin-focus inline-flex items-center gap-2 rounded-xl px-2 py-1 hover:bg-white/5">
                                        <span>Order</span>
                                        <i class="fa-solid {{ $sortIcon('order') }}" aria-hidden="true"></i>
                                    </a>
                                </th>
                                <th scope="col" class="px-5 py-4">
                                    <a href="{{ $sortUrl('created_at') }}"
                                        class="admin-focus inline-flex items-center gap-2 rounded-xl px-2 py-1 hover:bg-white/5">
                                        <span>Created</span>
                                        <i class="fa-solid {{ $sortIcon('created_at') }}" aria-hidden="true"></i>
                                    </a>
                                </th>
                                <th scope="col" class="px-5 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse($projects as $project)
                                <tr class="align-top text-sm text-slate-200">
                                    <td class="px-5 py-5">
                                        <input type="checkbox" name="project_ids[]" value="{{ $project->id }}"
                                            class="project-selector admin-focus h-4 w-4 rounded border-white/20 bg-slate-950/70 text-cyan-300">
                                    </td>
                                    <td class="px-5 py-5 font-medium text-slate-400">#{{ $project->id }}</td>
                                    <td class="px-5 py-5">
                                        <div class="flex min-w-[18rem] items-start gap-4">
                                            <img src="{{ $project->display_image_url }}" alt="{{ $project->title }}" width="80"
                                                height="60" class="h-16 w-20 rounded-2xl object-cover" loading="lazy">
                                            <div class="min-w-0">
                                                <p class="truncate font-semibold text-white">{{ $project->title }}</p>
                                                <p class="mt-1 max-w-md break-words text-sm leading-6 text-slate-400">
                                                    {{ \Illuminate\Support\Str::limit($project->description, 130) }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-5">
                                        @if(!empty($project->technologies))
                                            <div class="flex max-w-xs flex-wrap gap-2">
                                                @foreach(array_slice($project->technologies, 0, 3) as $technology)
                                                    <span
                                                        class="rounded-full border border-cyan-400/15 bg-cyan-400/10 px-2.5 py-1 text-xs font-medium text-cyan-100">
                                                        {{ $technology }}
                                                    </span>
                                                @endforeach
                                                @if(count($project->technologies) > 3)
                                                    <span
                                                        class="rounded-full border border-white/10 bg-white/5 px-2.5 py-1 text-xs font-medium text-slate-300">
                                                        +{{ count($project->technologies) - 3 }}
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-slate-500">No stack listed</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-5">
                                        <span
                                            class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $project->featured ? 'bg-amber-400/15 text-amber-100' : 'bg-white/5 text-slate-300' }}">
                                            {{ $project->featured ? 'Featured' : 'Standard' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-5">
                                        <form method="POST" action="{{ route('admin.projects.toggle-status', $project) }}">
                                            @csrf
                                            <input type="hidden" name="redirect_to" value="{{ url()->full() }}">
                                            <button type="submit"
                                                class="admin-focus inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-semibold {{ $project->is_active ? 'bg-emerald-400/15 text-emerald-100' : 'bg-slate-700 text-slate-200' }}">
                                                <span class="h-2 w-2 rounded-full {{ $project->is_active ? 'bg-emerald-300' : 'bg-slate-400' }}"></span>
                                                {{ $project->is_active ? 'Active' : 'Hidden' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-5 py-5 font-medium tabular-nums text-slate-300">{{ $project->order }}</td>
                                    <td class="px-5 py-5 text-slate-400">
                                        <time datetime="{{ $project->created_at->toDateString() }}">
                                            {{ $project->created_at->format('M d, Y') }}
                                        </time>
                                    </td>
                                    <td class="px-5 py-5">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.projects.show', $project) }}"
                                                class="admin-focus inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-slate-200 transition-colors duration-200 hover:bg-white/10"
                                                aria-label="View {{ $project->title }}">
                                                <i class="fa-solid fa-eye" aria-hidden="true"></i>
                                            </a>
                                            <a href="{{ route('admin.projects.edit', $project) }}"
                                                class="admin-focus inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-slate-200 transition-colors duration-200 hover:bg-white/10"
                                                aria-label="Edit {{ $project->title }}">
                                                <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.projects.destroy', $project) }}"
                                                data-confirm-message="Delete {{ $project->title }}? This action cannot be undone.">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="redirect_to" value="{{ url()->full() }}">
                                                <button type="submit"
                                                    class="admin-focus inline-flex h-10 w-10 items-center justify-center rounded-2xl border border-rose-400/15 bg-rose-500/10 text-rose-100 transition-colors duration-200 hover:bg-rose-500/20"
                                                    aria-label="Delete {{ $project->title }}">
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
                                            <div
                                                class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl border border-white/10 bg-white/5 text-slate-300">
                                                <i class="fa-solid fa-folder-open" aria-hidden="true"></i>
                                            </div>
                                            <h3 class="admin-display mt-5 text-2xl font-bold text-white">No projects found</h3>
                                            <p class="mt-2 text-sm leading-6 text-slate-400">
                                                Adjust the filters or create a new project to populate this module.
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

        @if($projects->hasPages())
            <div class="pt-2">
                {{ $projects->links('components.pagination') }}
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const bulkForm = document.getElementById('projectBulkForm');
            const selectAll = document.getElementById('selectAllProjects');
            const selectors = Array.from(document.querySelectorAll('.project-selector'));
            const selectedCount = document.getElementById('selectedProjectsCount');
            const bulkDeleteButton = document.getElementById('bulkDeleteButton');

            const syncSelectionState = () => {
                const checked = selectors.filter((checkbox) => checkbox.checked);
                selectedCount.textContent = checked.length.toString();
                bulkDeleteButton.disabled = checked.length === 0;

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
                    if (bulkDeleteButton.disabled) {
                        event.preventDefault();
                    }
                });
            }
        });
    </script>
@endpush
