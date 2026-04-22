@extends('layouts.app')

@section('content')
<style>
    .grace-confirm-wrap{
        min-height: calc(100vh - 210px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px 0 34px;
    }

    .grace-confirm-card{
        width: min(760px, 100%);
        text-align: center;
    }

    .grace-confirm-title{
        color: #965d39;
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 800;
        font-family: 'Baloo 2', cursive;
        margin-bottom: 18px;
    }

    .grace-confirm-image-wrap{
        display: flex;
        justify-content: center;
        margin-bottom: 22px;
    }

    .grace-confirm-image{
        width: min(210px, 52vw);
        height: auto;
        object-fit: contain;
        filter: drop-shadow(0 6px 18px rgba(0,0,0,.08));
    }

    .grace-confirm-subtitle{
        color: var(--grace-accent);
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 22px;
        font-family: 'Baloo 2', cursive;
    }

    .grace-confirm-ok{
        width: min(330px, 100%);
        margin: 0 auto 10px;
        min-height: 42px;
        border-radius: 10px;
        background: var(--grace-brown);
        color: #fff7ef;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-size: .9rem;
        font-weight: 800;
        padding: 10px 18px;
    }

    .grace-confirm-pill{
        width: fit-content;
        max-width: 100%;
        margin: 0 auto 28px;
        display: inline-flex;
        align-items: center;
        overflow: hidden;
        border-radius: 10px;
        border: 1px solid #d4b8a2;
    }

    .grace-confirm-pill-label,
    .grace-confirm-pill-time{
        min-height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 18px;
        font-size: .82rem;
        font-weight: 800;
    }

    .grace-confirm-pill-label{
        background: var(--grace-accent);
        color: #fffaf7;
    }

    .grace-confirm-pill-time{
        background: #d8b39a;
        color: #6a4631;
    }

    .grace-confirm-summary{
        background: #f7f4f1;
        border: 1px solid #ece2da;
        border-radius: 18px;
        padding: 20px;
        text-align: left;
        box-shadow: 0 10px 24px rgba(77, 45, 23, 0.05);
    }

    .grace-confirm-summary-title{
        color: #7d4d2d;
        font-size: 1.1rem;
        font-weight: 800;
        margin-bottom: 14px;
    }

    .grace-confirm-grid{
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px 18px;
        margin-bottom: 18px;
    }

    .grace-confirm-label{
        font-size: .78rem;
        color: #b3a49a;
        font-weight: 800;
        margin-bottom: 3px;
    }

    .grace-confirm-value{
        font-size: .95rem;
        color: #503122;
        font-weight: 700;
        line-height: 1.35;
    }

    .grace-confirm-products{
        border-top: 1px solid #e8ddd5;
        padding-top: 14px;
    }

    .grace-confirm-product{
        display: flex;
        justify-content: space-between;
        gap: 14px;
        padding: 8px 0;
        border-bottom: 1px solid #f0e8e1;
    }

    .grace-confirm-product:last-child{ border-bottom: 0; }

    .grace-confirm-product-name{
        font-size: .95rem;
        font-weight: 800;
        color: #7d4d2d;
    }

    .grace-confirm-product-meta{
        font-size: .8rem;
        color: #7a6b61;
        margin-top: 2px;
    }

    .grace-confirm-product-price{
        font-size: .95rem;
        font-weight: 800;
        color: var(--grace-accent);
        white-space: nowrap;
    }

    .grace-confirm-total{
        border-top: 1px solid #e8ddd5;
        margin-top: 8px;
        padding-top: 14px;
        display: flex;
        justify-content: space-between;
        gap: 12px;
        align-items: center;
    }

    .grace-confirm-total-label{
        font-size: 1rem;
        font-weight: 800;
        color: #5a3927;
    }

    .grace-confirm-total-value{
        font-size: 1.3rem;
        font-weight: 900;
        color: var(--grace-accent);
    }

    .grace-confirm-actions{
        margin-top: 22px;
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .grace-confirm-btn{
        min-width: 220px;
        min-height: 44px;
        border-radius: 10px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 18px;
    }

    .grace-confirm-btn-primary{
        background: var(--grace-accent);
        color: #fff8f3;
        border: 0;
    }

    .grace-confirm-btn-secondary{
        background: #fff;
        color: #9a633f;
        border: 1px solid #d8c1b0;
    }

    @media (max-width: 767.98px){
        .grace-confirm-grid{ grid-template-columns: 1fr; }
        .grace-confirm-subtitle{ font-size: 1.4rem; }
    }
</style>

@php
    $confirmImagePath = public_path('storage/products/Recurso 9.png');
    $confirmImageAsset = file_exists($confirmImagePath)
        ? asset('storage/products/Recurso 9.png')
        : null;

    $pickupTime = $order->pickup_time ?? '11:00 - 12:00 pm';
    $paymentLabel = match($order->payment_method) {
        'transferencia' => 'Transferencia',
        'sucursal' => 'Pago en sucursal',
        default => ucfirst($order->payment_method),
    };
@endphp

<div class="grace-confirm-wrap">
    <div class="grace-confirm-card">
        <div class="grace-confirm-title">Horneando tu orden</div>

        <div class="grace-confirm-image-wrap">
            @if($confirmImageAsset)
                <img src="{{ $confirmImageAsset }}" alt="Orden confirmada" class="grace-confirm-image">
            @else
                <div class="display-1 text-secondary"><i class="bi bi-check-circle"></i></div>
            @endif
        </div>

        <div class="grace-confirm-subtitle">¡Ya casi está listo!</div>

        <div class="grace-confirm-ok">
            <i class="bi bi-check-circle-fill"></i>
            Tu orden ha sido confirmada
        </div>

        <div class="grace-confirm-pill">
            <span class="grace-confirm-pill-label">Pick-up</span>
            <span class="grace-confirm-pill-time">{{ $pickupTime }}</span>
        </div>

        <div class="grace-confirm-summary">
            <div class="grace-confirm-summary-title">Resumen del pedido #{{ $order->id }}</div>

            <div class="grace-confirm-grid">
                <div>
                    <div class="grace-confirm-label">Nombre</div>
                    <div class="grace-confirm-value">{{ $order->client_name }}</div>
                </div>
                <div>
                    <div class="grace-confirm-label">Teléfono</div>
                    <div class="grace-confirm-value">{{ $order->phone_number }}</div>
                </div>
                <div>
                    <div class="grace-confirm-label">Método de pago</div>
                    <div class="grace-confirm-value">{{ $paymentLabel }}</div>
                </div>
                <div>
                    <div class="grace-confirm-label">Fecha</div>
                    <div class="grace-confirm-value">{{ $order->created_at->format('d/m/Y h:i a') }}</div>
                </div>
                <div>
                    <div class="grace-confirm-label">Hora de recolección</div>
                    <div class="grace-confirm-value">{{ $pickupTime }}</div>
                </div>
                <div>
                    <div class="grace-confirm-label">Notas</div>
                    <div class="grace-confirm-value">{{ $order->notes ?: 'Sin notas adicionales' }}</div>
                </div>
            </div>

            <div class="grace-confirm-products">
                @foreach($order->orderProducts as $op)
                    @php
                        $lineTotal = $op->product->price * (1 - $op->product->discount / 100) * $op->quantity;
                    @endphp

                    <div class="grace-confirm-product">
                        <div>
                            <div class="grace-confirm-product-name">{{ $op->product->name }}</div>
                            <div class="grace-confirm-product-meta">
                                Cantidad: {{ $op->quantity }}
                                @if($op->specialIngredient)
                                    · Opción: {{ $op->specialIngredient->name }}
                                @endif
                            </div>
                        </div>

                        <div class="grace-confirm-product-price">
                            ${{ number_format($lineTotal, 2) }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="grace-confirm-total">
                <div class="grace-confirm-total-label">Total</div>
                <div class="grace-confirm-total-value">${{ number_format($order->total, 2) }}</div>
            </div>
        </div>

        <div class="grace-confirm-actions">
            <a href="{{ route('home') }}" class="grace-confirm-btn grace-confirm-btn-primary">
                <i class="bi bi-shop"></i>
                Volver al catálogo
            </a>

            @if(Route::has('history'))
                <a href="{{ route('history') }}" class="grace-confirm-btn grace-confirm-btn-secondary">
                    <i class="bi bi-clock-history"></i>
                    Ver mis pedidos
                </a>
            @endif
        </div>
    </div>
</div>
@endsection