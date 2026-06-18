<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'E-Commerce') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="w-100" style="max-width: 420px; padding: 1rem;">
        <div class="text-center mb-4">
            <a href="{{ route('home') }}" class="text-white text-decoration-none">
                <i class="bi bi-shop fs-1"></i>
                <div class="fw-bold fs-4 mt-1">{{ config('app.name') }}</div>
            </a>
        </div>
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body p-4">
                {{ $slot }}
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
