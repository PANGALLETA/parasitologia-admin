<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AsistenteIaController extends Controller
{
    public function index()
    {
        return view('asistente-ia.index');
    }

    public function preguntar(Request $request)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post(
            'https://api.groq.com/openai/v1/chat/completions',
            [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $request->mensaje
                    ]
                ]
            ]
        );

        return response()->json([
            'respuesta' =>
                $response['choices'][0]['message']['content']
        ]);
    }
}