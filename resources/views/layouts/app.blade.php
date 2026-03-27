<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panadería Grace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #fdf9f3; }
        .navbar-brand { font-weight: 700; letter-spacing: 1px; }
        .navbar { background: #5c3d1e !important; }
        .navbar .nav-link, .navbar-brand { color: #fff !important; }
        .navbar .nav-link:hover { color: #ffd966 !important; }
        .navbar .nav-link.active { color: #ffd966 !important; font-weight: 600; }
        .btn-primary { background: #5c3d1e; border-color: #5c3d1e; }
        .btn-primary:hover { background: #3e2810; border-color: #3e2810; }
        .card { border: none; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
        .badge-cart {
            position: absolute;
            top: 4px;
            right: -6px;
            font-size: .65rem;
            background: #ffd966;
            color: #333;
            border-radius: 50%;
            padding: 2px 5px;
        }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand">
            <i class="bi bi-basket2-fill"></i> Panadería Grace
        </a>
        <button class="navbar-toggler border-light" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">

                @auth
                    {{-- Logged-in navbar --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                           href="{{ route('dashboard') }}">
                            <i class="bi bi-house-door"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('history') ? 'active' : '' }}"
                           href="{{ route('history') }}">
                            <i class="bi bi-clock-history"></i> Historial
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('wallet') ? 'active' : '' }}"
                           href="{{ route('wallet') }}">
                            <i class="bi bi-wallet2"></i> Cartera
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin') || request()->routeIs('admin.*') ? 'active' : '' }}"
                           href="{{ route('admin') }}">
                            <i class="bi bi-gear"></i> Administración
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}"
                           href="{{ route('profile') }}">
                            <i class="bi bi-person-circle"></i> Cuenta
                        </a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button class="btn btn-sm btn-outline-light ms-2" type="submit">
                                <i class="bi bi-box-arrow-right"></i> Salir
                            </button>
                        </form>
                    </li>
                @else
                    {{-- Guest navbar --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                           href="{{ route('home') }}">
                            <i class="bi bi-house-door"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item position-relative">
                        <a class="nav-link {{ request()->routeIs('cart') ? 'active' : '' }}"
                           href="{{ route('cart') }}">
                            <i class="bi bi-cart3"></i> Carrito
                            @php $cartCount = count(session()->get('cart', [])); @endphp
                            @if($cartCount > 0)
                                <span class="badge-cart">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}"
                           href="{{ route('login') }}">
                            <i class="bi bi-person"></i> Login
                        </a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>

{{-- FLASH MESSAGES --}}
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show py-2">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

{{-- CONTENT --}}
<main class="container py-4">
    @yield('content')
</main>

<footer class="text-center text-muted py-4 small">
    &copy; {{ date('Y') }} Panadería Grace
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
