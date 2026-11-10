@props([
    'id' => 'image-upload',
    'name' => 'image',
    'previewId' => null,
    'preview' => asset('images/default_product.png'),
    'accept' => 'image/*',
    'helpText' => __('dashboard.image_upload_help'),
    'alt' => __('dashboard.image_preview'),
])

@php
    $previewId = $previewId ?: $id . '-preview';
@endphp

<div class="image-upload-component">
    <label for="{{ $id }}" class="product-image-upload">
        <img id="{{ $previewId }}" src="{{ $preview }}" alt="{{ $alt }}" class="product-image-preview" />
        <span class="product-image-plus" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16" fill="currentColor">
                <path d="M8 3a.5.5 0 0 1 .5.5v4h4a.5.5 0 0 1 0 1h-4v4a.5.5 0 0 1-1 0v-4h-4a.5.5 0 0 1 0-1h4v-4A.5.5 0 0 1 8 3z" />
            </svg>
        </span>
    </label>
    <input
        type="file"
        class="visually-hidden @error($name) is-invalid @enderror"
        name="{{ $name }}"
        id="{{ $id }}"
        accept="{{ $accept }}"
        data-image-preview-input
        data-preview-target="{{ $previewId }}"
    />
    @if ($helpText)
        <div class="form-text mt-3">{{ $helpText }}</div>
    @endif
    @error($name)
        <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
    @enderror
</div>