@extends('layouts.app')
@section('title', $product->name)

@section('content')
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('home', ['category' => $product->category_id]) }}">{{ $product->category->name }}</a></li>
        <li class="breadcrumb-item active">{{ $product->name }}</li>
    </ol>
</nav>

<div class="row g-4">
    <div class="col-md-5">
        <img src="{{ $product->image_url }}"
             class="img-fluid rounded shadow" alt="{{ $product->name }}">
    </div>

    <div class="col-md-7">
        <span class="badge bg-secondary mb-2">{{ $product->category->name }}</span>
        <h2 class="fw-bold">{{ $product->name }}</h2>
        <h3 class="text-primary fw-bold mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>

        <p class="text-muted">{{ $product->description ?: 'Tidak ada deskripsi.' }}</p>

        <div class="mb-3">
            @if($product->stock > 0)
                <span class="badge bg-success fs-6"><i class="bi bi-check-circle me-1"></i>Tersedia ({{ $product->stock }} stok)</span>
            @else
                <span class="badge bg-danger fs-6"><i class="bi bi-x-circle me-1"></i>Stok Habis</span>
            @endif
        </div>

        @auth
            @if($product->stock > 0)
                <form method="POST" action="{{ route('cart.add', $product->id) }}" class="d-flex gap-2 align-items-center">
                    @csrf
                    <div style="width:100px;">
                        <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-cart-plus me-1"></i>Tambah ke Keranjang
                    </button>
                </form>
            @else
                <button class="btn btn-secondary" disabled>Stok Habis</button>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn btn-primary">
                <i class="bi bi-cart-plus me-1"></i>Masuk untuk Membeli
            </a>
        @endauth
    </div>
</div>
@endsection
