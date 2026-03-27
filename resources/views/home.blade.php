@extends('layouts.app')

@section('content')
<h2 class="fw-bold mb-4">Nuestro Catálogo</h2>

@if($categories->isEmpty())
    <p class="text-muted">No hay productos disponibles por el momento.</p>
@else
    @foreach($categories as $category)
        @if($category->products->isNotEmpty())
            <h4 class="text-muted mb-3 border-bottom pb-1">{{ $category->name }}</h4>
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3 mb-4">
                @foreach($category->products as $product)
                    <div class="col">
                        <div class="card h-100 product-card"
                             style="cursor:pointer"
                             data-bs-toggle="modal"
                             data-bs-target="#productModal"
                             data-id="{{ $product->id }}"
                             data-name="{{ $product->name }}"
                             data-description="{{ $product->description }}"
                             data-price="{{ $product->price }}"
                             data-discount="{{ $product->discount }}"
                             data-image="{{ $product->image ? asset('storage/' . $product->image) : '' }}"
                             data-ingredients="{{ $product->productIngredients->map(fn($pi) => $pi->ingredient->name)->implode(', ') }}">

                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     class="card-img-top"
                                     style="height:140px;object-fit:cover;"
                                     alt="{{ $product->name }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light"
                                     style="height:140px;">
                                    <i class="bi bi-image text-muted fs-2"></i>
                                </div>
                            @endif

                            <div class="card-body p-2">
                                <p class="mb-0 fw-semibold small">{{ $product->name }}</p>
                                @if($product->discount > 0)
                                    <span class="text-decoration-line-through text-muted small">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                    <span class="text-danger small fw-bold ms-1">
                                        ${{ number_format($product->price * (1 - $product->discount / 100), 2) }}
                                    </span>
                                @else
                                    <span class="text-dark small">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endforeach
@endif

{{-- PRODUCT MODAL --}}
<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="modalProductName">-</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="modalImageWrap" class="mb-3 text-center">
                    <img id="modalProductImage" src="" alt=""
                         class="img-fluid rounded"
                         style="max-height:220px;object-fit:cover;width:100%;">
                </div>
                <p id="modalProductDescription" class="mb-2"></p>
                <p class="mb-1 small text-muted">
                    <strong>Ingredientes:</strong>
                    <span id="modalProductIngredients">-</span>
                </p>
                <p class="mb-3">
                    <strong id="modalProductPrice"></strong>
                </p>

                <form action="{{ route('cart.add') }}" method="POST" class="d-flex align-items-center gap-2">
                    @csrf
                    <input type="hidden" name="product_id" id="modalProductId">
                    <label class="form-label mb-0 me-1">Cantidad:</label>
                    <input type="number" name="quantity" value="1" min="1" max="99"
                           class="form-control form-control-sm" style="width:80px">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-cart-plus"></i> Agregar a bandeja
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.product-card').forEach(function(card) {
    card.addEventListener('click', function() {
        const name        = this.dataset.name;
        const description = this.dataset.description;
        const price       = parseFloat(this.dataset.price);
        const discount    = parseInt(this.dataset.discount);
        const image       = this.dataset.image;
        const ingredients = this.dataset.ingredients;
        const id          = this.dataset.id;

        document.getElementById('modalProductId').value = id;
        document.getElementById('modalProductName').textContent = name;
        document.getElementById('modalProductDescription').textContent = description;
        document.getElementById('modalProductIngredients').textContent = ingredients || 'Sin ingredientes listados';

        const img = document.getElementById('modalProductImage');
        const wrap = document.getElementById('modalImageWrap');
        if (image) {
            img.src = image;
            img.alt = name;
            wrap.style.display = '';
        } else {
            wrap.style.display = 'none';
        }

        let priceHtml = '';
        if (discount > 0) {
            const final = (price * (1 - discount / 100)).toFixed(2);
            priceHtml = `<span class="text-decoration-line-through text-muted me-2">$${price.toFixed(2)}</span>
                         <span class="text-danger">$${final}</span>
                         <span class="badge bg-warning text-dark ms-1">${discount}% OFF</span>`;
        } else {
            priceHtml = `$${price.toFixed(2)}`;
        }
        document.getElementById('modalProductPrice').innerHTML = priceHtml;
    });
});
</script>
@endpush
