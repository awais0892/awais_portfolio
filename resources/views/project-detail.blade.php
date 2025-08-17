{{-- resources/views/project-detail.blade.php --}}
@extends('layouts.app')

@section('title', $project->title . ' - Project Details')

@section('content')
    <section class="py-20">
        <div class="max-w-4xl mx-auto">
            <!-- Back Button -->
            <a href="{{ route('projects') }}" class="inline-flex items-center text-cyan-400 hover:text-cyan-300 mb-8 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Back to Projects
            </a>

            <!-- Project Header -->
            <div class="glass-card rounded-lg overflow-hidden mb-8">
                @if($project->image_url)
                    <div class="relative">
                        <img src="{{ $project->image_url }}" 
                             alt="{{ $project->title }}" 
                             class="w-full h-64 md:h-96 object-cover"
                             onerror="this.onerror=null; this.src='{{ $project->fallback_image_url ?? 'https://via.placeholder.com/800x400/1a1a2e/16a085?text=' . urlencode($project->title) }}';">
                        
                        <!-- Image overlay for better text readability -->
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 via-transparent to-transparent"></div>
                        
                        <!-- Project badges overlay -->
                        @if($project->featured || $project->status)
                            <div class="absolute top-4 right-4 flex gap-2">
                                @if($project->featured)
                                    <span class="bg-yellow-500/90 text-black text-xs font-bold px-3 py-1 rounded-full">
                                        <i class="fas fa-star mr-1"></i>Featured
                                    </span>
                                @endif
                                @if($project->status)
                                    <span class="bg-green-500/90 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                        {{ ucfirst($project->status) }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                @else
                    <!-- Default gradient background if no image -->
                    <div class="w-full h-64 md:h-96 bg-gradient-to-br from-cyan-600 via-blue-700 to-purple-800 flex items-center justify-center">
                        <div class="text-center">
                            <i class="fas fa-code text-6xl text-white/80 mb-4"></i>
                            <h2 class="text-2xl font-orbitron text-white">{{ $project->title }}</h2>
                        </div>
                    </div>
                @endif
                
                <div class="p-8">
                    <div class="flex flex-col md:flex-row justify-between items-start mb-6">
                        <div class="flex-1">
                            <h1 class="text-4xl font-orbitron text-white mb-4">{{ $project->title }}</h1>
                            
                            <!-- Project Meta Information -->
                            <div class="flex flex-wrap gap-4 mb-4 text-sm text-gray-400">
                                @if($project->created_at)
                                    <span class="flex items-center">
                                        <i class="fas fa-calendar mr-2"></i>
                                        {{ $project->created_at->format('M Y') }}
                                    </span>
                                @endif
                                @if($project->category)
                                    <span class="flex items-center">
                                        <i class="fas fa-tag mr-2"></i>
                                        {{ $project->category }}
                                    </span>
                                @endif
                                @if($project->client)
                                    <span class="flex items-center">
                                        <i class="fas fa-user mr-2"></i>
                                        {{ $project->client }}
                                    </span>
                                @endif
                            </div>
                            
                            @if($project->technologies && count($project->technologies) > 0)
                                <div class="flex flex-wrap gap-2">
                                    @foreach($project->technologies as $tech)
                                        <span class="bg-cyan-900/50 text-cyan-300 text-xs font-semibold px-3 py-1.5 rounded-full border border-cyan-700/50 hover:bg-cyan-800/50 transition-colors">
                                            {{ $tech }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex flex-col gap-3 mt-6 md:mt-0 md:ml-6">
                            @if($project->live_url)
                                <a href="{{ $project->live_url }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="bg-cyan-500 hover:bg-cyan-400 text-black font-bold py-3 px-6 rounded-lg transition-all glow-button flex items-center justify-center min-w-[140px]">
                                    <i class="fas fa-external-link-alt mr-2"></i>Live Demo
                                </a>
                            @endif
                            
                            @if($project->github_url)
                                <a href="{{ $project->github_url }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="border-2 border-cyan-500 hover:bg-cyan-500/20 text-white font-bold py-3 px-6 rounded-lg transition-all flex items-center justify-center min-w-[140px]">
                                    <i class="fab fa-github mr-2"></i>Source Code
                                </a>
                            @endif
                            
                            @if($project->demo_video_url)
                                <a href="{{ $project->demo_video_url }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="border-2 border-purple-500 hover:bg-purple-500/20 text-purple-300 font-bold py-3 px-6 rounded-lg transition-all flex items-center justify-center min-w-[140px]">
                                    <i class="fas fa-play mr-2"></i>Demo Video
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Content Sections -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Project Description -->
                    <div class="glass-card rounded-lg p-8">
                        <h3 class="text-2xl font-orbitron text-white mb-6 flex items-center">
                            <i class="fas fa-info-circle mr-3 text-cyan-400"></i>
                            About This Project
                        </h3>
                        <div class="prose prose-invert max-w-none">
                            <p class="text-gray-300 leading-relaxed text-lg">
                                {{ $project->long_description ?: $project->description }}
                            </p>
                        </div>
                    </div>

                    <!-- Project Features -->
                    @if($project->features && count($project->features) > 0)
                        <div class="glass-card rounded-lg p-8">
                            <h3 class="text-2xl font-orbitron text-white mb-6 flex items-center">
                                <i class="fas fa-list-check mr-3 text-cyan-400"></i>
                                Key Features
                            </h3>
                            <ul class="space-y-3">
                                @foreach($project->features as $feature)
                                    <li class="flex items-start text-gray-300">
                                        <i class="fas fa-check-circle text-green-400 mr-3 mt-1 flex-shrink-0"></i>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Project Gallery -->
                    @if($project->gallery_images && count($project->gallery_images) > 0)
                        <div class="glass-card rounded-lg p-8">
                            <h3 class="text-2xl font-orbitron text-white mb-6 flex items-center">
                                <i class="fas fa-images mr-3 text-cyan-400"></i>
                                Project Gallery
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($project->gallery_images as $image)
                                    <div class="relative group cursor-pointer overflow-hidden rounded-lg">
                                        <img src="{{ $image['url'] }}" 
                                             alt="{{ $image['caption'] ?? $project->title }}"
                                             class="w-full h-48 object-cover transition-transform duration-300 group-hover:scale-110"
                                             onclick="openImageModal('{{ $image['url'] }}', '{{ $image['caption'] ?? $project->title }}')"
                                             onerror="this.parentElement.style.display='none';">
                                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                            <i class="fas fa-expand-alt text-white text-2xl"></i>
                                        </div>
                                        @if($image['caption'])
                                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-4">
                                                <p class="text-white text-sm">{{ $image['caption'] }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-8">
                    <!-- Project Stats -->
                    @if($project->stats)
                        <div class="glass-card rounded-lg p-6">
                            <h4 class="text-lg font-orbitron text-white mb-4">Project Stats</h4>
                            <div class="space-y-3">
                                @foreach($project->stats as $stat)
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-300 text-sm">{{ $stat['label'] }}</span>
                                        <span class="text-cyan-400 font-semibold">{{ $stat['value'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Technology Stack Details -->
                    @if($project->tech_details)
                        <div class="glass-card rounded-lg p-6">
                            <h4 class="text-lg font-orbitron text-white mb-4">Technology Stack</h4>
                            <div class="space-y-4">
                                @foreach($project->tech_details as $category => $techs)
                                    <div>
                                        <h5 class="text-cyan-400 text-sm font-semibold mb-2">{{ ucfirst($category) }}</h5>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($techs as $tech)
                                                <span class="bg-gray-800/50 text-gray-300 text-xs px-2 py-1 rounded">{{ $tech }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Challenges & Solutions -->
                    @if($project->challenges)
                        <div class="glass-card rounded-lg p-6">
                            <h4 class="text-lg font-orbitron text-white mb-4">Challenges & Solutions</h4>
                            <div class="space-y-4">
                                @foreach($project->challenges as $challenge)
                                    <div class="border-l-4 border-cyan-500 pl-4">
                                        <h5 class="text-cyan-400 font-semibold text-sm mb-1">{{ $challenge['challenge'] }}</h5>
                                        <p class="text-gray-300 text-xs">{{ $challenge['solution'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Related Projects -->
            @if($relatedProjects->count() > 0)
                <div class="mt-16">
                    <h2 class="text-3xl font-orbitron text-white mb-8 flex items-center">
                        <i class="fas fa-project-diagram mr-3 text-cyan-400"></i>
                        Related Projects
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($relatedProjects as $relatedProject)
                            <div class="glass-card rounded-lg overflow-hidden transform hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl hover:shadow-cyan-500/20">
                                <div class="relative">
                                    <img src="{{ $relatedProject->image_url }}" 
                                         alt="{{ $relatedProject->title }}" 
                                         class="w-full h-40 object-cover"
                                         onerror="this.onerror=null; this.src='https://via.placeholder.com/400x200/1a1a2e/16a085?text=' + encodeURIComponent('{{ $relatedProject->title }}');">
                                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent"></div>
                                </div>
                                
                                <div class="p-6">
                                    <h4 class="text-lg font-orbitron text-white mb-2">{{ $relatedProject->title }}</h4>
                                    <p class="text-gray-300 text-sm mb-4 leading-relaxed">{{ Str::limit($relatedProject->description, 100) }}</p>
                                    
                                    @if($relatedProject->technologies && count($relatedProject->technologies) > 0)
                                        <div class="flex flex-wrap gap-1 mb-4">
                                            @foreach(array_slice($relatedProject->technologies, 0, 3) as $tech)
                                                <span class="bg-cyan-900/30 text-cyan-300 text-xs px-2 py-1 rounded">{{ $tech }}</span>
                                            @endforeach
                                            @if(count($relatedProject->technologies) > 3)
                                                <span class="text-cyan-400 text-xs px-2 py-1">+{{ count($relatedProject->technologies) - 3 }} more</span>
                                            @endif
                                        </div>
                                    @endif
                                    
                                    <a href="{{ route('project.show', $relatedProject->slug) }}" 
                                       class="inline-flex items-center text-cyan-400 hover:text-cyan-300 font-semibold text-sm transition-colors">
                                        View Details 
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Image Modal for Gallery -->
    <div id="imageModal" class="fixed inset-0 bg-black/90 z-50 hidden flex items-center justify-center p-4" onclick="closeImageModal()">
        <div class="relative max-w-4xl max-h-full">
            <button onclick="closeImageModal()" class="absolute -top-10 right-0 text-white hover:text-gray-300 text-2xl">
                <i class="fas fa-times"></i>
            </button>
            <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
            <p id="modalCaption" class="text-white text-center mt-4"></p>
        </div>
    </div>

    <script>
        function openImageModal(src, caption) {
            document.getElementById('imageModal').classList.remove('hidden');
            document.getElementById('modalImage').src = src;
            document.getElementById('modalCaption').textContent = caption;
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
@endsection
