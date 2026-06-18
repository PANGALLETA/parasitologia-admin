<x-layouts.admin>

<x-slot:title>
    Parásitos
</x-slot:title>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">

    <div class="p-6 border-b flex justify-between items-center">

        <div>

            <h2 class="text-2xl font-bold text-slate-800">
                Gestión de Parásitos
            </h2>

            <p class="text-slate-500">
                Administración de registros parasitológicos.
            </p>

        </div>
        @can('crear parasitos')
        <a href="{{ route('parasitos.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">

            + Nuevo Parásito

        </a>
        @endcan
    </div>

    @if(session('success'))

        <div class="m-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">

            {{ session('success') }}

        </div>

    @endif

    <!-- Filtros -->

    <form method="GET"
          action="{{ route('parasitos.index') }}"
          class="p-6 border-b bg-slate-50">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <input
                type="text"
                name="buscar"
                value="{{ request('buscar') }}"
                placeholder="Buscar por nombre común o científico..."
                class="rounded-lg border-slate-300">

            <select
                name="activo"
                class="rounded-lg border-slate-300">

                <option value="">
                    Todos los estados
                </option>

                <option value="1"
                    {{ request('activo') === '1' ? 'selected' : '' }}>
                    Activos
                </option>

                <option value="0"
                    {{ request('activo') === '0' ? 'selected' : '' }}>
                    Inactivos
                </option>

            </select>

            <button
                type="submit"
                class="bg-indigo-600 text-white rounded-lg">

                Filtrar

            </button>

        </div>

    </form>

    <!-- Tabla -->

    <div class="overflow-x-auto">

        <table class="min-w-full">

            <thead class="bg-slate-50">

                <tr>

                    <th class="px-6 py-3 text-left">
                        Imagen
                    </th>

                    <th class="px-6 py-3 text-left">
                        Nombre Común
                    </th>

                    <th class="px-6 py-3 text-left">
                        Nombre Científico
                    </th>

                    <th class="px-6 py-3 text-left">
                        UUID
                    </th>

                    <th class="px-6 py-3 text-center">
                        Estado
                    </th>

                    <th class="px-6 py-3 text-center">
                        Acciones
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($parasitos as $parasito)

                    <tr class="border-t">

                        <td class="px-6 py-4">

                            @if($parasito->imagen_principal)

                                <img
                                    src="{{ asset('storage/'.$parasito->imagen_principal) }}"
                                    alt="{{ $parasito->nombre_comun }}"
                                    class="w-16 h-16 rounded-lg object-cover cursor-pointer hover:scale-110 transition"
                                    onclick="verImagen(
                                        '{{ asset('storage/'.$parasito->imagen_principal) }}',
                                        '{{ $parasito->nombre_comun }}'
                                    )">

                            @else

                                <div class="w-16 h-16 rounded-lg bg-slate-200 flex items-center justify-center">

                                    🦠

                                </div>

                            @endif

                        </td>

                        <td class="px-6 py-4 font-medium">

                            {{ $parasito->nombre_comun }}

                        </td>

                        <td class="px-6 py-4 italic">

                            {{ $parasito->nombre_cientifico }}

                        </td>

                        <td class="px-6 py-4 text-sm text-slate-500">

                            {{ Str::limit($parasito->uuid, 15) }}

                        </td>

                        <td class="px-6 py-4 text-center">

                            @if($parasito->activo)

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">

                                    Activo

                                </span>

                            @else

                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">

                                    Inactivo

                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-2">
                                @can('editar parasitos')
                                <a href="{{ route('parasitos.edit', $parasito) }}"
                                   class="px-3 py-1 rounded bg-amber-100 text-amber-700">

                                    Editar

                                </a>
                                @endcan
                                <a
                                    href="{{ route('parasitos.visualizar', $parasito->uuid) }}"
                                    target="_blank"
                                    class="px-3 py-2 rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200">

                                    Visualizar

                                </a>

                                @can('eliminar parasitos')
                                <form
                                    action="{{ route('parasitos.destroy', $parasito) }}"
                                    method="POST"
                                    class="form-estado">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="px-3 py-1 rounded {{ $parasito->activo
                                            ? 'bg-red-100 text-red-700'
                                            : 'bg-green-100 text-green-700' }}">

                                        {{ $parasito->activo
                                            ? 'Desactivar'
                                            : 'Activar' }}

                                    </button>

                                </form>
                                @endcan

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6"
                            class="text-center py-8 text-slate-500">

                            No existen registros.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="p-6">

        {{ $parasitos->links() }}

    </div>

</div>
<script>

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.form-estado').forEach(form => {

        form.addEventListener('submit', function (e) {

            e.preventDefault();

            Swal.fire({

                title: '¿Está seguro?',
                text: 'Se cambiará el estado del parásito.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#4f46e5',

            }).then((result) => {

                if (result.isConfirmed) {

                    form.submit();

                }

            });

        });

    });

});

function verImagen(url, titulo)
{
    Swal.fire({

        title: titulo,

        imageUrl: url,

        imageAlt: titulo,

        width: '90%',

        showCloseButton: true,

        showConfirmButton: false,

        padding: '1rem',

    });
}

</script>
</x-layouts.admin>
