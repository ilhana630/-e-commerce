@extends('layouts.app')
@section('title', 'Pembayaran')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">

        <div class="text-center mb-4">
            <h4 class="fw-bold"><i class="bi bi-credit-card me-2"></i>Pembayaran</h4>
            <p class="text-muted">Pesanan #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Total Pembayaran</span>
                    <span class="fw-bold fs-5 text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Alamat Pengiriman</span>
                    <span class="text-end" style="max-width:60%">{{ $order->shipping_address }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted">Nomor Telepon</span>
                    <span>{{ $order->phone }}</span>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button id="pay-button" class="btn btn-primary btn-lg">
                <i class="bi bi-lock me-2"></i>Bayar Sekarang
            </button>
            <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary">
                Bayar Nanti
            </a>
        </div>

        <div class="text-center mt-4">
            <img src="https://payment.midtrans.com/images/logo/new/midtrans-logo.png"
                 alt="Midtrans" height="28" class="opacity-75">
            <p class="text-muted small mt-2">Pembayaran diproses secara aman oleh Midtrans</p>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="{{ $snapUrl }}" data-client-key="{{ $clientKey }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                window.location.href = '{{ route('payment.finish', $order) }}';
            },
            onPending: function (result) {
                window.location.href = '{{ route('orders.show', $order) }}';
            },
            onError: function (result) {
                window.location.href = '{{ route('orders.show', $order) }}';
            },
            onClose: function () {
                // user closed popup without completing payment
            }
        });
    });
</script>
@endpush
