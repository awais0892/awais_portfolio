@extends('layouts.admin')

@section('title', 'Create Project')
@section('page-title', 'Create Project')
@section('page-subtitle', 'Add a new portfolio item with cleaner metadata, better image handling and consistent visibility controls.')

@section('page-actions')
    <a href="{{ route('admin.projects.index') }}"
        class="admin-focus inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-semibold text-slate-200 transition-colors duration-200 hover:bg-white/10">
        <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
        <span>Back To Projects</span>
    </a>
@endsection

@section('content')
    <form id="projectForm" method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data"
        class="space-y-6">
        @csrf

        @include('admin.projects.partials.form-fields')

        <div class="flex flex-wrap items-center justify-end gap-3">
            <a href="{{ route('admin.projects.index') }}"
                class="admin-focus inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-slate-200 transition-colors duration-200 hover:bg-white/10">
                Cancel
            </a>
            <button type="submit"
                class="admin-focus inline-flex items-center gap-2 rounded-2xl bg-cyan-300 px-5 py-3 text-sm font-semibold text-slate-950 transition-colors duration-200 hover:bg-cyan-200">
                <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                <span>Create Project</span>
            </button>
        </div>
    </form>
@endsection

@push('scripts')
    @include('admin.projects.partials.form-scripts')
@endpush
