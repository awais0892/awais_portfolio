@extends('layouts.app')

@section('title', $project->title . ' | Awais Ahmad')
@section('description', \Illuminate\Support\Str::limit(strip_tags($project->description), 150))

@section('content')
    <section class="relative py-20">
        <div class="mx-auto max-w-6xl">
            <a href="{{ route('projects') }}"
                class="mb-8 inline-flex items-center gap-2 text-sm font-semibold text-cyan-300 transition-colors duration-200 hover:text-cyan-200">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                <span>Back To Projects</span>
            </a>

            <div class="grid gap-10 xl:grid-cols-[minmax(0,1.5fr)_minmax(0,0.75fr)]">
                <article class="space-y-8">
                    <div class="glass-card overflow-hidden rounded-[2rem] border border-white/10">
                        <img src="{{ $project->display_image_url }}" alt="{{ $project->title }}" width="1400"
                            height="840" class="h-[22rem] w-full object-cover sm:h-[28rem]" fetchpriority="high">
                    </div>

                    <div class="space-y-5">
                        <div class="flex flex-wrap items-center gap-2">
                            @if($project->featured)
                                <span class="rounded-full bg-amber-400/15 px-3 py-1 text-xs font-semibold text-amber-200">
                                    Featured
                                </span>
                            @endif
                            <span
                                class="rounded-full {{ $project->is_active ? 'bg-emerald-400/15 text-emerald-200' : 'bg-slate-700/70 text-slate-200' }} px-3 py-1 text-xs font-semibold">
                                {{ $project->is_active ? 'Active Project' : 'Archived Project' }}
                            </span>
                            <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-semibold text-slate-300">
                                Added {{ $project->created_at->format('M Y') }}
                            </span>
                        </div>

                        <div>
                            <h1 class="text-balance text-4xl font-orbitron text-white sm:text-5xl">{{ $project->title }}</h1>
                            <p class="mt-4 max-w-4xl text-pretty text-lg leading-8 text-slate-300">{{ $project->description }}</p>
                        </div>
                    </div>

                    <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_18rem]">
                        <div class="glass-card rounded-[1.75rem] border border-white/10 p-7">
                            <h2 class="text-2xl font-orbitron text-white">Project Overview</h2>
                            <div class="mt-5 whitespace-pre-line text-base leading-8 text-slate-300">
                                {{ $project->long_description ?: $project->description }}
                            </div>
                        </div>

                        <aside class="glass-card rounded-[1.75rem] border border-white/10 p-7">
                            <h2 class="text-xl font-orbitron text-white">Links</h2>
                            <div class="mt-5 space-y-3">
                                @if($project->live_url)
                                    <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer"
                                        class="inline-flex w-full items-center justify-between gap-3 rounded-2xl bg-cyan-400 px-4 py-3 text-sm font-semibold text-slate-950 transition-colors duration-200 hover:bg-cyan-300">
                                        <span>Open Live Demo</span>
                                        <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i>
                                    </a>
                                @endif

                                @if($project->github_url)
                                    <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer"
                                        class="inline-flex w-full items-center justify-between gap-3 rounded-2xl border border-white/10 px-4 py-3 text-sm font-semibold text-slate-100 transition-colors duration-200 hover:bg-white/5">
                                        <span>View Source Code</span>
                                        <i class="fa-brands fa-github" aria-hidden="true"></i>
                                    </a>
                                @endif

                                @if(!$project->live_url && !$project->github_url)
                                    <p class="rounded-2xl border border-dashed border-white/10 px-4 py-3 text-sm leading-6 text-slate-400">
                                        Public links are not available for this project.
                                    </p>
                                @endif
                            </div>

                            <div class="mt-8">
                                <h3 class="text-sm uppercase tracking-[0.18em] text-slate-400">Delivery Notes</h3>
                                <dl class="mt-4 space-y-3 text-sm">
                                    <div class="flex items-center justify-between gap-4">
                                        <dt class="text-slate-400">Created</dt>
                                        <dd class="font-semibold text-white">{{ $project->created_at->format('M d, Y') }}</dd>
                                    </div>
                                    <div class="flex items-center justify-between gap-4">
                                        <dt class="text-slate-400">Updated</dt>
                                        <dd class="font-semibold text-white">{{ $project->updated_at->format('M d, Y') }}</dd>
                                    </div>
                                    <div class="flex items-center justify-between gap-4">
                                        <dt class="text-slate-400">Order</dt>
                                        <dd class="font-semibold tabular-nums text-white">{{ $project->order }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </aside>
                    </div>

                    @if(!empty($project->technologies))
                        <div class="glass-card rounded-[1.75rem] border border-white/10 p-7">
                            <h2 class="text-2xl font-orbitron text-white">Technology Stack</h2>
                            <div class="mt-5 flex flex-wrap gap-3">
                                @foreach($project->technologies as $technology)
                                    <span
                                        class="rounded-full border border-cyan-500/20 bg-cyan-500/10 px-4 py-2 text-sm font-semibold text-cyan-100">
                                        {{ $technology }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </article>

                <aside class="space-y-6">
                    <div class="glass-card rounded-[1.75rem] border border-white/10 p-7">
                        <h2 class="text-xl font-orbitron text-white">Project Snapshot</h2>
                        <p class="mt-3 text-sm leading-7 text-slate-300">
                            This entry is kept intentionally focused on the shipped scope, stack and delivery links rather
                            than speculative metadata.
                        </p>
                    </div>

                    @if($relatedProjects->count() > 0)
                        <div class="glass-card rounded-[1.75rem] border border-white/10 p-7">
                            <h2 class="text-xl font-orbitron text-white">Related Projects</h2>
                            <div class="mt-5 space-y-4">
                                @foreach($relatedProjects as $relatedProject)
                                    <article class="overflow-hidden rounded-[1.5rem] border border-white/10 bg-slate-950/55">
                                        <a href="{{ route('project.show', $relatedProject->slug) }}" class="block">
                                            <img src="{{ $relatedProject->display_image_url }}" alt="{{ $relatedProject->title }}"
                                                width="600" height="360" class="h-36 w-full object-cover" loading="lazy">
                                        </a>
                                        <div class="space-y-3 p-4">
                                            <h3 class="text-lg font-orbitron text-white">{{ $relatedProject->title }}</h3>
                                            <p class="text-sm leading-6 text-slate-300">
                                                {{ \Illuminate\Support\Str::limit($relatedProject->description, 92) }}
                                            </p>
                                            <a href="{{ route('project.show', $relatedProject->slug) }}"
                                                class="inline-flex items-center gap-2 text-sm font-semibold text-cyan-300 transition-colors duration-200 hover:text-cyan-200">
                                                View Details
                                                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </section>
@endsection
