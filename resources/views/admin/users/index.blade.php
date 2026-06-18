@extends('layouts.admin')
@section('title', 'Manajemen Pelanggan')

@section('content')
<h4 class="fw-bold mb-4"><i class="bi bi-people me-2"></i>Daftar Pelanggan</h4>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Bergabung</th>
                    <th>Status Email</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $users->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            @if($user->email_verified_at)
                                <span class="badge bg-success"><i class="bi bi-check me-1"></i>Terverifikasi</span>
                            @else
                                <span class="badge bg-warning text-dark"><i class="bi bi-clock me-1"></i>Belum Verifikasi</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada pelanggan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3 d-flex justify-content-center">
    {{ $users->links() }}
</div>
@endsection
