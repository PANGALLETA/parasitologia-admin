<x-layouts.admin>

    <x-slot:title>
        Mapa de Colombia
    </x-slot:title>

    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <div class="bg-white rounded-2xl shadow-sm p-6">

        <h2 class="text-2xl font-bold mb-4">
            Mapa de Colombia
        </h2>

        <div class="mb-4">

            <label class="block font-medium mb-2">
                Nivel de Presencia
            </label>

            <select
                id="nivel_presencia"
                class="w-full rounded-lg border-slate-300">

                <option value="alta">
                    Alta
                </option>

                <option value="media">
                    Media
                </option>

                <option value="baja">
                    Baja
                </option>

            </select>

        </div>

        <div
            id="map"
            style="height: 700px;">
        </div>

        <div
            id="listadoDepartamentos"
            class="mt-4 space-y-2">
        </div>

    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>

        const map = L.map('map').setView(
            [4.5709, -74.2973],
            5
        );

        let departamentosSeleccionados = [];

        function obtenerColor(nivel)
        {
            switch(nivel)
            {
                case 'alta':
                    return '#dc2626';

                case 'media':
                    return '#facc15';

                case 'baja':
                    return '#22c55e';

                default:
                    return '#94a3b8';
            }
        }

        function actualizarListado()
        {
            const contenedor =
                document.getElementById(
                    'listadoDepartamentos'
                );

            contenedor.innerHTML = '';

            departamentosSeleccionados.forEach(
                item => {

                    let color = '';

                    if(item.nivel === 'alta')
                        color = '🔴';

                    if(item.nivel === 'media')
                        color = '🟡';

                    if(item.nivel === 'baja')
                        color = '🟢';

                    contenedor.innerHTML += `
                        <div class="border rounded-lg p-2">

                            ${color}
                            ${item.departamento}
                            -
                            ${item.nivel.toUpperCase()}

                        </div>
                    `;
                }
            );
        }

        L.tileLayer(
            'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                maxZoom: 18
            }
        ).addTo(map);

        fetch('/geojson/colombia_departamentos.geojson')
        .then(response => response.json())
        .then(data => {

            L.geoJSON(data, {

                style: {
                    color: '#334155',
                    weight: 1,
                    fillColor: '#94a3b8',
                    fillOpacity: 0.5
                },

                onEachFeature: function(feature, layer) {

                    const nombre =
                        feature.properties.NOMBRE_DPT;

                    layer.bindTooltip(nombre);

                    layer.on('click', function() {

                        const departamento =
                            feature.properties.NOMBRE_DPT;

                        const nivel =
                            document.getElementById(
                                'nivel_presencia'
                            ).value;

                        departamentosSeleccionados =
                            departamentosSeleccionados.filter(
                                item =>
                                    item.departamento !==
                                    departamento
                            );

                        departamentosSeleccionados.push({

                            departamento,
                            nivel

                        });

                        layer.setStyle({

                            fillColor:
                                obtenerColor(nivel),

                            fillOpacity: 0.8

                        });

                        actualizarListado();

                    });

                }

            }).addTo(map);

        });

    </script>

</x-layouts.admin>