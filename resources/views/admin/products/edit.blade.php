@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('admin.products') }}" class="btn btn-sm btn-outline-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h2 class="fw-bold mb-0">Editar Producto</h2>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @php
                        $selectedIngredients = old('ingredients', $product->productIngredients->pluck('ingredient_id')->all());
                    @endphp

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Nombre *</label>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $product->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Categoría *</label>
                            <select name="category_id"
                                    class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">-- Seleccionar --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ (string) old('category_id', $product->category_id) === (string) $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Descripción *</label>
                            <textarea name="description" rows="3"
                                      class="form-control @error('description') is-invalid @enderror"
                                      required>{{ old('description', $product->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Precio (₡) *</label>
                            <input type="number" name="price" step="0.01" min="0"
                                   class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price', $product->price) }}" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Descuento (%)</label>
                            <input type="number" name="discount" min="0" max="100"
                                   class="form-control @error('discount') is-invalid @enderror"
                                   value="{{ old('discount', $product->discount) }}">
                            @error('discount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Imagen</label>
                            @if($product->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="rounded"
                                         style="width:96px;height:96px;object-fit:cover;">
                                </div>
                            @endif
                            <input type="file" name="image" accept="image/*"
                                   class="form-control @error('image') is-invalid @enderror">
                            <div class="form-text">Deja vacío para conservar la imagen actual.</div>
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        @if($regularIngredients->isNotEmpty() || $specialIngredients->isNotEmpty())
                            <div class="col-12">
                                <label class="form-label fw-semibold">Ingredientes</label>

                                @if($regularIngredients->isNotEmpty())
                                    <div class="mb-3">
                                        <div class="small text-muted text-uppercase fw-semibold mb-2">Ingredientes informativos</div>
                                        <div class="row row-cols-2 row-cols-md-3 g-2">
                                            @foreach($regularIngredients as $ing)
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                               name="ingredients[]"
                                                               value="{{ $ing->id }}"
                                                               id="ing_{{ $ing->id }}"
                                                               {{ in_array($ing->id, $selectedIngredients) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="ing_{{ $ing->id }}">
                                                            {{ $ing->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if($specialIngredients->isNotEmpty())
                                    <div class="rounded border p-3 bg-light-subtle">
                                        <div class="small text-muted text-uppercase fw-semibold mb-2">Opciones especiales del cliente</div>
                                        <div class="row row-cols-2 row-cols-md-3 g-2">
                                            @foreach($specialIngredients as $ing)
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                               name="ingredients[]"
                                                               value="{{ $ing->id }}"
                                                               id="ing_{{ $ing->id }}_special"
                                                               {{ in_array($ing->id, $selectedIngredients) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="ing_{{ $ing->id }}_special">
                                                            {{ $ing->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="form-text mb-0">
                                            Si marcas varias, el cliente podrá elegir una en el modal del carrito.
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-floppy"></i> Guardar Cambios
                        </button>
                        <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection