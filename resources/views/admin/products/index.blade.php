@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0"><i class="bi bi-box-seam"></i> Productos</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle"></i> Agregar Producto
    </a>
</div>

@if($products->isEmpty())
    <div class="alert alert-info">No hay productos registrados. <a href="{{ route('admin.products.create') }}">Agregar uno</a>.</div>
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Descuento</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     style="width:50px;height:50px;object-fit:cover;border-radius:4px;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                     style="width:50px;height:50px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td><strong>{{ $product->name }}</strong><br>
                            <span class="text-muted small">{{ Str::limit($product->description, 60) }}</span>
                        </td>
                        <td>{{ $product->category->name }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>
                            @if($product->discount > 0)
                                <span class="badge bg-warning text-dark">{{ $product->discount }}%</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.products.destroy', $product) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Eliminar este producto?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

{{-- Add category inline --}}
<hr>
<h5 class="fw-semibold mb-3">Categorías</h5>
<form action="{{ route('admin.categories.store') }}" method="POST" class="d-flex gap-2 mb-3">
    @csrf
    <input type="text" name="name" class="form-control form-control-sm"
           placeholder="Nueva categoría..." required style="max-width:260px">
    <button class="btn btn-sm btn-outline-primary" type="submit">
        <i class="bi bi-plus"></i> Agregar
    </button>
</form>
@endsection
