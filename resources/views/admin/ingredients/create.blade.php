@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('admin.ingredients') }}" class="btn btn-sm btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h2 class="fw-bold mb-0">Agregar Ingrediente</h2>
</div>

<div class="row justify-content-center">
    <div class="col-sm-8 col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('admin.ingredients.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre del ingrediente *</label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="Ej. Harina, Azúcar..."
                               autofocus required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-check mb-4">
                        <input type="hidden" name="is_special" value="0">
                        <input class="form-check-input" type="checkbox"
                               name="is_special"
                               value="1"
                               id="is_special"
                               {{ old('is_special') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_special">
                            Marcar como ingrediente especial seleccionable
                        </label>
                        <div class="form-text">
                            Úsalo para opciones como pan blanco o pan integral.
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-floppy"></i> Guardar
                        </button>
                        <a href="{{ route('admin.ingredients') }}" class="btn btn-outline-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
