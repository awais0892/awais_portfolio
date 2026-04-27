@extends('layouts.admin')

@section('title', $project->title)
@section('page-title', 'Project Details')
@section('page-subtitle', 'Review the published metadata, asset source and visibility for this portfolio entry.')

@section('page-actions')
    <div class="flex flex-wrap items-center gap-3">
        <a href="{{ route('admin.projects.edit', $project) }}"
            class="admin-focus inline-flex items-center gap-2 rounded-2xl bg-cyan-300 px-4 py-2.5 text-sm font-semibold text-slate-950 transition-colors duration-200 hover:bg-cyan-200">
            <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
            <span>Edit Project</span>
        </a>
        <a href="{{ route('admin.projects.index') }}"
            class="admin-focus inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-semibold text-slate-200 transition-colors duration-200 hover:bg-white/10">
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
            <span>Back</span>
        </a>
    </div>
@endsection

@section('content')
    <div class="space-y-6">
        <section class="grid gap-6 xl:grid-cols-[minmax(0,1.5fr)_minmax(0,0.8fr)]">
            <article class="admin-surface overflow-hidden rounded-[1.75rem]">
                <img src="{{ $project->display_image_url }}" alt="{{ $project->title }}" width="1280" height="720"
                    class="h-72 w-full object-cover sm:h-96" fetchpriority="high">
                <div class="space-y-6 p-6 sm:p-8">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span
                                    class="rounded-full px-3 py-1 text-xs font-semibold {{ $project->is_active ? 'bg-emerald-400/15 text-emerald-100' : 'bg-slate-700 text-slate-200' }}">
                                    {{ $project->is_active ? 'Active' : 'Hidden' }}
                                </span>
                                <span
                                    class="rounded-full px-3 py-1 text-xs font-semibold {{ $project->featured ? 'bg-amber-400/15 text-amber-100' : 'bg-white/5 text-slate-300' }}">
                                    {{ $project->featured ? 'Featured' : 'Standard' }}
                                </span>
                            </div>
                            <h2 class="admin-display mt-4 text-3xl font-bold text-white sm:text-4xl">{{ $project->title }}</h2>
                            <p class="mt-3 max-w-3xl text-base leading-7 text-slate-300">{{ $project->description }}</p>
                        </div>

                        <form method="POST" action="{{ route('admin.projects.toggle-status', $project) }}">
                            @csrf
                            <input type="hidden" name="redirect_to" value="{{ url()->full() }}">
                            <button type="submit"
                                class="admin-focus inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-semibold text-slate-200 transition-colors duration-200 hover:bg-white/10">
                                <i class="fa-solid {{ $project->is_active ? 'fa-eye-slash' : 'fa-eye' }}" aria-hidden="true"></i>
                                <span>{{ $project->is_active ? 'Hide Project' : 'Make Active' }}</span>
                            </button>
                        </form>
                    </div>

                    @if($project->long_description)
                        <div class="rounded-[1.5rem] border border-white/10 bg-slate-950/60 p-5">
                            <h3 class="mb-3 text-sm font-semibold uppercase tracking-[0.18em] text-slate-400">Detailed Description</h3>
                            <div class="space-y-4 whitespace-pre-line text-sm leading-7 text-slate-300">
                                {{ $project->long_description }}
                            </div>
                        </div>
                    @endif
                </div>
            </article>

            <aside class="space-y-6">
                <section class="admin-surface rounded-[1.75rem] p-6">
                    <h3 class="admin-display text-xl font-bold text-white">Publishing</h3>
                    <dl class="mt-5 space-y-4 text-sm">
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-slate-400">Order</dt>
                            <dd class="font-semibold tabular-nums text-white">{{ $project->order }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-slate-400">Created</dt>
                            <dd class="font-semibold text-white">{{ $project->created_at->format('M d, Y') }}</dd>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <dt class="text-slate-400">Updated</dt>
                            <dd class="font-semibold text-white">{{ $project->updated_at->format('M d, Y') }}</dd>
                        </div>
                    </dl>
                </section>

                <section class="admin-surface rounded-[1.75rem] p-6">
                    <h3 class="admin-display text-xl font-bold text-white">Links</h3>
                    <div class="mt-5 space-y-3">
                        @if($project->live_url)
                            <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer"
                                class="admin-focus flex items-center justify-between gap-3 rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-200 transition-colors duration-200 hover:bg-white/10">
                                <span class="truncate">Live Demo</span>
                                <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                            </a>
                        @endif

                        @if($project->github_url)
                            <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer"
                                class="admin-focus flex items-center justify-between gap-3 rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-200 transition-colors duration-200 hover:bg-white/10">
                                <span class="truncate">Source Repository</span>
                                <i class="fa-brands fa-github" aria-hidden="true"></i>
                            </a>
                        @endif

                        @if(!$project->live_url && !$project->github_url)
                            <p class="rounded-2xl border border-dashed border-white/10 px-4 py-3 text-sm text-slate-400">
                                No live or source links are attached to this project yet.
                            </p>
                        @endif
                    </div>
                </section>

                <section class="admin-surface rounded-[1.75rem] p-6">
                    <h3 class="admin-display text-xl font-bold text-white">Technology Stack</h3>
                    @if(!empty($project->technologies))
                        <div class="mt-5 flex flex-wrap gap-2">
                            @foreach($project->technologies as $technology)
                                <span
                                    class="rounded-full border border-cyan-400/15 bg-cyan-400/10 px-3 py-1.5 text-xs font-semibold text-cyan-100">
                                    {{ $technology }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-5 text-sm text-slate-400">No technologies have been listed for this project.</p>
                    @endif
                </section>

                <section class="admin-surface rounded-[1.75rem] p-6">
                    <h3 class="admin-display text-xl font-bold text-white">Image Sources</h3>
                    <dl class="mt-5 space-y-4 text-sm text-slate-300">
                        <div>
                            <dt class="font-semibold text-white">Uploaded Asset</dt>
                            <dd class="mt-1 break-words text-slate-400">{{ $project->image ?? 'Not set' }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-white">Hosted URL</dt>
                            <dd class="mt-1 break-words text-slate-400">{{ $project->image_url ?? 'Not set' }}</dd>
                        </div>
                        <div>
                            <dt class="font-semibold text-white">Fallback URL</dt>
                            <dd class="mt-1 break-words text-slate-400">{{ $project->fallback_image_url ?? 'Not set' }}</dd>
                        </div>
                    </dl>
                </section>

                <section class="admin-surface rounded-[1.75rem] p-6">
                    <h3 class="admin-display text-xl font-bold text-white">Danger Zone</h3>
                    <p class="mt-2 text-sm leading-6 text-slate-400">
                        Deleting a project removes the record and any uploaded local image from storage.
                    </p>
                    <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="mt-5"
                        data-confirm-message="Delete {{ $project->title }}? This action cannot be undone.">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="redirect_to" value="{{ route('admin.projects.index') }}">
                        <button type="submit"
                            class="admin-focus inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-rose-400/20 bg-rose-500/10 px-5 py-3 text-sm font-semibold text-rose-100 transition-colors duration-200 hover:bg-rose-500/20">
                            <i class="fa-solid fa-trash" aria-hidden="true"></i>
                            <span>Delete Project</span>
                        </button>
                    </form>
                </section>
            </aside>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('submit', (event) => {
            const form = event.target;
            const message = form.getAttribute('data-confirm-message');

            if (message && !window.confirm(message)) {
                event.preventDefault();
            }
        });
    </script>
@endpush
