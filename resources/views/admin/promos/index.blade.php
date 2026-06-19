@extends('layouts.admin')
@section('title', 'Kode Promo')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Kode Promo</h4>
    <a href="{{ route('admin.promos.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Tambah Promo
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Tipe</th>
                    <th>Nilai</th>
                    <th>Min. Pembelian</th>
                    <th>Penggunaan</th>
                    <th>Kadaluarsa</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($promos as $promo)
                <tr>
                    <td><span class="badge bg-dark fs-6 fw-bold">{{ $promo->code }}</span></td>
                    <td>{{ $promo->type === 'percentage' ? 'Persentase' : 'Nominal' }}</td>
                    <td class="fw-semibold text-success">
                        {{ $promo->type === 'percentage' ? $promo->value . '%' : 'Rp ' . number_format($promo->value, 0, ',', '.') }}
                    </td>
                    <td>Rp {{ number_format($promo->min_purchase, 0, ',', '.') }}</td>
                    <td>{{ $promo->used_count }}{{ $promo->max_uses ? ' / ' . $promo->max_uses : ' / ∞' }}</td>
                    <td>{{ $promo->expires_at ? $promo->expires_at->format('d M Y') : 'Tidak ada' }}</td>
                    <td>
                        @if($promo->isValid())
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.promos.edit', $promo) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form method="POST" action="{{ route('admin.promos.destroy', $promo) }}" class="d-inline"
                              onsubmit="return confirm('Hapus promo ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Belum ada kode promo.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $promos->links() }}</div>
@endsection
