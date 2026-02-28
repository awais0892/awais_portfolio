{{-- resources/views/components/header.blade.php --}}
<header class="bg-black/30 backdrop-blur-md fixed top-0 left-0 right-0 z-50 border-b border-cyan-500/20">
    <div class="container mx-auto px-6 py-4">
        <nav class="flex items-center justify-between">
            <a href="{{ route('home') }}" class="group flex items-center gap-2">
                <svg width="40" height="40" viewBox="0 0 100 100"
                    class="fill-current text-cyan-400 group-hover:text-cyan-300 transition-colors duration-300"
                    xmlns="http://www.w3.org/2000/svg">
                    <!-- Outer Hexagon -->
                    <polygon points="50,5 95,27.5 95,72.5 50,95 5,72.5 5,27.5" fill="none" stroke="currentColor"
                        stroke-width="3" opacity="0.5" />
                    <polygon points="50,12 88,32 88,68 50,88 12,68 12,32" fill="none" stroke="currentColor"
                        stroke-width="1" opacity="0.3" />

                    <!-- Stylized 'AA' -->
                    <path d="M 35 70 L 50 30 L 65 70 M 40 60 L 60 60" fill="none" stroke="currentColor" stroke-width="6"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="drop-shadow-[0_0_8px_rgba(0,245,255,0.8)]" />
                    <path d="M 30 70 L 45 30 L 60 70 M 35 60 L 55 60" fill="none" stroke="#7A00FF" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="drop-shadow-[0_0_12px_rgba(122,0,255,0.6)]" style="mix-blend-mode: screen;"
                        transform="translate(-2, 0)" />
                </svg>
                <div class="hidden sm:flex flex-col">
                    <span class="text-xl font-orbitron text-white leading-tight tracking-wider">AWAIS</span>
                    <span
                        class="text-[0.6rem] font-rajdhani text-cyan-400 uppercase font-bold tracking-[0.2em] leading-none">Portfolio</span>
                </div>
            </a>
            <div class="hidden md:flex items-center space-x-8 font-semibold">
                <a href="{{ route('home') }}#about" class="hover:text-cyan-400 transition-colors">About</a>
                <a href="{{ route('home') }}#experience" class="hover:text-cyan-400 transition-colors">Experience</a>
                <a href="{{ route('projects') }}" class="hover:text-cyan-400 transition-colors">Projects</a>
                <a href="{{ route('blog.index') }}" class="hover:text-cyan-400 transition-colors">Blog</a>
                <a href="{{ route('home') }}#skills" class="hover:text-cyan-400 transition-colors">Skills</a>
                <a href="{{ route('home') }}#contact" class="hover:text-cyan-400 transition-colors">Contact</a>
            </div>
            <a href="{{ route('home') }}#contact"
                class="hidden md:block bg-cyan-500 hover:bg-cyan-400 text-black font-bold py-2 px-4 rounded-lg glow-button">
                Let's Connect
            </a>

            @if(session('is_admin'))
                <div class="flex items-center gap-3 ml-4">
                    <a href="{{ route('admin.dashboard') }}"
                        class="hidden md:inline-block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="hidden md:inline-block bg-transparent border border-red-500 text-red-400 font-semibold py-2 px-4 rounded-lg hover:bg-red-500/10 transition-colors">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Logout
                        </button>
                    </form>
                </div>
            @endif
            <button id="mobile-menu-button" class="md:hidden text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </nav>
    </div>
    <div id="mobile-menu" class="hidden md:hidden bg-black/50 backdrop-blur-md">
        <a href="{{ route('home') }}#about" class="block py-3 px-4 text-sm hover:bg-cyan-900/50">About</a>
        <a href="{{ route('home') }}#experience" class="block py-3 px-4 text-sm hover:bg-cyan-900/50">Experience</a>
        <a href="{{ route('projects') }}" class="block py-3 px-4 text-sm hover:bg-cyan-900/50">Projects</a>
        <a href="{{ route('blog.index') }}" class="block py-3 px-4 text-sm hover:bg-cyan-900/50">Blog</a>
        <a href="{{ route('home') }}#skills" class="block py-3 px-4 text-sm hover:bg-cyan-900/50">Skills</a>
        <a href="{{ route('home') }}#contact" class="block py-3 px-4 text-sm hover:bg-cyan-900/50">Contact</a>

        @if(session('is_admin'))
            <div class="border-t border-cyan-500/20 mt-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="block py-3 px-4 text-sm text-purple-300 hover:bg-purple-900/50">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <form method="POST" action="{{ route('admin.logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left py-3 px-4 text-sm text-red-400 hover:bg-red-900/50">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        @endif
    </div>
</header>