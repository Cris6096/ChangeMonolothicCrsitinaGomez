<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Change.org - Peticiones')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
    <link href="{{ asset('estilos.css') }}" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100 @yield('body_class')">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-white border-bottom">
    <div class="container">
        <a class="logo" href="{{ route('pages.home') }}">change.org</a>

        <div class="ms-auto d-flex align-items-center d-lg-none">
            <a href="{{ route('peticiones.create') }}" class="btn btn-outline-dark fw-bold me-2">Inicia una petición</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Mostrar navegación">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>


        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto ms-lg-4">
                <li class="nav-item"><a class="nav-link fw-bold" href="{{ route('peticiones.index') }}">Peticiones</a></li>
                @auth
                    <li class="nav-item"><a class="nav-link fw-bold" href="{{ route('peticiones.mine') }}">Mis peticiones</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold" href="{{ route('users.firmas') }}">Mis firmas</a></li>
                @endauth
                <li class="nav-item"><a class="nav-link fw-bold" href="#">Programa de socios/as</a></li>
                <li class="nav-item"><a class="nav-link fw-bold" href="#">Buscar</a></li>
                @guest
                    <li class="nav-item d-lg-none"><a class="nav-link fw-bold" href="{{ route('login') }}">Entra o regístrate</a></li>
                @endguest
            </ul>

            <a href="{{ route('peticiones.create') }}" class="btn btn-outline-dark fw-bold d-none d-lg-block">Inicia una petición</a>

            @auth
                <div class="dropdown ms-lg-4">
                    <a class="nav-link dropdown-toggle fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Editar perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="nav-link fw-bold d-none d-lg-block ms-4">Entrar</a>
            @endauth
        </div>
    </div>
</nav>

<main class="@yield('main_class', 'container my-4') flex-grow-1">
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
</main>

<!-- FOOTER -->
<footer class="pie">
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-6 col-sm-4 col-lg mb-4">
                <h6 class="fw-bold">Participa</h6>
                <p><a href="{{ route('peticiones.create') }}">Inicia una petición</a></p>
                <p><a href="{{ route('peticiones.index') }}">Busca por tema</a></p>
                <p><a href="{{ route('peticiones.index') }}">Busca peticiones</a></p>

            </div>
            <div class="col-6 col-sm-4 col-lg mb-4">
                <h6 class="fw-bold">Aprende</h6>
                <p><a href="#">Guías para peticiones</a></p>
                <p><a href="#">Crea tu petición</a></p>
                <p><a href="#">Reune firmas</a></p>
                <p><a href="#">Contacta a los medios</a></p>
                <p><a href="#">Involucra al destinatario de la petición</a></p>
            </div>
            <div class="col-6 col-sm-4 col-lg mb-4">
                <h6 class="fw-bold">Sobre nosotros</h6>
                <p><a href="#">Sobre Change.org</a></p>
                <p><a href="#">Visión</a></p>
                <p><a href="#">Equipo</a></p>
                <p><a href="#">Empleo</a></p>
                <p><a href="#">Prensa</a></p>
            </div>
            <div class="col-6 col-sm-4 col-lg mb-4">
                <h6 class="fw-bold">Ayuda y aspectos legales</h6>
                <p><a href="#">Centro de ayuda</a></p>
                <p><a href="#">Normas de la comunidad</a></p>
                <p><a href="#">Política de privacidad</a></p>
                <p><a href="#">Términos de uso</a></p>
                <p><a href="#">Política de cookies</a></p>
                <p><a href="#">Administra cookies</a></p>
            </div>
            <div class="col-6 col-sm-4 col-lg mb-4">
                <h6 class="fw-bold">Síguenos</h6>
                <p><a href="#">Instagram</a></p>
                <p><a href="#">X</a></p>
                <p><a href="#">Facebook</a></p>
                <p><a href="#">TikTok</a></p>
            </div>
        </div>

        <select class="form-select mb-4 d-md-none">
            <option>Español (España)</option>
            <option>English</option>
        </select>

        <hr>

        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="mb-3">
                <p class="fw-bold mb-1">© {{ date('Y') }}, Change.org, PBC</p>                <p class="small mb-0">Esta web está protegida por reCAPTCHA y por Google <a href="#" class="text-primary">Política de privacidad</a> y <a href="#" class="text-primary">Normas de uso</a>.</p>
            </div>
            <select class="form-select w-auto mb-3 d-none d-md-block">
                <option>Español (España)</option>
                <option>English</option>
            </select>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
