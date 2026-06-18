@extends('layouts.admin')
@section('title', 'Detail Pesanan')

@section('content')
@php
    $statusColors = ['pending'=>'warning text-dark','paid'=>'info text-dark','shipped'=>'primary','done'=>'success','cancelled'=>'danger'];
    $statusLabels = ['pending'=>'Menunggu Pembayaran','paid'=>'Sudah Dibayar','shipped'=>'Dikirim','done'=>'Selesai','cancelled'=>'Dibatalkan'];
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-receipt me-2"></i>
        Pesanan #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
    </h4>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white fw-bold border-0 pt-3">Item Pesanan</div>
            <div class="card-body p-0">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
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

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white fw-bold border-0 pt-3">Info Pelanggan</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-5 text-muted">Nama</dt>
                    <dd class="col-7">{{ $order->user->name }}</dd>
                    <dt class="col-5 text-muted">Email</dt>
                    <dd class="col-7">{{ $order->user->email }}</dd>
                    <dt class="col-5 text-muted">Telepon</dt>
                    <dd class="col-7">{{ $order->phone }}</dd>
                    <dt class="col-5 text-muted">Alamat</dt>
                    <dd class="col-7">{{ $order->shipping_address }}</dd>
                </dl>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold border-0 pt-3">Update Status</div>
            <div class="card-body">
                <div class="mb-3">
                    <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }} fs-6">
                        {{ $statusLabels[$order->status] ?? $order->status }}
                    </span>
                </div>
                <form method="POST" action="{{ route('admin.orders.update', $order->id) }}">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Ubah Status</label>
                        <select name="status" class="form-select">
                            <option value="pending"   {{ $order->status === 'pending'   ? 'selected' : '' }}>Menunggu Pembayaran</option>
                            <option value="paid"      {{ $order->status === 'paid'      ? 'selected' : '' }}>Sudah Dibayar</option>
                            <option value="shipped"   {{ $order->status === 'shipped'   ? 'selected' : '' }}>Dikirim</option>
                            <option value="done"      {{ $order->status === 'done'      ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-arrow-clockwise me-1"></i>Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
