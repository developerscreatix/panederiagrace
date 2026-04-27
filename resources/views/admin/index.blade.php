@extends('layouts.app')

@section('content')
<h2 class="fw-bold mb-4"><i class="bi bi-gear"></i> Administración</h2>

<div class="row g-4">
    <div class="col-sm-6 col-md-4">
        <a href="{{ route('admin.products') }}" class="text-decoration-none">
            <div class="card text-center p-4 h-100">
                <div class="fs-1 mb-2" style="color:#5c3d1e;"><i class="bi bi-box-seam"></i></div>
                <h5 class="fw-bold mb-1">Productos</h5>
                <p class="text-muted small mb-0">Ver, agregar o eliminar productos del catálogo.</p>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-md-4">
        <a href="{{ route('admin.ingredients') }}" class="text-decoration-none">
            <div class="card text-center p-4 h-100">
                <div class="fs-1 mb-2 text-success"><i class="bi bi-flower1"></i></div>
                <h5 class="fw-bold mb-1">Ingredientes</h5>
                <p class="text-muted small mb-0">Gestionar los ingredientes disponibles.</p>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-md-4">
        <a href="{{ route('admin.advertisements') }}" class="text-decoration-none">
            <div class="card text-center p-4 h-100">
                <div class="fs-1 mb-2 text-warning"><i class="bi bi-images"></i></div>
                <h5 class="fw-bold mb-1">Publicidad</h5>
                <p class="text-muted small mb-0">Gestionar las imágenes del carrusel en inicio.</p>
            </div>
        </a>
    </div>
</div>
@endsection
