@extends('layouts.app')

@section('title', 'Admin - Add Skill')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 relative overflow-hidden">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
    </div>
    <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:50px_50px]"></div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-12 text-center">
            <div class="inline-block">
                <h1 class="text-6xl font-black bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 bg-clip-text text-transparent mb-4 tracking-tight">
                    ADD SKILL
                </h1>
                <div class="h-1 w-32 bg-gradient-to-r from-cyan-400 to-purple-600 mx-auto rounded-full"></div>
            </div>
            <p class="text-cyan-300/80 text-xl mt-6 font-light tracking-wide">Add a new technical skill to your portfolio</p>
        </div>

        <!-- Back -->
        <div class="mb-8">
            <a href="{{ route('admin.skills.index') }}"
               class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 text-cyan-300 border border-cyan-400/30 rounded-xl hover:from-cyan-500/30 hover:to-blue-500/30 transition-all duration-300 hover:scale-105">
                <i class="fas fa-arrow-left mr-3"></i>
                <span class="font-semibold">Back to Skills</span>
            </a>
        </div>

        <!-- Form -->
        <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-3xl p-8 shadow-2xl">
            <form method="POST" action="{{ route('admin.skills.store') }}" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Skill Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               placeholder="e.g., Laravel, React, Docker..."
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                        @error('name') <p class="text-red-400 text-sm mt-2">{{ $message }}</p> @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Category *</label>
                        <select name="category" required
                                class="js-choice w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                            <option value="">Select a category...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category') <p class="text-red-400 text-sm mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Proficiency -->
                <div>
                    <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">
                        Proficiency: <span id="proficiencyLabel">{{ old('proficiency', 80) }}%</span>
                    </label>
                    <input type="range" name="proficiency" min="1" max="100" value="{{ old('proficiency', 80) }}"
                           id="proficiencySlider"
                           class="w-full h-3 bg-white/10 rounded-full appearance-none cursor-pointer accent-cyan-400">
                    <div class="flex justify-between text-cyan-300/50 text-xs mt-2">
                        <span>Beginner (1%)</span><span>Intermediate (50%)</span><span>Expert (100%)</span>
                    </div>
                    @error('proficiency') <p class="text-red-400 text-sm mt-2">{{ $message }}</p> @enderror
                </div>

                <!-- Order & Active -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-bold text-cyan-300 uppercase tracking-wider mb-3">Display Order</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" min="0"
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                        <p class="text-cyan-300/50 text-sm mt-2">Lower number = displayed first</p>
                    </div>
                    <div class="flex items-center space-x-4 mt-8">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-white/10 peer-focus:ring-4 peer-focus:ring-cyan-300/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-cyan-500"></div>
                            <span class="ml-3 text-sm font-bold text-cyan-300 uppercase tracking-wider">Active</span>
                        </label>
                    </div>
                </div>

                <!-- Icon Upload via Cloudinary -->
                <div class="border-t border-white/10 pt-8">
                    <h3 class="text-xl font-bold text-cyan-300 mb-6">Skill Icon</h3>
                    <div id="cloudinary-upload-container">
                        @include('components.file-upload', [
                            'type'        => 'image',
                            'folder'      => 'portfolio/skill-icons',
                            'title'       => 'Upload Skill Icon',
                            'description' => 'Upload an icon or logo for this skill (PNG, SVG, WebP)'
                        ])
                    </div>
                    <input type="hidden" name="icon_url" id="icon_url" value="{{ old('icon_url') }}">

                    <!-- Icon Preview -->
                    <div id="iconPreview" class="{{ old('icon_url') ? '' : 'hidden' }} mt-4">
                        <div class="relative inline-block">
                            <img id="previewImg" src="{{ old('icon_url') }}" alt="Icon Preview" class="w-24 h-24 object-contain rounded-xl border border-white/20 bg-white/5 p-2">
                            <button type="button" onclick="removeIcon()"
                                    class="absolute -top-2 -right-2 bg-red-500/80 hover:bg-red-500 text-white rounded-full w-7 h-7 flex items-center justify-center transition-colors">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </div>
                    </div>
                    @error('icon_url') <p class="text-red-400 text-sm mt-2">{{ $message }}</p> @enderror
                </div>

                <!-- Submit -->
                <div class="flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4 pt-8 border-t border-white/10">
                    <a href="{{ route('admin.skills.index') }}"
                       class="px-8 py-3 bg-gradient-to-r from-gray-500/20 to-gray-600/20 text-gray-300 border border-gray-400/30 rounded-xl hover:from-gray-500/30 transition-all duration-300 hover:scale-105 text-center">
                        Cancel
                    </a>
                    <button type="submit"
                            class="group relative px-8 py-3 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-bold rounded-xl overflow-hidden transition-all duration-500 hover:scale-105 hover:shadow-2xl hover:shadow-cyan-500/25">
                        <div class="absolute inset-0 bg-gradient-to-r from-cyan-600 to-blue-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative flex items-center">
                            <i class="fas fa-save mr-3"></i>
                            <span>Save Skill</span>
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

    // Proficiency slider
    const slider = document.getElementById('proficiencySlider');
    const label  = document.getElementById('proficiencyLabel');
    if (slider) {
        slider.addEventListener('input', () => label.textContent = slider.value + '%');
    }

    // Cloudinary upload integration
    const uploadContainer = document.getElementById('cloudinary-upload-container');
    if (uploadContainer) {
        uploadContainer.addEventListener('fileUploaded', function(event) {
            const fileData = event.detail;
            document.getElementById('icon_url').value = fileData.secure_url;
            document.getElementById('previewImg').src = fileData.secure_url;
            document.getElementById('iconPreview').classList.remove('hidden');
            const uploadComponent = uploadContainer.querySelector('.file-upload-component');
            if (uploadComponent) uploadComponent.style.display = 'none';
        });
    }

    const existingUrl = document.getElementById('icon_url').value;
    if (existingUrl && uploadContainer) {
        const uploadComponent = uploadContainer.querySelector('.file-upload-component');
        if (uploadComponent) uploadComponent.style.display = 'none';
    }
});

function removeIcon() {
    document.getElementById('icon_url').value = '';
    document.getElementById('iconPreview').classList.add('hidden');
    const uploadContainer = document.getElementById('cloudinary-upload-container');
    const uploadComponent = uploadContainer.querySelector('.file-upload-component');
    if (uploadComponent) uploadComponent.style.display = 'block';
}
</script>
@endpush
