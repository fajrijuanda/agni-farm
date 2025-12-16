@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('meta_description', 'Tentang Agni Farm - Supplier bibit tanaman berkualitas dari Jawa Barat.')

@section('content')
<!-- Hero -->
<section style="background: linear-gradient(135deg, var(--color-primary-700) 0%, var(--color-primary-800) 100%); padding: calc(var(--header-height) + var(--spacing-16)) 0 var(--spacing-16);">
    <div class="container" style="text-align: center;">
        <h1 style="font-size: var(--font-size-4xl); font-weight: 800; color: white; margin-bottom: var(--spacing-4);">Tentang Kami</h1>
        <p style="font-size: var(--font-size-lg); color: rgba(255,255,255,0.9); max-width: 600px; margin: 0 auto;">
            Kenali lebih dekat Agni Farm, partner berkebun Anda
        </p>
    </div>
</section>

<!-- About Content -->
<section class="section-lg" style="background: white;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;">
            <div style="background: linear-gradient(135deg, var(--color-primary-100) 0%, var(--color-primary-200) 100%); border-radius: var(--radius-2xl); padding: 60px; text-align: center;">
                <span style="font-size: 120px;">🌱</span>
                <h3 style="color: var(--color-primary-700); font-size: var(--font-size-2xl); font-weight: 700; margin-top: var(--spacing-4);">Agni Farm</h3>
                <p style="color: var(--color-primary-600);">Est. 2020</p>
            </div>
            <div>
                <span class="section-badge">Cerita Kami</span>
                <h2 style="font-size: var(--font-size-3xl); font-weight: 700; color: var(--color-gray-900); margin-bottom: var(--spacing-6);">
                    Bermula dari Hobi, Tumbuh Menjadi Passion
                </h2>
                <p style="color: var(--color-gray-600); line-height: 1.8; margin-bottom: var(--spacing-4);">
                    Agni Farm bermula dari hobi berkebun yang berkembang menjadi bisnis. Dengan pengalaman bertahun-tahun
                    dalam budidaya tanaman, kami berkomitmen untuk menyediakan bibit tanaman berkualitas tinggi
                    dengan harga yang terjangkau.
                </p>
                <p style="color: var(--color-gray-600); line-height: 1.8;">
                    Nama "Agni" berasal dari bahasa Sanskerta yang berarti api, melambangkan semangat dan dedikasi
                    kami dalam menghadirkan produk terbaik untuk pelanggan.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission -->
<section class="section-lg">
    <div class="container">
        <div class="section-header">
            <span class="section-badge">Visi & Misi</span>
            <h2 class="section-title">Komitmen Kami</h2>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: var(--spacing-6);">
            <div style="background: white; border-radius: var(--radius-2xl); padding: var(--spacing-8); box-shadow: var(--shadow-md);">
                <div style="width: 64px; height: 64px; background: var(--color-primary-100); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; margin-bottom: var(--spacing-4);">
                    <i data-feather="eye" style="width: 32px; height: 32px; color: var(--color-primary-600);"></i>
                </div>
                <h3 style="font-size: var(--font-size-xl); font-weight: 700; color: var(--color-gray-900); margin-bottom: var(--spacing-3);">Visi</h3>
                <p style="color: var(--color-gray-600); line-height: 1.7;">
                    Menjadi supplier bibit tanaman terpercaya yang membantu masyarakat Indonesia mewujudkan
                    impian berkebunnya dengan mudah dan terjangkau.
                </p>
            </div>

            <div style="background: white; border-radius: var(--radius-2xl); padding: var(--spacing-8); box-shadow: var(--shadow-md);">
                <div style="width: 64px; height: 64px; background: var(--color-secondary-100); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; margin-bottom: var(--spacing-4);">
                    <i data-feather="target" style="width: 32px; height: 32px; color: var(--color-secondary-600);"></i>
                </div>
                <h3 style="font-size: var(--font-size-xl); font-weight: 700; color: var(--color-gray-900); margin-bottom: var(--spacing-3);">Misi</h3>
                <ul style="color: var(--color-gray-600); line-height: 1.8; padding-left: var(--spacing-5);">
                    <li>Menyediakan bibit tanaman berkualitas tinggi</li>
                    <li>Memberikan harga yang kompetitif</li>
                    <li>Pelayanan yang ramah dan responsif</li>
                    <li>Pengiriman cepat ke seluruh Indonesia</li>
                </ul>
            </div>

            <div style="background: white; border-radius: var(--radius-2xl); padding: var(--spacing-8); box-shadow: var(--shadow-md);">
                <div style="width: 64px; height: 64px; background: var(--color-primary-100); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; margin-bottom: var(--spacing-4);">
                    <i data-feather="heart" style="width: 32px; height: 32px; color: var(--color-primary-600);"></i>
                </div>
                <h3 style="font-size: var(--font-size-xl); font-weight: 700; color: var(--color-gray-900); margin-bottom: var(--spacing-3);">Nilai</h3>
                <p style="color: var(--color-gray-600); line-height: 1.7;">
                    Kualitas, Kepercayaan, dan Kepuasan Pelanggan adalah nilai utama yang kami pegang
                    dalam setiap layanan yang kami berikan.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="section-lg" style="background: white;">
    <div class="container">
        <div class="section-header">
            <span class="section-badge">Keunggulan Kami</span>
            <h2 class="section-title">Mengapa Memilih Agni Farm?</h2>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--spacing-6);">
            <div style="text-align: center; padding: var(--spacing-6);">
                <div style="font-size: 48px; margin-bottom: var(--spacing-4);">🌿</div>
                <h3 style="font-weight: 600; color: var(--color-gray-900); margin-bottom: var(--spacing-2);">Bibit Berkualitas</h3>
                <p style="color: var(--color-gray-500); font-size: var(--font-size-sm);">Setiap bibit melalui seleksi ketat</p>
            </div>
            <div style="text-align: center; padding: var(--spacing-6);">
                <div style="font-size: 48px; margin-bottom: var(--spacing-4);">💰</div>
                <h3 style="font-weight: 600; color: var(--color-gray-900); margin-bottom: var(--spacing-2);">Harga Terjangkau</h3>
                <p style="color: var(--color-gray-500); font-size: var(--font-size-sm);">Kualitas premium, harga bersahabat</p>
            </div>
            <div style="text-align: center; padding: var(--spacing-6);">
                <div style="font-size: 48px; margin-bottom: var(--spacing-4);">🚚</div>
                <h3 style="font-weight: 600; color: var(--color-gray-900); margin-bottom: var(--spacing-2);">Pengiriman Cepat</h3>
                <p style="color: var(--color-gray-500); font-size: var(--font-size-sm);">Ke seluruh Indonesia via Shopee</p>
            </div>
            <div style="text-align: center; padding: var(--spacing-6);">
                <div style="font-size: 48px; margin-bottom: var(--spacing-4);">💬</div>
                <h3 style="font-weight: 600; color: var(--color-gray-900); margin-bottom: var(--spacing-2);">Pelayanan Ramah</h3>
                <p style="color: var(--color-gray-500); font-size: var(--font-size-sm);">Konsultasi gratis via WhatsApp</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Ada Pertanyaan?</h2>
            <p class="cta-description">
                Hubungi kami untuk konsultasi atau informasi lebih lanjut
            </p>
            <div style="display: flex; gap: var(--spacing-4); justify-content: center; flex-wrap: wrap;">
                <a href="{{ route('contact') }}" class="btn btn-secondary btn-lg">
                    <i data-feather="mail" style="width: 20px; height: 20px;"></i>
                    Hubungi Kami
                </a>
                <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-whatsapp btn-lg">
                    <i data-feather="message-circle" style="width: 20px; height: 20px;"></i>
                    Chat WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    @@media (max-width: 1024px) {
        [style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endpush
