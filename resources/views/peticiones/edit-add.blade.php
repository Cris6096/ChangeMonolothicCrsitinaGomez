@php
    $editando = isset($peticione) && $peticione->exists;
@endphp
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Change.org - {{ $editando ? 'Editar petición' : 'Empezar una petición' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
    <link href="{{ asset('estilos.css') }}" rel="stylesheet">
</head>
<body class="fondo-crear">
<div class="marco-crear">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg bg-white border-bottom">
        <div class="container">
            <a class="logo" href="{{ route('pages.home') }}">change.org</a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav me-auto ms-lg-4">
                    <li class="nav-item"><a class="nav-link fw-bold" href="#">Programa de socios/as</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold" href="#">Buscar</a></li>
                    @guest
                        <li class="nav-item"><a class="nav-link fw-bold" href="{{ route('login') }}">Entra o regístrate</a></li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- CREACION / EDICION DE PETICION -->
    <main class="container my-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="formPeticion" method="POST" enctype="multipart/form-data"
              action="{{ $editando ? route('peticiones.update', $peticione->id) : route('peticiones.store') }}">
            @csrf
            @if ($editando)
                @method('PUT')
            @endif

            <section id="pasoFormulario" aria-label="Detalles de la petición">
                <div class="cabecera-negra">
                    <div class="row">
                        <div class="col-12 col-lg-8 offset-lg-2">
                            <div class="linea-roja"></div>
                            <label for="titulo" class="text-white small mb-1">Título</label>
                            <textarea class="form-control campo-titulo" id="titulo" name="titulo" placeholder="Tu título único" required>{{ old('titulo', $peticione->titulo ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="bloque-blanco">
                    <div class="row">
                        <div class="col-12 col-lg-8 offset-lg-2">
                            <div class="d-flex gap-2 mb-4">
                                <div class="d-flex gap-2 mb-4">
                                    <button type="button" class="btn btn-outline-secondary fw-bold flex-fill flex-md-grow-0" disabled><i class="bi bi-image"></i> Crear imagen</button>
                                    <input type="file" id="file" name="file" accept="image/*" class="d-none">
                                    <button type="button" id="botonFoto" class="btn btn-outline-dark fw-bold flex-fill flex-md-grow-0"><i class="bi bi-upload"></i> Usar mi foto</button>
                                    <small id="nombreArchivo" class="text-muted align-self-center"></small>
                                </div>
                            </div>
                            <h2 class="fw-bold">La causa</h2>
                            <label for="causa" class="visually-hidden">Describe la causa de tu petición</label>
                            <textarea class="form-control" id="causa" name="descripcion" rows="8" placeholder="Explica por qué es importante esta petición..." required>{{ old('descripcion', $peticione->descripcion ?? '') }}</textarea>

                            <label for="destinatario" class="form-label fw-bold mt-4">Destinatario</label>
                            <input type="text" class="form-control" id="destinatario" name="destinatario" value="{{ old('destinatario', $peticione->destinatario ?? '') }}" required>

                            <label for="categoria_id" class="form-label fw-bold mt-4">Tema</label>
                            <select class="form-select" id="categoria_id" name="categoria_id" required>
                                <option value="" disabled @selected(!old('categoria_id', $peticione->categoria_id ?? null))>Elige un tema</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}" @selected(old('categoria_id', $peticione->categoria_id ?? null) == $categoria->id)>{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </section>

            <section id="pasoAlcance" class="d-none" aria-labelledby="tituloAlcance" aria-hidden="true">
                <h1 id="tituloAlcance" class="titulo-crear mb-4">Por último, ¿cuál es el alcance de tu petición?</h1>
                <fieldset>
                    <legend class="visually-hidden">Elige el alcance</legend>
                    <div class="row g-3">
                        <div class="col-4">
                            <label class="card opcion-alcance h-100">
                                <input class="form-check-input" type="radio" name="alcance" value="local" required>
                                <i class="bi bi-house-door fs-3" aria-hidden="true"></i>
                                <span class="fw-bold">Local</span>
                            </label>
                        </div>
                        <div class="col-4">
                            <label class="card opcion-alcance h-100">
                                <input class="form-check-input" type="radio" name="alcance" value="nacional" required>
                                <i class="bi bi-bank fs-3" aria-hidden="true"></i>
                                <span class="fw-bold">Nacional</span>
                            </label>
                        </div>
                        <div class="col-4">
                            <label class="card opcion-alcance h-100">
                                <input class="form-check-input" type="radio" name="alcance" value="global" required>
                                <i class="bi bi-globe fs-3" aria-hidden="true"></i>
                                <span class="fw-bold">Global</span>
                            </label>
                        </div>
                    </div>
                </fieldset>
            </section>

            <section id="pasoResumen" class="d-none" aria-labelledby="tituloResumen" aria-hidden="true">
                <h1 id="tituloResumen" class="titulo-crear mb-4">Ya puedes guardar y compartir tu petición</h1>
                <p class="fs-5">Esto es lo que sigue:</p>
                <ol class="lista-resumen">
                    <li><span class="numero-resumen" aria-hidden="true">1</span><span>Inicia sesión para guardar tu petición</span></li>
                    <li><span class="numero-resumen" aria-hidden="true">2</span><span>Completa tu petición (puedes editarla en cualquier momento)</span></li>
                    <li><span class="numero-resumen" aria-hidden="true">3</span><span>Compártela con tus conocidos o con comunidades en línea</span></li>
                </ol>
                <div class="aviso-resumen">
                    <i class="bi bi-graph-up-arrow fs-4" aria-hidden="true"></i>
                    <p class="mb-0">Tu petición será visible en Change.org una vez que alcance las 5 firmas.</p>
                </div>
            </section>
        </form>
    </main>

    <!-- AVISO DE BORRADOR -->
    <div class="banner-borrador">
        <div class="container">
            <p class="mb-2">
                <i class="bi bi-hand-index me-2"></i>
                <b>Este es un borrador sin guardar</b><br class="d-md-none">
                <span class="ms-md-2">¡Continúa para publicar y compartir!</span>
            </p>
            <a href="#" class="btn btn-outline-light btn-sm fw-bold ms-md-4">Vista previa de mi petición</a>
        </div>
    </div>

    <!-- BARRA FIJA: Volver / Continuar -->
    <div class="barra-acciones sticky-bottom">
        <div class="container d-flex justify-content-end gap-2 py-3">
            <a id="volverInicio" href="{{ route('pages.home') }}" class="btn btn-outline-dark fw-bold px-4">Volver</a>
            <button id="volverPaso" type="button" class="btn btn-outline-dark fw-bold px-4 d-none">Volver</button>
            <button id="continuarAlcance" type="button" class="btn boton-continuar fw-bold px-4">Continuar</button>
            <button id="continuarResumen" type="button" class="btn boton-continuar fw-bold px-4 d-none">Continuar</button>
            <button id="crearPeticion" type="button" class="btn boton-continuar fw-bold px-4 d-none">{{ $editando ? 'Guardar cambios' : 'Crear petición' }}</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const formPeticion = document.getElementById('formPeticion');
    const pasos = [
        document.getElementById('pasoFormulario'),
        document.getElementById('pasoAlcance'),
        document.getElementById('pasoResumen')
    ];
    const bannerBorrador = document.querySelector('.banner-borrador');
    const volverInicio = document.getElementById('volverInicio');
    const volverPaso = document.getElementById('volverPaso');
    const continuarAlcance = document.getElementById('continuarAlcance');
    const continuarResumen = document.getElementById('continuarResumen');
    const crearPeticion = document.getElementById('crearPeticion');
    let pasoActual = 0;

    // Archivo
    const editando = @json($editando);
    const inputFile = document.getElementById('file');
    const nombreArchivo = document.getElementById('nombreArchivo');

    document.getElementById('botonFoto').addEventListener('click', () => inputFile.click());

    inputFile.addEventListener('change', () => {
        nombreArchivo.textContent = inputFile.files.length ? inputFile.files[0].name : '';
        nombreArchivo.classList.remove('text-danger');
    });

    const mostrarPaso = (indice) => {
        pasoActual = indice;
        pasos.forEach((paso, posicion) => {
            const esVisible = posicion === pasoActual;
            paso.classList.toggle('d-none', !esVisible);
            paso.setAttribute('aria-hidden', String(!esVisible));
        });

        bannerBorrador.classList.toggle('d-none', pasoActual !== 0);
        volverInicio.classList.toggle('d-none', pasoActual !== 0);
        volverPaso.classList.toggle('d-none', pasoActual === 0);
        continuarAlcance.classList.toggle('d-none', pasoActual !== 0);
        continuarResumen.classList.toggle('d-none', pasoActual !== 1);
        crearPeticion.classList.toggle('d-none', pasoActual !== 2);
    };

    continuarAlcance.addEventListener('click', () => {
        const camposIniciales = [
            document.getElementById('titulo'),
            document.getElementById('causa'),
            document.getElementById('destinatario'),
            document.getElementById('categoria_id')
        ];
        const formularioValido = camposIniciales.every((campo) => campo.reportValidity());


        if (formularioValido && !editando && !inputFile.files.length) {
            nombreArchivo.textContent = 'Selecciona una imagen';
            nombreArchivo.classList.add('text-danger');
            return;
        }

        if (formularioValido) {
            mostrarPaso(1);
        }
    });

    continuarResumen.addEventListener('click', () => {
        const alcance = formPeticion.querySelector('input[name="alcance"]:checked');
        if (!alcance && !editando) {
            formPeticion.querySelector('input[name="alcance"]').reportValidity();
            return;
        }

        mostrarPaso(2);
    });

    volverPaso.addEventListener('click', () => {
        mostrarPaso(pasoActual - 1);
    });

    crearPeticion.addEventListener('click', () => {
        formPeticion.submit();
    });

    formPeticion.querySelectorAll('input[name="alcance"]').forEach((opcion) => {
        opcion.addEventListener('change', () => {
            formPeticion.querySelectorAll('.opcion-alcance').forEach((tarjeta) => {
                tarjeta.classList.toggle('seleccionada', tarjeta.querySelector('input').checked);
            });
        });
    });
</script>
</body>
</html>
