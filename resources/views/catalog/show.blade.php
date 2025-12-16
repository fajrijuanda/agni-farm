@extends('layouts.app')

@section('title', $product->name)

@section('meta_description', $product->short_description ?? 'Beli ' . $product->name . ' di Agni Farm dengan harga terjangkau.')

@section('content')
<!-- Breadcrumb -->
<section style="background: white; padding-top: calc(var(--header-height) + var(--spacing-4)); padding-bottom: var(--spacing-4); border-bottom: 1px solid var(--color-gray-100);">
    <div class="container">
        <nav style="display: flex; align-items: center; gap: var(--spacing-2); font-size: var(--font-size-sm); color: var(--color-gray-500);">
            <a href="{{ route('home') }}" style="color: var(--color-gray-500);">Beranda</a>
            <i data-feather="chevron-right" style="width: 16px; height: 16px;"></i>
            <a href="{{ route('catalog') }}" style="color: var(--color-gray-500);">Catalog</a>
            <i data-feather="chevron-right" style="width: 16px; height: 16px;"></i>
            <span style="color: var(--color-gray-800);">{{ $product->name }}</span>
        </nav>
    </div>
</section>

<!-- Product Detail -->
<section class="section-lg" style="background: white;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px;">
            <!-- Product Images -->
            <div>
                <div style="background: var(--color-gray-50); border-radius: var(--radius-2xl); overflow: hidden; margin-bottom: var(--spacing-4);">
                    @if($product->images->count() > 0)
                        <img id="mainImage" src="{{ asset('storage/' . $product->primary_image->image_path) }}"
                             alt="{{ $product->name }}"
                             style="width: 100%; aspect-ratio: 1/1; object-fit: cover;">
                    @else
                        <div style="width: 100%; aspect-ratio: 1/1; display: flex; align-items: center; justify-content: center;">
                            <i data-feather="image" style="width: 64px; height: 64px; color: var(--color-gray-300);"></i>
                        </div>
                    @endif
                </div>

                @if($product->images->count() > 1)
                    <div style="display: flex; gap: var(--spacing-3); overflow-x: auto;">
                        @foreach($product->images as $image)
                            <button onclick="changeImage('{{ asset('storage/' . $image->image_path) }}')"
                                    style="width: 80px; height: 80px; flex-shrink: 0; border-radius: var(--radius-lg); overflow: hidden; border: 2px solid var(--color-gray-200); cursor: pointer; padding: 0; background: none;">
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                     alt="{{ $product->name }}"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div>
                <span class="product-category" style="font-size: var(--font-size-sm);">{{ $product->category->name ?? 'Uncategorized' }}</span>
                <h1 style="font-size: var(--font-size-3xl); font-weight: 700; color: var(--color-gray-900); margin: var(--spacing-2) 0 var(--spacing-4);">
                    {{ $product->name }}
                </h1>

                <!-- Price -->
                <div style="margin-bottom: var(--spacing-6);">
                    @if($product->has_discount)
                        <div style="display: flex; align-items: center; gap: var(--spacing-3);">
                            <span style="font-size: var(--font-size-3xl); font-weight: 700; color: var(--color-primary-600);">
                                {{ $product->formatted_discount_price }}
                            </span>
                            <span style="font-size: var(--font-size-lg); color: var(--color-gray-400); text-decoration: line-through;">
                                {{ $product->formatted_price }}
                            </span>
                            <span style="background: var(--color-secondary-500); color: white; padding: var(--spacing-1) var(--spacing-3); border-radius: var(--radius-full); font-size: var(--font-size-sm); font-weight: 600;">
                                -{{ $product->discount_percentage }}%
                            </span>
                        </div>
                    @else
                        <span style="font-size: var(--font-size-3xl); font-weight: 700; color: var(--color-primary-600);">
                            {{ $product->formatted_price }}
                        </span>
                    @endif
                </div>

                <!-- Short Description -->
                @if($product->short_description)
                    <p style="color: var(--color-gray-600); line-height: 1.7; margin-bottom: var(--spacing-6);">
                        {{ $product->short_description }}
                    </p>
                @endif

                <!-- Specifications -->
                @if($product->specifications->count() > 0)
                    <div style="background: var(--color-gray-50); border-radius: var(--radius-lg); padding: var(--spacing-4); margin-bottom: var(--spacing-6);">
                        <h3 style="font-size: var(--font-size-base); font-weight: 600; color: var(--color-gray-800); margin-bottom: var(--spacing-3);">Spesifikasi</h3>
                        <div style="display: grid; gap: var(--spacing-2);">
                            @foreach($product->specifications as $spec)
                                <div style="display: flex; justify-content: space-between; font-size: var(--font-size-sm);">
                                    <span style="color: var(--color-gray-500);">{{ $spec->key }}</span>
                                    <span style="color: var(--color-gray-800); font-weight: 500;">{{ $spec->value }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div style="display: flex; gap: var(--spacing-3); margin-bottom: var(--spacing-6);">
                    <a href="{{ $product->shopee_link }}" target="_blank" class="btn btn-shopee btn-lg" style="flex: 1;">
                        <i data-feather="shopping-bag" style="width: 20px; height: 20px;"></i>
                        Beli di Shopee
                    </a>
                    <a href="https://wa.me/6281234567890?text=Halo, saya tertarik dengan produk {{ $product->name }}" target="_blank" class="btn btn-whatsapp btn-lg" style="flex: 1;">
                        <i data-feather="message-circle" style="width: 20px; height: 20px;"></i>
                        Tanya via WA
                    </a>
                </div>

                <!-- Info -->
                <div style="display: flex; gap: var(--spacing-6); padding: var(--spacing-4); background: var(--color-primary-50); border-radius: var(--radius-lg);">
                    <div style="display: flex; align-items: center; gap: var(--spacing-2);">
                        <i data-feather="truck" style="width: 20px; height: 20px; color: var(--color-primary-600);"></i>
                        <span style="font-size: var(--font-size-sm); color: var(--color-primary-700);">Pengiriman via Shopee</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: var(--spacing-2);">
                        <i data-feather="shield" style="width: 20px; height: 20px; color: var(--color-primary-600);"></i>
                        <span style="font-size: var(--font-size-sm); color: var(--color-primary-700);">Garansi Bibit</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Full Description -->
        @if($product->full_description)
            <div style="margin-top: var(--spacing-12); padding-top: var(--spacing-8); border-top: 1px solid var(--color-gray-200);">
                <h2 style="font-size: var(--font-size-xl); font-weight: 600; color: var(--color-gray-900); margin-bottom: var(--spacing-4);">Deskripsi Produk</h2>
                <div style="color: var(--color-gray-600); line-height: 1.8;">
                    {!! nl2br(e($product->full_description)) !!}
                </div>
            </div>
        @endif
    </div>
</section>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
<section class="section-lg">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Produk Terkait</h2>
        </div>

        <div class="products-grid">
            @foreach($relatedProducts as $relatedProduct)
                <div class="product-card">
                    <div class="product-card-image">
                        @if($relatedProduct->primary_image)
                            <img src="{{ asset('storage/' . $relatedProduct->primary_image->image_path) }}" alt="{{ $relatedProduct->name }}">
                        @else
                            <div style="width: 100%; height: 100%; background: var(--color-gray-100); display: flex; align-items: center; justify-content: center;">
                                <i data-feather="image" style="width: 48px; height: 48px; color: var(--color-gray-300);"></i>
                            </div>
                        @endif
                        @if($relatedProduct->has_discount)
                            <span class="product-badge">-{{ $relatedProduct->discount_percentage }}%</span>
                        @endif
                    </div>
                    <div class="product-card-body">
                        <span class="product-category">{{ $relatedProduct->category->name ?? 'Uncategorized' }}</span>
                        <h3 class="product-title">
                            <a href="{{ route('catalog.show', $relatedProduct->slug) }}">{{ $relatedProduct->name }}</a>
                        </h3>
                        <div class="product-price">
                            @if($relatedProduct->has_discount)
                                <span class="product-price-current">{{ $relatedProduct->formatted_discount_price }}</span>
                                <span class="product-price-original">{{ $relatedProduct->formatted_price }}</span>
                            @else
                                <span class="product-price-current">{{ $relatedProduct->formatted_price }}</span>
                            @endif
                        </div>
                        <div class="product-card-footer">
                            <a href="{{ route('catalog.show', $relatedProduct->slug) }}" class="btn btn-secondary">
                                <i data-feather="eye" style="width: 16px; height: 16px;"></i>
                                Detail
                            </a>
                            <a href="{{ $relatedProduct->shopee_link }}" target="_blank" class="btn btn-shopee">
                                <i data-feather="shopping-bag" style="width: 16px; height: 16px;"></i>
                                Beli
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection

@push('scripts')
<script>
function changeImage(src) {
    document.getElementById('mainImage').src = src;
}
</script>
@endpush

@push('styles')
<style>
    @@media (max-width: 1024px) {
        [style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endpush
