@extends('layouts.app')

@section('content')
<h2 class="fw-bold mb-4"><i class="bi bi-person-circle"></i> Mi Cuenta</h2>

<div class="row g-4">

    {{-- Edit profile --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header fw-bold">Editar Perfil</div>
            <div class="card-body p-4">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre</label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', auth()->user()->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Correo electrónico</label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-floppy"></i> Guardar Cambios
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Change password --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header fw-bold">Cambiar Contraseña</div>
            <div class="card-body p-4">
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Contraseña actual</label>
                        <input type="password" name="current_password"
                               class="form-control @error('current_password') is-invalid @enderror"
                               required>
                        @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nueva contraseña</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required minlength="8">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Confirmar contraseña</label>
                        <input type="password" name="password_confirmation"
                               class="form-control" required minlength="8">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-key"></i> Actualizar Contraseña
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- User management — only for user id=1 --}}
    @if(auth()->id() === 1)
    <div class="col-12">
        <hr class="my-2">
        <h4 class="fw-bold mb-3"><i class="bi bi-people"></i> Gestión de Cuentas</h4>
    </div>

    {{-- Create user --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header fw-bold">Crear Nueva Cuenta</div>
            <div class="card-body p-4">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre</label>
                        <input type="text" name="name"
                               class="form-control @error('name', 'createUser') is-invalid @enderror"
                               value="{{ old('name') }}" required>
                        @error('name', 'createUser')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Correo electrónico</label>
                        <input type="email" name="email"
                               class="form-control @error('email', 'createUser') is-invalid @enderror"
                               value="{{ old('email') }}" required>
                        @error('email', 'createUser')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Contraseña</label>
                        <input type="password" name="password"
                               class="form-control @error('password', 'createUser') is-invalid @enderror"
                               required minlength="8">
                        @error('password', 'createUser')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Confirmar contraseña</label>
                        <input type="password" name="password_confirmation"
                               class="form-control" required minlength="8">
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-person-plus"></i> Crear Cuenta
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- List of users --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header fw-bold">Cuentas Existentes</div>
            <div class="card-body p-0">
                @if($users->isEmpty())
                    <p class="text-muted p-4 mb-0">No hay otras cuentas registradas.</p>
                @else
                    <ul class="list-group list-group-flush">
                        @foreach($users as $u)
                            <li class="list-group-item d-flex align-items-center justify-content-between gap-2 px-4 py-3">
                                <div>
                                    <div class="fw-semibold">{{ $u->name }}</div>
                                    <div class="text-muted small">{{ $u->email }}</div>
                                </div>
                                <form action="{{ route('users.destroy', $u) }}" method="POST"
                                      onsubmit="return confirm('¿Eliminar la cuenta de {{ $u->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
