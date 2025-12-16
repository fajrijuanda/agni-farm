@extends('admin.layouts.app')

@section('title', 'Pengaturan Website')

@section('content')
<div class="page-header">
    <div>
        <h1>Pengaturan Website</h1>
        <p>Kelola konfigurasi global website Anda</p>
    </div>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-grid">
        <!-- Left Column: General & Contact -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <!-- Site Identity -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Identitas Website</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="site_name">Nama Website</label>
                        <input type="text" id="site_name" name="site_name" class="form-input"
                               value="{{ $settings['site_name'] ?? 'Agni Farm' }}" placeholder="Nama website Anda">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="site_tagline">Tagline</label>
                        <input type="text" id="site_tagline" name="site_tagline" class="form-input"
                               value="{{ $settings['site_tagline'] ?? '' }}" placeholder="Slogan website">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="site_description">Deskripsi SEO</label>
                        <textarea id="site_description" name="site_description" class="form-textarea" rows="3"
                                  placeholder="Deskripsi singkat untuk mesin pencari...">{{ $settings['site_description'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kontak & Lokasi</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="contact_email">Email</label>
                        <input type="email" id="contact_email" name="contact_email" class="form-input"
                               value="{{ $settings['contact_email'] ?? '' }}" placeholder="admin@agnifarm.com">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="contact_phone">WhatsApp</label>
                        <input type="text" id="contact_phone" name="contact_phone" class="form-input"
                               value="{{ $settings['contact_phone'] ?? '' }}" placeholder="628123xxx">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="contact_address">Alamat Lengkap</label>
                        <textarea id="contact_address" name="contact_address" class="form-textarea" rows="3"
                                  placeholder="Alamat fisik toko/farm...">{{ $settings['contact_address'] ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="contact_maps">Embed Google Maps</label>
                        <textarea id="contact_maps" name="contact_maps" class="form-textarea" rows="3"
                                  placeholder="<iframe src='...'></iframe>">{{ $settings['contact_maps'] ?? '' }}</textarea>
                        <div class="form-hint">Paste kode embed iframe dari Google Maps di sini</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Visuals & Social -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <!-- Visual Branding -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Visual Branding</h3>
                </div>
                <div class="card-body">
                    <!-- Logo -->
                    <div class="form-group">
                        <label class="form-label">Logo Website</label>
                        @if(isset($settings['site_logo']))
                            <div style="background: var(--color-gray-100); padding: 12px; border-radius: 8px; margin-bottom: 12px; text-align: center;">
                                <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo" style="height: 60px;">
                            </div>
                        @endif
                        <input type="file" name="site_logo" class="form-input" accept="image/*" style="padding: 10px;">
                        <div class="form-hint">Format PNG/WebP transparan. Tinggi rec: 60px.</div>
                    </div>

                    <!-- Favicon -->
                    <div class="form-group">
                        <label class="form-label">Favicon</label>
                        @if(isset($settings['site_favicon']))
                            <div style="margin-bottom: 12px;">
                                <img src="{{ asset('storage/' . $settings['site_favicon']) }}" alt="Favicon" style="width: 32px; height: 32px;">
                            </div>
                        @endif
                        <input type="file" name="site_favicon" class="form-input" accept="image/*" style="padding: 10px;">
                        <div class="form-hint">Icon di tab browser (32x32 px).</div>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sosial Media</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label" for="social_facebook">Facebook URL</label>
                        <input type="url" id="social_facebook" name="social_facebook" class="form-input"
                               value="{{ $settings['social_facebook'] ?? '' }}" placeholder="https://facebook.com/...">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="social_instagram">Instagram URL</label>
                        <input type="url" id="social_instagram" name="social_instagram" class="form-input"
                               value="{{ $settings['social_instagram'] ?? '' }}" placeholder="https://instagram.com/...">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="social_tiktok">TikTok URL</label>
                        <input type="url" id="social_tiktok" name="social_tiktok" class="form-input"
                               value="{{ $settings['social_tiktok'] ?? '' }}" placeholder="https://tiktok.com/...">
                    </div>
                </div>
            </div>

            <!-- Action -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i data-feather="save"></i>
                        Simpan Pengaturan
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
