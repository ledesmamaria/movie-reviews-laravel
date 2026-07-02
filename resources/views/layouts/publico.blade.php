<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Reviews Laravel</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

    <header class="site-header">
        <div class="topbar">
            <nav class="main-nav">
                <a href="{{ route('catalogo') }}" class="brand-block">
                    <span class="brand-kicker">Aplicación Laravel</span>
                    <span class="brand-title">Movie Reviews</span>
                </a>

                <div class="nav-links">
                    <a href="{{ route('catalogo') }}">Catálogo</a>

                    @auth
                        <a href="{{ route('valoraciones.index') }}">Mis valoraciones</a>

                        <form action="{{ route('logout') }}" method="POST" class="logout-form">
                            @csrf
                            <button type="submit" class="nav-button">Cerrar sesión</button>
                        </form>
                    @else
                        <a href="{{ route('login.form') }}">Iniciar sesión</a>
                    @endauth
                </div>
            </nav>
        </div>
    </header>

    <main class="contenedor">
        @yield('contenido_principal')
    </main>

    <footer class="site-footer">
        <p>Movie Reviews Laravel · Aplicación web desarrollada con Laravel, Blade y MySQL</p>
    </footer>

</body>
</html>