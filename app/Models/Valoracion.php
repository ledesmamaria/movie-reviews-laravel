<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Valoracion extends Model
{
    use HasFactory;

    protected $table = 'criticas';

    protected $fillable = [
        'valoracion',
        'comentario',
        'pelicula',
        'usuario',
    ];

    public function usuarioRelacion(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario');
    }

    public function peliculaRelacion(): BelongsTo
    {
        return $this->belongsTo(Pelicula::class, 'pelicula');
    }
}