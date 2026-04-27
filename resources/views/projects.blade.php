@extends('layouts.app')

@section('title', 'Projects | Awais Ahmad')
@section('description', 'Explore portfolio projects by Awais Ahmad, including Laravel, React and full-stack application work.')

@section('content')
    <section class="relative py-20">
        <div class="mx-auto max-w-6xl">
            <div class="mb-14 max-w-3xl">
                <p class="text-sm uppercase tracking-[0.28em] text-cyan-300/70 gsap-reveal">Selected Work</p>
                <h1 class="mt-4 text-balance text-5xl font-orbitron text-white gsap-reveal sm:text-6xl">
                    Projects Built Around Product, Performance & Delivery
                </h1>
                <p class="mt-5 max-w-2xl text-pretty text-lg leading-8 text-slate-300 gsap-reveal" data-gsap-delay="0.08">
                    A running archive of shipped applications, internal tools and experiments with a focus on practical
                    architecture, resilient backends and polished interfaces.
                </p>
            </div>

            @if($projects->count())
                <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-3">
                    @foreach($projects as $project)
                        <article
                            class="glass-card gsap-reveal overflow-hidden rounded-[1.75rem] border border-white/10 bg-slate-950/55"
                            data-gsap-delay="{{ ($loop->index % 6) * 0.06 }}">
                            <a href="{{ route('project.show', $project->slug) }}" class="block">
                                <img src="{{ $project->display_image_url }}" alt="{{ $project->title }}" width="800"
                                    height="560" class="h-56 w-full object-cover" loading="lazy">
                            </a>
                            <div class="space-y-5 p-6">
                                <div class="flex items-center gap-2">
                                    @if($project->featured)
                                        <span class="rounded-full bg-amber-400/15 px-3 py-1 text-xs font-semibold text-amber-200">
                                            Featured
                                        </span>
                                    @endif
                                    <span
                                        class="rounded-full {{ $project->is_active ? 'bg-emerald-400/15 text-emerald-200' : 'bg-slate-700/70 text-slate-200' }} px-3 py-1 text-xs font-semibold">
                                        {{ $project->is_active ? 'Active' : 'Archived' }}
                                    </span>
                                </div>

                                <div>
                                    <h2 class="text-2xl font-orbitron text-white">{{ $project->title }}</h2>
                                    <p class="mt-3 text-sm leading-7 text-slate-300">
                                        {{ \Illuminate\Support\Str::limit($project->description, 145) }}
                                    </p>
                                </div>

                                @if(!empty($project->technologies))
                                    <div class="flex flex-wrap gap-2">
                                        @foreach(array_slice($project->technologies, 0, 4) as $technology)
                                            <span
                                                class="rounded-full border border-cyan-500/20 bg-cyan-500/10 px-3 py-1 text-xs font-semibold text-cyan-100">
                                                {{ $technology }}
                                            </span>
                                        @endforeach
                                        @if(count($project->technologies) > 4)
                                            <span
                                                class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-semibold text-slate-300">
                                                +{{ count($project->technologies) - 4 }}
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                <div class="flex flex-wrap gap-3 pt-1">
                                    <a href="{{ route('project.show', $project->slug) }}"
                                        class="inline-flex items-center gap-2 rounded-full bg-cyan-400 px-4 py-2 text-sm font-semibold text-slate-950 transition-colors duration-200 hover:bg-cyan-300">
                                        View Details
                                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                                    </a>
                                    @if($project->live_url)
                                        <a href="{{ $project->live_url }}" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center gap-2 rounded-full border border-cyan-500/30 px-4 py-2 text-sm font-semibold text-cyan-100 transition-colors duration-200 hover:bg-cyan-500/10">
                                            Live Demo
                                        </a>
                                    @endif
                                    @if($project->github_url)
                                        <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center gap-2 rounded-full border border-white/10 px-4 py-2 text-sm font-semibold text-slate-200 transition-colors duration-200 hover:bg-white/5">
                                            Source
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="glass-card rounded-[1.75rem] border border-dashed border-white/10 px-8 py-16 text-center">
                    <div
                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl border border-white/10 bg-white/5 text-slate-200">
                        <i class="fa-solid fa-folder-open" aria-hidden="true"></i>
                    </div>
                    <h2 class="mt-5 text-3xl font-orbitron text-white">No projects published yet</h2>
                    <p class="mx-auto mt-3 max-w-xl text-base leading-7 text-slate-300">
                        This section will be updated once the next project batch is ready for publication.
                    </p>
                </div>
            @endif

            @if($projects->hasPages())
                <div class="mt-12">
                    {{ $projects->links('components.pagination') }}
                </div>
            @endif
        </div>
    </section>
@endsection
