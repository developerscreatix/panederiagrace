@extends('layouts.app')

@section('content')
<h2 class="fw-bold mb-4"><i class="bi bi-clock-history"></i> Historial de Órdenes</h2>

@if($orders->isEmpty())
    <div class="alert alert-info">No hay órdenes completadas aún.</div>
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Teléfono</th>
                    <th>Pago</th>
                    <th>Productos</th>
                    <th class="text-end">Total</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->client_name }}</td>
                        <td>{{ $order->phone_number }}</td>
                        <td class="text-capitalize">{{ $order->payment_method }}</td>
                        <td>
                            <small>
                                @foreach($order->orderProducts as $op)
                                    {{ $op->product->name }} ×{{ $op->quantity }}
                                    @if($op->specialIngredient)
                                        <span class="text-muted">({{ $op->specialIngredient->name }})</span>
                                    @endif
                                    <br>
                                @endforeach
                            </small>
                        </td>
                        <td class="text-end fw-bold">${{ number_format($order->total, 2) }}</td>
                        <td>{{ $order->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
