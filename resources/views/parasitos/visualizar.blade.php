<x-layouts.admin>

    <x-slot:title>
        {{ $parasito->nombre_comun }}
    </x-slot:title>

    <div class="max-w-5xl mx-auto">

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            @if($parasito->imagen_principal)

                <div class="relative h-[500px] overflow-hidden rounded-2xl">

                    <img
                        src="{{ asset('storage/' . $parasito->imagen_principal) }}"
                        class="absolute inset-0 w-full h-full object-cover blur-xl scale-110 opacity-40">

                    <img
                        src="{{ asset('storage/' . $parasito->imagen_principal) }}"
                        class="relative z-10 w-full h-full object-contain cursor-pointer"
                        onclick="abrirImagen(this.src)">

                </div>

            @endif

            <div class="p-8">

                <h1 class="text-4xl font-bold text-slate-800">

                    {{ $parasito->nombre_comun }}

                </h1>

                <h2 class="text-xl italic text-slate-500 mt-2">

                    {{ $parasito->nombre_cientifico }}

                </h2>

                <div class="grid grid-cols-2 gap-6 mt-8">

                    <div>

                        <h3 class="font-bold mb-2">
                            Familia
                        </h3>

                        <p>
                            {{ $parasito->familia }}
                        </p>

                    </div>

                    <div>

                        <h3 class="font-bold mb-2">
                            Género
                        </h3>

                        <p>
                            {{ $parasito->genero }}
                        </p>

                    </div>

                </div>

                <div class="mt-8">

                    <h3 class="font-bold mb-2">
                        Descripción General
                    </h3>

                    <p>
                        {{ $parasito->descripcion_general }}
                    </p>

                </div>

                <div class="mt-8">

                    <h3 class="font-bold mb-2">
                        Morfología
                    </h3>

                    <p>
                        {{ $parasito->morfologia }}
                    </p>

                </div>

                <div class="mt-8">

                    <h3 class="font-bold mb-2">
                        Hospedadores
                    </h3>

                    <p>
                        {{ $parasito->hospedadores }}
                    </p>

                </div>

                <div class="mt-8">

                    <h3 class="font-bold mb-2">
                        Síntomas
                    </h3>

                    <p>
                        {{ $parasito->sintomas }}
                    </p>

                </div>

                <div class="mt-8">

                    <h3 class="font-bold mb-2">
                        Tratamiento
                    </h3>

                    <p>
                        {{ $parasito->tratamiento }}
                    </p>

                </div>

            </div>

        </div>

    </div>

    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <div class="mt-8 max-w-5xl mx-auto">

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b">

                <h2 class="text-2xl font-bold text-slate-800">

                    Distribución Geográfica

                </h2>

                <p class="text-slate-500 mt-1">

                    Presencia epidemiológica registrada en Colombia.

                </p>

            </div>

            <div class="p-6">

                <div class="flex gap-6 mb-6">

                    <div class="flex items-center gap-2">

                        <span class="w-4 h-4 rounded-full bg-red-500 inline-block"></span>

                        Alta

                    </div>

                    <div class="flex items-center gap-2">

                        <span class="w-4 h-4 rounded-full bg-yellow-400 inline-block"></span>

                        Media

                    </div>

                    <div class="flex items-center gap-2">

                        <span class="w-4 h-4 rounded-full bg-green-500 inline-block"></span>

                        Baja

                    </div>

                </div>

                <div
                    id="map"
                    class="rounded-xl border border-slate-200"
                    style="height: 450px;">
                </div>

            </div>

        </div>

        @if($mapas->first()?->observaciones)

        <div class="mt-8">

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                <div class="px-8 py-6 border-b">

                    <h2 class="text-2xl font-bold text-slate-800">

                        Observaciones Epidemiológicas

                    </h2>

                    <p class="text-slate-500 mt-1">

                        Información complementaria sobre la distribución geográfica.

                    </p>

                </div>

                <div class="p-8">

                    <div class="leading-relaxed text-slate-700">

                        {{ $mapas->first()->observaciones }}

                    </div>

                </div>

            </div>

        </div>

        @endif

        @if($partes->count())

        <div class="mt-10 max-w-5xl mx-auto">

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                <div class="px-8 py-6 border-b">

                    <h2 class="text-3xl font-bold text-slate-800">

                        Partes Anatómicas

                    </h2>

                    <p class="text-slate-500 mt-2">

                        Identificación de las principales estructuras anatómicas del parásito.

                    </p>

                </div>

                <div class="p-8">

                    <div class="grid md:grid-cols-2 gap-8">

                        @foreach($partes as $parte)

                            <div
                                class="border rounded-2xl overflow-hidden hover:shadow-lg transition">

                                <img
                                    src="{{ asset('storage/' . $parte->imagen) }}"
                                    class="w-full h-64 object-cover cursor-pointer"
                                    onclick="abrirImagen(this.src)">

                                <div class="p-5">

                                    <div class="flex justify-between items-center">

                                        <h3 class="text-xl font-bold">

                                            {{ $parte->nombre }}

                                        </h3>

                                        <span
                                            class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm">

                                            #{{ $parte->orden }}

                                        </span>

                                    </div>

                                    <p class="text-slate-600 mt-4 leading-relaxed">

                                        {{ $parte->descripcion }}

                                    </p>

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

        @endif
        
        @if($preguntas->count())

        <div class="mt-10 max-w-5xl mx-auto">

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                <div class="px-8 py-6 border-b">

                    <h2 class="text-3xl font-bold text-slate-800">

                        Quiz de Evaluación

                    </h2>

                    <p class="text-slate-500 mt-2">

                        Pon a prueba tus conocimientos sobre este parásito.

                    </p>

                </div>

                <div class="p-8 text-center">

                    <div class="text-5xl mb-4">
                        🧠
                    </div>

                    <p class="text-slate-600 mb-6">

                        Este parásito contiene

                        <strong>{{ $preguntas->count() }}</strong>

                        preguntas disponibles.

                    </p>

                    <button
                        onclick="abrirQuiz()"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl">

                        Iniciar Quiz

                    </button>

                </div>

            </div>

        </div>

        @endif

        <div
            id="modalQuiz"
            class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">

            <div class="bg-white rounded-3xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">

                <div class="p-6 border-b flex justify-between items-center">

                    <h2 class="text-2xl font-bold">

                        Quiz de Evaluación

                    </h2>

                    <button
                        onclick="cerrarQuiz()"
                        class="text-3xl">

                        ×

                    </button>

                </div>

                <div class="p-8">

                    @foreach($preguntas as $index => $pregunta)

                        <div class="mb-8">

                            <h3 class="font-bold text-lg mb-4">

                                {{ $index + 1 }}.
                                {{ $pregunta->pregunta }}

                            </h3>

                            <div class="space-y-3">

                                @foreach($pregunta->respuestas as $respuesta)

                                    <label
                                        class="flex items-center gap-3 border rounded-xl p-4 cursor-pointer hover:bg-slate-50">

                                        <input
                                            type="radio"
                                            name="pregunta_{{ $pregunta->id }}"
                                            value="{{ $respuesta->id }}"
                                            data-correcta="{{ $respuesta->es_correcta ? 1 : 0 }}">

                                        <span>

                                            {{ $respuesta->respuesta }}

                                        </span>

                                    </label>

                                @endforeach

                            </div>

                        </div>

                    @endforeach

                    <div class="mt-8 text-center">

                        <button
                            type="button"
                            onclick="calificarQuiz()"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl">

                            Finalizar Quiz

                        </button>

                    </div>

                    <div
                        id="resultadoQuiz"
                        class="hidden mt-6 p-6 rounded-xl bg-slate-50 border">

                    </div>

                </div>

            </div>

        </div>

    </div>

<script>

function abrirQuiz()
{
    document
        .getElementById('modalQuiz')
        .classList.remove('hidden');
}

function cerrarQuiz()
{
    document
        .getElementById('modalQuiz')
        .classList.add('hidden');
}

function calificarQuiz()
{
    let total = 0;
    let correctas = 0;

    @foreach($preguntas as $pregunta)

        total++;

        const seleccionada =
            document.querySelector(
                'input[name="pregunta_{{ $pregunta->id }}"]:checked'
            );

        if(
            seleccionada &&
            seleccionada.dataset.correcta === '1'
        )
        {
            correctas++;
        }

    @endforeach

    let porcentaje =
        Math.round(
            (correctas / total) * 100
        );

    const resultado =
        document.getElementById(
            'resultadoQuiz'
        );

    resultado.classList.remove(
        'hidden'
    );

    let mensaje = '';

    if(porcentaje >= 80)
    {
        mensaje = 'Excelente conocimiento';
    }
    else if(porcentaje >= 60)
    {
        mensaje = 'Buen resultado';
    }
    else
    {
        mensaje = 'Debes repasar este tema';
    }

    resultado.innerHTML = `
        <div class="text-center">

            <h3 class="text-2xl font-bold mb-2">

                Resultado del Quiz

            </h3>

            <p class="text-lg">

                ${correctas} de ${total}
                respuestas correctas

            </p>

            <p class="text-5xl font-bold text-indigo-600 mt-4">

                ${porcentaje}%

            </p>

            <p class="mt-4 text-slate-600">

                ${mensaje}

            </p>

        </div>
    `;
}

</script>


<script>

const distribuciones = @json($mapas);

</script>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

const map = L.map('map').setView(
    [4.5709, -74.2973],
    5
);

L.tileLayer(
    'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        maxZoom: 18
    }
).addTo(map);

function obtenerColor(nombreDepartamento)
{
    const dep =
        distribuciones.find(
            item =>
                item.departamento ===
                nombreDepartamento
        );

    if(!dep)
        return '#d1d5db';

    switch(dep.nivel_presencia)
    {
        case 'alta':
            return '#dc2626';

        case 'media':
            return '#facc15';

        case 'baja':
            return '#22c55e';

        default:
            return '#d1d5db';
    }
}

fetch('/geojson/colombia_departamentos.geojson')
.then(response => response.json())
.then(data => {

    L.geoJSON(data, {

        style: function(feature)
        {
            return {

                color: '#334155',

                weight: 1,

                fillColor:
                    obtenerColor(
                        feature.properties.NOMBRE_DPT
                    ),

                fillOpacity: 0.8

            };
        },

        onEachFeature: function(feature, layer)
        {
            const nombre =
                feature.properties.NOMBRE_DPT;

            const dep =
                distribuciones.find(
                    item =>
                        item.departamento ===
                        nombre
                );

            layer.bindPopup(`

                <strong>${nombre}</strong>

                <br>

                Nivel:

                ${
                    dep
                    ? dep.nivel_presencia.toUpperCase()
                    : 'SIN INFORMACIÓN'
                }

            `);
        }

    }).addTo(map);

});

</script>

</x-layouts.admin>