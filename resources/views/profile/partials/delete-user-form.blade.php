<p class="text-muted small mb-3">Setelah akun dihapus, semua data akan dihapus permanen.</p>

<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
    <i class="bi bi-trash me-1"></i>Hapus Akun
</button>

<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Konfirmasi Hapus Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf @method('delete')
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak dapat dibatalkan.</p>
                    <div class="mb-3">
                        <label for="del_password" class="form-label fw-semibold">Password</label>
                        <input id="del_password" name="password" type="password"
                               class="form-control @if($errors->userDeletion->get('password')) is-invalid @endif"
                               placeholder="Masukkan password untuk konfirmasi">
                        @if($errors->userDeletion->get('password'))
                            <div class="invalid-feedback">{{ $errors->userDeletion->first('password') }}</div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus Akun</button>
                </div>
            </form>
        </div>
    </div>
</div>
