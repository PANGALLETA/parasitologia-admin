<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParteParasito extends Model
{
    protected $fillable = [

        'parasito_id',
        'nombre',
        'imagen',
        'descripcion',
        'orden',
        'activo'

    ];

    public function parasito()
    {
        return $this->belongsTo(
            Parasito::class
        );
    }
}