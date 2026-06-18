<x-guest-layout>
    <h4 class="fw-bold mb-4 text-center">Masuk ke Akun</h4>

    @if(session('status'))
        <div class="alert alert-success mb-3">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password</label>
            <input id="password" type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   required autocomplete="current-password">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3 form-check">
            <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
            <label class="form-check-label" for="remember_me">Ingat Saya</label>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-box-arrow-in-right me-1"></i>Masuk
            </button>
        </div>

        <div class="text-center mt-3">
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-muted small me-3">Lupa Password?</a>
            @endif
            <a href="{{ route('register') }}" class="small">Belum punya akun? Daftar</a>
        </div>
    </form>
</x-guest-layout>
