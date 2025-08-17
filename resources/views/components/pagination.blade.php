{{-- resources/views/components/pagination.blade.php --}}
@if ($paginator->hasPages())
    <nav class="flex justify-center">
        <div class="flex items-center space-x-3">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="group relative px-4 py-2 text-cyan-300/50 bg-white/5 border border-white/10 rounded-xl cursor-not-allowed backdrop-blur-sm">
                    <i class="fas fa-chevron-left mr-2"></i>Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" 
                   class="group relative px-4 py-2 text-cyan-300 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 border border-cyan-400/30 rounded-xl hover:from-cyan-500/30 hover:to-blue-500/30 transition-all duration-300 hover:scale-105 backdrop-blur-sm">
                    <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <i class="fas fa-chevron-left mr-2 relative z-10"></i>
                    <span class="relative z-10 font-semibold">Previous</span>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-4 py-2 text-cyan-300/50 font-semibold">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="group relative px-4 py-2 text-white bg-gradient-to-r from-cyan-500/30 to-blue-500/30 border border-cyan-400/50 rounded-xl font-bold backdrop-blur-sm shadow-lg">
                                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/20 to-transparent opacity-50"></div>
                                <span class="relative z-10">{{ $page }}</span>
                            </span>
                        @else
                            <a href="{{ $url }}" 
                               class="group relative px-4 py-2 text-cyan-300 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 hover:border-cyan-400/30 transition-all duration-300 hover:scale-105 backdrop-blur-sm">
                                <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <span class="relative z-10 font-semibold">{{ $page }}</span>
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" 
                   class="group relative px-4 py-2 text-cyan-300 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 border border-cyan-400/30 rounded-xl hover:from-cyan-500/30 hover:to-blue-500/30 transition-all duration-300 hover:scale-105 backdrop-blur-sm">
                    <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <span class="relative z-10 font-semibold">Next</span>
                    <i class="fas fa-chevron-right ml-2 relative z-10"></i>
                </a>
            @else
                <span class="group relative px-4 py-2 text-cyan-300/50 bg-white/5 border border-white/10 rounded-xl cursor-not-allowed backdrop-blur-sm">
                    Next<i class="fas fa-chevron-right ml-2"></i>
                </span>
            @endif
        </div>
    </nav>
@endif