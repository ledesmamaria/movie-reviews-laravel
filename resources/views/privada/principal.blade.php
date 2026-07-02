@extends('layouts.privado')

@section('contenido_privado')

@php
    $mediaPersonal = $recuento > 0 ? number_format($valoraciones->avg('valoracion'), 1) : '0.0';
    $ultimaValoracion = $recuento > 0 ? $valoraciones->first() : null;
@endphp

<section class="catalog-panel">
    <div class="catalog-header">
        <div>
            <p class="eyebrow">Área personal</p>
            <h1>Mis valoraciones</h1>

            <p class="page-description">
                Consulta tu actividad, revisa las películas que has puntuado y elimina valoraciones si quieres volver a realizarlas.
            </p>
        </div>

        <div class="catalog-stats">
            <article class="mini-stat">
                <span class="mini-stat-value">{{ $recuento }}</span>
                <span class="mini-stat-label">Valoraciones</span>
            </article>

            <article class="mini-stat">
                <span class="mini-stat-value">{{ $mediaPersonal }}</span>
                <span class="mini-stat-label">Media personal</span>
            </article>

            <article class="mini-stat">
                <span class="mini-stat-value">
                    {{ $ultimaValoracion ? $ultimaValoracion->valoracion . ' / 5' : '—' }}
                </span>
                <span class="mini-stat-label">Última puntuación</span>
            </article>
        </div>
    </div>

    @if ($ultimaValoracion)
        <div class="catalog-notice">
            <p>
                Última película valorada: <strong>{{ $ultimaValoracion->peliculaRelacion->titulo }}</strong>.
            </p>

            <a href="{{ route('catalogo') }}" class="btn btn-primary btn-small">
                Valorar otra película
            </a>
        </div>
    @endif

    @if ($recuento === 0)
        <section class="empty-state">
            <p class="eyebrow">Empieza a valorar</p>
            <h2>Aún no tienes valoraciones guardadas</h2>

            <p class="page-description">
                Vuelve al catálogo, elige una película y añade tu primera valoración para verla después en esta zona privada.
            </p>

            <div class="actions-row">
                <a href="{{ route('catalogo') }}" class="btn btn-primary">
                    Ir al catálogo
                </a>
            </div>
        </section>
    @else
        <section class="section-card">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Historial</p>
                    <h2>Valoraciones guardadas</h2>
                </div>

                <p class="section-note">
                    Puedes eliminar una valoración si quieres volver a valorar esa película más adelante.
                </p>
            </div>

            <div class="table-wrapper">
                <table class="movies-table">
                    <thead>
                        <tr>
                            <th>Película</th>
                            <th class="text-center">Año</th>
                            <th>Director/a</th>
                            <th class="text-center">Puntuación</th>
                            <th>Comentario</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($valoraciones as $valoracion)
                            <tr>
                                <td class="movie-title">
                                    {{ $valoracion->peliculaRelacion->titulo }}
                                </td>

                                <td class="text-center">
                                    {{ $valoracion->peliculaRelacion->anio }}
                                </td>

                                <td>
                                    {{ $valoracion->peliculaRelacion->direccion }}
                                </td>

                                <td class="text-center">
                                    <span class="metric-pill">
                                        {{ $valoracion->valoracion }} / 5
                                    </span>
                                </td>

                                <td>
                                    {{ $valoracion->comentario }}
                                </td>

                                <td class="text-center">
                                    <a
                                        href="{{ route('valoraciones.delete', $valoracion->id) }}"
                                        class="btn btn-danger btn-small"
                                    >
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    @endif
</section>

@endsection