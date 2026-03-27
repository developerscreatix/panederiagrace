@extends('layouts.app')

@section('content')
<h2 class="fw-bold mb-4"><i class="bi bi-cart3"></i> Mi Carrito</h2>

@if(empty($cart))
    <div class="alert alert-info">
        Tu carrito está vacío. <a href="{{ route('home') }}">Ver catálogo</a>
    </div>
@else
    <div class="row g-4">
        {{-- Cart items --}}
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Precio</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $subtotal = 0; @endphp
                            @foreach($cart as $item)
                                @php
                                    $unitPrice = $item['price'] * (1 - ($item['discount'] / 100));
                                    $lineTotal = $unitPrice * $item['quantity'];
                                    $subtotal += $lineTotal;
                                @endphp
                                <tr>
                                    <td class="align-middle">
                                        {{ $item['name'] }}
                                        @if($item['discount'] > 0)
                                            <span class="badge bg-warning text-dark ms-1">-{{ $item['discount'] }}%</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">{{ $item['quantity'] }}</td>
                                    <td class="text-end align-middle">${{ number_format($lineTotal, 2) }}</td>
                                    <td class="text-end align-middle">
                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                            <button class="btn btn-sm btn-outline-danger" type="submit">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td colspan="2">Subtotal</td>
                                <td class="text-end">${{ number_format($subtotal, 2) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Order form --}}
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header fw-bold">Información de Pedido</div>
                <div class="card-body">
                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nombre</label>
                            <input type="text" name="client_name"
                                   class="form-control @error('client_name') is-invalid @enderror"
                                   value="{{ old('client_name') }}"
                                   placeholder="Tu nombre completo" required>
                            @error('client_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Teléfono</label>
                            <input type="tel" name="phone_number"
                                   class="form-control @error('phone_number') is-invalid @enderror"
                                   value="{{ old('phone_number') }}"
                                   placeholder="Ej. 8888-0000" required>
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Método de pago</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                           name="payment_method" id="payTransfer"
                                           value="transferencia"
                                           {{ old('payment_method') === 'transferencia' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="payTransfer">
                                        <i class="bi bi-bank"></i> Transferencia
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                           name="payment_method" id="payCash"
                                           value="efectivo"
                                           {{ old('payment_method') === 'efectivo' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="payCash">
                                        <i class="bi bi-cash"></i> Efectivo
                                    </label>
                                </div>
                            </div>
                            @error('payment_method')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-send"></i> Enviar Pedido
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
