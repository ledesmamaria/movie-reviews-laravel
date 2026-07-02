<?php

namespace Tests\Feature;

use App\Models\Genero;
use App\Models\Pelicula;
use App\Models\User;
use App\Models\Valoracion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ValoracionTest extends TestCase
{
    use RefreshDatabase;

    public function test_el_catalogo_publico_se_puede_ver(): void
    {
        $response = $this->get(route('catalogo'));

        $response->assertStatus(200);
        $response->assertSee('Explora y valora películas');
    }

    public function test_un_usuario_puede_iniciar_sesion(): void
    {
        User::factory()->create([
            'email' => 'demo@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'demo@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('valoraciones.index'));
        $this->assertAuthenticated();
    }

    public function test_un_usuario_autenticado_puede_crear_una_valoracion(): void
    {
        $usuario = User::factory()->create();

        $pelicula = $this->crearPelicula();

        $response = $this
            ->actingAs($usuario)
            ->post(route('valoraciones.store', $pelicula->id), [
                'valoracion' => 5,
                'comentario' => 'Muy buena película.',
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('criticas', [
            'pelicula' => $pelicula->id,
            'usuario' => $usuario->id,
            'valoracion' => 5,
            'comentario' => 'Muy buena película.',
        ]);
    }

    public function test_un_usuario_no_puede_valorar_dos_veces_la_misma_pelicula(): void
    {
        $usuario = User::factory()->create();

        $pelicula = $this->crearPelicula();

        Valoracion::create([
            'pelicula' => $pelicula->id,
            'usuario' => $usuario->id,
            'valoracion' => 4,
            'comentario' => 'Primera valoración.',
        ]);

        $response = $this
            ->actingAs($usuario)
            ->post(route('valoraciones.store', $pelicula->id), [
                'valoracion' => 5,
                'comentario' => 'Segunda valoración.',
            ]);

        $response->assertStatus(200);
        $response->assertSee('Esta película ya está valorada');

        $this->assertDatabaseCount('criticas', 1);
    }

    public function test_un_usuario_no_puede_eliminar_valoraciones_de_otro_usuario(): void
    {
        $usuario = User::factory()->create();
        $otroUsuario = User::factory()->create();

        $pelicula = $this->crearPelicula();

        $valoracion = Valoracion::create([
            'pelicula' => $pelicula->id,
            'usuario' => $otroUsuario->id,
            'valoracion' => 3,
            'comentario' => 'Valoración de otro usuario.',
        ]);

        $response = $this
            ->actingAs($usuario)
            ->post(route('valoraciones.destroy', $valoracion->id));

        $response->assertStatus(200);
        $response->assertSee('No se ha podido eliminar la valoración');

        $this->assertDatabaseHas('criticas', [
            'id' => $valoracion->id,
        ]);
    }

    private function crearPelicula(): Pelicula
    {
        $genero = Genero::create([
            'nombre' => 'Drama',
            'descripcion' => 'Películas centradas en conflictos emocionales.',
        ]);

        return Pelicula::create([
            'genero' => $genero->id,
            'titulo' => 'Película de prueba',
            'direccion' => 'Dirección de prueba',
            'duracion' => 120,
            'argumento' => 'Argumento de prueba para la película.',
            'anio' => 2024,
        ]);
    }
}