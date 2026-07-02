@extends('layouts.publico')

@section('contenido_principal')

@auth
    <section class="catalog-panel">
        <div class="catalog-header">
            <div>
                <p class="eyebrow">Sesión iniciada</p>
                <h1>Ya estás dentro</h1>

                <p class="page-description">
                    Puedes acceder a tu zona privada para consultar tus valoraciones o volver al catálogo para seguir puntuando películas.
                </p>
            </div>
        </div>

        <div class="actions-row">
            <a href="{{ route('valoraciones.index') }}" class="btn btn-primary">
                Ir a mi zona privada
            </a>

            <a href="{{ route('catalogo') }}" class="btn btn-secondary">
                Volver al catálogo
            </a>
        </div>
    </section>
@endauth

@guest
    <section class="catalog-panel">
        <div class="catalog-header">
            <div>
                <p class="eyebrow">Acceso de usuario</p>
                <h1>Iniciar sesión</h1>

                <p class="page-description">
                    Accede con una cuenta demo para valorar películas y consultar tu actividad dentro de la aplicación.
                </p>
            </div>

            <div class="catalog-stats">
                <article class="mini-stat">
                    <span class="mini-stat-value">Demo</span>
                    <span class="mini-stat-label">Cuenta de prueba</span>
                </article>
            </div>
        </div>

        @if ($errors->any())
            <section class="message-card message-error">
                <p class="eyebrow">Error de acceso</p>
                <h2>No se ha podido iniciar sesión</h2>

                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </section>
        @endif

        <section class="form-card">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="demo@example.com"
                        autocomplete="email"
                    >
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="password"
                        autocomplete="current-password"
                    >
                </div>

                <p class="form-help">
                    Usuario demo: <strong>demo@example.com</strong> · Contraseña: <strong>password</strong>
                </p>

                <div class="actions-row">
                    <button type="submit" class="btn btn-primary">
                        Entrar
                    </button>

                    <a href="{{ route('catalogo') }}" class="btn btn-secondary">
                        Volver al catálogo
                    </a>
                </div>
            </form>
        </section>
    </section>
@endguest

@endsection