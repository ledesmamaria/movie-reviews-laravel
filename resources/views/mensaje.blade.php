@extends(auth()->check() ? 'layouts.privado' : 'layouts.publico')

@section(auth()->check() ? 'contenido_privado' : 'contenido_principal')

@php
    $tipo = $tipo ?? 'info';
    $titulo = $titulo ?? 'Aviso';
    $subtitulo = $subtitulo ?? 'Información';

    $claseBoton = $tipo === 'error' ? 'btn-secondary' : 'btn-primary';
@endphp

<section class="catalog-panel">
    <section class="message-card message-{{ $tipo }}">
        <p class="eyebrow">{{ $subtitulo }}</p>

        <h1>{{ $titulo }}</h1>

        <p class="message-text">
            {{ $mensaje }}
        </p>

        <div class="actions-row">
            <a href="{{ route($ruta) }}" class="btn {{ $claseBoton }}">
                {{ $textoBoton }}
            </a>

            @auth
                <a href="{{ route('catalogo') }}" class="btn btn-secondary">
                    Ir al catálogo
                </a>
            @endauth
        </div>
    </section>
</section>

@endsection