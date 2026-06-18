@extends('layouts.admin')
@section('title', 'Edit Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Edit Kategori: {{ $category->name }}</h4>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="card border-0 shadow-sm" style="max-width:500px;">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.categories.update', $category->id) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $category->name) }}" required autofocus>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i>Perbarui
            </button>
        </form>
    </div>
</div>
@endsection
