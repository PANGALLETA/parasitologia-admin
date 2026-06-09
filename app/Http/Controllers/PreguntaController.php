<?php

namespace App\Http\Controllers;

use App\Models\Pregunta;
use Illuminate\Http\Request;
use App\Models\Parasito;
use App\Models\Respuesta;

class PreguntaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pregunta::with([
            'parasito',
            'respuestas'
        ]);

        if($request->filled('parasito_id'))
        {
            $query->where(
                'parasito_id',
                $request->parasito_id
            );
        }

        $preguntas = $query
            ->latest()
            ->paginate(10);

        $parasitos = Parasito::orderBy(
            'nombre_comun'
        )->get();

        return view(
            'preguntas.index',
            compact(
                'preguntas',
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
            'preguntas.create',
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

            'pregunta' => 'required|string',

            'respuesta_a' => 'required|string',
            'respuesta_b' => 'required|string',
            'respuesta_c' => 'required|string',
            'respuesta_d' => 'required|string',

            'respuesta_correcta' => 'required|in:a,b,c,d'

        ]);

        $pregunta = Pregunta::create([

            'parasito_id' => $request->parasito_id,

            'pregunta' => $request->pregunta,

            'activo' => $request->boolean('activo')

        ]);

        $respuestas = [

            'a' => $request->respuesta_a,
            'b' => $request->respuesta_b,
            'c' => $request->respuesta_c,
            'd' => $request->respuesta_d,

        ];

        foreach ($respuestas as $clave => $texto)
        {
            Respuesta::create([

                'pregunta_id' => $pregunta->id,

                'respuesta' => $texto,

                'es_correcta' =>
                    $request->respuesta_correcta === $clave

            ]);
        }

        return redirect()
            ->route('preguntas.index')
            ->with(
                'success',
                'Pregunta registrada correctamente.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(Pregunta $pregunta)
    {
        $pregunta->load([
            'parasito',
            'respuestas'
        ]);

        return view(
            'preguntas.show',
            compact('pregunta')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pregunta $pregunta)
    {
        $pregunta->load('respuestas');

        $parasitos = Parasito::where(
            'activo',
            true
        )
        ->orderBy('nombre_comun')
        ->get();

        return view(
            'preguntas.edit',
            compact(
                'pregunta',
                'parasitos'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Pregunta $pregunta)
    {
        $request->validate([

            'parasito_id' => 'required|exists:parasitos,id',

            'pregunta' => 'required|string',

            'respuesta_a' => 'required|string',
            'respuesta_b' => 'required|string',
            'respuesta_c' => 'required|string',
            'respuesta_d' => 'required|string',

            'respuesta_correcta' => 'required|in:a,b,c,d'

        ]);

        $pregunta->update([

            'parasito_id' => $request->parasito_id,

            'pregunta' => $request->pregunta,

            'activo' => $request->boolean('activo')

        ]);

        $respuestas = $pregunta
            ->respuestas()
            ->orderBy('id')
            ->get();

        if($respuestas->count() == 4)
        {
            $respuestas[0]->update([

                'respuesta' => $request->respuesta_a,

                'es_correcta' =>
                    $request->respuesta_correcta === 'a'

            ]);

            $respuestas[1]->update([

                'respuesta' => $request->respuesta_b,

                'es_correcta' =>
                    $request->respuesta_correcta === 'b'

            ]);

            $respuestas[2]->update([

                'respuesta' => $request->respuesta_c,

                'es_correcta' =>
                    $request->respuesta_correcta === 'c'

            ]);

            $respuestas[3]->update([

                'respuesta' => $request->respuesta_d,

                'es_correcta' =>
                    $request->respuesta_correcta === 'd'

            ]);
        }

        return redirect()
            ->route('preguntas.index')
            ->with(
                'success',
                'Pregunta actualizada correctamente.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pregunta $pregunta)
    {
        $pregunta->delete();

        return redirect()
            ->route('preguntas.index')
            ->with(
                'success',
                'Pregunta eliminada correctamente.'
            );
    }
}
