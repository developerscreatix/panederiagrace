@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0"><i class="bi bi-flower1"></i> Ingredientes</h2>
    <a href="{{ route('admin.ingredients.create') }}" class="btn btn-primary btn-sm">
        <i class="bi bi-plus-circle"></i> Agregar Ingrediente
    </a>
</div>

@if($ingredients->isEmpty())
    <div class="alert alert-info">
        No hay ingredientes registrados. <a href="{{ route('admin.ingredients.create') }}">Agregar uno</a>.
    </div>
@else
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($ingredients as $ingredient)
                    <tr>
                        <td>{{ $ingredient->id }}</td>
                        <td>{{ $ingredient->name }}</td>
                        <td class="text-end">
                            <form action="{{ route('admin.ingredients.destroy', $ingredient) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Eliminar este ingrediente?')">
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
@endsection
