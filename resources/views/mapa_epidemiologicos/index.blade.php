<x-layouts.admin>

    <x-slot:title>
        Mapa Epidemiológico
    </x-slot:title>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

        <div class="p-6 border-b flex justify-between items-center">

            <div>

                <h2 class="text-2xl font-bold text-slate-800">
                    Distribución Geográfica
                </h2>

                <p class="text-slate-500">
                    Gestión de presencia geográfica de los parásitos en Colombia.
                </p>

            </div>

            <a href="{{ route('mapa-epidemiologicos.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">

                + Nueva Distribución

            </a>

        </div>

        @if(session('success'))

            <div class="m-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">

                {{ session('success') }}

            </div>

        @endif

        <form method="GET"
            action="{{ route('mapa-epidemiologicos.index') }}"
            class="p-6 border-b bg-slate-50">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <input
                    type="text"
                    name="buscar"
                    value="{{ request('buscar') }}"
                    placeholder="Buscar parásito..."
                    class="rounded-lg border-slate-300">

                <input
                    type="text"
                    name="departamento"
                    value="{{ request('departamento') }}"
                    placeholder="Departamento..."
                    class="rounded-lg border-slate-300">

                <select
                    name="nivel_presencia"
                    class="rounded-lg border-slate-300">

                    <option value="">
                        Todos los niveles
                    </option>

                    <option value="alta"
                        {{ request('nivel_presencia') === 'alta' ? 'selected' : '' }}>
                        Alta
                    </option>

                    <option value="media"
                        {{ request('nivel_presencia') === 'media' ? 'selected' : '' }}>
                        Media
                    </option>

                    <option value="baja"
                        {{ request('nivel_presencia') === 'baja' ? 'selected' : '' }}>
                        Baja
                    </option>

                </select>

                <button
                    type="submit"
                    class="bg-indigo-600 text-white rounded-lg">

                    Filtrar

                </button>

            </div>

        </form>

        <div class="overflow-x-auto">

            <div class="p-6">

                <div class="grid gap-6">

                    @forelse($mapas as $grupo)

                        @php
                            $primerRegistro = $grupo->first();
                        @endphp

                        <div class="bg-white border rounded-2xl shadow-sm p-6">

                            <div class="flex justify-between items-start">

                                <div>

                                    <h3 class="text-xl font-bold text-slate-800">

                                        {{ $primerRegistro->parasito->nombre_comun }}

                                    </h3>

                                    <p class="text-slate-500 italic">

                                        {{ $primerRegistro->parasito->nombre_cientifico }}

                                    </p>

                                </div>

                                <div class="flex gap-2">

                                    <a
                                        href="{{ route('mapa-epidemiologicos.show', $primerRegistro->parasito_id) }}"
                                        class="px-3 py-2 rounded-lg bg-blue-100 text-blue-700">

                                        Ver Mapa

                                    </a>

                                    <a
                                        href="{{ route('mapa-epidemiologicos.edit', $primerRegistro->parasito_id) }}"
                                        class="px-3 py-2 rounded-lg bg-amber-100 text-amber-700">

                                        Editar

                                    </a>

                                    <form
                                        action="{{ route('mapa-epidemiologicos.destroyPorParasito', $primerRegistro->parasito_id) }}"
                                        method="POST"
                                        class="form-eliminar-distribucion inline">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="px-3 py-2 rounded-lg bg-red-100 text-red-700 hover:bg-red-200">

                                            Eliminar

                                        </button>

                                    </form>

                                </div>

                            </div>

                            <div class="mt-4 space-y-2">

                                @foreach($grupo as $item)

                                    <div
                                        class="flex items-center justify-between border rounded-lg px-4 py-2">

                                        <div>

                                            @if($item->nivel_presencia === 'alta')

                                                🔴

                                            @elseif($item->nivel_presencia === 'media')

                                                🟡

                                            @else

                                                🟢

                                            @endif

                                            {{ $item->departamento }}

                                        </div>

                                        <div class="font-semibold">

                                            {{ strtoupper($item->nivel_presencia) }}

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    @empty

                        <div class="text-center py-10 text-slate-500">

                            No existen distribuciones registradas.

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

<script>

document.addEventListener('DOMContentLoaded', () => {

    document
        .querySelectorAll('.form-eliminar-distribucion')
        .forEach(form => {

            form.addEventListener('submit', function(e) {

                e.preventDefault();

                Swal.fire({

                    title: '¿Eliminar distribución?',

                    text: 'Se eliminarán todos los departamentos asociados a este parásito.',

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonColor: '#dc2626',

                    cancelButtonColor: '#64748b',

                    confirmButtonText: 'Sí, eliminar',

                    cancelButtonText: 'Cancelar'

                }).then((result) => {

                    if(result.isConfirmed)
                    {
                        form.submit();
                    }

                });

            });

        });

});

</script>

</x-layouts.admin>