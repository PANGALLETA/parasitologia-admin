<x-layouts.admin>

    <x-slot:title>
        Editar Pregunta
    </x-slot:title>

    @php

        $respuestaA = $pregunta->respuestas[0] ?? null;
        $respuestaB = $pregunta->respuestas[1] ?? null;
        $respuestaC = $pregunta->respuestas[2] ?? null;
        $respuestaD = $pregunta->respuestas[3] ?? null;

    @endphp

    <div class="max-w-5xl mx-auto">

        <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

            <div class="p-8 border-b">

                <h2 class="text-3xl font-bold text-slate-800">

                    Editar Pregunta

                </h2>

                <p class="text-slate-500 mt-2">

                    Modifique la información de la pregunta.

                </p>

            </div>

            <form
                action="{{ route('preguntas.update', $pregunta) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="p-8 space-y-6">

                    <div>

                        <label class="block font-semibold mb-2">

                            Parásito *

                        </label>

                        <select
                            name="parasito_id"
                            required
                            class="w-full rounded-xl border-slate-300">

                            @foreach($parasitos as $parasito)

                                <option
                                    value="{{ $parasito->id }}"
                                    {{ $pregunta->parasito_id == $parasito->id ? 'selected' : '' }}>

                                    {{ $parasito->nombre_comun }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div>

                        <label class="block font-semibold mb-2">

                            Pregunta *

                        </label>

                        <textarea
                            name="pregunta"
                            rows="3"
                            required
                            class="w-full rounded-xl border-slate-300">{{ $pregunta->pregunta }}</textarea>

                    </div>

                    <div class="border rounded-2xl p-6">

                        <h3 class="font-bold text-lg mb-4">

                            Respuestas

                        </h3>

                        <div class="space-y-4">

                            <div class="flex items-center gap-4">

                                <input
                                    type="radio"
                                    name="respuesta_correcta"
                                    value="a"
                                    {{ $respuestaA?->es_correcta ? 'checked' : '' }}>

                                <input
                                    type="text"
                                    name="respuesta_a"
                                    value="{{ $respuestaA?->respuesta }}"
                                    required
                                    class="flex-1 rounded-xl border-slate-300">

                            </div>

                            <div class="flex items-center gap-4">

                                <input
                                    type="radio"
                                    name="respuesta_correcta"
                                    value="b"
                                    {{ $respuestaB?->es_correcta ? 'checked' : '' }}>

                                <input
                                    type="text"
                                    name="respuesta_b"
                                    value="{{ $respuestaB?->respuesta }}"
                                    required
                                    class="flex-1 rounded-xl border-slate-300">

                            </div>

                            <div class="flex items-center gap-4">

                                <input
                                    type="radio"
                                    name="respuesta_correcta"
                                    value="c"
                                    {{ $respuestaC?->es_correcta ? 'checked' : '' }}>

                                <input
                                    type="text"
                                    name="respuesta_c"
                                    value="{{ $respuestaC?->respuesta }}"
                                    required
                                    class="flex-1 rounded-xl border-slate-300">

                            </div>

                            <div class="flex items-center gap-4">

                                <input
                                    type="radio"
                                    name="respuesta_correcta"
                                    value="d"
                                    {{ $respuestaD?->es_correcta ? 'checked' : '' }}>

                                <input
                                    type="text"
                                    name="respuesta_d"
                                    value="{{ $respuestaD?->respuesta }}"
                                    required
                                    class="flex-1 rounded-xl border-slate-300">

                            </div>

                        </div>

                    </div>

                    <div>

                        <label class="flex items-center gap-3">

                            <input
                                type="checkbox"
                                name="activo"
                                value="1"
                                {{ $pregunta->activo ? 'checked' : '' }}>

                            <span>

                                Activa

                            </span>

                        </label>

                    </div>

                </div>

                <div class="px-8 pb-8">

                    <button
                        type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl">

                        Actualizar Pregunta

                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts.admin>