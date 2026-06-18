<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}">
    @csrf @method('patch')

    @if(session('status') === 'profile-updated')
        <div class="alert alert-success alert-sm">Profil berhasil diperbarui.</div>
    @endif

    <div class="mb-3">
        <label for="name" class="form-label fw-semibold">Nama</label>
        <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label fw-semibold">Email</label>
        <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $user->email) }}" required autocomplete="username">
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
</form>
