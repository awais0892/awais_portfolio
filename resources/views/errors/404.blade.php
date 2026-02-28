{{-- resources/views/errors/404.blade.php --}}
@extends('layouts.app')

@section('title', 'Page Not Found | Awais Ahmad')
@section('description', 'The page you are looking for could not be found.')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center">
    <div class="text-center">
        <div class="text-7xl font-orbitron text-cyan-400 mb-4">404</div>
        <h1 class="text-2xl md:text-3xl text-white font-semibold mb-3">Oops! Page not found.</h1>
        <p class="text-cyan-200/80 mb-6 max-w-xl mx-auto">The page you’re looking for doesn’t exist or may have been moved. Let’s get you back on track.</p>
        <div class="flex items-center justify-center gap-4">
            <a href="{{ route('home') }}" class="bg-cyan-500 hover:bg-cyan-400 text-black font-bold py-2 px-4 rounded-lg glow-button">Back to Home</a>
            <a href="{{ route('projects') }}" class="border-2 border-cyan-500 hover:bg-cyan-500/20 text-white font-bold py-2 px-4 rounded-lg">View Projects</a>
        </div>
    </div>
</div>
@endsection
