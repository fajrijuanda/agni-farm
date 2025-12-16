@extends('layouts.app')

@section('title', 'Kontak')

@section('meta_description', 'Hubungi Agni Farm untuk pertanyaan atau informasi lebih lanjut tentang bibit tanaman.')

@section('content')
<!-- Hero -->
<section style="background: linear-gradient(135deg, var(--color-primary-700) 0%, var(--color-primary-800) 100%); padding: calc(var(--header-height) + var(--spacing-16)) 0 var(--spacing-16);">
    <div class="container" style="text-align: center;">
        <h1 style="font-size: var(--font-size-4xl); font-weight: 800; color: white; margin-bottom: var(--spacing-4);">Hubungi Kami</h1>
        <p style="font-size: var(--font-size-lg); color: rgba(255,255,255,0.9); max-width: 600px; margin: 0 auto;">
            Ada pertanyaan? Jangan ragu untuk menghubungi kami
        </p>
    </div>
</section>

<!-- Contact Content -->
<section class="section-lg">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px;">
            <!-- Contact Form -->
            <div>
                <h2 style="font-size: var(--font-size-2xl); font-weight: 700; color: var(--color-gray-900); margin-bottom: var(--spacing-6);">Kirim Pesan</h2>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label required" for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" class="form-input @error('name') error @enderror"
                               value="{{ old('name') }}" placeholder="Nama Anda" required>
                        @error('name')
                            <div style="color: #ef4444; font-size: var(--font-size-sm); margin-top: var(--spacing-1);">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-4);">
                        <div class="form-group">
                            <label class="form-label required" for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-input @error('email') error @enderror"
                                   value="{{ old('email') }}" placeholder="email@example.com" required>
                            @error('email')
                                <div style="color: #ef4444; font-size: var(--font-size-sm); margin-top: var(--spacing-1);">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="phone">Telepon</label>
                            <input type="tel" id="phone" name="phone" class="form-input @error('phone') error @enderror"
                                   value="{{ old('phone') }}" placeholder="08xx xxxx xxxx">
                            @error('phone')
                                <div style="color: #ef4444; font-size: var(--font-size-sm); margin-top: var(--spacing-1);">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required" for="subject">Subjek</label>
                        <input type="text" id="subject" name="subject" class="form-input @error('subject') error @enderror"
                               value="{{ old('subject') }}" placeholder="Perihal pesan Anda" required>
                        @error('subject')
                            <div style="color: #ef4444; font-size: var(--font-size-sm); margin-top: var(--spacing-1);">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required" for="message">Pesan</label>
                        <textarea id="message" name="message" class="form-textarea @error('message') error @enderror"
                                  placeholder="Tuliskan pesan Anda..." rows="5" required>{{ old('message') }}</textarea>
                        @error('message')
                            <div style="color: #ef4444; font-size: var(--font-size-sm); margin-top: var(--spacing-1);">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg">
                        <i data-feather="send" style="width: 20px; height: 20px;"></i>
                        Kirim Pesan
                    </button>
                </form>
            </div>

            <!-- Contact Info -->
            <div>
                <h2 style="font-size: var(--font-size-2xl); font-weight: 700; color: var(--color-gray-900); margin-bottom: var(--spacing-6);">Informasi Kontak</h2>

                <div style="display: flex; flex-direction: column; gap: var(--spacing-6);">
                    <div style="display: flex; gap: var(--spacing-4); align-items: flex-start;">
                        <div style="width: 48px; height: 48px; background: var(--color-primary-100); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i data-feather="map-pin" style="width: 24px; height: 24px; color: var(--color-primary-600);"></i>
                        </div>
                        <div>
                            <h3 style="font-weight: 600; color: var(--color-gray-900); margin-bottom: var(--spacing-1);">Alamat</h3>
                            <p style="color: var(--color-gray-600);">Jawa Barat, Indonesia</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: var(--spacing-4); align-items: flex-start;">
                        <div style="width: 48px; height: 48px; background: var(--color-primary-100); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i data-feather="phone" style="width: 24px; height: 24px; color: var(--color-primary-600);"></i>
                        </div>
                        <div>
                            <h3 style="font-weight: 600; color: var(--color-gray-900); margin-bottom: var(--spacing-1);">Telepon</h3>
                            <p style="color: var(--color-gray-600);">+62 812 3456 7890</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: var(--spacing-4); align-items: flex-start;">
                        <div style="width: 48px; height: 48px; background: var(--color-primary-100); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i data-feather="mail" style="width: 24px; height: 24px; color: var(--color-primary-600);"></i>
                        </div>
                        <div>
                            <h3 style="font-weight: 600; color: var(--color-gray-900); margin-bottom: var(--spacing-1);">Email</h3>
                            <p style="color: var(--color-gray-600);">info@agnifarm.com</p>
                        </div>
                    </div>

                    <div style="display: flex; gap: var(--spacing-4); align-items: flex-start;">
                        <div style="width: 48px; height: 48px; background: var(--color-primary-100); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i data-feather="clock" style="width: 24px; height: 24px; color: var(--color-primary-600);"></i>
                        </div>
                        <div>
                            <h3 style="font-weight: 600; color: var(--color-gray-900); margin-bottom: var(--spacing-1);">Jam Operasional</h3>
                            <p style="color: var(--color-gray-600);">Senin - Sabtu: 08.00 - 17.00 WIB</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Contact Buttons -->
                <div style="margin-top: var(--spacing-8); padding: var(--spacing-6); background: var(--color-gray-50); border-radius: var(--radius-xl);">
                    <h3 style="font-weight: 600; color: var(--color-gray-900); margin-bottom: var(--spacing-4);">Hubungi Langsung</h3>
                    <div style="display: flex; flex-direction: column; gap: var(--spacing-3);">
                        <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-whatsapp" style="justify-content: flex-start;">
                            <i data-feather="message-circle" style="width: 20px; height: 20px;"></i>
                            Chat via WhatsApp
                        </a>
                        <a href="https://shopee.co.id/agnifarm" target="_blank" class="btn btn-shopee" style="justify-content: flex-start;">
                            <i data-feather="shopping-bag" style="width: 20px; height: 20px;"></i>
                            Kunjungi Shopee
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    @media (max-width: 1024px) {
        [style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }

    .form-input.error,
    .form-textarea.error {
        border-color: #ef4444;
    }
</style>
@endpush
