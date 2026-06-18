@extends('layouts.app')
@section('title', 'Katalog Produk')

@section('content')
<div class="row">
    {{-- Filter sidebar --}}
    <div class="col-lg-3 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white fw-semibold">
                <i class="bi bi-funnel me-1"></i> Filter Produk
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('home') }}">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pencarian</label>
                        <input type="text" name="search" class="form-control"
                               placeholder="Cari produk..." value="{{ request('search') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori</label>
                        <select name="category" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search me-1"></i> Filter
                        </button>
                        @if(request()->hasAny(['search', 'category']))
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Product grid --}}
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 fw-bold">
                Produk
                @if(request('search'))
                    <span class="text-muted fs-6">untuk "{{ request('search') }}"</span>
                @endif
            </h5>
            <small class="text-muted">{{ $products->total() }} produk ditemukan</small>
        </div>

        @if($products->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-inbox display-4 text-muted"></i>
                <p class="mt-3 text-muted">Tidak ada produk ditemukan.</p>
                <a href="{{ route('home') }}" class="btn btn-outline-primary">Lihat Semua Produk</a>
            </div>
        @else
            <div class="row row-cols-2 row-cols-md-3 g-3">
                @foreach($products as $product)
                    <div class="col">
                        <div class="card h-100 product-card shadow-sm border-0">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <img src="{{ $product->image_url }}"
                                     class="card-img-top" style="height:180px; object-fit:cover;" alt="{{ $product->name }}">
                            </a>
                            <div class="card-body d-flex flex-column">
                                <span class="badge bg-secondary mb-1 align-self-start">{{ $product->category->name }}</span>
                                <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark">
                                    <h6 class="card-title fw-semibold mb-1">{{ $product->name }}</h6>
                                </a>
                                <p class="text-primary fw-bold mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <div class="mt-auto">
                                    @if($product->stock > 0)
                                        <small class="text-success"><i class="bi bi-check-circle me-1"></i>Stok: {{ $product->stock }}</small>
                                    @else
                                        <small class="text-danger"><i class="bi bi-x-circle me-1"></i>Habis</small>
                                    @endif
                                    <div class="mt-2">
                                        @auth
                                            <form method="POST" action="{{ route('cart.add', $product->id) }}">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-primary btn-sm w-100"
                                                    {{ $product->stock < 1 ? 'disabled' : '' }}>
                                                    <i class="bi bi-cart-plus me-1"></i>Tambah
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm w-100">
                                                <i class="bi bi-cart-plus me-1"></i>Tambah
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
