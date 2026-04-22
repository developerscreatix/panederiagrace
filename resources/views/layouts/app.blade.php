<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panadería Grace</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .grace-brand-mark img{
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        .grace-brand-text{
            font-family: 'Baloo 2', cursive;
            color: #fff7ef;
            font-size: clamp(1.35rem, 2vw, 2rem);
            font-weight: 800;
            line-height: 1;
            white-space: nowrap;
        }

        .grace-navbar-spacer{ flex: 1; }

        .grace-navbar-actions{
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .grace-nav-icon-btn{
            width: 54px;
            height: 54px;
            border: 0;
            background: transparent;
            color: #fff5eb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            position: relative;
            transition: background .18s ease, transform .18s ease;
            flex-shrink: 0;
            padding: 0;
        }

        .grace-nav-icon-btn:hover,
        .grace-nav-icon-btn.active{
            background: rgba(255,255,255,.08);
            transform: translateY(-1px);
        }

        .grace-nav-icon-btn svg,
        .grace-nav-icon-btn i{
            width: 22px;
            height: 22px;
            display: block;
            font-size: 22px;
            line-height: 22px;
        }

        .grace-cart-badge{
            position: absolute;
            top: 6px;
            right: 6px;
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
            width: min(260px, 100%);
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
            height: 46px;
            border: 0;
            outline: none;
            border-radius: 14px;
            background: rgba(240, 204, 180, 0.32);
            color: #fff7f1;
            padding: 0 14px 0 34px;
            font-size: .95rem;
            font-weight: 700;
        }

        .grace-search-input::placeholder{
            color: rgba(255,247,241,.92);
        }

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
                flex-wrap: wrap;
                justify-content: flex-end;
            }

            .grace-search-wrap{
                width: 100%;
                order: 4;
            }
        }

        @media (max-width: 575.98px){
            .grace-brand-text{ font-size: 1.25rem; }
            .grace-brand-mark{ width: 50px; height: 50px; }
            .grace-nav-icon-btn{
                width: 48px;
                height: 48px;
            }
            .grace-search-input{
                height: 42px;
                font-size: .88rem;
            }
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
                        <i class="bi bi-house-fill"></i>
                    </a>

                    <a href="{{ route('cart') }}"
                    class="grace-nav-icon-btn {{ request()->routeIs('cart') ? 'active' : '' }}"
                    title="Bandeja"
                    aria-label="Bandeja">

                    <svg id="Capa_2" data-name="Capa 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 528.46 423.84">
                        <defs>
                            <style>
                            .cls-1 {
                                fill: none;
                                stroke: #ffffff;
                                stroke-miterlimit: 10;
                                stroke-width: 65px;
                            }

                            .cls-2 {
                                fill: #ffffff;
                            }
                            </style>
                        </defs>
                        <g id="Capa_1-2" data-name="Capa 1">
                            <g>
                            <path class="cls-1" d="M159.6,259.12c17.41,13.35,36.16,26.57,56.01,39.39,126.64,81.79,250.06,115.95,275.66,76.3,25.6-39.64-56.31-138.08-182.95-219.87-18.5-11.94-36.92-22.87-54.98-32.7"/>
                            <ellipse class="cls-2" cx="122.42" cy="231.11" rx="55.38" ry="141.23" transform="translate(-138.14 208.56) rotate(-57.15)"/>
                            <ellipse class="cls-2" cx="213.3" cy="89.65" rx="55.38" ry="141.23" transform="translate(22.27 220.19) rotate(-57.15)"/>
                            </g>
                        </g>
                    </svg>

                        @php $cartCount = count(session()->get('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="grace-cart-badge">{{ $cartCount }}</span>
                        @endif
                    </a>

                    @auth
                        <a href="{{ route('history') }}"
                           class="grace-nav-icon-btn {{ request()->routeIs('history') ? 'active' : '' }}"
                           title="Historial"
                           aria-label="Historial">
                            <i class="bi bi-clock-history"></i>
                        </a>

                        <a href="{{ route('wallet') }}"
                           class="grace-nav-icon-btn {{ request()->routeIs('wallet') ? 'active' : '' }}"
                           title="Cartera"
                           aria-label="Cartera">
                            <i class="bi bi-wallet2"></i>
                        </a>

                        @if(Route::has('admin'))
                            <a href="{{ route('admin') }}"
                               class="grace-nav-icon-btn {{ request()->routeIs('admin') || request()->routeIs('admin.*') ? 'active' : '' }}"
                               title="Administración"
                               aria-label="Administración">
                                <i class="bi bi-gear"></i>
                            </a>
                        @endif

                        <a href="{{ route('profile') }}"
                           class="grace-nav-icon-btn {{ request()->routeIs('profile') ? 'active' : '' }}"
                           title="Cuenta"
                           aria-label="Cuenta">
                            <i class="bi bi-person-circle"></i>
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit"
                                    class="grace-nav-icon-btn {{ request()->routeIs('logout') ? 'active' : '' }}"
                                    title="Salir"
                                    aria-label="Salir">
                                <i class="bi bi-box-arrow-right"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                           class="grace-nav-icon-btn {{ request()->routeIs('login') ? 'active' : '' }}"
                           title="Login"
                           aria-label="Login">
                            <i class="bi bi-person"></i>
                        </a>
                    @endauth
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