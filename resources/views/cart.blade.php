@extends('layouts.app')

@section('content')
<style>
    .grace-order-page{ padding-top: 6px; }

    .grace-order-breadcrumb{
        display: flex;
        align-items: center;
        gap: 8px;
        color: #b36f46;
        font-size: .95rem;
        font-weight: 700;
        margin-bottom: 26px;
    }

    .grace-order-breadcrumb a{ color: #b36f46; }

    .grace-pickup-top{
        display: inline-flex;
        align-items: center;
        background: #d7b093;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 34px;
        border: 1px solid #d2b29b;
    }

    .grace-pickup-pill,
    .grace-pickup-time{
        min-height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 18px;
        font-size: .82rem;
        font-weight: 800;
    }

    .grace-pickup-pill{
        background: var(--grace-accent);
        color: #fff8f3;
        min-width: 86px;
    }

    .grace-pickup-time{
        color: #6a4631;
        background: #d7b093;
    }

    .grace-order-grid{
        display: grid;
        grid-template-columns: minmax(0, 1fr) 320px;
        gap: 34px;
        align-items: start;
    }

    .grace-order-items{ min-width: 0; }

    .grace-order-item{
        display: grid;
        grid-template-columns: 62px minmax(0, 1fr) auto auto auto;
        gap: 16px;
        align-items: center;
        margin-bottom: 14px;
    }

    .grace-order-item-image{
        width: 56px;
        height: 56px;
        border-radius: 6px;
        background: #e8e8e8;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .grace-order-item-image img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .grace-order-item-name{
        font-size: 1.02rem;
        font-weight: 800;
        color: #7d4d2d;
        line-height: 1.1;
        margin-bottom: 2px;
    }

    .grace-order-item-variant{
        font-size: .82rem;
        color: #6f6258;
    }

    .grace-order-item-qty{
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .grace-qty-btn{
        width: 24px;
        height: 24px;
        border: 0;
        border-radius: 50%;
        background: #efebe8;
        color: #b8aaa0;
        font-size: .95rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        padding: 0;
    }

    .grace-qty-btn:hover{
        background: #e2d6ce;
        color: #8f6f5a;
    }

    .grace-qty-btn:disabled{
        opacity: .45;
        cursor: not-allowed;
    }

    .grace-qty-value{
        min-width: 16px;
        text-align: center;
        color: #7b6556;
        font-size: .94rem;
        font-weight: 700;
    }

    .grace-order-item-price{
        font-size: 1.02rem;
        font-weight: 800;
        color: var(--grace-accent);
        min-width: 42px;
        text-align: right;
    }

    .grace-remove-btn{
        width: 26px;
        height: 26px;
        border: 1px solid #e5d8cf;
        border-radius: 50%;
        background: #fff;
        color: #b36f46;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .grace-order-side-title{
        font-size: 1.05rem;
        font-weight: 800;
        color: #7d4d2d;
        margin-bottom: 4px;
    }

    .grace-order-side-text{
        font-size: .86rem;
        color: #6e6156;
        line-height: 1.45;
    }

    .grace-link-chip{
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border: 1px solid #b97348;
        color: #b97348;
        border-radius: 999px;
        padding: 7px 14px;
        font-size: .78rem;
        font-weight: 800;
        background: #fff;
        margin-top: 10px;
    }

    .grace-order-form-grid{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px 22px;
        margin-top: 22px;
    }

    .grace-form-block{ min-width: 0; }
    .grace-form-block-full{ grid-column: 1 / -1; }

    .grace-form-label{
        display: block;
        font-size: .95rem;
        font-weight: 800;
        color: #7d4d2d;
        margin-bottom: 8px;
    }

    .grace-input,
    .grace-select,
    .grace-textarea{
        width: 100%;
        border: 1px solid #e5d8cf;
        border-radius: 12px;
        background: #fff;
        min-height: 44px;
        padding: 10px 14px;
        font-size: .92rem;
        color: #4e382b;
        outline: none;
        box-shadow: 0 2px 8px rgba(79, 47, 27, 0.03);
    }

    .grace-textarea{ min-height: 92px; resize: vertical; }

    .grace-invalid{
        font-size: .78rem;
        color: #b02f2f;
        margin-top: 6px;
        font-weight: 700;
    }

    .grace-payment-summary-title{
        margin-top: 42px;
        margin-bottom: 10px;
        color: #7d4d2d;
        font-size: 1.25rem;
        font-weight: 800;
    }

    .grace-payment-box{
        background: #f5f2ef;
        border: 1px solid #ece2da;
        border-radius: 16px;
        padding: 16px 18px;
        box-shadow: 0 6px 18px rgba(77, 45, 23, 0.04);
    }

    .grace-payment-grid{
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 18px;
        align-items: stretch;
    }

    .grace-payment-col-title{
        font-size: .78rem;
        color: #b4a59b;
        margin-bottom: 8px;
        font-weight: 800;
    }

    .grace-payment-method-btn{
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 36px;
        padding: 8px 14px;
        border-radius: 999px;
        border: 1px solid #c58b62;
        color: #b97348;
        background: #fff;
        font-size: .78rem;
        font-weight: 800;
        cursor: pointer;
    }

    .grace-payment-selected{
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 36px;
        font-size: .9rem;
        font-weight: 700;
        color: #7c6555;
    }

    .grace-payment-note{
        font-size: .68rem;
        color: #b2a49b;
        margin-top: 3px;
        line-height: 1.2;
    }

    .grace-total-wrap{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .grace-total-row{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 10px;
    }

    .grace-total-label{
        display: flex;
        align-items: center;
        gap: 8px;
        color: #c2b5ac;
        font-size: .85rem;
        font-weight: 800;
    }

    .grace-total-value{
        font-size: .92rem;
        font-weight: 900;
        color: #3f2c22;
    }

    .grace-order-btn{
        width: 100%;
        min-height: 44px;
        border: 0;
        border-radius: 10px;
        background: var(--grace-accent);
        color: #fff8f3;
        font-size: .92rem;
        font-weight: 800;
        box-shadow: 0 8px 16px rgba(201, 134, 85, 0.22);
    }

    .grace-payment-options{
        display: none;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #e7ddd6;
    }

    .grace-payment-options.show{ display: block; }

    .grace-radio-grid{
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .grace-pay-card{
        position: relative;
        border: 1px solid #e4d8cf;
        border-radius: 16px;
        background: #fff;
        padding: 16px;
        cursor: pointer;
        transition: .18s ease;
    }

    .grace-pay-card:hover,
    .grace-pay-card.active{
        border-color: #c98655;
        box-shadow: 0 10px 24px rgba(111, 69, 41, 0.08);
    }

    .grace-pay-card input{
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .grace-pay-card-title{
        font-size: .98rem;
        font-weight: 800;
        color: #6f4529;
        margin-bottom: 6px;
    }

    .grace-pay-card-text{
        font-size: .82rem;
        color: #76685d;
        line-height: 1.45;
    }

    .grace-transfer-card{
        display: none;
        margin-top: 16px;
        border-radius: 18px;
        overflow: hidden;
        background: linear-gradient(135deg, #7b4d31 0%, #a06a48 55%, #c99167 100%);
        color: #fff9f4;
        box-shadow: 0 14px 30px rgba(111, 69, 41, 0.18);
    }

    .grace-transfer-card.show{ display: block; }
    .grace-transfer-card-inner{ padding: 18px 18px 16px; }

    .grace-transfer-top{
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 18px;
    }

    .grace-transfer-bank{ font-size: 1rem; font-weight: 900; letter-spacing: .4px; }

    .grace-transfer-chip{
        width: 42px;
        height: 30px;
        border-radius: 8px;
        background: rgba(255,255,255,.22);
    }

    .grace-transfer-label{ font-size: .72rem; opacity: .82; margin-bottom: 2px; }
    .grace-transfer-value{ font-size: 1rem; font-weight: 800; letter-spacing: .5px; word-break: break-word; margin-bottom: 12px; }

    .grace-transfer-bottom{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 12px;
    }

    .grace-transfer-help{
        font-size: .76rem;
        color: #f8e8dc;
        line-height: 1.45;
        margin-top: 4px;
    }

    @media (max-width: 991.98px){
        .grace-order-grid,
        .grace-payment-grid{ grid-template-columns: 1fr; }
    }

    @media (max-width: 767.98px){
        .grace-order-item{
            grid-template-columns: 56px minmax(0, 1fr) auto;
            gap: 12px;
        }

        .grace-order-item-qty,
        .grace-order-item-price{ grid-column: 2; }

        .grace-order-form-grid,
        .grace-radio-grid,
        .grace-transfer-bottom{ grid-template-columns: 1fr; }
    }
</style>

@php
    $pickupAddress = 'Justo Sierra 22 Santa Cecilia, 66636 Cdad. Apodaca, NL';
    $pickupMapUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($pickupAddress);
    $pickupTimeDefault = old('pickup_time', '11:00 - 12:00 pm');
    $paymentMethodOld = old('payment_method', 'transferencia');
    $clientNameOld = old('client_name', auth()->user()->name ?? '');
    $phoneOld = old('phone_number', auth()->user()->phone_number ?? auth()->user()->phone ?? '');
    $notesOld = old('notes');
@endphp

<div class="grace-order-page">
    <div class="grace-order-breadcrumb">
        <span><i class="bi bi-chevron-left"></i></span>
        <a href="{{ route('home') }}">Inicio</a>
        <span><i class="bi bi-chevron-left"></i></span>
        <span>Mis pedidos</span>
    </div>

    @if(empty($cart))
        <div class="alert alert-info">Tu bandeja está vacía.</div>
    @else
        @php $subtotal = 0; @endphp

        {{-- Forms externos para evitar anidar formularios --}}
        @foreach($cart as $item)
            @php
                $cartKey = $item['key'] ?? $item['id'];
                $minusQty = max(1, $item['quantity'] - 1);
                $plusQty = $item['quantity'] + 1;
            @endphp

            <form id="cart-minus-{{ $cartKey }}" action="{{ route('cart.update') }}" method="POST" class="d-none">
                @csrf
                <input type="hidden" name="cart_key" value="{{ $cartKey }}">
                <input type="hidden" name="quantity" value="{{ $minusQty }}">
            </form>

            <form id="cart-plus-{{ $cartKey }}" action="{{ route('cart.update') }}" method="POST" class="d-none">
                @csrf
                <input type="hidden" name="cart_key" value="{{ $cartKey }}">
                <input type="hidden" name="quantity" value="{{ $plusQty }}">
            </form>

            <form id="cart-remove-{{ $cartKey }}" action="{{ route('cart.remove') }}" method="POST" class="d-none">
                @csrf
                <input type="hidden" name="cart_key" value="{{ $cartKey }}">
            </form>
        @endforeach

        <div class="grace-pickup-top">
            <span class="grace-pickup-pill">Pick-up</span>
            <span class="grace-pickup-time" id="pickupTimePreview">{{ $pickupTimeDefault }}</span>
        </div>

        <form action="{{ route('order.store') }}" method="POST" id="graceOrderForm">
            @csrf

            <div class="grace-order-grid">
                <div class="grace-order-items">
                    @foreach($cart as $item)
                        @php
                            $unitPrice = $item['price'] * (1 - ($item['discount'] / 100));
                            $lineTotal = $unitPrice * $item['quantity'];
                            $subtotal += $lineTotal;
                            $cartKey = $item['key'] ?? $item['id'];
                            $itemImage = !empty($item['image']) ? $item['image'] : null;
                        @endphp

                        <div class="grace-order-item">
                            <div class="grace-order-item-image">
                                @if($itemImage)
                                    <img
                                        src="{{ $itemImage }}"
                                        alt="{{ $item['name'] }}"
                                        onerror="this.style.display='none'; this.parentNode.innerHTML='<i class=&quot;bi bi-image text-muted&quot;></i>';"
                                    >
                                @else
                                    <i class="bi bi-image text-muted"></i>
                                @endif
                            </div>

                            <div>
                                <div class="grace-order-item-name">{{ $item['name'] }}</div>
                                <div class="grace-order-item-variant">
                                    {{ !empty($item['special_ingredient_name']) ? $item['special_ingredient_name'] : 'Clásico' }}
                                </div>
                            </div>

                            <div class="grace-order-item-qty" aria-label="Cantidad">
                                <button
                                    type="submit"
                                    class="grace-qty-btn"
                                    form="cart-minus-{{ $cartKey }}"
                                    {{ $item['quantity'] <= 1 ? 'disabled' : '' }}
                                >−</button>

                                <span class="grace-qty-value">{{ $item['quantity'] }}</span>

                                <button
                                    type="submit"
                                    class="grace-qty-btn"
                                    form="cart-plus-{{ $cartKey }}"
                                >+</button>
                            </div>

                            <div class="grace-order-item-price">${{ number_format($lineTotal, 0) }}</div>

                            <button
                                type="submit"
                                class="grace-remove-btn"
                                form="cart-remove-{{ $cartKey }}"
                                aria-label="Eliminar producto"
                            >
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    @endforeach
                </div>

                <div>
                    <div class="grace-order-side-title">Recoger en</div>
                    <div class="grace-order-side-text">{{ $pickupAddress }}</div>
                    <a href="{{ $pickupMapUrl }}" target="_blank" class="grace-link-chip">
                        <i class="bi bi-geo-alt-fill"></i>
                        Ver Ubicación
                    </a>

                    <div class="grace-order-form-grid">
                        <div class="grace-form-block">
                            <label class="grace-form-label" for="client_name">Nombre</label>
                            <input type="text" id="client_name" name="client_name" class="grace-input" value="{{ $clientNameOld }}" placeholder="Tu nombre completo" required>
                            @error('client_name')<div class="grace-invalid">{{ $message }}</div>@enderror
                        </div>

                        <div class="grace-form-block">
                            <label class="grace-form-label" for="phone_number">Teléfono</label>
                            <input type="tel" id="phone_number" name="phone_number" class="grace-input" value="{{ $phoneOld }}" placeholder="Ej. 8112345678" required>
                            @error('phone_number')<div class="grace-invalid">{{ $message }}</div>@enderror
                        </div>

                        <div class="grace-form-block">
                            <label class="grace-form-label" for="pickup_time">Hora para recoger</label>
                            <select id="pickup_time" name="pickup_time" class="grace-select" required>
                                <option value="11:00 - 12:00 pm" {{ $pickupTimeDefault === '11:00 - 12:00 pm' ? 'selected' : '' }}>11:00 - 12:00 pm</option>
                                <option value="12:00 - 01:00 pm" {{ $pickupTimeDefault === '12:00 - 01:00 pm' ? 'selected' : '' }}>12:00 - 01:00 pm</option>
                                <option value="01:00 - 02:00 pm" {{ $pickupTimeDefault === '01:00 - 02:00 pm' ? 'selected' : '' }}>01:00 - 02:00 pm</option>
                                <option value="02:00 - 03:00 pm" {{ $pickupTimeDefault === '02:00 - 03:00 pm' ? 'selected' : '' }}>02:00 - 03:00 pm</option>
                                <option value="03:00 - 04:00 pm" {{ $pickupTimeDefault === '03:00 - 04:00 pm' ? 'selected' : '' }}>03:00 - 04:00 pm</option>
                            </select>
                            @error('pickup_time')<div class="grace-invalid">{{ $message }}</div>@enderror
                        </div>

                        <div class="grace-form-block grace-form-block-full">
                            <label class="grace-form-label" for="notes">Notas</label>
                            <textarea id="notes" name="notes" class="grace-textarea" placeholder="Ej. Paso a recoger a las 11:30, sin azúcar glass, etc.">{{ $notesOld }}</textarea>
                            @error('notes')<div class="grace-invalid">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="grace-payment-summary-title">Resumen de pago</div>

            <div class="grace-payment-box">
                <div class="grace-payment-grid">
                    <div>
                        <div class="grace-payment-col-title">Método de pago</div>
                        <button type="button" class="grace-payment-method-btn" id="togglePaymentMethodsBtn">
                            <i class="bi bi-arrow-left-right"></i>
                            Cambiar método de pago
                        </button>
                    </div>

                    <div>
                        <div class="grace-payment-col-title">Método seleccionado</div>
                        <div class="grace-payment-selected">
                            <i class="bi bi-credit-card-2-front"></i>
                            <span id="selectedPaymentLabel">{{ $paymentMethodOld === 'transferencia' ? 'Transferencia' : 'Pago en sucursal' }}</span>
                        </div>
                        <div class="grace-payment-note" id="selectedPaymentHelp">
                            {{ $paymentMethodOld === 'transferencia' ? 'Te compartiremos los datos para depositar o transferir.' : 'Pagas al recoger en sucursal, en efectivo o tarjeta.' }}
                        </div>
                    </div>

                    <div class="grace-total-wrap">
                        <div class="grace-total-row">
                            <div class="grace-total-label">
                                <i class="bi bi-credit-card"></i>
                                <span>Total a pagar</span>
                            </div>
                            <div class="grace-total-value">${{ number_format($subtotal, 0) }}</div>
                        </div>

                        <button type="submit" class="grace-order-btn" data-show-loader>Ordenar</button>
                    </div>
                </div>

                <div class="grace-payment-options show" id="paymentOptionsWrap">
                    <div class="grace-radio-grid">
                        <label class="grace-pay-card {{ $paymentMethodOld === 'transferencia' ? 'active' : '' }}">
                            <input type="radio" name="payment_method" value="transferencia" {{ $paymentMethodOld === 'transferencia' ? 'checked' : '' }} required>
                            <div class="grace-pay-card-title">Transferencia</div>
                            <div class="grace-pay-card-text">Realiza el pago por transferencia bancaria. Aquí mismo verás los datos de banco, cuenta y beneficiario.</div>
                        </label>

                        <label class="grace-pay-card {{ $paymentMethodOld === 'sucursal' ? 'active' : '' }}">
                            <input type="radio" name="payment_method" value="sucursal" {{ $paymentMethodOld === 'sucursal' ? 'checked' : '' }}>
                            <div class="grace-pay-card-title">Pago en sucursal</div>
                            <div class="grace-pay-card-text">Pagas al recoger tu pedido en la sucursal. Puede ser en efectivo o con tarjeta.</div>
                        </label>
                    </div>

                    <div class="grace-transfer-card {{ $paymentMethodOld === 'transferencia' ? 'show' : '' }}" id="transferInfoCard">
                        <div class="grace-transfer-card-inner">
                            <div class="grace-transfer-top">
                                <div class="grace-transfer-bank">BANCO GRACE</div>
                                <div class="grace-transfer-chip"></div>
                            </div>

                            <div class="grace-transfer-label">Titular</div>
                            <div class="grace-transfer-value">Panadería Grace S.A. de C.V.</div>

                            <div class="grace-transfer-label">Número de cuenta / CLABE</div>
                            <div class="grace-transfer-value">0123 4567 8901 2345 678</div>

                            <div class="grace-transfer-bottom">
                                <div>
                                    <div class="grace-transfer-label">Banco</div>
                                    <div class="grace-transfer-value">BBVA</div>
                                </div>
                                <div>
                                    <div class="grace-transfer-label">Referencia</div>
                                    <div class="grace-transfer-value">PANGRACE</div>
                                </div>
                            </div>

                            <div class="grace-transfer-help">Usa esta cuenta para transferir. Después de tu pago, puedes compartir tu comprobante por WhatsApp o mostrarlo al recoger.</div>
                        </div>
                    </div>
                </div>

                @error('payment_method')<div class="grace-invalid mt-2">{{ $message }}</div>@enderror
            </div>
        </form>
    @endif
</div>
@endsection

@push('scripts')
<script>
(function () {
    const pickupTimeSelect = document.getElementById('pickup_time');
    const pickupTimePreview = document.getElementById('pickupTimePreview');
    const togglePaymentMethodsBtn = document.getElementById('togglePaymentMethodsBtn');
    const paymentOptionsWrap = document.getElementById('paymentOptionsWrap');
    const paymentInputs = document.querySelectorAll('input[name="payment_method"]');
    const selectedPaymentLabel = document.getElementById('selectedPaymentLabel');
    const selectedPaymentHelp = document.getElementById('selectedPaymentHelp');
    const transferInfoCard = document.getElementById('transferInfoCard');
    const payCards = document.querySelectorAll('.grace-pay-card');

    function syncPickupPreview() {
        if (!pickupTimeSelect || !pickupTimePreview) return;
        pickupTimePreview.textContent = pickupTimeSelect.value || '11:00 - 12:00 pm';
    }

    function updatePaymentUI() {
        const selected = document.querySelector('input[name="payment_method"]:checked');
        const value = selected ? selected.value : 'transferencia';

        payCards.forEach(card => {
            const input = card.querySelector('input[name="payment_method"]');
            card.classList.toggle('active', !!(input && input.checked));
        });

        if (selectedPaymentLabel) {
            selectedPaymentLabel.textContent = value === 'transferencia' ? 'Transferencia' : 'Pago en sucursal';
        }

        if (selectedPaymentHelp) {
            selectedPaymentHelp.textContent = value === 'transferencia'
                ? 'Te compartiremos los datos para depositar o transferir.'
                : 'Pagas al recoger en sucursal, en efectivo o tarjeta.';
        }

        if (transferInfoCard) {
            transferInfoCard.classList.toggle('show', value === 'transferencia');
        }
    }

    pickupTimeSelect?.addEventListener('change', syncPickupPreview);

    togglePaymentMethodsBtn?.addEventListener('click', function () {
        paymentOptionsWrap?.classList.toggle('show');
    });

    paymentInputs.forEach(input => {
        input.addEventListener('change', updatePaymentUI);
    });

    syncPickupPreview();
    updatePaymentUI();
})();
</script>
@endpush