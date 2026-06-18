<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Beranda') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: 700; font-size: 1.4rem; }
        .product-card { transition: transform .2s, box-shadow .2s; }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,.12); }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-shop"></i> {{ config('app.name') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-3">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Produk</a>
                    </li>
                </ul>

                <form class="d-flex me-auto" method="GET" action="{{ route('home') }}" style="max-width:500px; width:100%;">
                    @php $navCategories = \App\Models\Category::all(); @endphp
                    <div class="input-group">
                        <select name="category" class="form-select border-0 flex-shrink-1" style="max-width:150px;">
                            <option value="">Semua</option>
                            @foreach($navCategories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="text" name="search" class="form-control border-0"
                               placeholder="Cari produk..."
                               value="{{ request('search') }}"
                               autocomplete="off">
                        <button class="btn btn-light" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <ul class="navbar-nav align-items-center ms-3">
                    @auth
                        <li class="nav-item me-2">
                            <a class="nav-link" href="{{ route('cart.index') }}">
                                <i class="bi bi-cart3 fs-5"></i>
                                @php $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity'); @endphp
                                @if($cartCount > 0)
                                    <span class="badge bg-warning text-dark">{{ $cartCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="bi bi-bag-check me-1"></i>Pesanan Saya</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-1"></i>Profil</a></li>
                                @if(auth()->user()->isAdmin())
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-primary" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-1"></i>Admin Panel</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item text-danger" type="submit">
                                            <i class="bi bi-box-arrow-right me-1"></i>Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Masuk</a></li>
                        <li class="nav-item ms-2"><a class="btn btn-light btn-sm" href="{{ route('register') }}">Daftar</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle me-1"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </main>

    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
