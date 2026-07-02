<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis valoraciones · Movie Reviews Laravel</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}"></head>
<body>

    <header class="site-header">
        <div class="topbar">
            <nav class="main-nav">
                <a href="{{ route('valoraciones.index') }}" class="brand-block">
                    <span class="brand-kicker">Área personal</span>
                    <span class="brand-title">Movie Reviews</span>
                </a>

                <div class="nav-links">
                    <a href="{{ route('catalogo') }}">Catálogo</a>

                    <span class="user-badge">
                        Cuenta demo
                    </span>

                    <form action="{{ route('logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="nav-button">Cerrar sesión</button>
                    </form>
                </div>
            </nav>
        </div>
    </header>

    <main class="contenedor">
        @yield('contenido_privado')
    </main>

    <footer class="site-footer">
        <p>Área personal · Consulta y gestiona tus valoraciones</p>
    </footer>

</body>
</html>