@extends('layouts.public')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <h2 class="mb-4 text-center">Crear cuenta</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                           class="form-control @error('name') is-invalid @enderror"
                           required autofocus autocomplete="name">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           required autocomplete="username">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required autocomplete="new-password">
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           class="form-control @error('password_confirmation') is-invalid @enderror"
                           required autocomplete="new-password">
                    @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a class="link-danger small" href="{{ route('login') }}">¿Ya tienes cuenta?</a>
                    <button type="submit" class="btn btn-danger">Registrarme</button>
                </div>
            </form>
        </div>
    </div>
@endsection
