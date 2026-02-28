@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<div class="max-w-md mx-auto mt-32 glass-card p-8 rounded-lg">
    <h2 class="text-2xl font-orbitron text-white mb-4">Admin Login</h2>
    @if ($errors->any())
        <div class="mb-4 text-red-300">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-cyan-400 mb-2" for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="w-full p-3 rounded-lg form-input" required autofocus />
        </div>
        <div>
            <label class="block text-cyan-400 mb-2" for="password">Password</label>
            <input id="password" type="password" name="password" class="w-full p-3 rounded-lg form-input" required />
        </div>
        <div class="flex items-center justify-between">
            <label class="inline-flex items-center text-cyan-300 text-sm">
                <input type="checkbox" name="remember" class="mr-2"> Remember me
            </label>
            <button type="submit" class="bg-cyan-500 hover:bg-cyan-400 text-black font-bold py-2 px-4 rounded-lg">Login</button>
        </div>
    </form>
    <p class="text-xs text-cyan-300/70 mt-4">Use your registered admin account to sign in.</p>
    </div>
@endsection
