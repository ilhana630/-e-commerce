@extends('layouts.app')
@section('title', 'Detail Pesanan')

@section('content')
@php
    $statusLabels = [
        'pending'   => ['label' => 'Menunggu Pembayaran', 'color' => 'warning text-dark'],
        'paid'      => ['label' => 'Sudah Dibayar', 'color' => 'info text-dark'],
        'shipped'   => ['label' => 'Dikirim', 'color' => 'primary'],
        'done'      => ['label' => 'Selesai', 'color' => 'success'],
        'cancelled' => ['label' => 'Dibatalkan', 'color' => 'danger'],
    ];
    $s = $statusLabels[$order->status] ?? ['label' => $order->status, 'color' => 'secondary'];
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-receipt me-2"></i>
        Pesanan #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
    </h4>
    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header bg-white fw-bold border-0 pt-3">Item Pesanan</div>
            <div class="card-body p-0">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th>Harga Satuan</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total</td>
                            <td class="fw-bold text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header bg-white fw-bold border-0 pt-3">Info Pesanan</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-5 text-muted">Status</dt>
                    <dd class="col-7"><span class="badge bg-{{ $s['color'] }}">{{ $s['label'] }}</span></dd>
                    <dt class="col-5 text-muted">Tanggal</dt>
                    <dd class="col-7">{{ $order->created_at->format('d M Y') }}</dd>
                    <dt class="col-5 text-muted">Alamat</dt>
                    <dd class="col-7">{{ $order->shipping_address }}</dd>
                    <dt class="col-5 text-muted">Telepon</dt>
                    <dd class="col-7">{{ $order->phone }}</dd>
                </dl>
            </div>
        </div>

        @if($order->status === 'pending')
            <div class="alert alert-warning">
                <i class="bi bi-clock me-1"></i>
                <strong>Menunggu Pembayaran</strong><br>
                Selesaikan pembayaran Anda sekarang.
            </div>
            <div class="d-grid">
                <a href="{{ route('payment.page', $order) }}" class="btn btn-primary">
                    <i class="bi bi-credit-card me-1"></i>Bayar Sekarang
                </a>
            </div>
        @endif

        @if($order->payment_ref)
            <div class="mt-3 text-muted small">
                <i class="bi bi-hash me-1"></i>Ref: {{ $order->payment_ref }}
            </div>
        @endif
    </div>
</div>
@endsection
