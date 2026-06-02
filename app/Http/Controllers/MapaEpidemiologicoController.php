<?php

namespace App\Http\Controllers;

use App\Models\MapaEpidemiologico;
use Illuminate\Http\Request;
use App\Models\Parasito;

class MapaEpidemiologicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MapaEpidemiologico::with('parasito');

        if ($request->filled('buscar')) {

            $query->whereHas('parasito', function ($q) use ($request) {

                $q->where(
                    'nombre_comun',
                    'like',
                    '%' . $request->buscar . '%'
                )
                ->orWhere(
                    'nombre_cientifico',
                    'like',
                    '%' . $request->buscar . '%'
                );

            });

        }

        if ($request->filled('departamento')) {

            $query->where(
                'departamento',
                'like',
                '%' . $request->departamento . '%'
            );

        }

        if ($request->filled('nivel_presencia')) {

            $query->where(
                'nivel_presencia',
                $request->nivel_presencia
            );

        }

        $mapas = $query
            ->orderBy('parasito_id')
            ->get()
            ->groupBy('parasito_id');

        return view(
            'mapa_epidemiologicos.index',
            compact('mapas')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parasitosConMapa =
            MapaEpidemiologico::select(
                'parasito_id'
            )->distinct();

        $parasitos = Parasito::whereNotIn(
            'id',
            $parasitosConMapa
        )
        ->orderBy('nombre_comun')
        ->get();

        return view(
            'mapa_epidemiologicos.create',
            compact('parasitos')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'parasito_id' => 'required|exists:parasitos,id',
            'departamentos' => 'required'
        ], [
            'parasito_id.required' => 'Debe seleccionar un parásito.',
            'departamentos.required' => 'Debe seleccionar al menos un departamento.'
        ]);

        $departamentos = json_decode(
            $request->departamentos,
            true
        );

        if (
            !$departamentos ||
            count($departamentos) === 0
        ) {

            return back()
                ->withInput()
                ->withErrors([
                    'departamentos' =>
                        'Debe seleccionar al menos un departamento.'
                ]);

        }

        foreach ($departamentos as $item) {

            MapaEpidemiologico::updateOrCreate(

                [
                    'parasito_id' => $request->parasito_id,
                    'departamento' => $item['departamento']
                ],

                [
                    'nivel_presencia' => $item['nivel'],
                    'observaciones' => $request->observaciones
                ]

            );

        }

        return redirect()
            ->route('mapa-epidemiologicos.index')
            ->with(
                'success',
                'Distribución geográfica registrada correctamente.'
            );
    }

    public function destroyPorParasito($parasitoId)
    {
        MapaEpidemiologico::where(
            'parasito_id',
            $parasitoId
        )->delete();

        return redirect()
            ->route('mapa-epidemiologicos.index')
            ->with(
                'success',
                'Distribución geográfica eliminada correctamente.'
            );
    }
    /**
     * Display the specified resource.
     */
    public function show($parasitoId)
    {
        $mapas = MapaEpidemiologico::with('parasito')
            ->where('parasito_id', $parasitoId)
            ->get();

        if ($mapas->isEmpty()) {

            return redirect()
                ->route('mapa-epidemiologicos.index')
                ->with(
                    'error',
                    'No existen datos para este parásito.'
                );

        }

        $parasito = $mapas->first()->parasito;

        return view(
            'mapa_epidemiologicos.show',
            compact(
                'parasito',
                'mapas'
            )
        );
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($parasitoId)
    {
        $parasito = Parasito::findOrFail($parasitoId);

        $mapas = MapaEpidemiologico::where(
            'parasito_id',
            $parasitoId
        )->get();

        return view(
            'mapa_epidemiologicos.edit',
            compact('parasito', 'mapas')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$parasitoId)
    {
        $request->validate([
            'departamentos' => 'required'
        ], [
            'departamentos.required' =>
                'Debe seleccionar al menos un departamento.'
        ]);

        $departamentos = json_decode(
            $request->departamentos,
            true
        );

        if(
            !$departamentos ||
            count($departamentos) === 0
        ){
            return back()
                ->withInput()
                ->withErrors([
                    'departamentos' =>
                        'Debe seleccionar al menos un departamento.'
                ]);
        }

        MapaEpidemiologico::where(
            'parasito_id',
            $parasitoId
        )->delete();

        foreach($departamentos as $item)
        {
            MapaEpidemiologico::create([

                'parasito_id' =>
                    $parasitoId,

                'departamento' =>
                    $item['departamento'],

                'nivel_presencia' =>
                    $item['nivel'],

                'observaciones' =>
                    $request->observaciones

            ]);
        }

        return redirect()
            ->route('mapa-epidemiologicos.index')
            ->with(
                'success',
                'Distribución geográfica actualizada correctamente.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MapaEpidemiologico $mapaEpidemiologico)
    {
        //
    }
}
