<x-layouts.admin>

    <x-slot:title>
        Dashboard
    </x-slot:title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="space-y-8">

        <div>

            <h1 class="text-4xl font-bold text-slate-800">

                Sistema de Parasitología Animal

            </h1>

            <p class="text-slate-500 mt-2">

                Plataforma para la gestión, consulta y evaluación de información parasitológica.

            </p>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <div class="bg-white rounded-3xl p-6 shadow-sm">

                <div class="text-4xl mb-2">
                    🦠
                </div>

                <div class="text-slate-500">

                    Parásitos

                </div>

                <div class="text-4xl font-bold">

                    {{ $totalParasitos }}

                </div>

            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm">

                <div class="text-4xl mb-2">
                    🌎
                </div>

                <div class="text-slate-500">

                    Distribuciones

                </div>

                <div class="text-4xl font-bold">

                    {{ $totalMapas }}

                </div>

            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm">

                <div class="text-4xl mb-2">
                    🔬
                </div>

                <div class="text-slate-500">

                    Partes Anatómicas

                </div>

                <div class="text-4xl font-bold">

                    {{ $totalPartes }}

                </div>

            </div>

            <div class="bg-white rounded-3xl p-6 shadow-sm">

                <div class="text-4xl mb-2">
                    ❓
                </div>

                <div class="text-slate-500">

                    Preguntas

                </div>

                <div class="text-4xl font-bold">

                    {{ $totalPreguntas }}

                </div>

            </div>

        </div>

        <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

            <div class="p-8 border-b">

                <h2 class="text-2xl font-bold">

                    Resumen General

                </h2>

            </div>

            <div class="p-8">

                <div class="grid md:grid-cols-2 gap-8">

                    <div>

                        <p class="text-slate-600 leading-8">

                            Este sistema permite gestionar información
                            relacionada con parásitos de importancia veterinaria,
                            incluyendo distribución geográfica, partes anatómicas,
                            contenido educativo y evaluaciones tipo quiz.

                        </p>

                    </div>

                    <div>

                        <ul class="space-y-3">

                            <li>
                                🦠 {{ $totalParasitos }} Parásitos registrados
                            </li>

                            <li>
                                🌎 {{ $totalMapas }} Distribuciones geográficas
                            </li>

                            <li>
                                🔬 {{ $totalPartes }} Partes anatómicas
                            </li>

                            <li>
                                ❓ {{ $totalPreguntas }} Preguntas de evaluación
                            </li>

                            <li>
                                👥 {{ $totalUsuarios }} Usuarios registrados
                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

        <div class="bg-white rounded-3xl shadow-sm p-8">

            <h2 class="text-2xl font-bold mb-6">

                Estadísticas del Sistema

            </h2>

            <canvas id="graficaSistema"></canvas>

        </div>

        <div class="grid md:grid-cols-2 gap-6">

            <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

                <div class="p-6 border-b">

                    <h2 class="text-xl font-bold">

                        Top Parásitos

                    </h2>

                </div>

                <div class="p-6">

                    @forelse($topParasitos as $parasito)

                        <div class="flex justify-between py-3 border-b">

                            <span>

                                {{ $parasito->nombre_comun }}

                            </span>

                            <span class="font-semibold">

                                {{ $parasito->mapas_epidemiologicos_count }}

                            </span>

                        </div>

                    @empty

                        <p>

                            No hay información.

                        </p>

                    @endforelse

                </div>

            </div>

            <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

                <div class="p-6 border-b">

                    <h2 class="text-xl font-bold">

                        Últimos Parásitos Registrados

                    </h2>

                </div>

                <div class="p-6">

                    @forelse($ultimosParasitos as $parasito)

                        <div class="py-3 border-b">

                            {{ $parasito->nombre_comun }}

                        </div>

                    @empty

                        <p>

                            No existen registros.

                        </p>

                    @endforelse

                </div>

            </div>

        </div>

        <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

            <div class="p-6 border-b">

                <h2 class="text-xl font-bold">

                    Accesos Rápidos

                </h2>

            </div>

            <div class="p-8">

                <div class="grid md:grid-cols-4 gap-4">

                    <a
                        href="{{ route('parasitos.create') }}"
                        class="bg-indigo-600 text-white text-center py-4 rounded-xl">

                        + Nuevo Parásito

                    </a>

                    <a
                        href="{{ route('mapa-epidemiologicos.create') }}"
                        class="bg-green-600 text-white text-center py-4 rounded-xl">

                        + Distribución

                    </a>

                    <a
                        href="{{ route('parte-parasitos.create') }}"
                        class="bg-orange-600 text-white text-center py-4 rounded-xl">

                        + Parte Anatómica

                    </a>

                    <a
                        href="{{ route('preguntas.create') }}"
                        class="bg-purple-600 text-white text-center py-4 rounded-xl">

                        + Pregunta

                    </a>

                </div>

            </div>

        </div>

    </div>

    <script>

        const ctx =
            document.getElementById(
                'graficaSistema'
            );

        new Chart(ctx, {

            type: 'bar',

            data: {

                labels: [

                    'Parásitos',
                    'Mapas',
                    'Partes',
                    'Preguntas'

                ],

                datasets: [{

                    label: 'Cantidad',

                    data: [

                        {{ $totalParasitos }},
                        {{ $totalMapas }},
                        {{ $totalPartes }},
                        {{ $totalPreguntas }}

                    ]

                }]

            }

        });

    </script>

</x-layouts.admin>