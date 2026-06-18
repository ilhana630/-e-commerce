@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
<h4 class="fw-bold mb-4"><i class="bi bi-person me-2"></i>Profil Saya</h4>
<div class="row g-4" style="max-width:700px;">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold border-0 pt-3">Informasi Profil</div>
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold border-0 pt-3">Ubah Password</div>
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card shadow-sm border-0 border-danger">
            <div class="card-header bg-white fw-bold border-0 pt-3 text-danger">Hapus Akun</div>
            <div class="card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
