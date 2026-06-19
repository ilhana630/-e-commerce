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
        <h3 class="text-primary fw-bold mb-1">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>

        {{-- Rating ringkasan --}}
        @if($product->reviews->count() > 0)
        <div class="mb-3 d-flex align-items-center gap-2">
            @php $avg = $product->average_rating; @endphp
            <div class="text-warning">
                @for($i = 1; $i <= 5; $i++)
                    <i class="bi bi-star{{ $i <= round($avg) ? '-fill' : ($i - 0.5 <= $avg ? '-half' : '') }}"></i>
                @endfor
            </div>
            <span class="fw-semibold">{{ $avg }}</span>
            <span class="text-muted">({{ $product->reviews->count() }} ulasan)</span>
        </div>
        @endif

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

{{-- SECTION REVIEW --}}
<hr class="my-5">
<h4 class="fw-bold mb-4"><i class="bi bi-chat-square-text me-2"></i>Ulasan Produk</h4>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@auth
{{-- Form tulis / edit review --}}
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <h6 class="card-title fw-semibold">{{ $userReview ? 'Edit Ulasan Anda' : 'Tulis Ulasan' }}</h6>
        <form method="POST" action="{{ route('reviews.store', $product->slug) }}">
            @csrf
            {{-- Rating bintang interaktif --}}
            <div class="mb-3">
                <label class="form-label">Rating</label>
                <div class="star-rating d-flex gap-1 fs-4" style="cursor:pointer;">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star{{ $userReview && $userReview->rating >= $i ? '-fill' : '' }} star-icon text-warning"
                           data-value="{{ $i }}"></i>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating-input" value="{{ $userReview->rating ?? '' }}" required>
                @error('rating')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Komentar (opsional)</label>
                <textarea name="comment" class="form-control @error('comment') is-invalid @enderror"
                          rows="3" maxlength="1000" placeholder="Ceritakan pengalaman kamu...">{{ old('comment', $userReview->comment ?? '') }}</textarea>
                @error('comment')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="bi bi-send me-1"></i>{{ $userReview ? 'Perbarui' : 'Kirim' }} Ulasan
            </button>
            @if($userReview)
                <form method="POST" action="{{ route('reviews.destroy', $userReview->id) }}" class="d-inline ms-2">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('Hapus ulasan ini?')">
                        <i class="bi bi-trash me-1"></i>Hapus
                    </button>
                </form>
            @endif
        </form>
    </div>
</div>
@else
<p class="text-muted mb-4"><a href="{{ route('login') }}">Masuk</a> untuk menulis ulasan.</p>
@endauth

{{-- Daftar review --}}
@forelse($product->reviews as $review)
<div class="card mb-3 shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <span class="fw-semibold">{{ $review->user->name }}</span>
                <div class="text-warning small">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star{{ $review->rating >= $i ? '-fill' : '' }}"></i>
                    @endfor
                </div>
            </div>
            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
        </div>
        @if($review->comment)
            <p class="mt-2 mb-0 text-muted">{{ $review->comment }}</p>
        @endif
    </div>
</div>
@empty
<p class="text-muted">Belum ada ulasan untuk produk ini.</p>
@endforelse

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const stars = document.querySelectorAll('.star-icon');
    const ratingInput = document.getElementById('rating-input');

    stars.forEach(star => {
        star.addEventListener('mouseover', function () {
            const val = this.dataset.value;
            stars.forEach((s, idx) => {
                s.classList.toggle('bi-star-fill', idx < val);
                s.classList.toggle('bi-star', idx >= val);
            });
        });

        star.addEventListener('click', function () {
            ratingInput.value = this.dataset.value;
        });
    });

    document.querySelector('.star-rating')?.addEventListener('mouseleave', function () {
        const selected = ratingInput.value;
        stars.forEach((s, idx) => {
            s.classList.toggle('bi-star-fill', idx < selected);
            s.classList.toggle('bi-star', idx >= selected);
        });
    });
});
</script>
@endpush
@endsection
