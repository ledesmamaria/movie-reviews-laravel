<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use App\Models\Valoracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValoracionController extends Controller
{
    /**
     * Muestra el formulario para valorar una película.
     */
    public function create(Request $request)
    {
        $id = $request->input('id', session('id_pelicula_error'));

        $pelicula = Pelicula::with('generoRelacion')->find($id);

        if (!$pelicula) {
            return view('mensaje', [
                'tipo' => 'error',
                'subtitulo' => 'Película no disponible',
                'titulo' => 'No se ha encontrado la película',
                'mensaje' => 'La película seleccionada no existe o ya no está disponible.',
                'ruta' => 'catalogo',
                'textoBoton' => 'Volver al catálogo',
            ]);
        }

        session(['id_pelicula_error' => $id]);

        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();

        $yaHaVotado = $usuario
            ->valoraciones()
            ->where('pelicula', $id)
            ->exists();

        if ($yaHaVotado) {
            session()->forget('id_pelicula_error');

            return view('mensaje', [
                'tipo' => 'info',
                'subtitulo' => 'Valoración existente',
                'titulo' => 'Esta película ya está valorada',
                'mensaje' => 'Ya has añadido una valoración para esta película. Puedes consultarla desde tu zona privada.',
                'ruta' => 'valoraciones.index',
                'textoBoton' => 'Ir a mis valoraciones',
            ]);
        }

        return view('valoraciones.create', [
            'pelicula' => $pelicula,
        ]);
    }

    /**
     * Guarda una nueva valoración asociada al usuario autenticado.
     */
    public function store(Pelicula $pelicula, Request $request)
    {
        $request->merge([
            'comentario' => trim((string) $request->input('comentario', '')),
        ]);

        $request->validate(
            [
                'valoracion' => 'required|integer|min:1|max:5',
                'comentario' => 'required|string|max:255',
            ],
            [
                'valoracion.required' => 'Debes seleccionar una puntuación del 1 al 5.',
                'valoracion.integer' => 'La valoración seleccionada no es válida.',
                'valoracion.min' => 'La puntuación mínima es 1.',
                'valoracion.max' => 'La puntuación máxima es 5.',
                'comentario.required' => 'El comentario no puede estar vacío.',
                'comentario.max' => 'El comentario es demasiado largo. Máximo 255 caracteres.',
            ]
        );

        $usuario = Auth::user();

        $yaExiste = Valoracion::where('pelicula', $pelicula->id)
            ->where('usuario', $usuario->id)
            ->exists();

        if ($yaExiste) {
            session()->forget('id_pelicula_error');

            return view('mensaje', [
                'tipo' => 'info',
                'subtitulo' => 'Valoración existente',
                'titulo' => 'Esta película ya está valorada',
                'mensaje' => 'No puedes añadir dos valoraciones a la misma película.',
                'ruta' => 'valoraciones.index',
                'textoBoton' => 'Ir a mis valoraciones',
            ]);
        }

        Valoracion::create([
            'valoracion' => $request->input('valoracion'),
            'comentario' => $request->input('comentario'),
            'pelicula' => $pelicula->id,
            'usuario' => $usuario->id,
        ]);

        session()->forget('id_pelicula_error');

        return view('mensaje', [
            'tipo' => 'success',
            'subtitulo' => 'Valoración registrada',
            'titulo' => 'Valoración guardada',
            'mensaje' => 'Tu valoración de "' . $pelicula->titulo . '" se ha guardado correctamente.',
            'ruta' => 'valoraciones.index',
            'textoBoton' => 'Ver mis valoraciones',
        ]);
    }

    /**
     * Muestra la pantalla de confirmación antes de eliminar una valoración.
     */
    public function confirmDelete($id)
    {
        $valoracion = Valoracion::with('peliculaRelacion')->find($id);

        if (!$valoracion || $valoracion->usuario !== Auth::id()) {
            return view('mensaje', [
                'tipo' => 'error',
                'subtitulo' => 'Acceso no permitido',
                'titulo' => 'No se puede eliminar esta valoración',
                'mensaje' => 'La valoración no existe o no pertenece a tu cuenta.',
                'ruta' => 'valoraciones.index',
                'textoBoton' => 'Volver a mis valoraciones',
            ]);
        }

        return view('valoraciones.delete', [
            'valoracion' => $valoracion,
        ]);
    }

    /**
     * Elimina definitivamente una valoración del usuario autenticado.
     */
    public function destroy($id)
    {
        $valoracion = Valoracion::with('peliculaRelacion')->find($id);

        if (!$valoracion || $valoracion->usuario !== Auth::id()) {
            return view('mensaje', [
                'tipo' => 'error',
                'subtitulo' => 'Acceso no permitido',
                'titulo' => 'No se ha podido eliminar la valoración',
                'mensaje' => 'No tienes permiso para realizar esta acción.',
                'ruta' => 'valoraciones.index',
                'textoBoton' => 'Volver a mis valoraciones',
            ]);
        }

        $tituloPelicula = $valoracion->peliculaRelacion->titulo;

        $valoracion->delete();

        return view('mensaje', [
            'tipo' => 'success',
            'subtitulo' => 'Valoración eliminada',
            'titulo' => 'Valoración eliminada',
            'mensaje' => 'La valoración de "' . $tituloPelicula . '" se ha eliminado correctamente.',
            'ruta' => 'valoraciones.index',
            'textoBoton' => 'Volver a mis valoraciones',
        ]);
    }
}