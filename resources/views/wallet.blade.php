@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0"><i class="bi bi-wallet2"></i> Cartera</h2>
    <span class="text-muted">{{ now()->format('d/m/Y') }}</span>
</div>

{{-- Summary card --}}
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="card text-white" style="background:#5c3d1e;">
            <div class="card-body">
                <div class="small text-white-50">Órdenes del día</div>
                <div class="fs-3 fw-bold">{{ $orders->count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="small text-white-50">Ganancia total</div>
                <div class="fs-3 fw-bold">${{ number_format($total, 2) }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Orders table --}}
@if($orders->isEmpty())
    <div class="alert alert-info">No hay órdenes registradas hoy.</div>
@else
    <h5 class="fw-semibold mb-3">Órdenes del Día</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Teléfono</th>
                    <th>Pago</th>
                    <th>Estado</th>
                    <th class="text-end">Total</th>
                    <th>Hora</th>
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
                            @if($order->is_recieved)
                                <span class="badge bg-success">Completado</span>
                            @else
                                <span class="badge bg-warning text-dark">Pendiente</span>
                            @endif
                        </td>
                        <td class="text-end fw-bold">${{ number_format($order->total, 2) }}</td>
                        <td>{{ $order->created_at->format('H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
