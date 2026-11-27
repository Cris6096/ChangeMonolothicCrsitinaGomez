@extends('layouts.public')

@section('title', 'Página no encontrada - Change.org')

@section('content')
    <section class="text-center py-5">
        <i class="bi bi-compass fs-1 text-secondary"></i>
        <p class="fw-bold text-muted mt-3 mb-1">Error 404</p>
        <h1 class="titulo-peticiones">Esta página no existe</h1>
        <p class="fs-5 mb-4">La dirección que has escrito no existe o la petición ya no está disponible.</p>
        <a href="{{ route('peticiones.index') }}" class="btn btn-outline-dark fw-bold px-4 me-2 mb-2">Explorar peticiones</a>
        <a href="{{ route('pages.home') }}" class="btn boton-buscar fw-bold px-4 mb-2">Volver al inicio</a>
    </section>
@endsection
