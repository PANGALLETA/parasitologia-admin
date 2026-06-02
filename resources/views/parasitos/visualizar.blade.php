<x-layouts.admin>

    <x-slot:title>
        {{ $parasito->nombre_comun }}
    </x-slot:title>

    <div class="max-w-5xl mx-auto">

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            @if($parasito->imagen_principal)

                <img
                    src="{{ asset('storage/' . $parasito->imagen_principal) }}"
                    class="w-full h-96 object-cover">

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

                        🔴 Alta

                    </div>

                    <div class="flex items-center gap-2">

                        <span class="w-4 h-4 rounded-full bg-yellow-400 inline-block"></span>

                        🟡 Media

                    </div>

                    <div class="flex items-center gap-2">

                        <span class="w-4 h-4 rounded-full bg-green-500 inline-block"></span>

                        🟢 Baja

                    </div>

                </div>

                <div
                    id="map"
                    class="rounded-xl border border-slate-200"
                    style="height: 450px;">
                </div>

            </div>

        </div>

    </div>

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