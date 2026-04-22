<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panadería Grace</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root{
            --grace-brown: #845534;
            --grace-brown-dark: #6f4529;
            --grace-brown-soft: #a97957;
            --grace-cream: #f4efe9;
            --grace-cream-2: #ead9ca;
            --grace-cream-3: #d7bca8;
            --grace-card: #fbf8f5;
            --grace-text: #4b2f20;
            --grace-muted: #8a6a56;
            --grace-border: #eaded5;
            --grace-accent: #c98655;
            --grace-shadow: 0 12px 28px rgba(93, 58, 34, 0.10);
            --grace-shadow-soft: 0 8px 18px rgba(93, 58, 34, 0.08);
            --grace-radius-xl: 26px;
            --grace-radius-lg: 20px;
            --grace-radius-md: 14px;
            --grace-header-height: 92px;
        }

        *{ box-sizing: border-box; }

        html, body{ min-height: 100%; }

        body{
            margin: 0;
            font-family: 'Nunito', sans-serif;
            color: var(--grace-text);
            background: #f3f3f3;
        }

        a{ text-decoration: none; }

        .grace-page-shell{
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .grace-main-wrap{ flex: 1; }

        .grace-container{
            width: min(1280px, calc(100% - 24px));
            margin: 0 auto;
        }

        /* =========================
           LOADING SCREEN
        ========================== */
        .grace-loader-overlay{
            position: fixed;
            inset: 0;
            z-index: 2000;
            background: #ededed;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
            visibility: visible;
            transition: opacity .28s ease, visibility .28s ease;
        }

        .grace-loader-overlay.hidden{
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .grace-loader-box{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 14px;
            text-align: center;
        }

        .grace-loader-logo{
            width: 84px;
            height: 84px;
            object-fit: contain;
        }

        .grace-loader-brand{
            font-family: 'Baloo 2', cursive;
            font-size: 1.35rem;
            line-height: 1;
            font-weight: 800;
            color: var(--grace-brown);
            margin-top: -4px;
        }

        .grace-loader-bar{
            width: 94px;
            height: 10px;
            border-radius: 999px;
            background: #f7efe8;
            overflow: hidden;
            border: 1px solid #e6d4c7;
        }

        .grace-loader-progress{
            width: 68%;
            height: 100%;
            border-radius: inherit;
            background: #c98655;
            animation: graceLoadingPulse 1.2s ease-in-out infinite alternate;
        }

        @keyframes graceLoadingPulse{
            from{ width: 38%; }
            to{ width: 82%; }
        }

        /* =========================
           HEADER
        ========================== */
        .grace-navbar-wrap{
            background: var(--grace-brown);
            min-height: var(--grace-header-height);
            display: flex;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0,0,0,.06);
        }

        .grace-navbar{
            min-height: var(--grace-header-height);
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 10px 0;
        }

        .grace-brand{
            display: inline-flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
            flex-shrink: 0;
        }

        .grace-brand-mark{
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: #f4e9d5;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 0 0 2px rgba(255,255,255,.08);
        }

        .grace-brand-mark img{
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .grace-brand-text{
            font-family: 'Baloo 2', cursive;
            color: #fff7ef;
            font-size: clamp(1.35rem, 2vw, 2rem);
            font-weight: 800;
            line-height: 1;
            white-space: nowrap;
        }

        .grace-navbar-spacer{
            flex: 1;
        }

        .grace-navbar-actions{
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .grace-nav-icon-btn{
            width: 42px;
            height: 42px;
            border: 0;
            background: transparent;
            color: #fff5eb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            position: relative;
            transition: background .18s ease, transform .18s ease;
        }

        .grace-nav-icon-btn:hover,
        .grace-nav-icon-btn.active{
            background: rgba(255,255,255,.08);
            transform: translateY(-1px);
        }

        .grace-nav-icon-btn svg{
            width: 22px;
            height: 22px;
            display: block;
        }

        .grace-cart-badge{
            position: absolute;
            top: 4px;
            right: 3px;
            min-width: 17px;
            height: 17px;
            border-radius: 999px;
            background: #fff3dd;
            color: var(--grace-brown);
            font-size: .70rem;
            font-weight: 900;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
        }

        .grace-search-wrap{
            position: relative;
            width: min(230px, 100%);
            flex-shrink: 0;
        }

        .grace-search-icon{
            position: absolute;
            top: 50%;
            left: 13px;
            transform: translateY(-50%);
            color: #fff0e6;
            font-size: .9rem;
            pointer-events: none;
        }

        .grace-search-input{
            width: 100%;
            height: 38px;
            border: 0;
            outline: none;
            border-radius: 10px;
            background: rgba(240, 204, 180, 0.32);
            color: #fff7f1;
            padding: 0 14px 0 34px;
            font-size: .82rem;
            font-weight: 700;
        }

        .grace-search-input::placeholder{
            color: rgba(255,247,241,.92);
        }

        .grace-mobile-extra{ display:none; }

        .alert{
            border: 0;
            border-radius: 14px;
            box-shadow: var(--grace-shadow-soft);
            font-weight: 800;
        }

        .alert-success{ background: #edf8ea; color: #275025; }
        .alert-danger{ background: #fde9e6; color: #822c23; }

        .grace-main{ padding: 26px 0 36px; }

        .grace-footer{
            text-align: center;
            padding: 24px 12px 30px;
            color: var(--grace-muted);
            font-weight: 800;
        }

        .grace-heading-font{ font-family: 'Baloo 2', cursive; }

        .btn-primary{
            background: var(--grace-accent);
            border-color: var(--grace-accent);
            border-radius: 14px;
            font-weight: 800;
        }

        .btn-primary:hover,
        .btn-primary:focus{
            background: #b87346;
            border-color: #b87346;
        }

        @media (max-width: 991.98px){
            .grace-navbar{
                flex-wrap: wrap;
                gap: 12px;
                padding: 12px 0 14px;
            }

            .grace-navbar-spacer{ display:none; }

            .grace-navbar-actions{
                margin-left: auto;
            }

            .grace-search-wrap{
                width: 100%;
                order: 4;
            }

            .grace-mobile-extra{
                display:block;
                width: 100%;
                background: #fff;
                border: 1px solid var(--grace-border);
                border-radius: 16px;
                padding: 10px 12px;
                box-shadow: var(--grace-shadow-soft);
            }

            .grace-mobile-extra .nav-link{
                color: var(--grace-text);
                font-weight: 800;
                border-radius: 10px;
                padding: 8px 10px;
            }

            .grace-mobile-extra .nav-link.active{
                background: #f3e8df;
                color: var(--grace-brown);
            }
        }

        @media (max-width: 575.98px){
            .grace-brand-text{ font-size: 1.25rem; }
            .grace-brand-mark{ width: 42px; height: 42px; }
        }
    </style>

    @stack('styles')
</head>
<body>
<div class="grace-page-shell">

    @php
        $logoPublicPath = public_path('storage/products/Recurso 4.png');
        $logoAsset = file_exists($logoPublicPath)
            ? asset('storage/products/Recurso 4.png')
            : null;
    @endphp

    <div id="gracePageLoader" class="grace-loader-overlay">
        <div class="grace-loader-box">
            @if($logoAsset)
                <img src="{{ $logoAsset }}" alt="Panadería Grace" class="grace-loader-logo">
            @else
                <div class="grace-loader-brand">PG</div>
            @endif
            <div class="grace-loader-brand">Panadería Grace</div>
            <div class="grace-loader-bar">
                <div class="grace-loader-progress"></div>
            </div>
        </div>
    </div>

    <header class="grace-navbar-wrap">
        <div class="grace-container">
            <div class="grace-navbar">

                <a href="{{ auth()->check() ? route('dashboard') : route('home') }}" class="grace-brand" aria-label="Panadería Grace">
                    <span class="grace-brand-mark">
                        @if($logoAsset)
                            <img src="{{ $logoAsset }}" alt="Grace">
                        @else
                            <span class="fw-bold">G</span>
                        @endif
                    </span>
                    <span class="grace-brand-text">Panadería Grace</span>
                </a>

                <div class="grace-navbar-spacer"></div>

                <div class="grace-navbar-actions">
                    <a href="{{ auth()->check() ? route('dashboard') : route('home') }}"
                       class="grace-nav-icon-btn {{ request()->routeIs('home') || request()->routeIs('dashboard') ? 'active' : '' }}"
                       title="Inicio"
                       aria-label="Inicio">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M12 3.4 3.6 10a1 1 0 0 0 .62 1.8h1.03v7.08A2.12 2.12 0 0 0 7.37 21h3.22v-5.03c0-.47.38-.85.85-.85h1.12c.47 0 .85.38.85.85V21h3.22a2.12 2.12 0 0 0 2.12-2.12V11.8h1.03A1 1 0 0 0 20.4 10L12 3.4Z"/>
                        </svg>
                    </a>

                    <a href="{{ route('cart') }}"
                       class="grace-nav-icon-btn {{ request()->routeIs('cart') ? 'active' : '' }}"
                       title="Bandeja"
                       aria-label="Bandeja">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M4.62 14.82c2.08-3.68 5.1-7.02 8.58-9.8.9-.72 2.16-.82 3.18-.24 1 .57 1.55 1.67 1.38 2.8-.62 4.13-2.2 8.04-4.66 11.43-.72.99-1.97 1.43-3.16 1.12-2.23-.58-4.08-2.1-5.18-4.24a2.87 2.87 0 0 1-.14-2.07Zm9.8-7.42C11.6 9.76 9.14 12.5 7.34 15.55c.7 1.1 1.77 1.9 3 2.26 1.95-2.9 3.23-6.16 3.78-9.57l.3-.84Z"/>
                            <path d="M14.64 17.66a1.1 1.1 0 1 1 2.2 0 1.1 1.1 0 0 1-2.2 0Z"/>
                        </svg>
                        @php $cartCount = count(session()->get('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="grace-cart-badge">{{ $cartCount }}</span>
                        @endif
                    </a>
                </div>

                <div class="grace-search-wrap">
                    <i class="bi bi-search grace-search-icon"></i>
                    <input
                        type="search"
                        id="globalProductSearch"
                        class="grace-search-input"
                        placeholder="Buscar pan..."
                        autocomplete="off"
                    >
                </div>

                <div class="grace-mobile-extra">
                    <div class="d-flex flex-wrap gap-2">
                        @auth
                            <a class="nav-link {{ request()->routeIs('history') ? 'active' : '' }}" href="{{ route('history') }}">
                                <i class="bi bi-clock-history me-1"></i> Historial
                            </a>
                            <a class="nav-link {{ request()->routeIs('wallet') ? 'active' : '' }}" href="{{ route('wallet') }}">
                                <i class="bi bi-wallet2 me-1"></i> Cartera
                            </a>
                            <a class="nav-link {{ request()->routeIs('admin') || request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin') }}">
                                <i class="bi bi-gear me-1"></i> Administración
                            </a>
                            <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">
                                <i class="bi bi-person-circle me-1"></i> Cuenta
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="ms-auto">
                                @csrf
                                <button class="btn btn-sm btn-outline-dark" type="submit">
                                    <i class="bi bi-box-arrow-right me-1"></i> Salir
                                </button>
                            </form>
                        @else
                            <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                                <i class="bi bi-person me-1"></i> Login
                            </a>
                        @endauth
                    </div>
                </div>

            </div>
        </div>
    </header>

    <div class="grace-main-wrap">
        <div class="grace-container pt-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show py-2 mb-3">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show py-2 mb-3">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        <main class="grace-main">
            <div class="grace-container">
                @yield('content')
            </div>
        </main>
    </div>

    <footer class="grace-footer">
        &copy; {{ date('Y') }} Panadería Grace
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function () {
        const loader = document.getElementById('gracePageLoader');

        function hideLoader() {
            if (!loader) return;
            loader.classList.add('hidden');
            setTimeout(() => loader.remove(), 350);
        }

        window.addEventListener('load', hideLoader);

        document.addEventListener('click', function (event) {
            const trigger = event.target.closest('[data-show-loader], a[href], button[type="submit"]');
            if (!trigger) return;

            if (trigger.matches('[data-bs-toggle="modal"]') || trigger.closest('.modal')) {
                return;
            }

            const href = trigger.getAttribute('href');
            const target = trigger.getAttribute('target');
            const isSubmit = trigger.matches('button[type="submit"]');

            if (target === '_blank') return;
            if (href && (href.startsWith('#') || href.startsWith('javascript:'))) return;

            if (isSubmit || href) {
                loader?.classList.remove('hidden');
            }
        });

        window.GraceLoader = {
            show() { loader?.classList.remove('hidden'); },
            hide() { loader?.classList.add('hidden'); }
        };
    })();
</script>
@stack('scripts')
</body>
</html>