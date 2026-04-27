@extends('layouts.app')

@section('content')
<h2 class="fw-bold mb-4"><i class="bi bi-clock"></i> Pedidos Pendientes</h2>

@if($orders->isEmpty())
    <div class="alert alert-info">No hay pedidos pendientes en este momento.</div>
@else
    <div class="row g-3">
        @foreach($orders as $order)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Pedido #{{ $order->id }}</span>
                        <span class="badge bg-warning text-dark">Pendiente</span>
                    </div>
                    <div class="card-body">
                        <p class="mb-1"><i class="bi bi-person"></i> <strong>{{ $order->client_name }}</strong></p>
                        <p class="mb-1"><i class="bi bi-telephone"></i> {{ $order->phone_number }}</p>
                        <p class="mb-2">
                            <i class="bi bi-credit-card"></i>
                            <span class="text-capitalize">{{ $order->payment_method }}</span>
                        </p>
                        <hr class="my-2">
                        <ul class="list-unstyled mb-2 small">
                            @foreach($order->orderProducts as $op)
                                <li>
                                    <i class="bi bi-dot"></i> {{ $op->product->name }} × {{ $op->quantity }}
                                    @if($op->specialIngredient)
                                        <span class="text-muted">({{ $op->specialIngredient->name }})</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        <p class="mb-0 fw-bold">Total: ${{ number_format($order->total, 2) }}</p>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex gap-2">
                            <form action="{{ route('order.status', $order) }}" method="POST" class="flex-fill">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm w-100">
                                    <i class="bi bi-check-circle"></i> Marcar como recibido
                                </button>
                            </form>

                            <form action="{{ route('order.disable', $order) }}" method="POST" class="flex-fill"
                                  onsubmit="return confirm('¿Deseas deshabilitar este pedido?');">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                    <i class="bi bi-trash"></i> Borrarlo
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
