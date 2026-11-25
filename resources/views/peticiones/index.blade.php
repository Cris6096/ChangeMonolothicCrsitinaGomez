@extends('layouts.public')

@section('title', 'Change.org - Peticiones')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- BUSCADOR -->
    <header class="mt-2 text-md-center">
        <h1 class="titulo-peticiones">{{ $titulo ?? 'Descubre tu próxima causa' }}</h1>
        <p class="fs-4 d-none d-md-block">Explora millones de peticiones y encuentra las que te interesan</p>

        <div class="row justify-content-md-center mt-4">
            <div class="col-12 col-md-9 col-lg-8">
                <form class="d-flex gap-2">
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-white border-dark border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control border-dark border-start-0" placeholder="Buscar peticiones">
                    </div>
                    <button type="button" class="btn boton-buscar fw-bold d-none d-md-block">Buscar</button>
                </form>
            </div>
        </div>
    </header>

    <!-- EXPLORAR -->
    <section class="mt-5">
        <h2 class="h4 fw-bold d-none d-md-block mb-4">Explorar</h2>
        <div class="row g-2 g-md-4">
            <div class="col-4">
                <a href="#" class="card tarjeta-explorar text-center text-decoration-none text-dark">
                    <i class="bi bi-map icono-explorar"></i>
                    <span class="fw-bold">Cerca de ti</span>
                </a>
            </div>
            <div class="col-4">
                <a href="#" class="card tarjeta-explorar text-center text-decoration-none text-dark">
                    <i class="bi bi-graph-up-arrow icono-explorar"></i>
                    <span class="fw-bold">Populares</span>
                </a>
            </div>
            <div class="col-4">
                <a href="#" class="card tarjeta-explorar text-center text-decoration-none text-dark">
                    <i class="bi bi-flag icono-explorar"></i>
                    <span class="fw-bold">Victorias</span>
                </a>
            </div>
        </div>
    </section>

    <!-- TEMAS (desde la tabla categorias) -->
    @if (!empty($categorias) && $categorias->count())
        <section class="mt-5">
            <h2 class="h4 fw-bold mb-3">Temas</h2>
            <div class="d-flex flex-wrap gap-2">
                @foreach ($categorias as $categoria)
                    <a href="#" class="tema">{{ $categoria->nombre }}</a>
                @endforeach
            </div>
        </section>
    @endif

    <!-- MIS PETICIONES -->
    <section class="mt-5">
        <h2 class="h4 fw-bold mb-4">Mis peticiones</h2>

        @auth
            <div class="row">
                @forelse ($misPeticiones as $miPeticion)
                    <div class="col-12 col-md-6 col-lg-3 mb-4">
                        <div class="card h-100 tarjeta-pet">
                            <a href="{{ route('peticiones.show', $miPeticion->id) }}">
                                {{-- Imagen provisional hasta tener el modelo File --}}
                                <img src="{{ asset('img/peticionPaliativos.webp') }}" class="card-img-top" alt="{{ $miPeticion->titulo }}">
                            </a>
                            <div class="card-body">
                                <h5 class="titulo-pet">{{ $miPeticion->titulo }}</h5>
                                <p class="text-muted small mb-2">{{ $miPeticion->categoria?->nombre }}</p>
                                <p class="firmas mb-0"><i class="bi bi-pen"></i> {{ $miPeticion->firmantes }} firmas</p>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <a href="{{ route('peticiones.show', $miPeticion->id) }}"
                                   class="btn btn-outline-secondary text-dark fw-bold w-100">Ver petición</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light border text-center">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            No tienes ninguna petición creada todavía.
                        </div>
                    </div>
                @endforelse
            </div>
        @else
            <div class="alert alert-light border text-center">
                Inicia sesión para ver tus peticiones.
            </div>
        @endauth
    </section>

    <!-- PETICIONES DE OTROS USUARIOS -->
    <section class="mt-5">
        <h2 class="h4 fw-bold mb-4">Peticiones patrocinadas por otros usuarios de Change.org</h2>
        <div class="row">
            @forelse ($peticiones as $peticion)
                <div class="col-12 col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 tarjeta-pet">
                        <div class="position-relative">
                            <a href="{{ route('peticiones.show', $peticion->id) }}">
                                {{-- Imagen provisional hasta tener el modelo File --}}
                                <img src="{{ asset('img/peticionPaliativos.webp') }}" class="card-img-top" alt="{{ $peticion->titulo }}">
                            </a>
                            <a href="{{ route('peticiones.show', $peticion->id) }}" class="flecha-card d-none d-md-flex">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <span class="patrocinada">Patrocinada por {{ $peticion->user?->name }}</span>
                            <h5 class="titulo-pet mt-1">{{ $peticion->titulo }}</h5>
                            <p class="text-muted small mb-2">{{ $peticion->categoria?->nombre }}</p>
                            <p class="firmas mb-0"><i class="bi bi-pen"></i> {{ $peticion->firmantes }} firmas</p>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <a href="{{ route('peticiones.show', $peticion->id) }}"
                               class="btn btn-outline-secondary text-dark fw-bold w-100">Firma esta petición</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Todavía no hay peticiones.</p>
            @endforelse
        </div>

        @if ($peticiones instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="d-flex justify-content-center">
                {{ $peticiones->links() }}
            </div>
        @endif
    </section>
@endsection
