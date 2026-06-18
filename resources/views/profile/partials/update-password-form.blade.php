<form method="post" action="{{ route('password.update') }}">
    @csrf @method('put')

    @if(session('status') === 'password-updated')
        <div class="alert alert-success alert-sm">Password berhasil diperbarui.</div>
    @endif

    <div class="mb-3">
        <label for="current_password" class="form-label fw-semibold">Password Saat Ini</label>
        <input id="current_password" name="current_password" type="password"
               class="form-control @if($errors->updatePassword->get('current_password')) is-invalid @endif"
               autocomplete="current-password">
        @if($errors->updatePassword->get('current_password'))
            <div class="invalid-feedback">{{ $errors->updatePassword->first('current_password') }}</div>
        @endif
    </div>

    <div class="mb-3">
        <label for="password" class="form-label fw-semibold">Password Baru</label>
        <input id="password" name="password" type="password"
               class="form-control @if($errors->updatePassword->get('password')) is-invalid @endif"
               autocomplete="new-password">
        @if($errors->updatePassword->get('password'))
            <div class="invalid-feedback">{{ $errors->updatePassword->first('password') }}</div>
        @endif
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
        <input id="password_confirmation" name="password_confirmation" type="password"
               class="form-control" autocomplete="new-password">
    </div>

    <button type="submit" class="btn btn-primary">Simpan Password</button>
</form>
