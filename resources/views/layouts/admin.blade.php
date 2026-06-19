<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Dashboard') | {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; }
        .sidebar { min-height: calc(100vh - 56px); background: #1e3a5f; }
        .sidebar .nav-link { color: rgba(255,255,255,.75); border-radius: 8px; margin: 2px 8px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background-color: rgba(255,255,255,.15); }
        .sidebar .nav-link i { width: 20px; }
        .sidebar-header { color: rgba(255,255,255,.5); font-size: .75rem; font-weight: 700; text-transform: uppercase; padding: 12px 16px 4px; }
        .stat-card { border-left: 4px solid; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-primary shadow-sm px-3" style="height:56px;">
        <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i> Admin Panel
        </a>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('home') }}" class="text-white text-decoration-none small">
                <i class="bi bi-arrow-left"></i> Ke Toko
            </a>
            <span class="text-white-50">|</span>
            <form method="POST" action="{{ route('logout') }}" class="mb-0">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-light">
                    <i class="bi bi-box-arrow-right"></i> Keluar
                </button>
            </form>
        </div>
    </nav>

    <div class="d-flex">
        <div class="sidebar d-flex flex-column py-3" style="width:240px; min-width:240px;">
            <div class="sidebar-header">Menu</div>
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-grid me-2"></i> Dashboard
                </a>
            </nav>
            <div class="sidebar-header mt-3">Manajemen</div>
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                    <i class="bi bi-box-seam me-2"></i> Produk
                </a>
                <a class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                    <i class="bi bi-tag me-2"></i> Kategori
                </a>
                <a class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                    <i class="bi bi-receipt me-2"></i> Pesanan
                </a>
                <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people me-2"></i> Pelanggan
                </a>
                <a class="nav-link {{ request()->routeIs('admin.promos*') ? 'active' : '' }}" href="{{ route('admin.promos.index') }}">
                    <i class="bi bi-ticket-perforated me-2"></i> Kode Promo
                </a>
            </nav>
        </div>

        <div class="flex-grow-1 p-4" style="overflow-x:auto;">
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
