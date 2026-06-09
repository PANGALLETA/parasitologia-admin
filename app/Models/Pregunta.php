<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $fillable = [

        'parasito_id',
        'pregunta',
        'activo'

    ];

    protected $casts = [

        'activo' => 'boolean'

    ];

    public function parasito()
    {
        return $this->belongsTo(
            Parasito::class
        );
    }

    public function respuestas()
    {
        return $this->hasMany(
            Respuesta::class
        );
    }
}