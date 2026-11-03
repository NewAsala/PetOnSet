document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-image-preview-input]').forEach(function (input) {
        input.addEventListener('change', function () {
            const file = input.files && input.files[0];
            const preview = document.getElementById(input.dataset.previewTarget);

            if (!file || !preview || !file.type.startsWith('image/')) {
                return;
            }

            if (input.dataset.previewUrl) {
                URL.revokeObjectURL(input.dataset.previewUrl);
            }

            input.dataset.previewUrl = URL.createObjectURL(file);
            preview.src = input.dataset.previewUrl;
        });
    });
});