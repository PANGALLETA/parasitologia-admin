<x-layouts.admin>

    <x-slot:title>
        Distribución Geográfica
    </x-slot:title>

    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <div class="bg-white rounded-2xl shadow-sm p-6">

        <div class="flex justify-between items-center mb-6">

            <div>

                <h2 class="text-3xl font-bold">

                    {{ $parasito->nombre_comun }}

                </h2>

                <p class="text-slate-500 italic">

                    {{ $parasito->nombre_cientifico }}

                </p>

            </div>

            <a
                href="{{ route('mapa-epidemiologicos.index') }}"
                class="px-4 py-2 bg-slate-200 rounded-lg">

                Volver

            </a>

        </div>

        <div class="mb-6 flex gap-6">

            <div>
                🔴 Alta presencia
            </div>

            <div>
                🟡 Media presencia
            </div>

            <div>
                🟢 Baja presencia
            </div>

        </div>

        <div
            id="map"
            style="height: 750px;">
        </div>

    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>

        const distribuciones =
            @json($mapas);

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