<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelicula extends Model
{
    use HasFactory;

    protected $table = 'peliculas';

    protected $fillable = [
        'genero',
        'titulo',
        'direccion',
        'duracion',
        'argumento',
        'anio',
    ];

    public function generoRelacion(): BelongsTo
    {
        return $this->belongsTo(Genero::class, 'genero');
    }

    public function valoraciones(): HasMany
    {
        return $this->hasMany(Valoracion::class, 'pelicula');
    }
}