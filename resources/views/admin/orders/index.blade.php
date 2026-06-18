@extends('layouts.admin')
@section('title', 'Manajemen Pesanan')

@section('content')
<h4 class="fw-bold mb-4"><i class="bi bi-receipt me-2"></i>Manajemen Pesanan</h4>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#Order</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    @php
                        $colors = ['pending'=>'warning text-dark','paid'=>'info text-dark','shipped'=>'primary','done'=>'success','cancelled'=>'danger'];
                        $labels = ['pending'=>'Pending','paid'=>'Dibayar','shipped'=>'Dikirim','done'=>'Selesai','cancelled'=>'Batal'];
                    @endphp
                    <tr>
                        <td class="text-muted">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td>
                            <div class="fw-semibold">{{ $order->user->name }}</div>
                            <div class="text-muted small">{{ $order->user->email }}</div>
                        </td>
                        <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td><span class="badge bg-{{ $colors[$order->status] ?? 'secondary' }}">{{ $labels[$order->status] ?? $order->status }}</span></td>
                        <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye me-1"></i>Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3 d-flex justify-content-center">
    {{ $orders->links() }}
</div>
@endsection
