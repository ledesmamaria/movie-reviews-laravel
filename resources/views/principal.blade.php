@extends('layouts.publico')

@section('contenido_principal')

@php
    $totalPeliculas = $peliculas->count();

    $peliculasValoradasIds = auth()->check()
        ? auth()->user()->valoraciones()->pluck('pelicula')->unique()->toArray()
        : [];

    $misValoraciones = count($peliculasValoradasIds);
    $peliculasPendientes = max($totalPeliculas - $misValoraciones, 0);
@endphp

<section class="catalog-panel">
    <div class="catalog-header">
        <div>
            <p class="eyebrow">Catálogo de películas</p>
            <h1>Explora y valora películas</h1>

            <p class="page-description">
                Consulta el catálogo disponible, revisa las puntuaciones y añade tu opinión personal sobre cada película.
            </p>
        </div>

        <div class="catalog-stats">
            <article class="mini-stat">
                <span class="mini-stat-value">{{ $totalPeliculas }}</span>
                <span class="mini-stat-label">Películas</span>
            </article>

            @auth
                <article class="mini-stat">
                    <span class="mini-stat-value">{{ $misValoraciones }}</span>
                    <span class="mini-stat-label">Mis valoraciones</span>
                </article>

                <article class="mini-stat">
                    <span class="mini-stat-value">{{ $peliculasPendientes }}</span>
                    <span class="mini-stat-label">Por valorar</span>
                </article>
            @endauth
        </div>
    </div>

    @guest
        <div class="catalog-notice">
            <p>
                Inicia sesión para ver las puntuaciones del catálogo y añadir tus propias valoraciones.
            </p>

            <a href="{{ route('login.form') }}" class="btn btn-primary btn-small">
                Iniciar sesión
            </a>
        </div>
    @endguest

    <div class="catalog-table-header">
        <div>
            <p class="eyebrow">Listado principal</p>
            <h2>Películas disponibles</h2>
        </div>
    </div>

    <div class="table-wrapper">
        <table class="movies-table">
            <thead>
                <tr>
                    <th>Género</th>
                    <th>Título</th>
                    <th>Director/a</th>
                    <th class="text-center">Duración</th>
                    <th class="text-center">Año</th>

                    @auth
                        <th class="text-center">Valoraciones</th>
                        <th class="text-center">Media</th>
                    @endauth

                    <th class="text-center">Acción</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($peliculas as $pelicula)
                    <tr>
                        <td>{{ $pelicula->generoRelacion->nombre }}</td>

                        <td class="movie-title">
                            {{ $pelicula->titulo }}
                        </td>

                        <td>{{ $pelicula->direccion }}</td>

                        <td class="text-center">
                            {{ $pelicula->duracion }} min
                        </td>

                        <td class="text-center">
                            {{ $pelicula->anio }}
                        </td>

                        @auth
                            <td class="text-center">
                                <span class="metric-pill">
                                    {{ $pelicula->valoraciones->count() }}
                                </span>
                            </td>

                            <td class="text-center">
                                <span class="metric-pill">
                                    {{ $pelicula->valoraciones->count() > 0
                                        ? number_format($pelicula->valoraciones->avg('valoracion'), 1)
                                        : '0.0' }}
                                </span>
                            </td>
                        @endauth

                        <td class="text-center">
                            @auth
                                @if (in_array($pelicula->id, $peliculasValoradasIds))
                                    <a href="{{ route('valoraciones.index') }}" class="btn btn-secondary btn-small">
                                        Valorada
                                    </a>
                                @else
                                    <form action="{{ route('valoraciones.create') }}" method="POST" class="inline-form">
                                        @csrf

                                        <input type="hidden" name="id" value="{{ $pelicula->id }}">

                                        <button type="submit" class="btn btn-primary btn-small">
                                            Valorar
                                        </button>
                                    </form>
                                @endif
                            @endauth

                            @guest
                                <span class="muted-text">
                                    Inicia sesión para valorar
                                </span>
                            @endguest
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@endsection