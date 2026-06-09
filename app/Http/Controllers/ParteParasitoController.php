<?php

namespace App\Http\Controllers;

use App\Models\ParteParasito;
use App\Models\Parasito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ParteParasitoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ParteParasito::with('parasito');

        if($request->filled('parasito_id'))
        {
            $query->where(
                'parasito_id',
                $request->parasito_id
            );
        }

        $partes = $query
            ->orderBy('parasito_id')
            ->orderBy('orden')
            ->paginate(10);

        $parasitos = Parasito::orderBy(
            'nombre_comun'
        )->get();

        return view(
            'parte_parasitos.index',
            compact(
                'partes',
                'parasitos'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parasitos = Parasito::where(
            'activo',
            true
        )
        ->orderBy('nombre_comun')
        ->get();

        return view(
            'parte_parasitos.create',
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
            'nombre' => 'required|max:255',
            'descripcion' => 'required',
            'orden' => 'required|integer|min:1',
            'imagen' => 'required|image|max:2048'

        ]);

        $imagen = $request
            ->file('imagen')
            ->store(
                'parte_parasitos',
                'public'
            );

        ParteParasito::create([

            'parasito_id' => $request->parasito_id,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'orden' => $request->orden,
            'imagen' => $imagen,
            'activo' => $request->boolean('activo')

        ]);

        return redirect()
            ->route('parte-parasitos.index')
            ->with(
                'success',
                'Parte anatómica registrada correctamente.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(ParteParasito $parteParasito)
    {
        $parteParasito->load(
            'parasito'
        );

        return view(
            'parte_parasitos.show',
            compact(
                'parteParasito'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParteParasito $parteParasito)
    {
        $parasitos = Parasito::where(
            'activo',
            true
        )
        ->orderBy('nombre_comun')
        ->get();

        return view(
            'parte_parasitos.edit',
            compact(
                'parteParasito',
                'parasitos'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,ParteParasito $parteParasito)
    {
        $request->validate([

            'parasito_id' => 'required|exists:parasitos,id',
            'nombre' => 'required|max:255',
            'descripcion' => 'required',
            'orden' => 'required|integer|min:1'

        ]);

        $datos = [

            'parasito_id' => $request->parasito_id,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'orden' => $request->orden,
            'activo' => $request->boolean('activo')

        ];

        if($request->hasFile('imagen'))
        {
            Storage::disk('public')->delete(
                $parteParasito->imagen
            );

            $datos['imagen'] =
                $request->file('imagen')
                ->store(
                    'parte_parasitos',
                    'public'
                );
        }

        $parteParasito->update(
            $datos
        );

        return redirect()
            ->route('parte-parasitos.index')
            ->with(
                'success',
                'Parte anatómica actualizada correctamente.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParteParasito $parteParasito)
    {
        if(
            $parteParasito->imagen &&
            Storage::disk('public')->exists(
                $parteParasito->imagen
            )
        ){
            Storage::disk('public')->delete(
                $parteParasito->imagen
            );
        }

        $parteParasito->delete();

        return redirect()
            ->route('parte-parasitos.index')
            ->with(
                'success',
                'Parte anatómica eliminada correctamente.'
            );
    }
}
