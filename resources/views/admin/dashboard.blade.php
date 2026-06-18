@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<h4 class="fw-bold mb-4">Dashboard</h4>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm stat-card" style="border-left-color:#0d6efd!important;">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                    <i class="bi bi-people fs-4 text-primary"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold">{{ number_format($totalUsers) }}</div>
                    <div class="text-muted small">Total Pelanggan</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm stat-card" style="border-left-color:#198754!important;">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                    <i class="bi bi-box-seam fs-4 text-success"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold">{{ number_format($totalProducts) }}</div>
                    <div class="text-muted small">Total Produk</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm stat-card" style="border-left-color:#ffc107!important;">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                    <i class="bi bi-receipt fs-4 text-warning"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold">{{ number_format($totalOrders) }}</div>
                    <div class="text-muted small">Total Pesanan</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm stat-card" style="border-left-color:#0dcaf0!important;">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="rounded-circle bg-info bg-opacity-10 p-3">
                    <i class="bi bi-currency-dollar fs-4 text-info"></i>
                </div>
                <div>
                    <div class="fs-2 fw-bold">Rp {{ number_format($totalRevenue / 1000000, 1) }}Jt</div>
                    <div class="text-muted small">Total Pendapatan</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-bold border-0 pt-3">Pesanan Terbaru</div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#Order</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                            @php
                                $colors = ['pending'=>'warning text-dark','paid'=>'info text-dark','shipped'=>'primary','done'=>'success','cancelled'=>'danger'];
                                $labels = ['pending'=>'Pending','paid'=>'Dibayar','shipped'=>'Dikirim','done'=>'Selesai','cancelled'=>'Batal'];
                            @endphp
                            <tr>
                                <td class="text-muted">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td><span class="badge bg-{{ $colors[$order->status] ?? 'secondary' }}">{{ $labels[$order->status] ?? $order->status }}</span></td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td><a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">Detail</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
