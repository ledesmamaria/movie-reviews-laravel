<?php

namespace Database\Seeders;

use App\Models\Genero;
use App\Models\Pelicula;
use App\Models\User;
use App\Models\Valoracion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Inserta usuarios, géneros, películas y valoraciones de prueba.
     */
    public function run(): void
    {
        $usuarioDemo = User::updateOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'Cuenta Demo',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        $otroUsuario = User::updateOrCreate(
            ['email' => 'reviewer@example.com'],
            [
                'name' => 'Usuario de prueba',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
            ]
        );

        $animacion = Genero::updateOrCreate(
            ['nombre' => 'Animación'],
            ['descripcion' => 'Películas de animación tradicional o digital.']
        );

        $drama = Genero::updateOrCreate(
            ['nombre' => 'Drama'],
            ['descripcion' => 'Películas centradas en conflictos emocionales y desarrollo de personajes.']
        );

        $cienciaFiccion = Genero::updateOrCreate(
            ['nombre' => 'Ciencia ficción'],
            ['descripcion' => 'Películas con elementos tecnológicos, futuristas o especulativos.']
        );

        $comedia = Genero::updateOrCreate(
            ['nombre' => 'Comedia'],
            ['descripcion' => 'Películas orientadas al humor y al entretenimiento ligero.']
        );

        $otros = Genero::updateOrCreate(
            ['nombre' => 'Otros'],
            ['descripcion' => 'Películas de otros géneros o categorías mixtas.']
        );

        $luma = Pelicula::updateOrCreate(
            [
                'titulo' => 'El viaje de Luma',
                'anio' => 2018,
                'direccion' => 'Carla Gómez',
            ],
            [
                'genero' => $animacion->id,
                'duracion' => 96,
                'argumento' => 'Una joven descubre un mundo mágico durante un viaje inesperado.',
            ]
        );

        $cajaColores = Pelicula::updateOrCreate(
            [
                'titulo' => 'La caja de colores',
                'anio' => 2015,
                'direccion' => 'Miguel Ruiz',
            ],
            [
                'genero' => $animacion->id,
                'duracion' => 82,
                'argumento' => 'Una aventura animada sobre amistad, creatividad y segundas oportunidades.',
            ]
        );

        $sombras = Pelicula::updateOrCreate(
            [
                'titulo' => 'Sombras en la ciudad',
                'anio' => 2010,
                'direccion' => 'Luis Martín',
            ],
            [
                'genero' => $drama->id,
                'duracion' => 120,
                'argumento' => 'Historia íntima de varios personajes cuyas vidas se cruzan en una gran ciudad.',
            ]
        );

        $estrella = Pelicula::updateOrCreate(
            [
                'titulo' => 'Estrella de vidrio',
                'anio' => 2023,
                'direccion' => 'Elena Vega',
            ],
            [
                'genero' => $cienciaFiccion->id,
                'duracion' => 130,
                'argumento' => 'Un descubrimiento científico cambia la forma en la que la humanidad entiende el universo.',
            ]
        );

        $cafe = Pelicula::updateOrCreate(
            [
                'titulo' => 'Un café y dos risas',
                'anio' => 2019,
                'direccion' => 'Raúl Sánchez',
            ],
            [
                'genero' => $comedia->id,
                'duracion' => 85,
                'argumento' => 'Comedia ligera sobre encuentros inesperados y enredos entre amigos.',
            ]
        );

        $archivos = Pelicula::updateOrCreate(
            [
                'titulo' => 'Archivos olvidados',
                'anio' => 2001,
                'direccion' => 'Lucía Blanco',
            ],
            [
                'genero' => $otros->id,
                'duracion' => 95,
                'argumento' => 'Una investigación documental recupera testimonios ocultos durante décadas.',
            ]
        );

        Valoracion::updateOrCreate(
            [
                'pelicula' => $luma->id,
                'usuario' => $usuarioDemo->id,
            ],
            [
                'valoracion' => 4,
                'comentario' => 'Una película sencilla, visual y muy entretenida.',
            ]
        );

        Valoracion::updateOrCreate(
            [
                'pelicula' => $estrella->id,
                'usuario' => $usuarioDemo->id,
            ],
            [
                'valoracion' => 5,
                'comentario' => 'Muy buena mezcla de ciencia ficción y emoción.',
            ]
        );

        Valoracion::updateOrCreate(
            [
                'pelicula' => $cajaColores->id,
                'usuario' => $otroUsuario->id,
            ],
            [
                'valoracion' => 3,
                'comentario' => 'Correcta y agradable para una tarde ligera.',
            ]
        );

        Valoracion::updateOrCreate(
            [
                'pelicula' => $sombras->id,
                'usuario' => $otroUsuario->id,
            ],
            [
                'valoracion' => 4,
                'comentario' => 'Un drama pausado, pero con buenos personajes.',
            ]
        );

        Valoracion::updateOrCreate(
            [
                'pelicula' => $cafe->id,
                'usuario' => $otroUsuario->id,
            ],
            [
                'valoracion' => 3,
                'comentario' => 'Comedia simple, ligera y fácil de ver.',
            ]
        );

        Valoracion::updateOrCreate(
            [
                'pelicula' => $archivos->id,
                'usuario' => $otroUsuario->id,
            ],
            [
                'valoracion' => 4,
                'comentario' => 'Interesante por su tono documental.',
            ]
        );
    }
}