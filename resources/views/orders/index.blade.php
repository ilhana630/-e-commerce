@extends('layouts.app')
@section('title', 'Pesanan Saya')

@section('content')
<h4 class="fw-bold mb-4"><i class="bi bi-bag-check me-2"></i>Pesanan Saya</h4>

@if($orders->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-bag-x display-3 text-muted"></i>
        <p class="mt-3 text-muted fs-5">Belum ada pesanan.</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Mulai Belanja</a>
    </div>
@else
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#Order</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
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
                        <tr>
                            <td><span class="fw-mono text-muted">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></td>
                            <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td class="fw-semibold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td><span class="badge bg-{{ $s['color'] }}">{{ $s['label'] }}</span></td>
                            <td>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3 d-flex justify-content-center">
        {{ $orders->links() }}
    </div>
@endif
@endsection
