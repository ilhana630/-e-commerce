@extends('layouts.admin')
@section('title', 'Manajemen Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-tag me-2"></i>Manajemen Kategori</h4>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah Kategori
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Jumlah Produk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $category->name }}</td>
                        <td><code>{{ $category->slug }}</code></td>
                        <td><span class="badge bg-primary rounded-pill">{{ $category->products_count }}</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Hapus kategori ini? Semua produk terkait akan terhapus!')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
