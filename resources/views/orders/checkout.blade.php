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

                {{-- Kode Promo --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold small">Kode Promo</label>
                    <div class="input-group">
                        <input type="text" id="promo_input" class="form-control text-uppercase"
                               placeholder="Masukkan kode promo">
                        <button type="button" class="btn btn-outline-secondary" id="btn-apply-promo">Terapkan</button>
                    </div>
                    <div id="promo-msg" class="form-text mt-1"></div>
                    <input type="hidden" name="promo_code" id="promo_code_hidden">
                </div>

                <div class="d-flex justify-content-between text-muted mb-1">
                    <span>Subtotal</span>
                    <span id="subtotal-label">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between text-success mb-1" id="discount-row" style="display:none!important">
                    <span>Diskon</span>
                    <span id="discount-label">-</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>Total</span>
                    <span class="text-primary" id="total-label">Rp {{ number_format($total, 0, ',', '.') }}</span>
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

@push('scripts')
<script>
document.getElementById('btn-apply-promo').addEventListener('click', function () {
    const code = document.getElementById('promo_input').value.trim();
    const msg  = document.getElementById('promo-msg');
    if (!code) return;

    fetch('{{ route('promo.apply') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ code })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('promo_code_hidden').value = data.code;
            document.getElementById('discount-row').style.display = 'flex';
            document.getElementById('discount-label').textContent = '- ' + data.discount_label;
            document.getElementById('total-label').textContent = data.total_label;
            msg.className = 'form-text text-success mt-1';
            msg.textContent = data.message;
        } else {
            msg.className = 'form-text text-danger mt-1';
            msg.textContent = data.error;
        }
    })
    .catch(() => {
        msg.className = 'form-text text-danger mt-1';
        msg.textContent = 'Kode promo tidak valid.';
    });
});
</script>
@endpush
@endsection
