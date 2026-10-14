<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class AsistenteIaController extends Controller
{
    public function index()
    {
        return view('asistente-ia.index');
    }
    public function preguntar(Request $request)
    {
        $request->validate([
            'mensaje' => 'required|string|max:5000',
        ]);

        try {

            $response = Http::withToken(config('services.groq.key'))
                ->acceptJson()
                ->timeout(60)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => config('services.groq.model'),
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Eres un asistente experto en parasitología animal. Responde en español de manera clara y precisa.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $request->mensaje
                        ]
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 1024
                ]);

            if ($response->failed()) {

                Log::error('Error API Groq', [
                    'status' => $response->status(),
                    'body' => $response->json()
                ]);

                return response()->json([
                    'error' => 'Error al consultar la inteligencia artificial',
                    'status' => $response->status(),
                    'detalle' => $response->json('error.message')
                ], 502);
            }

            $respuesta = $response->json('choices.0.message.content');

            if (empty($respuesta)) {

                Log::error('Respuesta inesperada de Groq', [
                    'body' => $response->json()
                ]);

                return response()->json([
                    'error' => 'La IA no devolvió una respuesta válida'
                ], 502);
            }

            return response()->json([
                'respuesta' => $respuesta
            ]);

        } catch (\Exception $e) {

            Log::error('Error Asistente IA', [
                'mensaje' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'No fue posible conectar con la IA'
            ], 500);
        }
    }
}