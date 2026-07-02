<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de valoraciones de películas.
     */
    public function up(): void
    {
        Schema::create('criticas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pelicula')
                ->constrained('peliculas')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('usuario')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('valoracion');
            $table->string('comentario', 255);
            $table->timestamps();

            $table->unique(['pelicula', 'usuario']);
        });
    }

    /**
     * Elimina la tabla de valoraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('criticas');
    }
};