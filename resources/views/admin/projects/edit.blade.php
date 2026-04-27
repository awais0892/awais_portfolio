@extends('layouts.admin')

@section('title', 'Edit Project')
@section('page-title', 'Edit Project')
@section('page-subtitle', 'Update copy, imagery and visibility without losing the current module state.')

@section('page-actions')
    <div class="flex flex-wrap items-center gap-3">
        <a href="{{ route('admin.projects.show', $project) }}"
            class="admin-focus inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-semibold text-slate-200 transition-colors duration-200 hover:bg-white/10">
            <i class="fa-solid fa-eye" aria-hidden="true"></i>
            <span>View</span>
        </a>
        <a href="{{ route('admin.projects.index') }}"
            class="admin-focus inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-semibold text-slate-200 transition-colors duration-200 hover:bg-white/10">
            <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
            <span>Back</span>
        </a>
    </div>
@endsection

@section('content')
    <form id="projectForm" method="POST" action="{{ route('admin.projects.update', $project) }}"
        enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        @include('admin.projects.partials.form-fields', ['project' => $project])

        <div class="flex flex-wrap items-center justify-end gap-3">
            <a href="{{ route('admin.projects.show', $project) }}"
                class="admin-focus inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-slate-200 transition-colors duration-200 hover:bg-white/10">
                Cancel
            </a>
            <button type="submit"
                class="admin-focus inline-flex items-center gap-2 rounded-2xl bg-cyan-300 px-5 py-3 text-sm font-semibold text-slate-950 transition-colors duration-200 hover:bg-cyan-200">
                <i class="fa-solid fa-floppy-disk" aria-hidden="true"></i>
                <span>Save Changes</span>
            </button>
        </div>
    </form>
@endsection

@push('scripts')
    @include('admin.projects.partials.form-scripts')
@endpush
