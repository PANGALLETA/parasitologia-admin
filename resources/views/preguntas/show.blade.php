<x-layouts.admin>

    <x-slot:title>
        Visualizar Pregunta
    </x-slot:title>

    <div class="max-w-5xl mx-auto">

        <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

            <div class="p-8 border-b">

                <div class="flex justify-between items-center">

                    <div>

                        <h2 class="text-3xl font-bold text-slate-800">

                            Visualizar Pregunta

                        </h2>

                        <p class="text-slate-500 mt-2">

                            Detalle completo de la pregunta.

                        </p>

                    </div>

                    <a
                        href="{{ route('preguntas.index') }}"
                        class="bg-slate-100 hover:bg-slate-200 px-4 py-2 rounded-xl">

                        Volver

                    </a>

                </div>

            </div>

            <div class="p-8 space-y-8">

                <div>

                    <label class="block text-sm text-slate-500 mb-2">

                        Parásito

                    </label>

                    <div class="text-lg font-semibold">

                        {{ $pregunta->parasito?->nombre_comun }}

                    </div>

                </div>

                <div>

                    <label class="block text-sm text-slate-500 mb-2">

                        Pregunta

                    </label>

                    <div
                        class="bg-slate-50 border rounded-xl p-5 text-lg font-medium">

                        {{ $pregunta->pregunta }}

                    </div>

                </div>

                <div>

                    <label class="block text-sm text-slate-500 mb-4">

                        Respuestas

                    </label>

                    <div class="space-y-3">

                        @foreach($pregunta->respuestas as $respuesta)

                            <div
                                class="border rounded-xl p-4 flex items-center justify-between
                                {{ $respuesta->es_correcta
                                    ? 'bg-green-50 border-green-300'
                                    : 'bg-white' }}">

                                <span>

                                    {{ $respuesta->respuesta }}

                                </span>

                                @if($respuesta->es_correcta)

                                    <span
                                        class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

                                        Correcta

                                    </span>

                                @endif

                            </div>

                        @endforeach

                    </div>

                </div>

                <div>

                    <label class="block text-sm text-slate-500 mb-2">

                        Estado

                    </label>

                    @if($pregunta->activo)

                        <span
                            class="bg-green-100 text-green-700 px-4 py-2 rounded-full">

                            Activa

                        </span>

                    @else

                        <span
                            class="bg-red-100 text-red-700 px-4 py-2 rounded-full">

                            Inactiva

                        </span>

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-layouts.admin>