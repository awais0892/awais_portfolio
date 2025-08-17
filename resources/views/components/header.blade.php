{{-- resources/views/components/header.blade.php --}}
<header class="bg-black/30 backdrop-blur-md fixed top-0 left-0 right-0 z-50 border-b border-cyan-500/20">
    <div class="container mx-auto px-6 py-4">
        <nav class="flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-2xl font-orbitron text-white">AA.</a>
            <div class="hidden md:flex items-center space-x-8 font-semibold">
                <a href="{{ route('home') }}#about" class="hover:text-cyan-400 transition-colors">About</a>
                <a href="{{ route('home') }}#experience" class="hover:text-cyan-400 transition-colors">Experience</a>
                <a href="{{ route('projects') }}" class="hover:text-cyan-400 transition-colors">Projects</a>
                <a href="{{ route('blog.index') }}" class="hover:text-cyan-400 transition-colors">Blog</a>
                <a href="{{ route('home') }}#skills" class="hover:text-cyan-400 transition-colors">Skills</a>
                <a href="{{ route('home') }}#contact" class="hover:text-cyan-400 transition-colors">Contact</a>
            </div>
            <a href="{{ route('home') }}#contact" class="hidden md:block bg-cyan-500 hover:bg-cyan-400 text-black font-bold py-2 px-4 rounded-lg glow-button">
                Let's Connect
            </a>
            
            @if(session('is_admin'))
                <div class="flex items-center gap-3 ml-4">
                    <a href="{{ route('admin.dashboard') }}" class="hidden md:inline-block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="hidden md:inline-block bg-transparent border border-red-500 text-red-400 font-semibold py-2 px-4 rounded-lg hover:bg-red-500/10 transition-colors">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('admin.login') }}" class="ml-4 hidden md:inline-block bg-transparent border border-cyan-500 text-cyan-400 font-semibold py-2 px-4 rounded-lg hover:bg-cyan-500/10">
                    <i class="fas fa-user-shield mr-2"></i>
                    Admin Login
                </a>
            @endif
            <button id="mobile-menu-button" class="md:hidden text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" /></svg>
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
                <a href="{{ route('admin.dashboard') }}" class="block py-3 px-4 text-sm text-purple-300 hover:bg-purple-900/50">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <form method="POST" action="{{ route('admin.logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left py-3 px-4 text-sm text-red-400 hover:bg-red-900/50">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        @else
            <div class="border-t border-cyan-500/20 mt-2">
                <a href="{{ route('admin.login') }}" class="block py-3 px-4 text-sm text-cyan-300 hover:bg-cyan-900/50">
                    <i class="fas fa-user-shield mr-2"></i>Admin Login
                </a>
            </div>
        @endif
    </div>
</header>