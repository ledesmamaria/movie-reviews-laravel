<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de películas.
     */
    public function up(): void
    {
        Schema::create('peliculas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('genero')
                ->constrained('generos')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('titulo', 100);
            $table->string('direccion', 100);
            $table->unsignedSmallInteger('duracion');
            $table->text('argumento');
            $table->unsignedSmallInteger('anio');
            $table->timestamps();
        });
    }

    /**
     * Elimina la tabla de películas.
     */
    public function down(): void
    {
        Schema::dropIfExists('peliculas');
    }
};