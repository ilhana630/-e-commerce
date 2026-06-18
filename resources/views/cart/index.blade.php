@extends('layouts.app')
@section('title', 'Keranjang Belanja')

@section('content')
<h4 class="fw-bold mb-4"><i class="bi bi-cart3 me-2"></i>Keranjang Belanja</h4>

@if($cartItems->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-cart-x display-3 text-muted"></i>
        <p class="mt-3 text-muted fs-5">Keranjang belanja Anda kosong.</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Mulai Belanja</a>
    </div>
@else
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th style="width:130px;">Jumlah</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ $item->product->image_url }}"
                                                 width="60" height="60" class="rounded object-fit-cover" alt="">
                                            <div>
                                                <a href="{{ route('products.show', $item->product->slug) }}"
                                                   class="text-decoration-none fw-semibold text-dark">
                                                    {{ $item->product->name }}
                                                </a>
                                                <div class="small text-muted">{{ $item->product->category->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($item->product->price, 0, ',', '.') }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('cart.update', $item->id) }}" class="d-flex gap-1">
                                            @csrf @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                   min="1" max="{{ $item->product->stock }}"
                                                   class="form-control form-control-sm" style="width:70px;">
                                            <button type="submit" class="btn btn-sm btn-outline-secondary">
                                                <i class="bi bi-check"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="fw-semibold">
                                        Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('cart.destroy', $item->id) }}">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Hapus item ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold border-0 pt-3">Ringkasan Pesanan</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal ({{ $cartItems->count() }} item)</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span class="text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-grid mt-3">
                        <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-credit-card me-1"></i>Checkout
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary mt-2">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
