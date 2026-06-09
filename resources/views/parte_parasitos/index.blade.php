<x-layouts.admin>

    <x-slot:title>
        Partes Anatómicas
    </x-slot:title>

    <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

        <div class="p-8 border-b">

            <div class="flex justify-between items-center">

                <div>

                    <h2 class="text-4xl font-bold text-slate-800">

                        Partes Anatómicas

                    </h2>

                    <p class="text-slate-500 mt-2">

                        Gestión de partes anatómicas de los parásitos.

                    </p>

                </div>

                <a
                    href="{{ route('parte-parasitos.create') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold">

                    + Nueva Parte

                </a>

            </div>

        </div>

        @if(session('success'))

            <div class="mx-6 mt-6 rounded-xl border border-green-200 bg-green-50 p-4 text-green-700">

                {{ session('success') }}

            </div>

        @endif

        <div class="p-6 border-b">

            <form
                method="GET"
                class="flex gap-4">

                <select
                    name="parasito_id"
                    class="flex-1 rounded-xl border-slate-300">

                    <option value="">
                        Todos los parásitos
                    </option>

                    @foreach($parasitos as $parasito)

                        <option
                            value="{{ $parasito->id }}"
                            {{ request('parasito_id') == $parasito->id ? 'selected' : '' }}>

                            {{ $parasito->nombre_comun }}

                        </option>

                    @endforeach

                </select>

                <button
                    type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 rounded-xl">

                    Filtrar

                </button>

            </form>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left">

                            Imagen

                        </th>

                        <th class="px-6 py-4 text-left">

                            Parásito

                        </th>

                        <th class="px-6 py-4 text-left">

                            Parte

                        </th>

                        <th class="px-6 py-4 text-left">

                            Orden

                        </th>

                        <th class="px-6 py-4 text-center">

                            Estado

                        </th>

                        <th class="px-6 py-4 text-center">

                            Acciones

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($partes as $parte)

                        <tr class="border-t">

                            <td class="px-6 py-4">

                                @if($parte->imagen)

                                    <img
                                        src="{{ asset('storage/' . $parte->imagen) }}"
                                        onclick="abrirImagen(this.src)"
                                        class="w-20 h-20 rounded-lg object-cover cursor-pointer hover:scale-105 transition">

                                @endif

                            </td>

                            <td class="px-6 py-4">

                                {{ $parte->parasito->nombre_comun }}

                            </td>

                            <td class="px-6 py-4 font-semibold">

                                {{ $parte->nombre }}

                            </td>

                            <td class="px-6 py-4">

                                {{ $parte->orden }}

                            </td>

                            <td class="px-6 py-4 text-center">

                                @if($parte->activo)

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

                                        Activo

                                    </span>

                                @else

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">

                                        Inactivo

                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    <a
                                        href="{{ route('parte-parasitos.show', $parte) }}"
                                        class="bg-blue-100 text-blue-700 px-4 py-2 rounded-lg hover:bg-blue-200">

                                        Visualizar

                                    </a>

                                    <a
                                        href="{{ route('parte-parasitos.edit', $parte) }}"
                                        class="bg-amber-100 text-amber-700 px-4 py-2 rounded-lg">

                                        Editar

                                    </a>

                                    <form
                                        id="form-eliminar-{{ $parte->id }}"
                                        action="{{ route('parte-parasitos.destroy', $parte) }}"
                                        method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="button"
                                            onclick="eliminarParte({{ $parte->id }})"
                                            class="bg-red-100 text-red-700 px-4 py-2 rounded-lg hover:bg-red-200">

                                            Eliminar

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center py-10 text-slate-500">

                                No existen partes anatómicas registradas.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="p-6">

            {{ $partes->links() }}

        </div>

    </div>

<!-- Modal Imagen -->

<div
    id="modalImagen"
    class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4">

    <div class="relative">

        <button
            onclick="cerrarImagen()"
            class="absolute -top-12 right-0 text-white text-4xl font-bold">

            ×

        </button>

        <img
            id="imagenAmpliada"
            class="max-w-[90vw] max-h-[90vh] rounded-2xl shadow-2xl">

    </div>

</div>
<script>

function abrirImagen(src)
{
    document
        .getElementById('imagenAmpliada')
        .src = src;

    document
        .getElementById('modalImagen')
        .classList.remove('hidden');
}

function cerrarImagen()
{
    document
        .getElementById('modalImagen')
        .classList.add('hidden');
}

document
    .getElementById('modalImagen')
    .addEventListener('click', function(e){

        if(e.target === this)
        {
            cerrarImagen();
        }

    });

</script>
<script>

function eliminarParte(id)
{
    Swal.fire({

        title: '¿Eliminar registro?',

        text: 'Esta acción no se puede deshacer.',

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#dc2626',

        cancelButtonColor: '#64748b',

        confirmButtonText: 'Sí, eliminar',

        cancelButtonText: 'Cancelar'

    }).then((result) => {

        if(result.isConfirmed)
        {
            document
                .getElementById(
                    'form-eliminar-' + id
                )
                .submit();
        }

    });
}

</script>
</x-layouts.admin>