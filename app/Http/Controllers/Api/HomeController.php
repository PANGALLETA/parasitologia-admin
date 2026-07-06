<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MapaEpidemiologico;
use App\Models\Parasito;
use App\Models\ParteParasito;
use App\Models\Pregunta;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Parasito::where('activo', true)
            ->latest()
            ->take(6)
            ->get([
                'uuid',
                'nombre_comun',
                'nombre_cientifico',
                'imagen_principal'
            ]);

        return response()->json([

            'stats' => [

                'parasitos' => Parasito::count(),

                'partes' => ParteParasito::count(),

                'mapas' => MapaEpidemiologico::count(),

                'preguntas' => Pregunta::count(),

            ],

            'featured' => $featured,

        ]);
    }
}