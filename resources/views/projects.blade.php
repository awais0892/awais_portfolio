{{-- resources/views/projects.blade.php --}}
@extends('layouts.app')

@section('title', 'Projects - Awais Ahmad')

@section('content')
    <section class="py-20">
        <h1 class="text-5xl font-orbitron text-center text-white mb-4 gsap-reveal">My Projects</h1>
        <p class="text-gray-300 max-w-2xl mx-auto mb-12 text-lg text-center gsap-reveal" data-gsap-delay="0.1">
            A collection of projects that showcase my skills in full-stack development, from web applications to mobile apps.
        </p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($projects as $project)
                <div class="glass-card rounded-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 gsap-reveal" data-gsap-delay="{{ ($loop->index % 6) * 0.1 }}">
                    <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-orbitron text-white mb-2">{{ $project->title }}</h3>
                        <p class="text-gray-300 mb-4">{{ Str::limit($project->description, 120) }}</p>
                        
                        @if($project->technologies && count($project->technologies) > 0)
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach(array_slice($project->technologies, 0, 4) as $tech)
                                    <span class="bg-cyan-900/50 text-cyan-300 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $tech }}</span>
                                @endforeach
                                @if(count($project->technologies) > 4)
                                    <span class="bg-gray-700/50 text-gray-300 text-xs font-semibold px-2.5 py-1 rounded-full">+{{ count($project->technologies) - 4 }} more</span>
                                @endif
                            </div>
                        @endif
                        
                        <div class="flex gap-4 flex-wrap">
                            @if($project->live_url)
                                <a href="{{ $project->live_url }}" target="_blank" class="text-cyan-400 hover:underline font-semibold text-sm">Live Demo &rarr;</a>
                            @endif
                            @if($project->github_url)
                                <a href="{{ $project->github_url }}" target="_blank" class="text-cyan-400 hover:underline font-semibold text-sm">Source Code &rarr;</a>
                            @endif
                            <a href="{{ route('project.show', $project->slug) }}" class="text-cyan-400 hover:underline font-semibold text-sm">View Details &rarr;</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($projects->hasPages())
            <div class="mt-12">
                {{ $projects->links('components.pagination') }}
            </div>
        @endif
    </section>
@endsection