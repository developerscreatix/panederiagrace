@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-sm-8 col-md-6 col-lg-4">

        <div class="card">
            <div class="card-header fw-bold text-center fs-5">
                <i class="bi bi-person-lock"></i> Iniciar Sesión
            </div>
            <div class="card-body p-4">

                @if($errors->any())
                    <div class="alert alert-danger py-2">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Correo electrónico</label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="correo@ejemplo.com"
                               autofocus required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Contraseña</label>
                        <input type="password" name="password"
                               class="form-control"
                               placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right"></i> Entrar
                    </button>
                </form>

            </div>
        </div>

        <p class="text-center mt-3 text-muted small">
            No se aceptan registros públicos.
        </p>

    </div>
</div>
@endsection
