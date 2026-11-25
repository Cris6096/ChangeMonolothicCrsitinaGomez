@extends('layouts.public')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <h2 class="mb-4 text-center">Iniciar sesión</h2>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           required autofocus autocomplete="username">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           required autocomplete="current-password">
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember me -->
                <div class="form-check mb-3">
                    <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
                    <label for="remember_me" class="form-check-label">Recordarme</label>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    @if (Route::has('password.request'))
                        <a class="link-danger small" href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                    <button type="submit" class="btn btn-danger">Entrar</button>
                </div>
            </form>

            <p class="text-center mt-4 mb-0">
                ¿No tienes cuenta?
                <a class="link-danger" href="{{ route('register') }}">Regístrate</a>
            </p>
        </div>
    </div>
@endsection
