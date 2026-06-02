<x-layouts.admin>

<x-slot:title>
    Editar Distribución Geográfica
</x-slot:title>

<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet/dist/leaflet.css" />

<script>

const distribucionesExistentes = @json(

    $mapas->map(function($item){

        return [

            'departamento' =>
                $item->departamento,

            'nivel' =>
                $item->nivel_presencia

        ];

    })

);

</script>

<div class="max-w-7xl mx-auto">

@if ($errors->any())

    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

        <ul class="list-disc pl-5 text-red-700">

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

<form
    action="{{ route('mapa-epidemiologicos.update', $parasito->id) }}"
    method="POST">

    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- FORMULARIO -->

        <div class="lg:col-span-1">

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                <div class="px-6 py-5 border-b">

                    <h2 class="text-2xl font-bold text-slate-800">
                        Editar Distribución Geográfica
                    </h2>

                    <p class="text-slate-500 mt-1">
                        Actualice los departamentos seleccionados en el mapa.
                    </p>

                </div>

                <div class="p-6 space-y-6">

                    <input
                        type="hidden"
                        name="parasito_id"
                        value="{{ $parasito->id }}">

                    <div class="rounded-xl bg-slate-100 p-4">

                        <div class="font-semibold text-lg">

                            {{ $parasito->nombre_comun }}

                        </div>

                        <div class="text-sm text-slate-500">

                            {{ $parasito->nombre_cientifico }}

                        </div>

                    </div>

                    <div>

                        <label class="block text-sm font-medium mb-2">

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

                    <div>

                        <label class="block text-sm font-medium mb-2">

                            Observaciones

                        </label>

                        <textarea
                            name="observaciones"
                            rows="4"
                            class="w-full rounded-lg border-slate-300">{{ $mapas->first()->observaciones }}</textarea>

                    </div>

                    <input
                        type="hidden"
                        id="departamentos_json"
                        name="departamentos">

                    <div>

                        <h3 class="font-semibold mb-3">

                            Departamentos Seleccionados

                        </h3>

                        <div
                            id="listadoDepartamentos"
                            class="space-y-2">
                        </div>

                    </div>

                    <button
                        type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl">

                        Actualizar Distribución

                    </button>

                </div>

            </div>

        </div>

        <!-- MAPA -->

        <div class="lg:col-span-2">

            <div class="bg-white rounded-2xl shadow-sm p-4">

                <div
                    id="map"
                    style="height: 800px;">
                </div>

            </div>

        </div>

    </div>

</form>
```

</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

    const map = L.map('map').setView(
        [4.5709, -74.2973],
        5
    );

    let departamentosSeleccionados =
        distribucionesExistentes;

    let geoLayer;

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

                let icono = '';

                if(item.nivel === 'alta')
                    icono = '🔴';

                if(item.nivel === 'media')
                    icono = '🟡';

                if(item.nivel === 'baja')
                    icono = '🟢';

                contenedor.innerHTML += `
                    <div class="border rounded-lg p-3 flex justify-between items-center">

                        <div>

                            ${icono}
                            ${item.departamento}
                            -
                            ${item.nivel.toUpperCase()}

                        </div>

                        <button
                            type="button"
                            onclick="eliminarDepartamento('${item.departamento}')"
                            class="w-8 h-8 rounded-full bg-red-100 text-red-600 hover:bg-red-200 font-bold text-lg">

                            ×

                        </button>

                    </div>
                `;
            }
        );

        document.getElementById(
            'departamentos_json'
        ).value = JSON.stringify(
            departamentosSeleccionados
        );
    }

    function eliminarDepartamento(departamento)
    {
        departamentosSeleccionados =
            departamentosSeleccionados.filter(
                item =>
                    item.departamento !== departamento
            );

        geoLayer.eachLayer(layer => {

            if(
                layer.feature.properties.NOMBRE_DPT ===
                departamento
            ){

                layer.setStyle({

                    fillColor: '#94a3b8',
                    fillOpacity: 0.5

                });

            }

        });

        actualizarListado();
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

        geoLayer = L.geoJSON(data, {

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

                const existe =
                    departamentosSeleccionados.find(
                        item =>
                            item.departamento === nombre
                    );

                if(existe)
                {
                    layer.setStyle({

                        fillColor:
                            obtenerColor(
                                existe.nivel
                            ),

                        fillOpacity: 0.8

                    });
                }

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

        actualizarListado();

    });

</script>

</x-layouts.admin>
