@extends('layouts.admin')

@section('title', 'File Manager')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
    </div>

    <!-- Content Container -->
    <div class="relative z-10 container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">
                    File Manager
                </h1>
                <p class="text-cyan-200/80 mt-2">Upload and manage your files with Cloudinary</p>
            </div>
        </div>

        <!-- Upload Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Image Upload -->
            <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-image text-cyan-400"></i>
                    Image Upload
                </h2>
                @include('components.file-upload', [
                    'type' => 'image',
                    'folder' => 'portfolio/images',
                    'title' => 'Upload Images',
                    'description' => 'Upload project images, profile photos, and other graphics'
                ])
            </div>

            <!-- Document Upload -->
            <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
                <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-file-alt text-purple-400"></i>
                    Document Upload
                </h2>
                @include('components.file-upload', [
                    'type' => 'document',
                    'folder' => 'portfolio/documents',
                    'title' => 'Upload Documents',
                    'description' => 'Upload your CV, certificates, and other documents'
                ])
            </div>
        </div>

        <!-- File Management Tools -->
        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                <i class="fas fa-tools text-green-400"></i>
                File Management Tools
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Image Transformation -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-4">
                    <h3 class="text-lg font-semibold text-white mb-3">Image Transformation</h3>
                    <p class="text-cyan-300/70 text-sm mb-4">Transform images with different sizes and formats</p>
                    <button onclick="openTransformModal()" 
                            class="w-full px-4 py-2 bg-gradient-to-r from-cyan-500 to-purple-600 text-white font-semibold rounded-lg hover:from-cyan-600 hover:to-purple-700 transition-all duration-300">
                        <i class="fas fa-magic mr-2"></i>
                        Transform Images
                    </button>
                </div>

                <!-- File Info -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-4">
                    <h3 class="text-lg font-semibold text-white mb-3">File Information</h3>
                    <p class="text-cyan-300/70 text-sm mb-4">Get detailed information about your files</p>
                    <button onclick="openFileInfoModal()" 
                            class="w-full px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-600 text-white font-semibold rounded-lg hover:from-purple-600 hover:to-pink-700 transition-all duration-300">
                        <i class="fas fa-info-circle mr-2"></i>
                        Get File Info
                    </button>
                </div>

                <!-- Bulk Operations -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-4">
                    <h3 class="text-lg font-semibold text-white mb-3">Bulk Operations</h3>
                    <p class="text-cyan-300/70 text-sm mb-4">Manage multiple files at once</p>
                    <button onclick="openBulkModal()" 
                            class="w-full px-4 py-2 bg-gradient-to-r from-green-500 to-teal-600 text-white font-semibold rounded-lg hover:from-green-600 hover:to-teal-700 transition-all duration-300">
                        <i class="fas fa-layer-group mr-2"></i>
                        Bulk Actions
                    </button>
                </div>
            </div>
        </div>

        <!-- Usage Statistics -->
        <div class="mt-8 bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-2">
                <i class="fas fa-chart-bar text-yellow-400"></i>
                Usage Statistics
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-cyan-400 mb-2">25GB</div>
                    <div class="text-cyan-300/70">Storage Limit</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-purple-400 mb-2">0GB</div>
                    <div class="text-cyan-300/70">Used Storage</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-400 mb-2">25GB</div>
                    <div class="text-cyan-300/70">Available</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-yellow-400 mb-2">0</div>
                    <div class="text-cyan-300/70">Files Uploaded</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Transform Modal -->
<div id="transformModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 w-full max-w-md">
            <h3 class="text-xl font-bold text-white mb-4">Transform Image</h3>
            <form id="transformForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-cyan-300 mb-2">Public ID</label>
                    <input type="text" name="public_id" required
                           class="w-full bg-white/10 border border-white/20 rounded-lg px-3 py-2 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-cyan-300 mb-2">Width</label>
                        <input type="number" name="width" min="1" max="2000"
                               class="w-full bg-white/10 border border-white/20 rounded-lg px-3 py-2 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-cyan-300 mb-2">Height</label>
                        <input type="number" name="height" min="1" max="2000"
                               class="w-full bg-white/10 border border-white/20 rounded-lg px-3 py-2 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-cyan-300 mb-2">Quality</label>
                        <select name="quality" class="w-full bg-white/10 border border-white/20 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent">
                            <option value="auto">Auto</option>
                            <option value="eco">Eco</option>
                            <option value="good">Good</option>
                            <option value="better">Better</option>
                            <option value="best">Best</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-cyan-300 mb-2">Format</label>
                        <select name="format" class="w-full bg-white/10 border border-white/20 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent">
                            <option value="auto">Auto</option>
                            <option value="webp">WebP</option>
                            <option value="jpg">JPG</option>
                            <option value="png">PNG</option>
                            <option value="gif">GIF</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-gradient-to-r from-cyan-500 to-purple-600 text-white font-semibold rounded-lg hover:from-cyan-600 hover:to-purple-700 transition-all duration-300">
                        Transform
                    </button>
                    <button type="button" onclick="closeTransformModal()" 
                            class="px-4 py-2 bg-white/10 text-white font-semibold rounded-lg hover:bg-white/20 transition-all duration-300">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openTransformModal() {
    document.getElementById('transformModal').classList.remove('hidden');
}

function closeTransformModal() {
    document.getElementById('transformModal').classList.add('hidden');
}

function openFileInfoModal() {
    alert('File Info feature coming soon!');
}

function openBulkModal() {
    alert('Bulk Operations feature coming soon!');
}

// Transform form submission
document.getElementById('transformForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    fetch('{{ route("api.upload.transform") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Transformed URL: ' + data.data.url);
            closeTransformModal();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
});
</script>
@endsection
