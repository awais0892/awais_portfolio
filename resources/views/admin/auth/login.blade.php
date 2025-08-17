@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<div class="max-w-md mx-auto mt-32 glass-card p-8 rounded-lg">
    <h2 class="text-2xl font-orbitron text-white mb-4">Admin Login</h2>
    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-cyan-400 mb-2">Password</label>
            <input type="password" name="password" class="w-full p-3 rounded-lg form-input" required />
        </div>
        <div class="text-right">
            <button type="submit" class="bg-cyan-500 hover:bg-cyan-400 text-black font-bold py-2 px-4 rounded-lg">Login</button>
        </div>
    </form>
</div>
@endsection
