@extends('layouts.app')

@section('content')
<style>
    .grace-hero-carousel{
        margin-bottom: 16px;
        border-radius: 12px;
        overflow: hidden;
        background: #e8e8e8;
        box-shadow: var(--grace-shadow-soft);
    }

    .grace-hero-carousel .carousel-item{
        background: #ececec;
    }

    .grace-hero-slide{
        width: 100%;
        aspect-ratio: 16 / 4.1;
        min-height: 170px;
        max-height: 335px;
        object-fit: cover;
        display: block;
    }

    .catalog-header{
        margin-bottom: 18px;
    }

    .grace-filters{
        display: flex;
        gap: 10px;
        flex-wrap: nowrap;
        overflow-x: auto;
        padding: 0 6px 4px 6px;
        margin-bottom: 10px;
        scrollbar-width: none;
    }

    .grace-filters::-webkit-scrollbar{ display:none; }

    .grace-filter-btn{
        border: 0;
        background: #e7d8cc;
        color: var(--grace-text);
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 700;
        font-size: .92rem;
        white-space: nowrap;
        transition: .18s ease;
        min-width: 112px;
    }

    .grace-filter-btn:hover{ background: #dcc7b8; }

    .grace-filter-btn.active{
        background: var(--grace-accent);
        color: #fff9f4;
    }

    .grace-section{ margin-bottom: 22px; }

    .grace-products-grid{
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
    }

    .grace-product-col{ min-width: 0; }

    .grace-product-card{
        background: #faf9f7;
        border: 1px solid #ece4dd;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(77, 45, 23, 0.04);
        cursor: pointer;
        height: 100%;
        transition: transform .16s ease, box-shadow .16s ease;
    }

    .grace-product-card:hover{
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(77, 45, 23, 0.08);
    }

    .grace-card-image{
        position: relative;
        padding: 10px;
        background: #faf9f7;
    }

    .grace-card-badge{
        position: absolute;
        top: 16px;
        left: 16px;
        width: 84px;
        max-width: 32%;
        height: auto;
        z-index: 3;
        pointer-events: none;
    }

    .grace-card-image-box{
        width: 100%;
        aspect-ratio: 1 / 0.72;
        background: #efefef;
        border-radius: 6px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .grace-card-image-box img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .grace-card-body{
        padding: 10px 12px 14px;
        position: relative;
    }

    .grace-card-name{
        font-size: .98rem;
        font-weight: 800;
        color: #2e1e15;
        margin: 0 0 2px;
    }

    .grace-card-desc{
        display: none;
    }

    .grace-card-price{
        font-size: .92rem;
        line-height: 1;
        color: var(--grace-accent);
        font-weight: 800;
    }

    .grace-card-price .old{
        color: #998677;
        text-decoration: line-through;
        font-size: .78rem;
        margin-right: 3px;
    }

    .grace-card-icon{
        position: absolute;
        right: 10px;
        bottom: 10px;
        width: 20px;
        height: 20px;
        border-radius: 6px;
        background: var(--grace-accent);
        color: #fffaf6;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .grace-card-icon svg{
        width: 12px;
        height: 12px;
    }

    .grace-empty-results{
        display: none;
        margin-top: 18px;
        border-radius: 14px;
        background: #fff;
        padding: 18px 20px;
        border: 1px solid var(--grace-border);
        box-shadow: var(--grace-shadow-soft);
        font-weight: 800;
        color: var(--grace-muted);
    }

    .grace-empty-results.show{ display:block; }

    /* MODAL estilo de la 3a imagen */
    .grace-modal .modal-dialog{
        max-width: 1120px;
    }

    .grace-modal .modal-content{
        border: 0;
        border-radius: 0;
        overflow: hidden;
        background: #f4f4f4;
        min-height: 78vh;
    }

    .grace-modal .modal-header{
        border: 0;
        padding: 0;
        height: 0;
    }

    .grace-modal .btn-close{
        position: absolute;
        top: 18px;
        right: 18px;
        z-index: 10;
        border-radius: 50%;
        background-color: rgba(255,255,255,.85);
        opacity: 1;
    }

    .grace-modal .modal-body{
        padding: 32px 34px 34px;
    }

    .grace-detail-breadcrumb{
        display: flex;
        align-items: center;
        gap: 8px;
        color: #b77349;
        font-size: .9rem;
        font-weight: 700;
        margin-bottom: 18px;
    }

    .grace-detail-layout{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 46px;
        align-items: start;
    }

    .grace-detail-left{ min-width: 0; }
    .grace-detail-right{ min-width: 0; }

    .grace-detail-image-box{
        width: 100%;
        max-width: 430px;
        aspect-ratio: 1 / 1.1;
        background: #ececec;
        border-radius: 4px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .grace-detail-image-box img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .grace-flavor-options{
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 12px;
        max-width: 430px;
    }

    .grace-flavor-btn{
        min-width: 110px;
        height: 36px;
        border: 1px solid #dadada;
        background: #f8f8f8;
        border-radius: 8px;
        color: #2f2118;
        font-size: .78rem;
        font-weight: 700;
    }

    .grace-flavor-btn.active{
        background: #e7d8cc;
        border-color: #e7d8cc;
    }

    .grace-modal-title{
        font-size: clamp(2rem, 4vw, 3rem);
        color: var(--grace-accent);
        font-weight: 500;
        margin: 8px 0 22px;
    }

    .grace-detail-qty-inline{
        display: flex;
        align-items: center;
        gap: 14px;
        margin: 8px 0 20px;
    }

    .grace-detail-product-name{
        font-size: .92rem;
        font-weight: 800;
        color: #4d2e1d;
        margin-bottom: 2px;
    }

    .grace-detail-variant{
        font-size: .82rem;
        color: #71574a;
    }

    .grace-qty-inline-box{
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-left: 18px;
    }

    .grace-qty-inline-btn{
        width: 22px;
        height: 22px;
        border: 0;
        background: transparent;
        color: #b6a59b;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    .grace-qty-inline-value{
        min-width: 20px;
        text-align: center;
        font-size: .92rem;
        color: #b77349;
        font-weight: 700;
    }

    .grace-detail-block-title{
        font-size: .92rem;
        font-weight: 800;
        color: #6c462f;
        margin: 18px 0 6px;
    }

    .grace-detail-description,
    .grace-detail-ingredients{
        font-size: .86rem;
        line-height: 1.55;
        color: #6a584c;
        max-width: 430px;
    }

    .grace-bottom-bar{
        margin-top: 30px;
        max-width: 520px;
        background: #f8f4f0;
        border-radius: 16px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
    }

    .grace-bottom-price-label{
        font-size: .9rem;
        font-weight: 800;
        color: #503122;
        line-height: 1.1;
    }

    .grace-bottom-price-value{
        font-size: 1.75rem;
        color: var(--grace-accent);
        font-weight: 800;
        line-height: 1;
    }

    .grace-add-btn{
        min-width: 206px;
        min-height: 42px;
        border: 0;
        border-radius: 10px;
        background: var(--grace-accent);
        color: #fff9f4;
        font-size: .85rem;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 18px;
    }

    .grace-add-btn svg{
        width: 16px;
        height: 16px;
    }

    .grace-modal-discount{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .grace-modal-discount .old{
        text-decoration: line-through;
        color: #938173;
        font-size: .98rem;
        font-weight: 700;
    }

    .grace-modal-discount .new{
        color: var(--grace-accent);
        font-size: 1.75rem;
        font-weight: 800;
    }

    .grace-modal-discount .off{
        background: #f2e6db;
        color: #8a5838;
        border-radius: 999px;
        padding: 3px 8px;
        font-size: .78rem;
        font-weight: 900;
    }

    @media (max-width: 1199.98px){
        .grace-products-grid{ grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }

    @media (max-width: 991.98px){
        .grace-detail-layout{
            grid-template-columns: 1fr;
            gap: 24px;
        }

        .grace-detail-image-box,
        .grace-flavor-options,
        .grace-detail-description,
        .grace-detail-ingredients,
        .grace-bottom-bar{
            max-width: 100%;
        }
    }

    @media (max-width: 767.98px){
        .grace-hero-slide{ aspect-ratio: 16 / 6; }
        .grace-products-grid{ grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grace-modal .modal-body{ padding: 20px 16px 24px; }
        .grace-bottom-bar{
            flex-direction: column;
            align-items: stretch;
        }
        .grace-add-btn{ width: 100%; }
    }

    @media (max-width: 460px){
        .grace-products-grid{ grid-template-columns: 1fr 1fr; gap: 12px; }
        .grace-card-name{ font-size: .92rem; }
        .grace-filter-btn{ min-width: auto; padding: 10px 14px; font-size: .82rem; }
        .grace-card-badge{
            width: 68px;
            top: 14px;
            left: 14px;
        }
    }
</style>

@php
    $promoImages = [
        'storage/products/publicidad1.png',
        'storage/products/publicidad2.png',
        'storage/products/publicidad3.png',
    ];

    $productBadge = 'storage/products/Recurso 6.png';
@endphp

<div class="catalog-header">
    <div id="graceHeroCarousel" class="carousel slide grace-hero-carousel" data-bs-ride="carousel" data-bs-interval="3500">
        <div class="carousel-inner">
            @foreach($promoImages as $index => $promoImage)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img
                        src="{{ asset($promoImage) }}"
                        class="grace-hero-slide"
                        alt="Promoción {{ $index + 1 }}"
                        onerror="this.onerror=null;this.src='https://placehold.co/1400x420/e9e9e9/9a9a9a?text=Publicidad';"
                    >
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#graceHeroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#graceHeroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>

    @if($categories->isEmpty())
        <div class="grace-empty-results show">
            No hay productos disponibles por el momento.
        </div>
    @else
        <div class="grace-filters" id="categoryFilters">
            <button type="button" class="grace-filter-btn active" data-filter="all">Pan Dulce</button>
            @foreach($categories as $category)
                @if($category->products->isNotEmpty())
                    <button
                        type="button"
                        class="grace-filter-btn"
                        data-filter="category-{{ $category->id }}">
                        {{ $category->name }}
                    </button>
                @endif
            @endforeach
        </div>
    @endif
</div>

@if(!$categories->isEmpty())
    <div id="catalogSections">
        @foreach($categories as $category)
            @if($category->products->isNotEmpty())
                <section class="grace-section product-section" data-category="category-{{ $category->id }}">
                    <div class="grace-products-grid">
                        @foreach($category->products as $product)
                            @php
                                $regularIngredients = $product->productIngredients
                                    ->filter(fn ($pi) => !$pi->ingredient?->is_special)
                                    ->map(fn ($pi) => $pi->ingredient->name)
                                    ->values();

                                $specialIngredients = $product->productIngredients
                                    ->filter(fn ($pi) => $pi->ingredient?->is_special)
                                    ->map(fn ($pi) => ['id' => $pi->ingredient->id, 'name' => $pi->ingredient->name])
                                    ->values();

                                $specialNames = $specialIngredients->pluck('name')->values();
                                $shortDescription = \Illuminate\Support\Str::limit(trim($product->description), 82);
                            @endphp

                            <div class="grace-product-col product-item"
                                 data-name="{{ \Illuminate\Support\Str::lower($product->name) }}"
                                 data-description="{{ \Illuminate\Support\Str::lower($product->description) }}"
                                 data-category-text="{{ \Illuminate\Support\Str::lower($category->name) }}">
                                <div class="grace-product-card product-card"
                                     data-bs-toggle="modal"
                                     data-bs-target="#productModal"
                                     data-id="{{ $product->id }}"
                                     data-name="{{ $product->name }}"
                                     data-description="{{ $product->description }}"
                                     data-price="{{ $product->price }}"
                                     data-discount="{{ $product->discount }}"
                                     data-image="{{ $product->image ? asset('storage/' . $product->image) : '' }}"
                                     data-ingredients="{{ $regularIngredients->implode(', ') }}"
                                     data-special-ingredients='@json($specialIngredients)'
                                     data-special-ingredient-names='@json($specialNames)'>

                                    <div class="grace-card-image">
                                        <img
                                            src="{{ asset($productBadge) }}"
                                            alt="Panadería Grace"
                                            class="grace-card-badge"
                                        >

                                        <div class="grace-card-image-box">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <i class="bi bi-image text-muted fs-4"></i>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="grace-card-body">
                                        <h3 class="grace-card-name">{{ $product->name }}</h3>
                                        <div class="grace-card-desc">{{ $shortDescription }}</div>

                                        <div class="grace-card-price">
                                            @if($product->discount > 0)
                                                <span class="old">${{ number_format($product->price, 2) }}</span>
                                                <span class="new">${{ number_format($product->price * (1 - $product->discount / 100), 2) }}</span>
                                            @else
                                                ${{ number_format($product->price, 2) }}
                                            @endif
                                        </div>

                                        <span class="grace-card-icon" aria-hidden="true">
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
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        @endforeach
    </div>

    <div class="grace-empty-results" id="emptyCatalogResults">
        No se encontraron productos con ese filtro o búsqueda.
    </div>
@endif

<div class="modal fade grace-modal" id="productModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <div class="grace-detail-breadcrumb">
                    <span><i class="bi bi-chevron-left"></i></span>
                    <span>Inicio</span>
                    <span><i class="bi bi-chevron-left"></i></span>
                    <span>Detalles</span>
                </div>

                <div class="grace-detail-layout">
                    <div class="grace-detail-left">
                        <div class="grace-detail-image-box" id="modalImageWrap">
                            <img id="modalProductImage" src="" alt="">
                        </div>

                        <div class="grace-flavor-options" id="modalFlavorOptions">
                            <button type="button" class="grace-flavor-btn active">Vainilla</button>
                            <button type="button" class="grace-flavor-btn">Chocolate</button>
                            <button type="button" class="grace-flavor-btn">Fresa</button>
                        </div>
                    </div>

                    <div class="grace-detail-right">
                        <h2 class="grace-modal-title" id="modalProductName">Concha</h2>

                        <div class="grace-detail-qty-inline">
                            <div>
                                <div class="grace-detail-product-name" id="modalInlineProductName">Producto</div>
                                <div class="grace-detail-variant" id="modalInlineVariantName">Variante</div>
                            </div>

                            <div class="grace-qty-inline-box">
                                <button type="button" class="grace-qty-inline-btn" id="qtyMinus">−</button>
                                <span class="grace-qty-inline-value" id="modalQtyInline">1</span>
                                <button type="button" class="grace-qty-inline-btn" id="qtyPlus">+</button>
                            </div>
                        </div>

                        <div class="grace-detail-block-title">Descripción</div>
                        <div class="grace-detail-description" id="modalProductDescription"></div>

                        <div class="grace-detail-block-title">Ingredientes</div>
                        <div class="grace-detail-ingredients" id="modalProductIngredientsText">Sin ingredientes listados</div>

                        <form action="{{ route('cart.add') }}" method="POST" id="modalAddForm">
                            @csrf
                            <input type="hidden" name="product_id" id="modalProductId">
                            <input type="hidden" name="quantity" id="modalQuantity" value="1">
                            <input type="hidden" name="special_ingredient_id" id="modalSelectedSpecialIngredient">

                            <div id="modalSpecialIngredientWrap" class="mt-3 d-none">
                                <label for="modalSpecialIngredient" class="form-label fw-bold">Selecciona una opción</label>
                                <select id="modalSpecialIngredient" class="form-select">
                                    <option value="">-- Seleccionar --</option>
                                </select>
                            </div>

                            <div class="grace-bottom-bar">
                                <div>
                                    <div class="grace-bottom-price-label">Precio</div>
                                    <div class="grace-bottom-price-value" id="modalProductPrice">$0.00</div>
                                </div>

                                <button type="submit" class="grace-add-btn" data-show-loader>
                                    <span id="modalAddButtonText">Agregar a bandeja</span>
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
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const searchInput = document.getElementById('globalProductSearch');
    const filterButtons = document.querySelectorAll('.grace-filter-btn');
    const productItems = document.querySelectorAll('.product-item');
    const productSections = document.querySelectorAll('.product-section');
    const emptyResults = document.getElementById('emptyCatalogResults');

    let currentFilter = 'all';

    function normalizeText(value) {
        return (value || '').toString().trim().toLowerCase();
    }

    function applyCatalogFilters() {
        const search = normalizeText(searchInput ? searchInput.value : '');
        let visibleProducts = 0;

        productSections.forEach(section => {
            const sectionCategory = section.dataset.category;
            const sectionProducts = section.querySelectorAll('.product-item');
            let sectionHasVisibleProducts = false;

            sectionProducts.forEach(item => {
                const matchesFilter = currentFilter === 'all' || sectionCategory === currentFilter;
                const searchable = [
                    item.dataset.name,
                    item.dataset.description,
                    item.dataset.categoryText
                ].join(' ');

                const matchesSearch = search === '' || searchable.includes(search);
                const shouldShow = matchesFilter && matchesSearch;

                item.style.display = shouldShow ? '' : 'none';

                if (shouldShow) {
                    sectionHasVisibleProducts = true;
                    visibleProducts++;
                }
            });

            section.style.display = sectionHasVisibleProducts ? '' : 'none';
        });

        if (emptyResults) {
            emptyResults.classList.toggle('show', visibleProducts === 0);
        }
    }

    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.dataset.filter;
            applyCatalogFilters();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', applyCatalogFilters);
    }

    applyCatalogFilters();

    const productCards = document.querySelectorAll('.product-card');
    const modalProductId = document.getElementById('modalProductId');
    const modalProductName = document.getElementById('modalProductName');
    const modalInlineProductName = document.getElementById('modalInlineProductName');
    const modalInlineVariantName = document.getElementById('modalInlineVariantName');
    const modalProductDescription = document.getElementById('modalProductDescription');
    const modalProductPrice = document.getElementById('modalProductPrice');
    const modalProductImage = document.getElementById('modalProductImage');
    const modalImageWrap = document.getElementById('modalImageWrap');
    const modalIngredientsText = document.getElementById('modalProductIngredientsText');
    const modalSpecialWrap = document.getElementById('modalSpecialIngredientWrap');
    const modalSpecialSelect = document.getElementById('modalSpecialIngredient');
    const modalSelectedSpecialIngredient = document.getElementById('modalSelectedSpecialIngredient');
    const modalQuantity = document.getElementById('modalQuantity');
    const modalQtyInline = document.getElementById('modalQtyInline');
    const qtyMinus = document.getElementById('qtyMinus');
    const qtyPlus = document.getElementById('qtyPlus');
    const modalAddButtonText = document.getElementById('modalAddButtonText');
    const modalFlavorOptions = document.getElementById('modalFlavorOptions');

    function formatPriceHtml(price, discount) {
        if (discount > 0) {
            const finalPrice = (price * (1 - discount / 100)).toFixed(2);
            return `
                <span class="grace-modal-discount">
                    <span class="old">$${price.toFixed(2)}</span>
                    <span class="new">$${finalPrice}</span>
                    <span class="off">${discount}% OFF</span>
                </span>
            `;
        }

        return `$${price.toFixed(2)}`;
    }

    function updateQtyDisplay() {
        let qty = parseInt(modalQuantity.value, 10) || 1;

        if (qty < 1) qty = 1;
        if (qty > 99) qty = 99;

        modalQuantity.value = qty;
        modalQtyInline.textContent = qty;
        modalAddButtonText.textContent = qty > 1 ? `Agregar ${qty}` : 'Agregar a bandeja';
    }

    function setFlavorButtons(names) {
        if (!modalFlavorOptions) return;

        const cleanNames = Array.isArray(names) ? names.filter(Boolean) : [];
        const fallback = ['Vainilla', 'Chocolate', 'Fresa'];
        const finalNames = cleanNames.length ? cleanNames : fallback;

        modalFlavorOptions.innerHTML = finalNames.map((name, index) => `
            <button
                type="button"
                class="grace-flavor-btn ${index === 0 ? 'active' : ''}"
                data-flavor-name="${name}"
            >${name}</button>
        `).join('');

        const buttons = modalFlavorOptions.querySelectorAll('.grace-flavor-btn');
        buttons.forEach((button, index) => {
            button.addEventListener('click', function () {
                buttons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                modalInlineVariantName.textContent = this.dataset.flavorName || 'Clásico';

                const specialOption = modalSpecialSelect?.options[index + 1];
                if (specialOption) {
                    modalSpecialSelect.value = specialOption.value;
                    modalSelectedSpecialIngredient.value = specialOption.value;
                }
            });
        });

        modalInlineVariantName.textContent = finalNames[0] || 'Clásico';
    }

    qtyMinus?.addEventListener('click', function () {
        modalQuantity.value = Math.max(1, (parseInt(modalQuantity.value, 10) || 1) - 1);
        updateQtyDisplay();
    });

    qtyPlus?.addEventListener('click', function () {
        modalQuantity.value = Math.min(99, (parseInt(modalQuantity.value, 10) || 1) + 1);
        updateQtyDisplay();
    });

    modalSpecialSelect?.addEventListener('change', function () {
        modalSelectedSpecialIngredient.value = this.value || '';
        const selectedText = this.options[this.selectedIndex]?.textContent || 'Clásico';
        if (this.value) {
            modalInlineVariantName.textContent = selectedText;
            modalFlavorOptions?.querySelectorAll('.grace-flavor-btn').forEach(btn => {
                btn.classList.toggle('active', btn.dataset.flavorName === selectedText);
            });
        }
    });

    productCards.forEach(function(card) {
        card.addEventListener('click', function() {
            const name = this.dataset.name || '';
            const description = this.dataset.description || '';
            const price = parseFloat(this.dataset.price || '0');
            const discount = parseInt(this.dataset.discount || '0', 10);
            const image = this.dataset.image || '';
            const ingredients = this.dataset.ingredients || '';
            const specialIngredients = JSON.parse(this.dataset.specialIngredients || '[]');
            const specialIngredientNames = JSON.parse(this.dataset.specialIngredientNames || '[]');
            const id = this.dataset.id;

            modalProductId.value = id;
            modalProductName.textContent = name;
            modalInlineProductName.textContent = name;
            modalProductDescription.textContent = description || 'Sin descripción disponible.';
            modalProductPrice.innerHTML = formatPriceHtml(price, discount);
            modalIngredientsText.textContent = ingredients || 'Sin ingredientes listados';

            modalSpecialSelect.innerHTML = '<option value="">-- Seleccionar --</option>';
            modalSelectedSpecialIngredient.value = '';

            if (specialIngredients.length > 0) {
                specialIngredients.forEach(function(ingredient) {
                    const option = document.createElement('option');
                    option.value = ingredient.id;
                    option.textContent = ingredient.name;
                    modalSpecialSelect.appendChild(option);
                });

                modalSpecialWrap.classList.remove('d-none');
                modalSelectedSpecialIngredient.value = specialIngredients[0].id;
                modalSpecialSelect.value = specialIngredients[0].id;
            } else {
                modalSpecialWrap.classList.add('d-none');
            }

            setFlavorButtons(specialIngredientNames);

            if (image) {
                modalProductImage.src = image;
                modalProductImage.alt = name;
                modalImageWrap.style.display = '';
            } else {
                modalImageWrap.style.display = 'flex';
                modalProductImage.removeAttribute('src');
                modalProductImage.alt = name;
            }

            modalQuantity.value = 1;
            updateQtyDisplay();
        });
    });

    const modalAddForm = document.getElementById('modalAddForm');
    modalAddForm?.addEventListener('submit', function () {
        if (window.GraceLoader) {
            window.GraceLoader.show();
        }
    });

    updateQtyDisplay();
})();
</script>
@endpush