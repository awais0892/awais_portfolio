@extends('layouts.app')

@section('title', 'Admin - Edit Experience')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 relative overflow-hidden">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
    </div>
    <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:50px_50px]"></div>

    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-12 text-center">
            <div class="inline-block">
                <h1 class="text-6xl font-black bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 bg-clip-text text-transparent mb-4 tracking-tight">
                    EDIT EXPERIENCE
                </h1>
                <div class="h-1 w-32 bg-gradient-to-r from-cyan-400 to-purple-600 mx-auto rounded-full"></div>
            </div>
            <p class="text-cyan-300/80 text-xl mt-6 font-light tracking-wide">
                Editing: <span class="text-cyan-400 font-semibold">{{ $experience->title }}</span> at {{ $experience->company }}
            </p>
        </div>

        <!-- Back -->
        <div class="mb-8">
            <a href="{{ route('admin.experiences.index') }}"
               class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 text-cyan-300 border border-cyan-400/30 rounded-xl hover:from-cyan-500/30 hover:to-blue-500/30 transition-all duration-300 hover:scale-105">
                <i class="fas fa-arrow-left mr-3"></i>
                <span class="font-semibold">Back to Experience</span>
            </a>
        </div>

        <!-- Form -->
        <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-8 shadow-2xl">
            <form method="POST" action="{{ route('admin.experiences.update', $experience) }}" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Job Info -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Job Title *</label>
                        <input type="text" name="title" value="{{ old('title', $experience->title) }}" required
                               placeholder="e.g., Senior Software Engineer..."
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                        @error('title') <p class="text-red-400 text-sm mt-2">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Company *</label>
                        <input type="text" name="company" value="{{ old('company', $experience->company) }}" required
                               placeholder="e.g., Google, Meta, Startup Inc..."
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                        @error('company') <p class="text-red-400 text-sm mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Location</label>
                    <input type="text" name="location" value="{{ old('location', $experience->location) }}"
                           placeholder="e.g., San Francisco, CA / Remote..."
                           class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Start Date *</label>
                        <input type="date" name="start_date" value="{{ old('start_date', $experience->start_date?->format('Y-m-d')) }}" required
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                        @error('start_date') <p class="text-red-400 text-sm mt-2">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">End Date</label>
                        <input type="date" name="end_date" value="{{ old('end_date', $experience->end_date?->format('Y-m-d')) }}" id="endDateField"
                               {{ $experience->is_current ? 'disabled' : '' }}
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 {{ $experience->is_current ? 'opacity-50' : '' }}">
                        <p class="text-cyan-300/50 text-sm mt-2">Leave empty if this is your current role</p>
                    </div>
                </div>

                <!-- Toggles -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="flex items-center space-x-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_current" id="isCurrentToggle" value="1"
                                   {{ old('is_current', $experience->is_current) ? 'checked' : '' }} class="sr-only peer"
                                   onchange="toggleEndDate(this)">
                            <div class="w-11 h-6 bg-white/10 peer-focus:ring-4 peer-focus:ring-emerald-300/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                            <span class="ml-3 text-sm font-bold text-cyan-300 uppercase tracking-wider">Current Position</span>
                        </label>
                    </div>
                    <div class="flex items-center space-x-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1"
                                   {{ old('is_active', $experience->is_active) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-white/10 peer-focus:ring-4 peer-focus:ring-cyan-300/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-cyan-500"></div>
                            <span class="ml-3 text-sm font-bold text-cyan-300 uppercase tracking-wider">Active</span>
                        </label>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Description</label>
                    <textarea name="description" rows="4"
                              placeholder="Brief description of your role..."
                              class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">{{ old('description', $experience->description) }}</textarea>
                </div>

                <!-- Achievements -->
                <div>
                    <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Achievements</label>
                    <textarea name="achievements" rows="5"
                              class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 font-mono text-sm">{{ old('achievements', is_array($experience->achievements) ? implode("\n", $experience->achievements) : $experience->achievements) }}</textarea>
                    <p class="text-cyan-300/50 text-sm mt-2">One achievement per line</p>
                </div>

                <!-- Technologies -->
                <div>
                    <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Technologies Used</label>
                    <input type="text" name="technologies"
                           value="{{ old('technologies', is_array($experience->technologies) ? implode(', ', $experience->technologies) : $experience->technologies) }}"
                           placeholder="Laravel, React, PostgreSQL, Docker..."
                           class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                    <p class="text-cyan-300/50 text-sm mt-2">Separate with commas</p>
                </div>

                <!-- Order -->
                <div>
                    <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Display Order</label>
                    <input type="number" name="order" value="{{ old('order', $experience->order ?? 0) }}" min="0"
                           class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                </div>

                <!-- Company Logo -->
                <div class="border-t border-white/10 pt-8">
                    <h3 class="text-xl font-bold text-cyan-300 mb-6">Company Logo</h3>

                    @if($experience->company_logo)
                        <div class="mb-4 p-4 bg-white/5 border border-white/10 rounded-xl">
                            <p class="text-cyan-300/70 text-sm mb-3">Current Logo:</p>
                            <div class="flex items-center space-x-4">
                                <img src="{{ $experience->company_logo }}" alt="Current Logo" class="w-16 h-16 object-contain rounded-lg border border-white/20 bg-white/5 p-1">
                                <div>
                                    <p class="text-white text-sm font-medium">Upload a new logo to replace it</p>
                                    <label class="flex items-center mt-2 cursor-pointer">
                                        <input type="checkbox" name="clear_logo" value="1" class="mr-2 rounded" {{ old('clear_logo') ? 'checked' : '' }}>
                                        <span class="text-red-400 text-sm">Remove current logo</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div id="cloudinary-upload-container">
                        @include('components.file-upload', [
                            'type'        => 'image',
                            'folder'      => 'portfolio/company-logos',
                            'title'       => 'Upload New Logo',
                            'description' => 'Upload a new company logo'
                        ])
                    </div>
                    <input type="hidden" name="company_logo" id="company_logo" value="{{ old('company_logo') }}">

                    <div id="logoPreview" class="{{ old('company_logo') ? '' : 'hidden' }} mt-4">
                        <div class="relative inline-block">
                            <img id="previewImg" src="{{ old('company_logo') }}" alt="Logo Preview" class="w-24 h-24 object-contain rounded-xl border border-white/20 bg-white/5 p-2">
                            <button type="button" onclick="removeLogo()"
                                    class="absolute -top-2 -right-2 bg-red-500/80 hover:bg-red-500 text-white rounded-full w-7 h-7 flex items-center justify-center transition-colors">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4 pt-8 border-t border-white/10">
                    <a href="{{ route('admin.experiences.index') }}"
                       class="px-8 py-3 bg-gradient-to-r from-gray-500/20 to-gray-600/20 text-gray-300 border border-gray-400/30 rounded-xl hover:from-gray-500/30 transition-all duration-300 hover:scale-105 text-center">
                        Cancel
                    </a>
                    <button type="submit"
                            class="group relative px-8 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold rounded-xl overflow-hidden transition-all duration-500 hover:scale-105 hover:shadow-2xl hover:shadow-cyan-500/25">
                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-600 to-blue-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative flex items-center">
                            <i class="fas fa-save mr-3"></i>
                            <span>Update Experience</span>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    gsap.fromTo('.text-6xl', { y: 100, opacity: 0, scale: 0.8 }, { y: 0, opacity: 1, scale: 1, duration: 1.5, ease: "back.out(1.7)" });
    gsap.fromTo('.h-1', { scaleX: 0 }, { scaleX: 1, duration: 1.5, delay: 0.5, ease: "power2.out" });
    gsap.fromTo('.backdrop-blur-xl', { y: 50, opacity: 0, scale: 0.95 }, { y: 0, opacity: 1, scale: 1, duration: 1.2, delay: 1, ease: "power2.out" });

    const uploadContainer = document.getElementById('cloudinary-upload-container');
    if (uploadContainer) {
        uploadContainer.addEventListener('fileUploaded', function(event) {
            const fileData = event.detail;
            document.getElementById('company_logo').value = fileData.secure_url;
            document.getElementById('previewImg').src = fileData.secure_url;
            document.getElementById('logoPreview').classList.remove('hidden');
            const uploadComponent = uploadContainer.querySelector('.file-upload-component');
            if (uploadComponent) uploadComponent.style.display = 'none';
        });
    }
});

function toggleEndDate(checkbox) {
    const endDate = document.getElementById('endDateField');
    endDate.disabled = checkbox.checked;
    endDate.classList.toggle('opacity-50', checkbox.checked);
    if (checkbox.checked) endDate.value = '';
}

function removeLogo() {
    document.getElementById('company_logo').value = '';
    document.getElementById('logoPreview').classList.add('hidden');
    const uploadContainer = document.getElementById('cloudinary-upload-container');
    const uploadComponent = uploadContainer.querySelector('.file-upload-component');
    if (uploadComponent) uploadComponent.style.display = 'block';
}
</script>
@endpush
