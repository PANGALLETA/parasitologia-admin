<x-layouts.admin>

    <x-slot:title>
        Nueva Pregunta
    </x-slot:title>

    <div class="max-w-5xl mx-auto">

        <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

            <div class="p-8 border-b">

                <h2 class="text-3xl font-bold text-slate-800">

                    Nueva Pregunta

                </h2>

                <p class="text-slate-500 mt-2">

                    Registre una pregunta para el sistema de evaluación.

                </p>

            </div>

            <form
                action="{{ route('preguntas.store') }}"
                method="POST">

                @csrf

                <div class="p-8 space-y-6">

                    <div>

                        <label class="block font-semibold mb-2">

                            Parásito *

                        </label>

                        <select
                            name="parasito_id"
                            required
                            class="w-full rounded-xl border-slate-300">

                            <option value="">
                                Seleccione...
                            </option>

                            @foreach($parasitos as $parasito)

                                <option
                                    value="{{ $parasito->id }}">

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
                            class="w-full rounded-xl border-slate-300"></textarea>

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
                                    required>

                                <input
                                    type="text"
                                    name="respuesta_a"
                                    placeholder="Respuesta A"
                                    required
                                    class="flex-1 rounded-xl border-slate-300">

                            </div>

                            <div class="flex items-center gap-4">

                                <input
                                    type="radio"
                                    name="respuesta_correcta"
                                    value="b">

                                <input
                                    type="text"
                                    name="respuesta_b"
                                    placeholder="Respuesta B"
                                    required
                                    class="flex-1 rounded-xl border-slate-300">

                            </div>

                            <div class="flex items-center gap-4">

                                <input
                                    type="radio"
                                    name="respuesta_correcta"
                                    value="c">

                                <input
                                    type="text"
                                    name="respuesta_c"
                                    placeholder="Respuesta C"
                                    required
                                    class="flex-1 rounded-xl border-slate-300">

                            </div>

                            <div class="flex items-center gap-4">

                                <input
                                    type="radio"
                                    name="respuesta_correcta"
                                    value="d">

                                <input
                                    type="text"
                                    name="respuesta_d"
                                    placeholder="Respuesta D"
                                    required
                                    class="flex-1 rounded-xl border-slate-300">

                            </div>

                        </div>

                        <p class="text-sm text-slate-500 mt-4">

                            Seleccione el círculo de la respuesta correcta.

                        </p>

                    </div>

                    <div>

                        <label class="flex items-center gap-3">

                            <input
                                type="checkbox"
                                name="activo"
                                value="1"
                                checked>

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

                        Guardar Pregunta

                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts.admin>