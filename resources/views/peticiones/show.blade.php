@extends('layouts.public')

@section('title', $peticione->titulo . ' - Change.org')

@section('content')
    @php
        $porcentaje = min(100, ($peticione->firmantes / 300000) * 100);
        $url = urlencode(url()->current());

        $opiniones = [
            ['texto' => 'Yo sufrí violencia por mi pareja varios años hasta un día que los vecinos llamaron a la policía vino GC Y LOCAL entraron en la casa y yo estaba fuera porque ...', 'nombre' => 'Victoria', 'ciudad' => 'Las Palmas de Gran Canaria', 'likes' => 9, 'completo' => true],
            ['texto' => 'Yo sufro de violencia intrafamiliar y he buscado ayuda en el ayuntamiento y me han revictimizado, y la situación empeora cuando ven que soy negra,...', 'nombre' => 'Ysabel', 'ciudad' => 'Sevilla', 'likes' => 1, 'completo' => true],
            ['texto' => 'El gobierno tiene que hacer algo YA. No puede seguir existiendo esto, es muy triste leer comentarios de mujeres que han sufrido esto. Yo soy hija de una...', 'nombre' => 'Marta', 'ciudad' => 'Santander', 'likes' => 0, 'completo' => true],
            ['texto' => 'Me ha ATERRADO leer este testimonio... Y luego dicen que las mujeres “nos lo inventamos” y que “queremos beneficios”....', 'nombre' => 'Cristina', 'ciudad' => 'Madrid', 'likes' => 6, 'completo' => true],
            ['texto' => 'Yo también soy mujer de violencia de género.', 'nombre' => 'Maria nieves', 'ciudad' => 'Cruz grande 16 la rosa', 'likes' => 2, 'completo' => false],
        ];

        $victorias = [
            ['img' => 'victoria1.webp', 'alt' => 'Persona mayor en un cajero', 'titulo' => 'Tengo 78 años y me siento apartado por los bancos. ATENCIÓN HUMANA EN LAS OFICINAS BANCARIAS', 'firmas' => '647.516'],
            ['img' => 'victoria2.webp', 'alt' => 'Trastornos alimentarios', 'titulo' => 'URGENTE: Unidades Especializadas para los Trastornos de la Conducta Alimentaria', 'firmas' => '381.849'],
            ['img' => 'victoria3.webp', 'alt' => 'Madre e hija', 'titulo' => 'Mi madre se ha suicidado. Hoy lo harán 10 más. Teléfono público de prevención del suicidio', 'firmas' => '96.235'],
            ['img' => 'victoria4.webp', 'alt' => 'Ambulancia', 'titulo' => 'No habrá paz para los malvados. Para que los delitos sexuales contra menores no prescriban', 'firmas' => '566.799'],
        ];
    @endphp



    <!-- CABECERA DE LA PETICIÓN -->
    <header>
        <div class="hero-detalle">
            <img src="{{ $peticione->imagen_url }}" class="card-img-top" alt="{{ $peticione->titulo }}">
            <div class="hero-texto">
                <div class="linea-roja"></div>
                <h1>{{ $peticione->titulo }}</h1>
            </div>
        </div>
    </header>

    <div class="row">

        <!-- Formulario de firma -->
        <div class="col-12 col-lg-4 order-lg-last columna-firma">
            <div class="tarjeta-firma" id="firmar">
                <div class="text-center">
                    <span class="firmas-grandes">{{ number_format($peticione->firmantes, 0, ',', '.') }}</span>
                    <i class="bi bi-patch-check-fill text-primary align-top"></i>
                    <p class="mb-2">Firmas</p>
                    <div class="progress mb-2" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ $porcentaje }}%"></div>
                    </div>
                    <p class="small text-muted mb-3">de un objetivo de 300.000 firmas</p>
                </div>
                <hr>
                <h4 class="fw-bold mt-3">Firma esta petición</h4>

                @auth
                    <form method="POST" action="{{ route('peticiones.firmar', $peticione->id) }}">
                        @csrf
                        <label for="nombre" class="form-label small mt-2 mb-1">Nombre</label>
                        <input type="text" class="form-control mb-2" id="nombre" value="{{ Auth::user()->name }}" disabled>
                        <label for="correo" class="form-label small mb-1">Correo electrónico</label>
                        <input type="email" class="form-control mb-4" id="correo" value="{{ Auth::user()->email }}" disabled>

                        @if ($yaFirmada ?? false)
                            <button type="button" class="btn btn-secondary w-100 fw-bold fs-5" disabled>
                                <i class="bi bi-check-lg"></i> Ya has firmado
                            </button>
                        @else
                            <button type="submit" class="btn boton-firma w-100 fw-bold fs-5">
                                <i class="bi bi-pen"></i> Firma la petición
                            </button>
                        @endif
                        <p class="pequeno mt-3 mb-0">
                            Procesamos tus datos personales de acuerdo con nuestra
                            <a href="#" class="text-dark">Política de privacidad</a> y los
                            <a href="#" class="text-dark">Términos de uso</a>.
                        </p>
                    </form>
                @else
                    <p class="mt-3">Necesitas una cuenta para firmar esta petición.</p>
                    <a href="{{ route('login') }}" class="btn boton-firma w-100 fw-bold fs-5 mb-2">
                        <i class="bi bi-pen"></i> Entra para firmar
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-dark w-100 fw-bold">Crear cuenta</a>
                @endauth
            </div>
        </div>

        <!-- Contenido de la petición -->
        <div class="col-12 col-lg-8">

            <!-- Progreso -->
            <div class="border rounded p-3 mt-4">
                <div class="row align-items-center">
                    <div class="col-12 col-md-7 mb-3 mb-md-0">
                        <div class="caja-progreso">
                            <span class="badge rounded-pill bg-secondary mb-3">Progreso de la petición</span>
                            <p class="fs-5 mb-0">
                                <i class="bi bi-graph-up"></i>
                                Ganando impulso en {{ $peticione->categoria?->nombre ?? 'Sin categoría' }}
                            </p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <p class="mb-1 small">Compartidos</p>
                        <p class="fs-3 fw-bold mb-0">326</p>
                    </div>
                    <div class="col-6 col-md-2">
                        <p class="mb-1 small">Comentarios</p>
                        <p class="fs-3 fw-bold mb-0">17</p>
                    </div>
                </div>
            </div>

            <!-- Texto -->
            <h2 class="titulo-seccion mt-4 mb-4">El problema</h2>
            <p class="texto-peticion">{!! nl2br(e($peticione->descripcion)) !!}</p>
            <p class="texto-peticion">
                <b>Destinatario de la petición:</b> {{ $peticione->destinatario }}
            </p>

            <p class="small mt-4">
                <a href="#" class="text-dark"><i class="bi bi-flag"></i> Denunciar una violación de las políticas</a>
            </p>

            <!-- Creador -->
            <hr>
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-person-circle fs-1 text-secondary me-3"></i>
                    <div>
                        <p class="fs-5 mb-0">{{ $peticione->user?->name ?? 'Anónimo' }}</p>
                        <p class="text-muted mb-0">Creador de la petición</p>
                    </div>
                </div>
                <a href="#" class="btn btn-outline-dark fw-bold btn-sm mb-2">Consultas de medios de comunicación</a>
            </div>
            <hr>

            <!-- Actualizaciones -->
            <h2 class="titulo-seccion mt-4 mb-4">Actualizaciones de la petición</h2>

            @if ($peticione->firmantes > 0)
                <div class="actualizacion mb-3">
                    <span class="icono-azul"><i class="bi bi-pen"></i></span>
                    <div>
                        <p class="fs-5 mb-0">{{ number_format($peticione->firmantes, 0, ',', '.') }} firmantes</p>
                    </div>
                </div>
            @endif
            <div class="actualizacion mb-4">
                <span class="icono-azul"><i class="bi bi-pen"></i></span>
                <div>
                    <p class="fs-5 mb-0">{{ $peticione->user?->name ?? 'Alguien' }} ha lanzado esta petición</p>
                    <p class="small mb-0">{{ $peticione->created_at?->format('d/m/Y') }}</p>
                </div>
            </div>

            <!-- Compartir -->
            <h2 class="titulo-seccion mt-5 mb-4">Compartir esta petición</h2>
            <div class="row text-center small">
                <div class="col-3 mb-3">
                    <a href="#" class="compartir bg-light text-dark" id="copiarEnlace">
                        <i class="bi bi-link-45deg"></i>
                    </a>
                    <div id="textoCopiar">Copiar enlace</div>
                </div>
                <div class="col-3 mb-3">
                    <a href="https://wa.me/?text={{ $url }}" target="_blank" rel="noopener" class="compartir bg-success text-white"><i class="bi bi-whatsapp"></i></a>
                    <div>WhatsApp</div>
                </div>
                <div class="col-3 mb-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}" target="_blank" rel="noopener" class="compartir bg-primary text-white"><i class="bi bi-facebook"></i></a>
                    <div>Facebook</div>
                </div>
                <div class="col-3 mb-3">
                    <a href="https://twitter.com/intent/tweet?url={{ $url }}" target="_blank" rel="noopener" class="compartir bg-dark text-white"><i class="bi bi-twitter-x"></i></a>
                    <div>X</div>
                </div>
            </div>

            <hr class="mt-4">
            <p class="my-3">Petición creada el {{ $peticione->created_at?->format('d/m/Y') }}</p>
            <hr>

            <p class="mt-4 mb-2">
                <a href="{{ route('pages.home') }}" class="text-dark">Change.org</a>
                <i class="bi bi-chevron-right mx-2"></i>
                <a href="#" class="text-dark">Tema</a>
                <i class="bi bi-chevron-right mx-2"></i>
                <a href="#" class="text-dark">{{ $peticione->categoria?->nombre ?? 'Sin categoría' }}</a>
            </p>
            <p>{{ $peticione->titulo }}</p>
        </div>
    </div>

    <!-- OPINIONES DE FIRMANTES -->

    <section class="mt-5">
        <h2 class="titulo-seccion mb-4">Opiniones de firmantes</h2>
        <div class="row opiniones-carrusel" role="region"
             aria-label="Opiniones de firmantes; desliza horizontalmente para ver más" tabindex="0">

            @foreach ($opiniones as $o)
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="opinion">
                        <i class="bi bi-quote comillas"></i>
                        <p class="texto-peticion fst-italic mb-1">{{ $o['texto'] }}</p>
                        @if ($o['completo'])
                            <a href="#" class="text-dark d-block">Ver el texto completo</a>
                        @endif
                        <p class="text-end mt-2 mb-4"><b>{{ $o['nombre'] }},</b> <span class="small">{{ $o['ciudad'] }}</span></p>
                        <div class="mt-auto">
                            <i class="bi bi-heart fs-4"></i> <b>{{ $o['likes'] ?: '' }}</b>
                            <i class="bi bi-three-dots fs-4 ms-3"></i>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="opinion opinion-blanca text-center">
                    <img src="{{ asset('img/detalleFirmaLaCausa.webp') }}" class="img-fluid mb-3" style="max-width: 120px;" alt="Firma la causa">
                    <p>¡Firma la causa y comparte por qué te importa!</p>
                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <a href="#" class="btn btn-outline-dark fw-bold btn-lg">Consulta la opinión de todos los firmantes</a>
        </div>
    </section>

    <!-- OTRAS PETICIONES-->
    @if (!empty($otras) && $otras->count())
        <section class="mt-5" id="populares">
            <hr class="mb-4">
            <h2 class="h3 fw-bold mb-4">Peticiones patrocinadas por otros usuarios de Change.org</h2>
            <div class="row">
                @foreach ($otras as $otra)
                    <div class="col-12 col-md-6 col-lg-3 mb-4">
                        <div class="card h-100 tarjeta-pet">
                            <div class="position-relative">
                                <a href="{{ route('peticiones.show', $otra->id) }}">
                                    <img src="{{ $otra->imagen_url }}" class="card-img-top" alt="{{ $otra->titulo }}">
                                </a>
                                <a href="{{ route('peticiones.show', $otra->id) }}" class="flecha-card d-none d-md-flex">
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                            <div class="card-body">
                                <span class="patrocinada">Patrocinada por {{ $otra->user?->name }}</span>
                                <h5 class="titulo-pet mt-1">{{ $otra->titulo }}</h5>
                                <p class="firmas mb-0"><i class="bi bi-pen"></i> {{ $otra->firmantes }} firmas</p>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <a href="{{ route('peticiones.show', $otra->id) }}"
                                   class="btn btn-outline-secondary text-dark fw-bold w-100">Firma esta petición</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- VICTORIAS -->
    <section class="mt-4">
        <hr class="mb-4">
        <h2 class="titulo-seccion mb-4">Victorias</h2>
        <div class="row">
            @foreach ($victorias as $v)
                <div class="col-12 col-md-6 col-lg-3 mb-4">
                    <div class="card h-100 tarjeta-pet">
                        <div class="position-relative">
                            <a href="#"><img src="{{ asset('img/' . $v['img']) }}" class="card-img-top" alt="{{ $v['alt'] }}"></a>
                            <span class="badge rounded-pill bg-dark position-absolute top-0 start-0 m-2">Victoria</span>
                            <a href="#" class="flecha-card d-none d-md-flex"><i class="bi bi-arrow-right"></i></a>
                        </div>
                        <div class="card-body">
                            <h5 class="titulo-pet">{{ $v['titulo'] }}</h5>
                            <p class="firmas mb-0"><i class="bi bi-pen"></i> {{ $v['firmas'] }} firmas</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- BARRA FIJA DE FIRMA (solo en móvil) -->
    <div id="barraFirma" class="barra-firma">
        <a href="#firmar" class="btn boton-apoyar w-100 mb-2"><i class="bi bi-hand-thumbs-up"></i> Apoyar ahora</a>
        <a href="#firmar" class="btn boton-firma w-100 fw-bold fs-5"><i class="bi bi-pen"></i> Firma la petición</a>
    </div>

    <script>
        // Barra de firma: aparece cuando la tarjeta de firma sale por arriba
        var barra = document.getElementById("barraFirma");
        var tarjeta = document.getElementById("firmar");
        var populares = document.getElementById("populares");

        function actualizarBarraFirma() {
            var tarjetaFuera = tarjeta.getBoundingClientRect().bottom < 0;
            var llegadoAPopulares = populares && populares.getBoundingClientRect().top < window.innerHeight;

            if (tarjetaFuera && !llegadoAPopulares) {
                barra.classList.add("visible");
            } else {
                barra.classList.remove("visible");
            }
        }

        window.addEventListener("scroll", actualizarBarraFirma);
        window.addEventListener("resize", actualizarBarraFirma);
        actualizarBarraFirma();

        document.getElementById("copiarEnlace").addEventListener("click", function (e) {
            e.preventDefault();
            navigator.clipboard.writeText(window.location.href);
            var texto = document.getElementById("textoCopiar");
            texto.textContent = "¡Copiado!";
            setTimeout(function () { texto.textContent = "Copiar enlace"; }, 2000);
        });
    </script>
@endsection
