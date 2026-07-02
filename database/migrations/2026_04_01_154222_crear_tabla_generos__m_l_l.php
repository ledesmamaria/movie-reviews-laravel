<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de géneros de películas.
     */
    public function up(): void
    {
        Schema::create('generos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 45)->unique();
            $table->text('descripcion');
            $table->timestamps();
        });
    }

    /**
     * Elimina la tabla de géneros.
     */
    public function down(): void
    {
        Schema::dropIfExists('generos');
    }
};