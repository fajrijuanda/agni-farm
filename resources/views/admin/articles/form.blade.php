@extends('admin.layouts.app')

@section('title', $article->exists ? 'Edit Artikel' : 'Buat Artikel Baru')

@section('content')
<!-- Page Header -->
<div class="page-header" style="margin-bottom: 24px;">
    <div class="page-header-content">
        <nav aria-label="breadcrumb" style="margin-bottom: 8px;">
            <ol style="display: flex; align-items: center; gap: 8px; list-style: none; margin: 0; padding: 0; font-size: 13px;">
                <li><a href="{{ route('admin.articles.index') }}" style="color: #16a34a; text-decoration: none; font-weight: 500;">Artikel</a></li>
                <li style="color: #9ca3af;">›</li>
                <li style="color: #374151;">{{ $article->exists ? 'Edit' : 'Buat Baru' }}</li>
            </ol>
        </nav>
        <h1 class="page-title">
            <i data-feather="{{ $article->exists ? 'edit-2' : 'plus-circle' }}" class="page-title-icon"></i>
            {{ $article->exists ? 'Edit Artikel' : 'Buat Artikel Baru' }}
        </h1>
    </div>
</div>

<form id="articleForm" action="{{ $article->exists ? route('admin.articles.update', $article) : route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($article->exists)
        @method('PUT')
    @endif

    <input type="hidden" name="content" id="contentHidden">

    <div class="builder-layout">
        <!-- Left: Block Toolbox -->
        <div class="builder-toolbox">
            <div class="toolbox-card">
                <div class="toolbox-header">
                    <i data-feather="layers" style="width: 16px; height: 16px;"></i>
                    <span>Tambah Blok</span>
                </div>
                <div class="toolbox-blocks">
                    <div class="toolbox-block" draggable="true" data-type="heading">
                        <div class="toolbox-block-icon" style="background: #dbeafe;">
                            <i data-feather="type" style="width: 20px; height: 20px; color: #2563eb;"></i>
                        </div>
                        <span>Heading</span>
                    </div>
                    <div class="toolbox-block" draggable="true" data-type="text">
                        <div class="toolbox-block-icon" style="background: #dcfce7;">
                            <i data-feather="align-left" style="width: 20px; height: 20px; color: #16a34a;"></i>
                        </div>
                        <span>Paragraf</span>
                    </div>
                    <div class="toolbox-block" draggable="true" data-type="image">
                        <div class="toolbox-block-icon" style="background: #fef3c7;">
                            <i data-feather="image" style="width: 20px; height: 20px; color: #d97706;"></i>
                        </div>
                        <span>Gambar</span>
                    </div>
                    <div class="toolbox-block" draggable="true" data-type="video">
                        <div class="toolbox-block-icon" style="background: #fee2e2;">
                            <i data-feather="youtube" style="width: 20px; height: 20px; color: #dc2626;"></i>
                        </div>
                        <span>Video</span>
                    </div>
                    <div class="toolbox-block" draggable="true" data-type="divider">
                        <div class="toolbox-block-icon" style="background: #f3f4f6;">
                            <i data-feather="minus" style="width: 20px; height: 20px; color: #6b7280;"></i>
                        </div>
                        <span>Pembatas</span>
                    </div>
                    <div class="toolbox-block" draggable="true" data-type="quote">
                        <div class="toolbox-block-icon" style="background: #ede9fe;">
                            <i data-feather="message-square" style="width: 20px; height: 20px; color: #7c3aed;"></i>
                        </div>
                        <span>Kutipan</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Center: Main Editor -->
        <div class="builder-editor">
            <!-- Title Card -->
            <div class="editor-card">
                <label class="editor-label">Judul Artikel <span class="text-danger">*</span></label>
                <input type="text"
                       class="editor-title-input @error('title') is-invalid @enderror"
                       id="title"
                       name="title"
                       value="{{ old('title', $article->title) }}"
                       placeholder="Masukkan judul artikel yang menarik..."
                       required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Excerpt Card -->
            <div class="editor-card">
                <label class="editor-label">Ringkasan <span class="text-muted">(opsional)</span></label>
                <textarea class="editor-excerpt-input @error('excerpt') is-invalid @enderror"
                          id="excerpt"
                          name="excerpt"
                          rows="2"
                          placeholder="Ringkasan singkat untuk ditampilkan di halaman daftar...">{{ old('excerpt', $article->excerpt) }}</textarea>
                @error('excerpt')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Content Builder Area -->
            <div class="editor-card content-editor-card">
                <label class="editor-label">Konten Artikel</label>
                <div id="blocksContainer"></div>
                <div id="dropZone" class="drop-zone">
                    <i data-feather="plus-circle" style="width: 48px; height: 48px; color: #d1d5db;"></i>
                    <p>Drag blok dari panel kiri ke sini<br><small>atau klik blok untuk menambahkan</small></p>
                </div>
            </div>
        </div>

        <!-- Right: Settings -->
        <div class="builder-settings">
            <!-- Publish Card -->
            <div class="settings-card">
                <div class="settings-header">
                    <i data-feather="send" style="width: 16px; height: 16px;"></i>
                    <span>Publikasi</span>
                </div>
                <div class="settings-body">
                    <div class="form-check" style="margin-bottom: 12px;">
                        <input type="checkbox" class="form-check-input" id="is_published" name="is_published" value="1" {{ old('is_published', $article->is_published) ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer;">
                        <label class="form-check-label" for="is_published" style="margin-left: 8px; cursor: pointer;">
                            <strong style="font-size: 14px;">Publikasikan Artikel</strong>
                            <span style="display: block; font-size: 12px; color: #9ca3af;">Artikel akan terlihat di website</span>
                        </label>
                    </div>

                    <button type="submit" class="btn-save">
                        <i data-feather="save" style="width: 18px; height: 18px;"></i>
                        {{ $article->exists ? 'Simpan' : 'Simpan Artikel' }}
                    </button>
                    <a href="{{ route('admin.articles.index') }}" class="btn-cancel">Batal</a>
                </div>
            </div>

            <!-- Featured Image Card -->
            <div class="settings-card">
                <div class="settings-header">
                    <i data-feather="image" style="width: 16px; height: 16px;"></i>
                    <span>Gambar Utama</span>
                </div>
                <div class="settings-body">
                    <div id="featuredImagePreview" style="{{ $article->image ? '' : 'display: none;' }}">
                        @if($article->image)
                            <img src="{{ $article->image_url }}" alt="Preview">
                        @endif
                    </div>
                    <div id="featuredImageUpload" class="image-upload-area" onclick="document.getElementById('image').click()">
                        <i data-feather="upload" style="width: 24px; height: 24px; color: #9ca3af;"></i>
                        <span>Upload gambar</span>
                    </div>
                    <input type="file" id="image" name="image" accept="image/*" style="display: none;" onchange="previewFeaturedImage(this)">
                    @error('image')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- YouTube Card -->
            <div class="settings-card">
                <div class="settings-header">
                    <i data-feather="youtube" style="width: 16px; height: 16px; color: #dc2626;"></i>
                    <span>Video YouTube</span>
                </div>
                <div class="settings-body">
                    <input type="url"
                           class="settings-input @error('youtube_url') is-invalid @enderror"
                           id="youtube_url"
                           name="youtube_url"
                           value="{{ old('youtube_url', $article->youtube_url) }}"
                           placeholder="https://youtube.com/watch?v=...">
                    @error('youtube_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @if($article->youtube_url)
                        <div class="video-preview">
                            <iframe src="{{ $article->youtube_embed_url }}" allowfullscreen></iframe>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Block Templates -->
<template id="headingBlockTemplate">
    <div class="content-block" data-type="heading">
        <div class="block-handle"><i data-feather="grip-vertical"></i></div>
        <div class="block-body">
            <div class="block-type-badge" style="background: #dbeafe; color: #2563eb;">Heading</div>
            <input type="text" class="block-heading-input" placeholder="Masukkan judul bagian...">
        </div>
        <button type="button" class="block-delete"><i data-feather="trash-2"></i></button>
    </div>
</template>

<template id="textBlockTemplate">
    <div class="content-block" data-type="text">
        <div class="block-handle"><i data-feather="grip-vertical"></i></div>
        <div class="block-body">
            <div class="block-type-badge" style="background: #dcfce7; color: #16a34a;">Paragraf</div>
            <textarea class="block-text-input" placeholder="Tulis paragraf..." rows="4"></textarea>
        </div>
        <button type="button" class="block-delete"><i data-feather="trash-2"></i></button>
    </div>
</template>

<template id="imageBlockTemplate">
    <div class="content-block" data-type="image">
        <div class="block-handle"><i data-feather="grip-vertical"></i></div>
        <div class="block-body">
            <div class="block-type-badge" style="background: #fef3c7; color: #d97706;">Gambar</div>
            <div class="block-image-preview" style="display: none;"><img src="" alt="Preview"></div>
            <div class="block-image-upload">
                <i data-feather="image"></i>
                <span>Klik untuk pilih gambar</span>
                <input type="file" accept="image/*" style="display: none;">
            </div>
            <input type="text" class="block-caption-input" placeholder="Keterangan gambar (opsional)">
        </div>
        <button type="button" class="block-delete"><i data-feather="trash-2"></i></button>
    </div>
</template>

<template id="videoBlockTemplate">
    <div class="content-block" data-type="video">
        <div class="block-handle"><i data-feather="grip-vertical"></i></div>
        <div class="block-body">
            <div class="block-type-badge" style="background: #fee2e2; color: #dc2626;">Video</div>
            <div class="block-video-preview" style="display: none;"></div>
            <input type="url" class="block-video-input" placeholder="Paste URL YouTube...">
        </div>
        <button type="button" class="block-delete"><i data-feather="trash-2"></i></button>
    </div>
</template>

<template id="dividerBlockTemplate">
    <div class="content-block" data-type="divider">
        <div class="block-handle"><i data-feather="grip-vertical"></i></div>
        <div class="block-body">
            <div class="block-divider"><hr></div>
        </div>
        <button type="button" class="block-delete"><i data-feather="trash-2"></i></button>
    </div>
</template>

<template id="quoteBlockTemplate">
    <div class="content-block" data-type="quote">
        <div class="block-handle"><i data-feather="grip-vertical"></i></div>
        <div class="block-body">
            <div class="block-type-badge" style="background: #ede9fe; color: #7c3aed;">Kutipan</div>
            <textarea class="block-quote-input" placeholder="Tulis kutipan..." rows="2"></textarea>
            <input type="text" class="block-quote-author" placeholder="- Nama penulis">
        </div>
        <button type="button" class="block-delete"><i data-feather="trash-2"></i></button>
    </div>
</template>
@endsection

@push('styles')
<style>
    /* Builder Layout */
    .builder-layout {
        display: grid;
        grid-template-columns: 200px 1fr 280px;
        gap: 24px;
        align-items: start;
    }

    /* Toolbox */
    .builder-toolbox {
        position: sticky;
        top: 80px;
    }

    .toolbox-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .toolbox-header {
        padding: 16px;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        font-size: 13px;
        color: #374151;
    }

    .toolbox-blocks {
        padding: 12px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .toolbox-block {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        background: #f9fafb;
        border-radius: 8px;
        cursor: grab;
        transition: all 0.2s;
        font-size: 13px;
        font-weight: 500;
        color: #374151;
    }

    .toolbox-block:hover {
        background: #f3f4f6;
        transform: translateX(4px);
    }

    .toolbox-block:active {
        cursor: grabbing;
    }

    .toolbox-block-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Editor Area */
    .builder-editor {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .editor-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .editor-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 12px;
    }

    .editor-title-input {
        width: 100%;
        font-size: 24px;
        font-weight: 700;
        border: none;
        padding: 0;
        color: #111827;
    }

    .editor-title-input:focus {
        outline: none;
    }

    .editor-excerpt-input {
        width: 100%;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px;
        font-size: 14px;
        resize: none;
    }

    .editor-excerpt-input:focus {
        outline: none;
        border-color: #16a34a;
    }

    .content-editor-card {
        min-height: 350px;
    }

    .content-editor-card #blocksContainer:empty + .drop-zone {
        min-height: 280px;
    }

    .drop-zone {
        border: 2px dashed #e5e7eb;
        border-radius: 12px;
        padding: 40px;
        text-align: center;
        color: #9ca3af;
        transition: all 0.2s;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .drop-zone.drag-over {
        border-color: #16a34a;
        background: #f0fdf4;
    }

    .drop-zone p {
        margin: 12px 0 0;
        font-size: 14px;
    }

    .drop-zone small {
        color: #d1d5db;
    }

    /* Content Blocks */
    .content-block {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 16px;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        margin-bottom: 12px;
        transition: all 0.2s;
    }

    .content-block:hover {
        border-color: #d1d5db;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .content-block.dragging {
        opacity: 0.5;
        border: 2px dashed #16a34a;
    }

    .block-handle {
        cursor: grab;
        padding: 4px;
        color: #9ca3af;
    }

    .block-handle:hover {
        color: #6b7280;
    }

    .block-handle svg {
        width: 16px;
        height: 16px;
    }

    .block-body {
        flex: 1;
        min-width: 0;
    }

    .block-type-badge {
        display: inline-block;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 4px 8px;
        border-radius: 4px;
        margin-bottom: 10px;
    }

    .block-delete {
        padding: 4px;
        background: none;
        border: none;
        color: #d1d5db;
        cursor: pointer;
        transition: all 0.2s;
    }

    .block-delete:hover {
        color: #dc2626;
    }

    .block-delete svg {
        width: 16px;
        height: 16px;
    }

    .block-heading-input {
        width: 100%;
        font-size: 18px;
        font-weight: 700;
        border: none;
        background: transparent;
        padding: 0;
    }

    .block-heading-input:focus { outline: none; }

    .block-text-input, .block-quote-input {
        width: 100%;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 12px;
        font-size: 14px;
        line-height: 1.6;
        resize: vertical;
        background: white;
    }

    .block-text-input:focus, .block-quote-input:focus {
        outline: none;
        border-color: #16a34a;
    }

    .block-quote-author {
        width: 100%;
        border: none;
        border-top: 1px solid #e5e7eb;
        padding: 8px 0 0;
        margin-top: 8px;
        font-size: 13px;
        font-style: italic;
        color: #6b7280;
        background: transparent;
    }

    .block-quote-author:focus { outline: none; }

    .block-image-upload {
        border: 2px dashed #e5e7eb;
        border-radius: 8px;
        padding: 24px;
        text-align: center;
        cursor: pointer;
        color: #9ca3af;
        transition: all 0.2s;
    }

    .block-image-upload:hover {
        border-color: #16a34a;
        background: #f0fdf4;
    }

    .block-image-upload svg {
        width: 32px;
        height: 32px;
        margin-bottom: 8px;
    }

    .block-image-upload span {
        display: block;
        font-size: 13px;
    }

    .block-image-preview img {
        width: 100%;
        max-height: 200px;
        object-fit: cover;
        border-radius: 8px;
    }

    .block-caption-input {
        width: 100%;
        border: none;
        border-top: 1px solid #e5e7eb;
        padding: 8px 0 0;
        margin-top: 8px;
        font-size: 12px;
        color: #6b7280;
        background: transparent;
    }

    .block-caption-input:focus { outline: none; }

    .block-video-input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        font-size: 13px;
    }

    .block-video-input:focus {
        outline: none;
        border-color: #16a34a;
    }

    .block-video-preview iframe {
        width: 100%;
        aspect-ratio: 16/9;
        border: none;
        border-radius: 8px;
        margin-bottom: 8px;
    }

    .block-divider hr {
        border: none;
        border-top: 2px solid #e5e7eb;
        margin: 16px 0;
    }

    /* Settings Sidebar */
    .builder-settings {
        position: sticky;
        top: 80px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .settings-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .settings-header {
        padding: 14px 16px;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        font-size: 13px;
        color: #374151;
    }

    .settings-body {
        padding: 16px;
    }

    .toggle-switch {
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
    }

    .toggle-switch input { display: none; }

    .toggle-slider {
        width: 44px;
        height: 24px;
        background: #e5e7eb;
        border-radius: 12px;
        position: relative;
        transition: all 0.3s;
    }

    .toggle-slider:before {
        content: '';
        position: absolute;
        width: 18px;
        height: 18px;
        background: white;
        border-radius: 50%;
        top: 3px;
        left: 3px;
        transition: all 0.3s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }

    .toggle-switch input:checked + .toggle-slider {
        background: #16a34a;
    }

    .toggle-switch input:checked + .toggle-slider:before {
        left: 23px;
    }

    .toggle-label {
        font-weight: 600;
        font-size: 14px;
        color: #374151;
    }

    .settings-hint {
        font-size: 12px;
        color: #9ca3af;
        margin: 8px 0 16px;
    }

    .btn-save {
        width: 100%;
        padding: 12px;
        background: #16a34a;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-save:hover {
        background: #15803d;
    }

    .btn-cancel {
        display: block;
        width: 100%;
        padding: 10px;
        background: #f3f4f6;
        color: #6b7280;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        font-size: 13px;
        text-align: center;
        text-decoration: none;
        margin-top: 8px;
        transition: all 0.2s;
    }

    .btn-cancel:hover {
        background: #e5e7eb;
        color: #374151;
    }

    .settings-input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-size: 13px;
    }

    .settings-input:focus {
        outline: none;
        border-color: #16a34a;
    }

    .image-upload-area {
        border: 2px dashed #e5e7eb;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .image-upload-area:hover {
        border-color: #16a34a;
        background: #f0fdf4;
    }

    .image-upload-area span {
        display: block;
        font-size: 12px;
        color: #6b7280;
        margin-top: 8px;
    }

    #featuredImagePreview img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 8px;
    }

    .video-preview {
        margin-top: 12px;
        border-radius: 8px;
        overflow: hidden;
    }

    .video-preview iframe {
        width: 100%;
        aspect-ratio: 16/9;
        border: none;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .builder-layout {
            grid-template-columns: 1fr 260px;
        }
        .builder-toolbox {
            display: none;
        }
    }

    @media (max-width: 768px) {
        .builder-layout {
            grid-template-columns: 1fr;
        }
        .builder-settings {
            position: static;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('blocksContainer');
    const dropZone = document.getElementById('dropZone');
    const form = document.getElementById('articleForm');
    const contentHidden = document.getElementById('contentHidden');

    // Initialize with existing content
    const existingContent = @json(old('content', $article->content ?? ''));
    if (existingContent) {
        try {
            const blocks = JSON.parse(existingContent);
            if (Array.isArray(blocks)) {
                blocks.forEach(block => addBlock(block.type, block.content));
            }
        } catch (e) {
            if (existingContent.trim()) {
                addBlock('text', existingContent);
            }
        }
    }
    updateDropZone();

    // Toolbox drag and drop
    document.querySelectorAll('.toolbox-block').forEach(block => {
        block.addEventListener('dragstart', function(e) {
            e.dataTransfer.setData('blockType', this.dataset.type);
            e.dataTransfer.effectAllowed = 'copy';
        });

        block.addEventListener('click', function() {
            addBlock(this.dataset.type);
            updateDropZone();
        });
    });

    // Drop zone events
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('drag-over');
    });

    dropZone.addEventListener('dragleave', function() {
        this.classList.remove('drag-over');
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
        const type = e.dataTransfer.getData('blockType');
        if (type) {
            addBlock(type);
            updateDropZone();
        }
    });

    function addBlock(type, content = '') {
        const template = document.getElementById(type + 'BlockTemplate');
        if (!template) return;

        const block = template.content.cloneNode(true).querySelector('.content-block');

        if (content) {
            switch (type) {
                case 'heading':
                    block.querySelector('.block-heading-input').value = content;
                    break;
                case 'text':
                    block.querySelector('.block-text-input').value = content;
                    break;
                case 'quote':
                    if (typeof content === 'object') {
                        block.querySelector('.block-quote-input').value = content.text || '';
                        block.querySelector('.block-quote-author').value = content.author || '';
                    } else {
                        block.querySelector('.block-quote-input').value = content;
                    }
                    break;
                case 'image':
                    if (content.url) {
                        const preview = block.querySelector('.block-image-preview');
                        preview.style.display = 'block';
                        preview.querySelector('img').src = content.url;
                        block.querySelector('.block-image-upload').style.display = 'none';
                        if (content.caption) {
                            block.querySelector('.block-caption-input').value = content.caption;
                        }
                    }
                    break;
                case 'video':
                    block.querySelector('.block-video-input').value = content;
                    updateVideoPreview(block);
                    break;
            }
        }

        container.appendChild(block);
        initBlockEvents(block);
        feather.replace();
        updateDropZone();
    }

    function initBlockEvents(block) {
        block.querySelector('.block-delete').addEventListener('click', function() {
            block.remove();
            updateDropZone();
        });

        const handle = block.querySelector('.block-handle');
        handle.addEventListener('mousedown', () => block.draggable = true);
        handle.addEventListener('mouseup', () => block.draggable = false);

        block.addEventListener('dragstart', function(e) {
            block.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
        });

        block.addEventListener('dragend', function() {
            block.classList.remove('dragging');
            block.draggable = false;
        });

        block.addEventListener('dragover', function(e) {
            e.preventDefault();
            const dragging = document.querySelector('.content-block.dragging');
            if (dragging && dragging !== block) {
                const rect = block.getBoundingClientRect();
                const mid = rect.top + rect.height / 2;
                if (e.clientY < mid) {
                    container.insertBefore(dragging, block);
                } else {
                    container.insertBefore(dragging, block.nextSibling);
                }
            }
        });

        if (block.dataset.type === 'image') {
            const uploadArea = block.querySelector('.block-image-upload');
            const fileInput = uploadArea.querySelector('input[type="file"]');
            const preview = block.querySelector('.block-image-preview');

            uploadArea.addEventListener('click', () => fileInput.click());
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.querySelector('img').src = e.target.result;
                        preview.style.display = 'block';
                        uploadArea.style.display = 'none';
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }

        if (block.dataset.type === 'video') {
            const input = block.querySelector('.block-video-input');
            input.addEventListener('blur', () => updateVideoPreview(block));
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    updateVideoPreview(block);
                }
            });
        }
    }

    function updateVideoPreview(block) {
        const input = block.querySelector('.block-video-input');
        const preview = block.querySelector('.block-video-preview');
        const url = input.value;

        if (url) {
            const videoId = extractYouTubeId(url);
            if (videoId) {
                preview.innerHTML = `<iframe src="https://www.youtube.com/embed/${videoId}" allowfullscreen></iframe>`;
                preview.style.display = 'block';
            }
        } else {
            preview.style.display = 'none';
            preview.innerHTML = '';
        }
    }

    function extractYouTubeId(url) {
        const patterns = [
            /youtube\.com\/watch\?v=([^&]+)/,
            /youtube\.com\/embed\/([^?]+)/,
            /youtu\.be\/([^?]+)/
        ];
        for (const pattern of patterns) {
            const match = url.match(pattern);
            if (match) return match[1];
        }
        return null;
    }

    function updateDropZone() {
        dropZone.style.display = container.children.length === 0 ? 'block' : 'none';
    }

    form.addEventListener('submit', function(e) {
        const blocks = [];
        container.querySelectorAll('.content-block').forEach(block => {
            const type = block.dataset.type;
            let content = '';

            switch (type) {
                case 'heading':
                    content = block.querySelector('.block-heading-input').value;
                    break;
                case 'text':
                    content = block.querySelector('.block-text-input').value;
                    break;
                case 'quote':
                    content = {
                        text: block.querySelector('.block-quote-input').value,
                        author: block.querySelector('.block-quote-author').value
                    };
                    break;
                case 'image':
                    const img = block.querySelector('.block-image-preview img');
                    const caption = block.querySelector('.block-caption-input').value;
                    content = { url: img.src || '', caption: caption };
                    break;
                case 'video':
                    content = block.querySelector('.block-video-input').value;
                    break;
                case 'divider':
                    content = 'divider';
                    break;
            }

            if (content && (typeof content === 'string' ? content.trim() : (content.url || content.text || content === 'divider'))) {
                blocks.push({ type, content });
            }
        });

        contentHidden.value = JSON.stringify(blocks);
    });
});

function previewFeaturedImage(input) {
    const preview = document.getElementById('featuredImagePreview');
    const upload = document.getElementById('featuredImageUpload');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            preview.style.display = 'block';
            upload.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
