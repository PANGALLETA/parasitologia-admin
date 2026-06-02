<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Parasito extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'nombre_comun',
        'nombre_cientifico',
        'familia',
        'genero',
        'descripcion_general',
        'morfologia',
        'hospedadores',
        'sintomas',
        'tratamiento',
        'imagen_principal',
        'activo'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($parasito) {
            if (empty($parasito->uuid)) {
                $parasito->uuid = (string) Str::uuid();
            }
        });
    }

    public function mapasEpidemiologicos()
    {
        return $this->hasMany(MapaEpidemiologico::class);
    }
}