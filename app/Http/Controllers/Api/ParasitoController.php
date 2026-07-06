<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parasito;
use App\Models\MapaEpidemiologico;
use App\Models\ParteParasito;
use App\Models\Pregunta;
use Illuminate\Http\Request;

class ParasitoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $parasitos = Parasito::query()

            ->withCount([
                'mapasEpidemiologicos',
                'partes',
                'preguntas',
            ])

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('nombre_comun', 'like', "%{$search}%")
                        ->orWhere('nombre_cientifico', 'like', "%{$search}%")
                        ->orWhere('familia', 'like', "%{$search}%")
                        ->orWhere('genero', 'like', "%{$search}%");

                });

            })

            ->where('activo', true)

            ->orderBy('nombre_comun')

            ->paginate(12);

        $parasitos->getCollection()->transform(function ($parasito) {

            $parasito->imagen_principal = asset(
                'storage/' . $parasito->imagen_principal
            );

            $parasito->has_mapa = $parasito->mapas_epidemiologicos_count > 0;

            $parasito->has_partes = $parasito->partes_count > 0;

            $parasito->has_quiz = $parasito->preguntas_count > 0;

            $parasito->has_webar = false;

            return $parasito;

        });

        return response()->json($parasitos);
    }

    public function show($uuid)
    {
        $parasito = Parasito::where('uuid', $uuid)
            ->where('activo', true)
            ->firstOrFail();

        $parasito->imagen_principal = asset(
            'storage/' . $parasito->imagen_principal
        );

        $partes = ParteParasito::where(
            'parasito_id',
            $parasito->id
        )
            ->where('activo', true)
            ->orderBy('orden')
            ->get();

        $partes->transform(function ($parte) {

            $parte->imagen = asset(
                'storage/' . $parte->imagen
            );

            return $parte;

        });

        return response()->json([

            'parasito' => $parasito,

            'partes' => $partes,

            'mapas' => MapaEpidemiologico::where(
                'parasito_id',
                $parasito->id
            )->get(),

            'preguntas' => Pregunta::with('respuestas')
                ->where('parasito_id', $parasito->id)
                ->where('activo', true)
                ->get(),

            'webar' => [
                'disponible' => false,
                'url' => null,
            ]

        ]);
    }
}