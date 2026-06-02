<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapaEpidemiologico extends Model
{
    use HasFactory;

    protected $fillable = [
        'parasito_id',
        'departamento',
        'nivel_presencia',
        'observaciones'
    ];

    public function parasito()
    {
        return $this->belongsTo(Parasito::class);
    }
}