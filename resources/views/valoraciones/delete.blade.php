@extends('layouts.privado')

@section('contenido_privado')

<section class="catalog-panel">
    <div class="catalog-header">
        <div>
            <p class="eyebrow">Confirmar eliminación</p>
            <h1>Eliminar valoración</h1>

            <p class="page-description">
                Revisa los datos antes de eliminar esta valoración. Esta acción no se puede deshacer.
            </p>
        </div>

        <div class="catalog-stats">
            <article class="mini-stat">
                <span class="mini-stat-value">{{ $valoracion->valoracion }} / 5</span>
                <span class="mini-stat-label">Tu puntuación</span>
            </article>
        </div>
    </div>

    <section class="section-card">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Película valorada</p>
                <h2>{{ $valoracion->peliculaRelacion->titulo }}</h2>
            </div>
        </div>

        <div class="detail-grid">
            <p><strong>Director/a:</strong> {{ $valoracion->peliculaRelacion->direccion }}</p>
            <p><strong>Año:</strong> {{ $valoracion->peliculaRelacion->anio }}</p>
            <p><strong>Puntuación:</strong> {{ $valoracion->valoracion }} / 5</p>
            <p><strong>Comentario:</strong> {{ $valoracion->comentario }}</p>
        </div>
    </section>

    <section class="message-card message-error">
        <p class="eyebrow">Acción irreversible</p>
        <h2>¿Quieres eliminar esta valoración?</h2>

        <p class="message-text">
            Si eliminas esta valoración, desaparecerá de tu zona privada y la película volverá a estar disponible para valorarla de nuevo.
        </p>

        <div class="actions-row">
            <form action="{{ route('valoraciones.destroy', $valoracion->id) }}" method="POST" class="inline-form">
                @csrf

                <button type="submit" class="btn btn-danger">
                    Sí, eliminar valoración
                </button>
            </form>

            <a href="{{ route('valoraciones.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </div>
    </section>
</section>

@endsection