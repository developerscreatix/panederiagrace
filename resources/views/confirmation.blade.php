@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">

        <div class="text-center mb-4">
            <div class="display-1 text-success"><i class="bi bi-check-circle-fill"></i></div>
            <h2 class="fw-bold mt-2">¡Pedido Confirmado!</h2>
            <p class="text-muted">Tu pedido fue recibido correctamente.</p>
        </div>

        <div class="card mb-3">
            <div class="card-header fw-bold">Resumen del Pedido #{{ $order->id }}</div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Cant.</th>
                            <th class="text-end">Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderProducts as $op)
                            <tr>
                                <td>{{ $op->product->name }}</td>
                                <td class="text-center">{{ $op->quantity }}</td>
                                <td class="text-end">
                                    ${{ number_format($op->product->price * (1 - $op->product->discount / 100) * $op->quantity, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="fw-bold">
                        <tr>
                            <td colspan="2">Total</td>
                            <td class="text-end">${{ number_format($order->total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header fw-bold">Datos del Cliente</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Nombre</dt>
                    <dd class="col-sm-8">{{ $order->client_name }}</dd>

                    <dt class="col-sm-4">Teléfono</dt>
                    <dd class="col-sm-8">{{ $order->phone_number }}</dd>

                    <dt class="col-sm-4">Método de pago</dt>
                    <dd class="col-sm-8 text-capitalize">{{ $order->payment_method }}</dd>

                    <dt class="col-sm-4">Fecha</dt>
                    <dd class="col-sm-8">{{ $order->created_at->format('d/m/Y H:i') }}</dd>
                </dl>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Volver al catálogo
            </a>
        </div>

    </div>
</div>
@endsection
