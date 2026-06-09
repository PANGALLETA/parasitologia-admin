<?php

namespace App\Http\Controllers;

use App\Models\Parasito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\MapaEpidemiologico;
use App\Models\ParteParasito;

class ParasitoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Parasito::query();

        if ($request->filled('buscar')) {

            $query->where(function ($q) use ($request) {

                $q->where('nombre_comun', 'like', '%' . $request->buscar . '%')
                ->orWhere('nombre_cientifico', 'like', '%' . $request->buscar . '%');

            });

        }

        if ($request->filled('activo')) {

            $query->where('activo', $request->activo);

        }

        $parasitos = $query
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('parasitos.index', compact('parasitos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('parasitos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_comun' => 'required|max:255',
            'nombre_cientifico' => 'required|max:255',
            'imagen_principal' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'nombre_comun.required' => 'El nombre común es obligatorio.',
            'nombre_cientifico.required' => 'El nombre científico es obligatorio.',
            'imagen_principal.image' => 'El archivo debe ser una imagen.',
            'imagen_principal.mimes' => 'La imagen debe ser JPG, JPEG, PNG o WEBP.',
            'imagen_principal.max' => 'La imagen no puede superar los 5 MB.',
        ]);

        $rutaImagen = null;

        if ($request->hasFile('imagen_principal')) {

            $rutaImagen = $request
                ->file('imagen_principal')
                ->store('parasitos', 'public');

        }

        $parasito = Parasito::create([
            'nombre_comun' => $request->nombre_comun,
            'nombre_cientifico' => $request->nombre_cientifico,
            'familia' => $request->familia,
            'genero' => $request->genero,
            'descripcion_general' => $request->descripcion_general,
            'morfologia' => $request->morfologia,
            'hospedadores' => $request->hospedadores,
            'sintomas' => $request->sintomas,
            'tratamiento' => $request->tratamiento,
            'imagen_principal' => $rutaImagen,
            'activo' => $request->has('activo'),
        ]);

        return redirect()
            ->route('parasitos.index')
            ->with('success', 'Parásito registrado correctamente.');
    }
        /**
     * Display the specified resource.
     */
    public function show(Parasito $parasito)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Parasito $parasito)
    {
        return view('parasitos.edit', compact('parasito'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Parasito $parasito)
    {

        $request->validate([
            'nombre_comun' => 'required|max:255',
            'nombre_cientifico' => 'required|max:255',
            'imagen_principal' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'nombre_comun.required' => 'El nombre común es obligatorio.',
            'nombre_cientifico.required' => 'El nombre científico es obligatorio.',
            'imagen_principal.image' => 'El archivo debe ser una imagen.',
            'imagen_principal.mimes' => 'La imagen debe ser JPG, JPEG, PNG o WEBP.',
            'imagen_principal.max' => 'La imagen no puede superar los 5 MB.',
        ]);

        $rutaImagen = $parasito->imagen_principal;

        if ($request->hasFile('imagen_principal')) {

            if (
                $parasito->imagen_principal &&
                Storage::disk('public')->exists($parasito->imagen_principal)
            ) {
                Storage::disk('public')->delete($parasito->imagen_principal);
            }

            $rutaImagen = $request
                ->file('imagen_principal')
                ->store('parasitos', 'public');
        }

        $parasito->update([
            'nombre_comun' => $request->nombre_comun,
            'nombre_cientifico' => $request->nombre_cientifico,
            'familia' => $request->familia,
            'genero' => $request->genero,
            'descripcion_general' => $request->descripcion_general,
            'morfologia' => $request->morfologia,
            'hospedadores' => $request->hospedadores,
            'sintomas' => $request->sintomas,
            'tratamiento' => $request->tratamiento,
            'imagen_principal' => $rutaImagen,
            'activo' => $request->has('activo'),
        ]);

        return redirect()
            ->route('parasitos.index')
            ->with('success', 'Parásito actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Parasito $parasito)
    {
        $parasito->update([
            'activo' => !$parasito->activo
        ]);

        return redirect()
            ->route('parasitos.index')
            ->with(
                'success',
                $parasito->activo
                    ? 'Parásito activado correctamente.'
                    : 'Parásito desactivado correctamente.'
            );
    }

    public function visualizar($uuid)
    {
        $parasito = Parasito::where(
            'uuid',
            $uuid
        )->firstOrFail();

        $mapas = MapaEpidemiologico::where(
            'parasito_id',
            $parasito->id
        )->get();

        $partes = ParteParasito::where(
            'parasito_id',
            $parasito->id
        )
        ->where('activo', true)
        ->orderBy('orden')
        ->get();

        return view(
            'parasitos.visualizar',
            compact(
                'parasito',
                'mapas',
                'partes'
            )
        );
    }
}
