@extends('layouts.app')

@section('title', 'Catalog Produk')

@section('meta_description', 'Catalog produk bibit tanaman Agni Farm. Berbagai pilihan bibit berkualitas dengan harga terjangkau.')

@section('content')
<!-- Hero -->
<section style="background: linear-gradient(135deg, var(--color-primary-700) 0%, var(--color-primary-800) 100%); padding: calc(var(--header-height) + var(--spacing-16)) 0 var(--spacing-16);">
    <div class="container" style="text-align: center;">
        <h1 style="font-size: var(--font-size-4xl); font-weight: 800; color: white; margin-bottom: var(--spacing-4);">Catalog Produk</h1>
        <p style="font-size: var(--font-size-lg); color: rgba(255,255,255,0.9); max-width: 600px; margin: 0 auto;">
            Temukan berbagai bibit tanaman berkualitas untuk kebutuhan berkebun Anda
        </p>
    </div>
</section>

<!-- Filters & Products -->
<section class="section-lg">
    <div class="container">
        <!-- Filters -->
        <div style="background: white; border-radius: var(--radius-xl); padding: var(--spacing-5); margin-bottom: var(--spacing-8); box-shadow: var(--shadow-sm);">
            <form action="{{ route('catalog') }}" method="GET" style="display: flex; gap: var(--spacing-4); flex-wrap: wrap; align-items: flex-end;">
                <div style="flex: 1; min-width: 200px;">
                    <label class="form-label">Cari Produk</label>
                    <input type="text" name="search" class="form-input" placeholder="Ketik nama produk..." value="{{ request('search') }}">
                </div>
                <div style="min-width: 180px;">
                    <label class="form-label">Kategori</label>
                    <select name="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div style="min-width: 150px;">
                    <label class="form-label">Urutkan</label>
                    <select name="sort" class="form-select">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i data-feather="search" style="width: 18px; height: 18px;"></i>
                    Filter
                </button>
                @if(request()->hasAny(['search', 'category', 'sort']))
                    <a href="{{ route('catalog') }}" class="btn btn-secondary">Reset</a>
                @endif
            </form>
        </div>

        <!-- Results Count -->
        <div style="margin-bottom: var(--spacing-6);">
            <p style="color: var(--color-gray-600);">
                Menampilkan <strong>{{ $products->count() }}</strong> dari <strong>{{ $products->total() }}</strong> produk
                @if(request('category'))
                    @php $selectedCategory = $categories->find(request('category')); @endphp
                    @if($selectedCategory)
                        dalam kategori <strong>{{ $selectedCategory->name }}</strong>
                    @endif
                @endif
            </p>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        <div class="product-card-image">
                            @if($product->primary_image)
                                <img src="{{ asset('storage/' . $product->primary_image->image_path) }}" alt="{{ $product->name }}">
                            @else
                                <div style="width: 100%; height: 100%; background: var(--color-gray-100); display: flex; align-items: center; justify-content: center;">
                                    <i data-feather="image" style="width: 48px; height: 48px; color: var(--color-gray-300);"></i>
                                </div>
                            @endif
                            @if($product->has_discount)
                                <span class="product-badge">-{{ $product->discount_percentage }}%</span>
                            @endif
                        </div>
                        <div class="product-card-body">
                            <span class="product-category">{{ $product->category->name ?? 'Uncategorized' }}</span>
                            <h3 class="product-title">
                                <a href="{{ route('catalog.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            <div class="product-price">
                                @if($product->has_discount)
                                    <span class="product-price-current">{{ $product->formatted_discount_price }}</span>
                                    <span class="product-price-original">{{ $product->formatted_price }}</span>
                                @else
                                    <span class="product-price-current">{{ $product->formatted_price }}</span>
                                @endif
                            </div>
                            <div class="product-card-footer">
                                <a href="{{ route('catalog.show', $product->slug) }}" class="btn btn-secondary">
                                    <i data-feather="eye" style="width: 16px; height: 16px;"></i>
                                    Detail
                                </a>
                                <a href="{{ $product->shopee_link }}" target="_blank" class="btn btn-shopee">
                                    <i data-feather="shopping-bag" style="width: 16px; height: 16px;"></i>
                                    Beli
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div style="margin-top: var(--spacing-10); display: flex; justify-content: center;">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <div style="text-align: center; padding: var(--spacing-16) 0;">
                <div style="font-size: 64px; margin-bottom: var(--spacing-4);">🔍</div>
                <h3 style="font-size: var(--font-size-xl); font-weight: 600; color: var(--color-gray-800); margin-bottom: var(--spacing-2);">Produk Tidak Ditemukan</h3>
                <p style="color: var(--color-gray-500); margin-bottom: var(--spacing-6);">Coba ubah filter atau kata kunci pencarian</p>
                <a href="{{ route('catalog') }}" class="btn btn-primary">Lihat Semua Produk</a>
            </div>
        @endif
    </div>
</section>
@endsection
