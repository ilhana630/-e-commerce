<x-guest-layout>
    <h4 class="fw-bold mb-3 text-center">Lupa Password</h4>
    <p class="text-muted small mb-4">Masukkan email Anda dan kami akan mengirim link reset password.</p>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required autofocus>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Kirim Link Reset Password</button>
        </div>
        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="small">Kembali ke Login</a>
        </div>
    </form>
</x-guest-layout>
