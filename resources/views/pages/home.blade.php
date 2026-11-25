@extends('layouts.public')

@section('title', 'Change.org - El cambio comienza aquí')
@section('main_class', 'w-100')
@section('body_class', 'pagina-inicio')
@section('content')

    <!-- HERO -->
    <header class="hero text-center">
        <div class="container">
            <h1 class="titulo-hero">El cambio comienza aquí<span class="punto-rojo">.</span></h1>
            <p>Te ayudaremos a lograr el cambio que quieres ver.</p>

            <p class="fw-bold mt-4">Iniciar una petición para...</p>
            <div class="card caja-peticion mx-auto text-start shadow-sm">
                <div class="card-body">
                    <textarea class="form-control border-0" rows="3" placeholder="Es muy difícil moverse en silla de ruedas por Toledo"></textarea>
                    <div class="text-end">
                        <a href="{{ route('peticiones.create') }}" class="btn boton-amarillo rounded-circle"><i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <p class="mt-3">
                <a href="{{ route('peticiones.create') }}" class="text-dark">Ya tengo el borrador de mi petición <i class="bi bi-arrow-right"></i></a>
            </p>

            <!-- CARRUSEL -->
            <h2 class="h4 fw-bold mt-5 mb-4">Conoce a personas reales que están transformando sus comunidades.</h2>

            <div id="carrusel" class="carousel slide carrusel-personas mx-auto">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="persona-carrusel" data-caption="&quot;No podemos más. Stop guardias médicas de 24 horas&quot;">
                            <a href="#"><img src="{{ asset('img/imagenCarrusel2.webp') }}" class="circulo" alt="Persona 1"></a>
                            <div class="etiqueta"><span class="punto-rojo">●</span> <b>Trending!</b><br>100.875 firmas</div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="persona-carrusel" data-caption="Tiene cáncer de mama metastásico y ha logrado que financien su medicación">
                            <a href="#"><img src="{{ asset('img/imagenCarrusel1.webp') }}" class="circulo" alt="Persona 2"></a>
                            <div class="etiqueta"><span class="punto-rojo">●</span> <b>Trending!</b><br>204.522 firmas</div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="persona-carrusel" data-caption="Conseguido: sus padres con Alzheimer seguirán juntos en la misma residencia">
                            <a href="#"><img src="{{ asset('img/imagenCarrusel5.webp') }}" class="circulo" alt="Persona 3"></a>
                            <div class="etiqueta"><span class="punto-rojo">●</span> <b>Victory!</b><br>157.903 firmas</div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="persona-carrusel" data-caption="&quot;El asesino de mi hijo tenía 17 años. Pido revisar la Ley del Menor&quot;">
                            <a href="#"><img src="{{ asset('img/imagenCarrusel3.webp') }}" class="circulo" alt="Persona 4"></a>
                            <div class="etiqueta"><span class="punto-rojo">●</span> <b>Victory!</b><br>96.222 firmas</div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="persona-carrusel" data-caption="&quot;El calor nos mata - Soy barrendera y trabajo a 35°&quot;">
                            <a href="#"><img src="{{ asset('img/imagenCarrusel4.webp') }}" class="circulo" alt="Persona 5"></a>
                            <div class="etiqueta"><span class="punto-rojo">●</span> <b>Trending!</b><br>67.341 firmas</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="controles-carrusel d-flex justify-content-center align-items-center mt-4 d-md-none">
                <button class="btn flecha" data-bs-target="#carrusel" data-bs-slide="prev"><i class="bi bi-arrow-left"></i></button>
                <p id="texto-carrusel" class="mb-0 mx-2" aria-live="polite">&quot;No podemos más. Stop guardias médicas de 24 horas&quot;</p>
                <button class="btn flecha" data-bs-target="#carrusel" data-bs-slide="next"><i class="bi bi-arrow-right"></i></button>
            </div>
        </div>
    </header>

    <!-- USAR LA PLATAFORMA ES FÁCIL -->
    <section class="container text-center mt-5 pasos-section">
        <h2 class="fw-bold mb-4">Usar la plataforma de peticiones n.º 1 es fácil</h2>

        <div class="row">
            <div class="col-12 col-md-4 mb-4">
                <div class="paso">
                    <div class="numero">1</div>
                    <div class="paso-texto">
                        <h5 class="fw-bold">Crea una petición en dos minutos</h5>
                        <p class="text-muted small">Más de 2.000 nuevas cada día</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-4">
                <div class="paso">
                    <div class="numero">2</div>
                    <div class="paso-texto">
                        <h5 class="fw-bold">Consigue apoyo gracias a nuestra gran comunidad</h5>
                        <p class="text-muted small">Más de 500.000 firmas diarias</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-4">
                <div class="paso paso-ultimo">
                    <div class="numero">3</div>
                    <div class="paso-texto">
                        <h5 class="fw-bold">Llega hasta los responsables gracias a nuestra red</h5>
                        <p class="text-muted small">Más de 1.000 notificados a diario</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- ACORDEÓN -->
        <div class="accordion mx-auto text-start" id="guias" style="max-width: 460px;">
            <div class="accordion-item acordeon-azul">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#lista-guias">
                        Lee nuestros consejos y guías sobre cómo crear una petición
                    </button>
                </h2>
                <div id="lista-guias" class="accordion-collapse collapse" data-bs-parent="#guias">
                    <div class="accordion-body">
                        <a href="#" class="d-flex justify-content-between text-dark text-decoration-none py-2">Crea tu petición <i class="bi bi-arrow-right"></i></a>
                        <a href="#" class="d-flex justify-content-between text-dark text-decoration-none py-2">Reune firmas <i class="bi bi-arrow-right"></i></a>
                        <a href="#" class="d-flex justify-content-between text-dark text-decoration-none py-2">Contacta a los medios <i class="bi bi-arrow-right"></i></a>
                        <a href="#" class="d-flex justify-content-between text-dark text-decoration-none py-2">Involucra al destinatario de la petición <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- APOYA CAUSAS -->
    <section class="container mt-5 causas-section">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
            <div>
                <h2 class="fw-bold">Apoya causas que te importan</h2>
                <p>Encuentra peticiones que afecten a tu comunidad.</p>
            </div>
            <a href="{{ route('peticiones.index') }}" class="btn btn-outline-dark fw-bold mb-3">Ver todos los temas</a>
        </div>

        <div class="d-flex flex-wrap gap-2 mb-4 causas-temas">
            <a href="#" class="btn btn-outline-secondary text-dark fw-bold">Sanidad <i class="bi bi-arrow-right"></i></a>
            <a href="#" class="btn btn-outline-secondary text-dark fw-bold">Animales <i class="bi bi-arrow-right"></i></a>
            <a href="#" class="btn btn-outline-secondary text-dark fw-bold">Medio Ambiente <i class="bi bi-arrow-right"></i></a>
            <a href="#" class="btn btn-outline-secondary text-dark fw-bold">Educacion <i class="bi bi-arrow-right"></i></a>
            <a href="#" class="btn btn-outline-secondary text-dark fw-bold">Justicia Economica <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 col-lg-3 mb-4">
                <div class="tarjeta-causa">
                    <a href="{{ route('peticiones.index') }}"><img src="{{ asset('img/noticiaAdamuz.webp') }}" alt="Accidente de tren"></a>
                    <div class="texto-causa">
                        <div class="linea-roja"></div>
                        <h5><a href="{{ route('peticiones.index') }}" class="text-reset text-decoration-none">Exigimos justicia y seguridad en las líneas de tren</a></h5>
                        <p class="mb-0"><i class="bi bi-pencil"></i> 120.340 firmas</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-4">
                <div class="tarjeta-causa">
                    <a href="{{ route('peticiones.index') }}"><img src="{{ asset('img/noticiaHormonas.webp') }}" alt="Terapia hormonal"></a>
                    <div class="texto-causa">
                        <div class="linea-roja"></div>
                        <h5><a href="{{ route('peticiones.index') }}" class="text-reset text-decoration-none">No sin mi terapia hormonal</a></h5>
                        <p class="mb-0"><i class="bi bi-pencil"></i> 85.120 firmas</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-4">
                <div class="tarjeta-causa">
                    <a href="{{ route('peticiones.index') }}"><img src="{{ asset('img/noticiaAbuela.webp') }}" alt="Paciente en el hospital"></a>
                    <div class="texto-causa">
                        <div class="linea-roja"></div>
                        <h5><a href="{{ route('peticiones.index') }}" class="text-reset text-decoration-none">Tengo 94 años y llevo 3 meses ingresada. Pongan TV gratis en todos los hospitales</a></h5>
                        <p class="mb-0"><i class="bi bi-pencil"></i> 66.196 firmas</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-4">
                <div class="tarjeta-causa">
                    <a href="{{ route('peticiones.index') }}"><img src="{{ asset('img/noticiaAsesinato.webp') }}" alt="Joven"></a>
                    <div class="texto-causa">
                        <div class="linea-roja"></div>
                        <h5><a href="{{ route('peticiones.index') }}" class="text-reset text-decoration-none">El asesino de mi hijo tenía 17 años. Pido revisar YA la ley del menor para casos graves</a></h5>
                        <p class="mb-0"><i class="bi bi-pencil"></i> 100.875 firmas</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- IMPULSADO POR PERSONAS -->
    <section class="container mt-4 mb-5">
        <div class="bloque-gris">
            <div class="row align-items-center">
                <div class="col-12 col-md-6 p-5">
                    <h2 class="fw-bold">Impulsado por personas, no beneficios</h2>
                    <p>Independiente y propiedad de una organización sin ánimo de lucro. Financiada íntegramente por sus miembros en 196 países: sin anuncios, accionistas ni intereses particulares.</p>
                    <a href="#" class="btn btn-outline-dark fw-bold mb-3">Contribuir</a>
                </div>
                <div class="col-12 col-md-6">
                    <a href="#"><img src="{{ asset('img/impulsadoPor.webp') }}" class="img-fluid rounded" alt="Ilustración"></a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const carrusel = document.getElementById('carrusel');
        const textoCarrusel = document.getElementById('texto-carrusel');

        const actualizarCarrusel = (diapositiva) => {
            textoCarrusel.textContent = diapositiva.querySelector('.persona-carrusel').dataset.caption;
        };

        carrusel.addEventListener('click', (event) => {
            const enlace = event.target.closest('.persona-carrusel > a');
            if (enlace) {
                event.preventDefault();
            }
        });

        carrusel.addEventListener('slid.bs.carousel', (event) => {
            actualizarCarrusel(event.relatedTarget);
        });

        actualizarCarrusel(carrusel.querySelector('.carousel-item.active'));
    </script>
    @stack('scripts')
@endpush
