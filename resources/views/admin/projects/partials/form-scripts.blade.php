<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('projectForm');

        if (!form) {
            return;
        }

        const titleInput = document.getElementById('title');
        const descriptionInput = document.getElementById('description');
        const activeInput = document.getElementById('is_active');
        const imageInput = document.getElementById('image');
        const imageUrlInput = document.getElementById('image_url');
        const previewImage = document.getElementById('projectPreviewImage');
        const previewTitle = document.getElementById('projectPreviewTitle');
        const previewDescription = document.getElementById('projectPreviewDescription');
        const previewStatus = document.getElementById('projectPreviewStatus');

        let isDirty = false;
        let objectUrl = null;

        const revokePreviewUrl = () => {
            if (objectUrl) {
                URL.revokeObjectURL(objectUrl);
                objectUrl = null;
            }
        };

        const setPreviewImage = () => {
            if (!previewImage) {
                return;
            }

            if (imageInput?.files?.length) {
                revokePreviewUrl();
                objectUrl = URL.createObjectURL(imageInput.files[0]);
                previewImage.src = objectUrl;
                return;
            }

            if (imageUrlInput?.value.trim()) {
                previewImage.src = imageUrlInput.value.trim();
                return;
            }

            previewImage.src = previewImage.dataset.defaultSrc;
        };

        const updatePreview = () => {
            if (previewTitle && titleInput) {
                previewTitle.textContent = titleInput.value.trim() || 'Project title preview';
            }

            if (previewDescription && descriptionInput) {
                const summary = descriptionInput.value.trim() || 'Project summary preview.';
                previewDescription.textContent = summary.length > 130 ? `${summary.slice(0, 127)}...` : summary;
            }

            if (previewStatus && activeInput) {
                const isActive = activeInput.checked;
                previewStatus.textContent = isActive ? 'Active' : 'Hidden';
                previewStatus.className = isActive
                    ? 'rounded-full bg-emerald-400/15 px-2.5 py-1 text-xs font-semibold text-emerald-200'
                    : 'rounded-full bg-slate-700 px-2.5 py-1 text-xs font-semibold text-slate-300';
            }

            setPreviewImage();
        };

        form.addEventListener('input', () => {
            isDirty = true;
            updatePreview();
        });

        form.addEventListener('change', () => {
            isDirty = true;
            updatePreview();
        });

        form.addEventListener('submit', () => {
            isDirty = false;
            revokePreviewUrl();
        });

        window.addEventListener('beforeunload', (event) => {
            if (!isDirty) {
                return;
            }

            event.preventDefault();
            event.returnValue = '';
        });

        updatePreview();
    });
</script>
