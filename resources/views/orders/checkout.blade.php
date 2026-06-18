@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<h4 class="fw-bold mb-4"><i class="bi bi-credit-card me-2"></i>Checkout</h4>

<form method="POST" action="{{ route('orders.store') }}">
@csrf
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header bg-white fw-bold border-0 pt-3">Informasi Pengiriman</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Alamat Pengiriman <span class="text-danger">*</span></label>
                    <textarea name="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror"
                              rows="3" placeholder="Masukkan alamat lengkap...">{{ old('shipping_address') }}</textarea>
                    @error('shipping_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nomor Telepon <span class="text-danger">*</span></label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                           placeholder="08xx-xxxx-xxxx" value="{{ old('phone') }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold border-0 pt-3">Metode Pembayaran</div>
            <div class="card-body">
                <div class="alert alert-success mb-3">
                    <i class="bi bi-shield-check me-1"></i>
                    Pembayaran aman diproses oleh <strong>Midtrans</strong>. Tersedia Transfer Bank, E-Wallet, QRIS, Kartu Kredit, dan lainnya.
                </div>
                <div class="row g-2 text-center text-muted small">
                    <div class="col-3">
                        <div class="border rounded p-2 bg-light">
                            <i class="bi bi-bank2 fs-4 text-primary"></i>
                            <div class="mt-1">Transfer Bank</div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="border rounded p-2 bg-light">
                            <i class="bi bi-wallet2 fs-4 text-success"></i>
                            <div class="mt-1">E-Wallet</div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="border rounded p-2 bg-light">
                            <i class="bi bi-qr-code fs-4 text-warning"></i>
                            <div class="mt-1">QRIS</div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="border rounded p-2 bg-light">
                            <i class="bi bi-credit-card fs-4 text-danger"></i>
                            <div class="mt-1">Kartu Kredit</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold border-0 pt-3">Ringkasan Pesanan</div>
            <div class="card-body">
                @foreach($cartItems as $item)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <span class="fw-semibold">{{ $item->product->name }}</span>
                            <span class="text-muted small"> x{{ $item->quantity }}</span>
                        </div>
                        <span>Rp {{ number_format($item->quantity * $item->product->price, 0, ',', '.') }}</span>
                    </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span class="text-primary">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-bag-check me-1"></i>Buat Pesanan
                    </button>
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary mt-2">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Keranjang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
@endsection
