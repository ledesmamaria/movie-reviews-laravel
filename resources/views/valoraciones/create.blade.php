@extends('layouts.privado')

@section('contenido_privado')

<section class="catalog-panel">
    <div class="catalog-header">
        <div>
            <p class="eyebrow">Nueva valoración</p>
            <h1>Valorar película</h1>

            <p class="page-description">
                Añade una puntuación y un comentario personal sobre la película seleccionada.
            </p>
        </div>

        <div class="catalog-stats">
            <article class="mini-stat">
                <span class="mini-stat-value">{{ $pelicula->anio }}</span>
                <span class="mini-stat-label">Año</span>
            </article>

            <article class="mini-stat">
                <span class="mini-stat-value">{{ $pelicula->duracion }}</span>
                <span class="mini-stat-label">Minutos</span>
            </article>
        </div>
    </div>

    <section class="section-card">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Película seleccionada</p>
                <h2>{{ $pelicula->titulo }}</h2>
            </div>
        </div>

        <div class="detail-grid">
            <p><strong>Director/a:</strong> {{ $pelicula->direccion }}</p>
            <p><strong>Género:</strong> {{ $pelicula->generoRelacion->nombre }}</p>
            <p><strong>Año:</strong> {{ $pelicula->anio }}</p>
            <p><strong>Duración:</strong> {{ $pelicula->duracion }} minutos</p>
        </div>

        <p class="movie-argument">
            <strong>Argumento:</strong> {{ $pelicula->argumento }}
        </p>
    </section>

    @if ($errors->any())
        <section class="message-card message-error">
            <p class="eyebrow">Revisión necesaria</p>
            <h2>Revisa los datos introducidos</h2>

            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </section>
    @endif

    <section class="form-card">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Tu opinión</p>
                <h2>Añadir valoración</h2>
            </div>
        </div>

        <form action="{{ route('valoraciones.store', $pelicula->id) }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="valoracion">Puntuación</label>

                <select id="valoracion" name="valoracion">
                    <option value="">Selecciona una puntuación</option>
                    <option value="1" {{ old('valoracion') == '1' ? 'selected' : '' }}>1 - Muy mala</option>
                    <option value="2" {{ old('valoracion') == '2' ? 'selected' : '' }}>2 - Mala</option>
                    <option value="3" {{ old('valoracion') == '3' ? 'selected' : '' }}>3 - Normal</option>
                    <option value="4" {{ old('valoracion') == '4' ? 'selected' : '' }}>4 - Buena</option>
                    <option value="5" {{ old('valoracion') == '5' ? 'selected' : '' }}>5 - Excelente</option>
                </select>
            </div>

            <div class="form-group">
                <label for="comentario">Comentario</label>

                <textarea
                    id="comentario"
                    name="comentario"
                    rows="5"
                    maxlength="255"
                    placeholder="Escribe una opinión breve sobre la película..."
                >{{ old('comentario') }}</textarea>

                <p class="form-help">
                    Máximo 255 caracteres.
                </p>
            </div>

            <div class="actions-row">
                <button type="submit" class="btn btn-primary">
                    Guardar valoración
                </button>

                <a href="{{ route('catalogo') }}" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </section>
</section>

@endsection