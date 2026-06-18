@extends('layouts.admin')
@section('title', 'Manajemen Produk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-box-seam me-2"></i>Manajemen Produk</h4>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah Produk
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            <img src="{{ $product->image_url }}"
                                 width="50" height="50" class="rounded object-fit-cover" alt="">
                        </td>
                        <td class="fw-semibold">{{ $product->name }}</td>
                        <td><span class="badge bg-secondary">{{ $product->category->name }}</span></td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Hapus produk ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3 d-flex justify-content-center">
    {{ $products->links() }}
</div>
@endsection
