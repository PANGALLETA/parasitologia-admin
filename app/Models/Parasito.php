<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parasito extends Model
{
    protected $fillable = [
        'nombre_cientifico',
        'nombre_comun',
        'familia',
        'orden_taxonomico',
        'descripcion_general',
        'ciclo_vida',
        'hospedadores',
        'sintomas',
        'tratamiento',
        'imagen_principal',
        'activo'
    ];
}