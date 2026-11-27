@extends('layouts.public')

@section('title', 'Change.org - Mis peticiones')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- CABECERA -->
    <header class="mt-2 text-md-center">
        <h1 class="titulo-peticiones">Mis peticiones</h1>
    </header>

    <!-- LISTADO -->
    <section class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 fw-bold mb-0">
                Tus peticiones
                @if ($peticiones->total())
                    <span class="text-muted fw-normal">({{ $peticiones->total() }})</span>
                @endif
            </h2>
        </div>

        <div class="row">
            @forelse ($peticiones as $peticion)
                <div class="col-12 col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 tarjeta-pet">
                        <div class="position-relative">
                            <a href="{{ route('peticiones.show', $peticion->id) }}">
                                <img src="{{ $peticion->imagen_url }}" class="card-img-top" alt="{{ $peticion->titulo }}">
                            </a>
                            <a href="{{ route('peticiones.show', $peticion->id) }}" class="flecha-card d-none d-md-flex">
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <span class="patrocinada">Creada por ti</span>
                            <h5 class="titulo-pet mt-1">{{ $peticion->titulo }}</h5>
                            <p class="text-muted small mb-2">{{ $peticion->categoria?->nombre }}</p>
                            <p class="firmas mb-0"><i class="bi bi-pen"></i> {{ $peticion->firmantes }} firmas</p>
                        </div>
                        <div class="card-footer bg-white border-0 d-flex gap-2">
                            <a href="{{ route('peticiones.show', $peticion->id) }}"
                               class="btn btn-outline-secondary text-dark fw-bold flex-fill">Ver</a>
                            <a href="{{ route('peticiones.edit', $peticion->id) }}"
                               class="btn btn-outline-secondary text-dark fw-bold flex-fill">Editar</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card tarjeta-explorar text-center py-5">
                        <i class="bi bi-inbox icono-explorar"></i>
                        <p class="fw-bold fs-5 mb-1">No tienes ninguna petición creada</p>
                        <p class="text-muted mb-4">Cuando inicies una, aparecerá aquí.</p>
                        <div>
                            <a href="{{ route('peticiones.create') }}" class="btn btn-outline-dark fw-bold">Inicia tu primera petición</a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center">
            {{ $peticiones->links() }}
        </div>
    </section>
@endsection
