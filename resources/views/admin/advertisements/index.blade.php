@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0"><i class="bi bi-images"></i> Publicidad</h2>
    <a href="{{ route('admin') }}" class="btn btn-sm btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Administración
    </a>
</div>

{{-- Upload form --}}
<div class="card mb-4">
    <div class="card-header fw-bold">Agregar Imagen</div>
    <div class="card-body p-4">
        <form action="{{ route('admin.advertisements.store') }}" method="POST" enctype="multipart/form-data"
              class="row g-3 align-items-end">
            @csrf

            <div class="col-sm-5">
                <label class="form-label fw-semibold">Nombre / Descripción *</label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}"
                       placeholder="Ej. Promo de verano"
                       required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-sm-5">
                <label class="form-label fw-semibold">Imagen *</label>
                <input type="file" name="image" accept="image/*"
                       class="form-control @error('image') is-invalid @enderror"
                       required>
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="col-sm-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-plus-circle"></i> Agregar
                </button>
            </div>
        </form>
    </div>
</div>

{{-- List --}}
@if($advertisements->isEmpty())
    <div class="alert alert-info">
        No hay imágenes de publicidad. Agrega una arriba para que aparezca en el carrusel del inicio.
    </div>
@else
    <div class="row g-3">
        @foreach($advertisements as $ad)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100">
                    <img src="{{ asset('storage/' . $ad->image) }}"
                         class="card-img-top"
                         alt="{{ $ad->name }}"
                         style="height:140px;object-fit:cover;">
                    <div class="card-body p-2 d-flex align-items-center justify-content-between gap-2">
                        <span class="small fw-semibold text-truncate">{{ $ad->name }}</span>
                        <form action="{{ route('admin.advertisements.destroy', $ad) }}"
                              method="POST"
                              onsubmit="return confirm('¿Eliminar esta imagen de publicidad?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
