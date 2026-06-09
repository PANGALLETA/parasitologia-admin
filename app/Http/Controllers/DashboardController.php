<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pregunta;
use App\Models\Parasito;
use App\Models\ParteParasito;
use App\Models\MapaEpidemiologico;

class DashboardController extends Controller
{
    public function index()
    {
        $totalParasitos = Parasito::count();

        $totalMapas = MapaEpidemiologico::count();

        $totalPartes = ParteParasito::count();

        $totalPreguntas = Pregunta::count();

        $totalUsuarios = User::count();

        $topParasitos = Parasito::withCount(
            'mapasEpidemiologicos'
        )
        ->orderByDesc(
            'mapas_epidemiologicos_count'
        )
        ->take(5)
        ->get();

        $ultimosParasitos = Parasito::latest()
            ->take(5)
            ->get();

        $ultimasPreguntas = Pregunta::latest()
            ->take(5)
            ->get();

        return view(
            'dashboard',
            compact(
                'totalParasitos',
                'totalMapas',
                'totalPartes',
                'totalPreguntas',
                'totalUsuarios',
                'topParasitos',
                'ultimosParasitos',
                'ultimasPreguntas'
            )
        );
    }
}