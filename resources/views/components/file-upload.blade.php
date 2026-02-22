{{-- File Upload Component --}}
<div class="file-upload-component" data-type="{{ $type ?? 'image' }}" data-folder="{{ $folder ?? 'portfolio' }}">
    <!-- Upload Area -->
    <div class="upload-area bg-white/5 backdrop-blur-sm border-2 border-dashed border-cyan-400/30 rounded-2xl p-8 text-center hover:border-cyan-400/50 transition-all duration-300 cursor-pointer"
        id="upload-area-{{ $type ?? 'image' }}">
        <div class="upload-content">
            <div class="text-6xl text-cyan-400/50 mb-4">
                <i class="fas fa-cloud-upload-alt"></i>
            </div>
            <h3 class="text-xl font-semibold text-white mb-2">
                {{ $title ?? 'Upload ' . ucfirst($type ?? 'image') }}
            </h3>
            <p class="text-cyan-300/70 mb-4">
                {{ $description ?? 'Click to upload or drag and drop your file here' }}
            </p>
            <div class="text-sm text-cyan-300/50">
                @if(($type ?? 'image') === 'image')
                    Supported: JPEG, PNG, JPG, GIF, WebP (Max 10MB)
                @else
                    Supported: PDF, DOC, DOCX, TXT (Max 10MB)
                @endif
            </div>
        </div>

        <!-- Hidden File Input -->
        <input type="file" id="file-input-{{ $type ?? 'image' }}" name="file"
            accept="{{ ($type ?? 'image') === 'image' ? 'image/*' : '.pdf,.doc,.docx,.txt' }}" class="hidden">
    </div>

    <!-- Upload Progress -->
    <div id="upload-progress-{{ $type ?? 'image' }}" class="hidden mt-4">
        <div class="bg-white/10 rounded-full h-2 overflow-hidden">
            <div id="progress-bar-{{ $type ?? 'image' }}"
                class="bg-gradient-to-r from-cyan-500 to-purple-600 h-full transition-all duration-300"
                style="width: 0%"></div>
        </div>
        <div class="text-center mt-2">
            <span id="progress-text-{{ $type ?? 'image' }}" class="text-cyan-300/70 text-sm">Uploading...</span>
        </div>
    </div>

    <!-- Uploaded Files Preview -->
    <div id="uploaded-files-{{ $type ?? 'image' }}" class="mt-6 space-y-4 hidden">
        <h4 class="text-lg font-semibold text-white mb-3">Uploaded Files</h4>
        <div id="files-list-{{ $type ?? 'image' }}" class="space-y-3">
            <!-- Files will be displayed here -->
        </div>
    </div>

    <!-- Error Messages -->
    <div id="upload-error-{{ $type ?? 'image' }}"
        class="hidden mt-4 p-4 bg-red-500/20 border border-red-500/30 rounded-xl">
        <div class="flex items-center gap-2">
            <i class="fas fa-exclamation-circle text-red-400"></i>
            <span id="error-message-{{ $type ?? 'image' }}" class="text-red-300"></span>
        </div>
    </div>

    <!-- Success Messages -->
    <div id="upload-success-{{ $type ?? 'image' }}"
        class="hidden mt-4 p-4 bg-green-500/20 border border-green-500/30 rounded-xl">
        <div class="flex items-center gap-2">
            <i class="fas fa-check-circle text-green-400"></i>
            <span id="success-message-{{ $type ?? 'image' }}" class="text-green-300"></span>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const component = document.querySelector('.file-upload-component[data-type="{{ $type ?? 'image' }}"]');
        const uploadArea = document.getElementById('upload-area-{{ $type ?? 'image' }}');
        const fileInput = document.getElementById('file-input-{{ $type ?? 'image' }}');
        const progressContainer = document.getElementById('upload-progress-{{ $type ?? 'image' }}');
        const progressBar = document.getElementById('progress-bar-{{ $type ?? 'image' }}');
        const progressText = document.getElementById('progress-text-{{ $type ?? 'image' }}');
        const uploadedFiles = document.getElementById('uploaded-files-{{ $type ?? 'image' }}');
        const filesList = document.getElementById('files-list-{{ $type ?? 'image' }}');
        const errorContainer = document.getElementById('upload-error-{{ $type ?? 'image' }}');
        const successContainer = document.getElementById('upload-success-{{ $type ?? 'image' }}');
        const errorMessage = document.getElementById('error-message-{{ $type ?? 'image' }}');
        const successMessage = document.getElementById('success-message-{{ $type ?? 'image' }}');

        const fileType = component.dataset.type;
        const folder = component.dataset.folder;

        // Click to upload
        uploadArea.addEventListener('click', function () {
            fileInput.click();
        });

        // Drag and drop
        uploadArea.addEventListener('dragover', function (e) {
            e.preventDefault();
            uploadArea.classList.add('border-cyan-400/70', 'bg-cyan-500/5');
        });

        uploadArea.addEventListener('dragleave', function (e) {
            e.preventDefault();
            uploadArea.classList.remove('border-cyan-400/70', 'bg-cyan-500/5');
        });

        uploadArea.addEventListener('drop', function (e) {
            e.preventDefault();
            uploadArea.classList.remove('border-cyan-400/70', 'bg-cyan-500/5');

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleFileUpload(files[0]);
            }
        });

        // File input change
        fileInput.addEventListener('change', function (e) {
            if (e.target.files.length > 0) {
                handleFileUpload(e.target.files[0]);
            }
        });

        function handleFileUpload(file) {
            // Validate file
            if (!validateFile(file)) {
                return;
            }

            // Show progress
            showProgress();
            hideMessages();

            // Create form data
            const formData = new FormData();
            formData.append(fileType === 'image' ? 'image' : 'document', file);
            formData.append('folder', folder);

            // Upload file
            const uploadUrl = fileType === 'image'
                ? '/api/upload/image'
                : '/api/upload/document';

            fetch(uploadUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    hideProgress();

                    if (data.success) {
                        showSuccess(data.message);
                        addFileToList(data.data);
                        // Trigger custom event for parent components
                        component.dispatchEvent(new CustomEvent('fileUploaded', {
                            detail: data.data
                        }));
                    } else {
                        console.error('Validation Errors:', data.errors);
                        showError(data.message || 'Upload failed');
                    }
                })
                .catch(error => {
                    hideProgress();
                    console.error('Upload error:', error);
                    showError('An error occurred during upload');
                });
        }

        function validateFile(file) {
            const maxSize = 10 * 1024 * 1024; // 10MB
            const allowedTypes = fileType === 'image'
                ? ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp']
                : ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'text/plain'];

            if (file.size > maxSize) {
                showError('File size must be less than 10MB');
                return false;
            }

            if (!allowedTypes.includes(file.type)) {
                showError('Invalid file type. Please select a valid file.');
                return false;
            }

            return true;
        }

        function showProgress() {
            progressContainer.classList.remove('hidden');
            progressBar.style.width = '0%';
            progressText.textContent = 'Uploading...';

            // Simulate progress
            let progress = 0;
            const interval = setInterval(() => {
                progress += Math.random() * 30;
                if (progress > 90) progress = 90;
                progressBar.style.width = progress + '%';
            }, 200);

            // Store interval for cleanup
            progressContainer.dataset.interval = interval;
        }

        function hideProgress() {
            progressContainer.classList.add('hidden');
            if (progressContainer.dataset.interval) {
                clearInterval(progressContainer.dataset.interval);
            }
            progressBar.style.width = '100%';
        }

        function showError(message) {
            errorMessage.textContent = message;
            errorContainer.classList.remove('hidden');
            setTimeout(() => {
                errorContainer.classList.add('hidden');
            }, 5000);
        }

        function showSuccess(message) {
            successMessage.textContent = message;
            successContainer.classList.remove('hidden');
            setTimeout(() => {
                successContainer.classList.add('hidden');
            }, 3000);
        }

        function hideMessages() {
            errorContainer.classList.add('hidden');
            successContainer.classList.add('hidden');
        }

        function addFileToList(fileData) {
            uploadedFiles.classList.remove('hidden');

            const fileItem = document.createElement('div');
            fileItem.className = 'file-item bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-4';
            fileItem.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas ${fileType === 'image' ? 'fa-image' : 'fa-file'} text-white"></i>
                    </div>
                    <div>
                        <div class="text-white font-medium">${fileData.public_id.split('/').pop()}</div>
                        <div class="text-cyan-300/70 text-sm">
                            ${fileData.format?.toUpperCase() || 'FILE'} • ${formatBytes(fileData.bytes)}
                            ${fileData.width && fileData.height ? ` • ${fileData.width}×${fileData.height}` : ''}
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="${fileData.secure_url}" target="_blank" 
                       class="px-3 py-1 bg-cyan-500/20 text-cyan-300 rounded-lg hover:bg-cyan-500/30 transition-colors text-sm">
                        <i class="fas fa-external-link-alt mr-1"></i>View
                    </a>
                    <button onclick="copyToClipboard('${fileData.secure_url}')" 
                            class="px-3 py-1 bg-purple-500/20 text-purple-300 rounded-lg hover:bg-purple-500/30 transition-colors text-sm">
                        <i class="fas fa-copy mr-1"></i>Copy URL
                    </button>
                    <button onclick="deleteFile('${fileData.public_id}')" 
                            class="px-3 py-1 bg-red-500/20 text-red-300 rounded-lg hover:bg-red-500/30 transition-colors text-sm">
                        <i class="fas fa-trash mr-1"></i>Delete
                    </button>
                </div>
            </div>
        `;

            filesList.appendChild(fileItem);
        }

        function formatBytes(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Global functions for file actions
        window.copyToClipboard = function (url) {
            navigator.clipboard.writeText(url).then(() => {
                showSuccess('URL copied to clipboard!');
            }).catch(() => {
                showError('Failed to copy URL');
            });
        };

        window.deleteFile = function (publicId) {
            if (confirm('Are you sure you want to delete this file?')) {
                fetch('/api/upload/delete', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        public_id: publicId,
                        resource_type: fileType === 'image' ? 'image' : 'raw'
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showSuccess('File deleted successfully');
                            // Remove from list
                            const fileItems = filesList.querySelectorAll('.file-item');
                            fileItems.forEach(item => {
                                if (item.innerHTML.includes(publicId)) {
                                    item.remove();
                                }
                            });
                        } else {
                            showError(data.message || 'Failed to delete file');
                        }
                    })
                    .catch(error => {
                        console.error('Delete error:', error);
                        showError('An error occurred while deleting the file');
                    });
            }
        };
    });
</script>

<style>
    .upload-area:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(6, 182, 212, 0.1);
    }

    .file-item {
        transition: all 0.3s ease;
    }

    .file-item:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(6, 182, 212, 0.1);
    }
</style>