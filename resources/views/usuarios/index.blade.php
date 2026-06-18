<x-layouts.admin>

    <x-slot:title>
        Usuarios
    </x-slot:title>
    @if(session('success'))

        <div
            class="mb-6 flex items-center rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">

            <svg class="w-5 h-5 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 13l4 4L19 7" />
            </svg>

            {{ session('success') }}

        </div>

    @endif

    @if(session('error'))

        <div
            class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">

            {{ session('error') }}

        </div>

    @endif

    <div class="w-full">

        <!-- Encabezado -->
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">

            <div class="flex items-center justify-between">

                <div>
                    <h2 class="text-2xl font-bold text-slate-800">
                        Gestión de Usuarios
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Administra administradores, profesores y estudiantes.
                    </p>
                </div>
                @can('crear usuarios')
                <a href="{{ route('usuarios.create') }}"
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg shadow-sm transition">
                    + Nuevo Usuario
                </a>
                @endcan

            </div>

        </div>

        <!-- Tarjetas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

            <div class="bg-white rounded-2xl shadow-sm p-6">
                <p class="text-sm text-slate-500">
                    Total Usuarios
                </p>

                <h3 class="text-3xl font-bold text-slate-800 mt-2">
                    {{ $usuarios->total() }}
                </h3>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6">
                <p class="text-sm text-slate-500">
                    Profesores
                </p>

                <h3 class="text-3xl font-bold text-blue-600 mt-2">
                    {{ \App\Models\User::role('Profesor')->count() }}
                </h3>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6">
                <p class="text-sm text-slate-500">
                    Estudiantes
                </p>

                <h3 class="text-3xl font-bold text-green-600 mt-2">
                    {{ \App\Models\User::role('Estudiante')->count() }}
                </h3>
            </div>

        </div>

        <!-- Tabla -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            <div class="px-6 py-4 border-b">
                <h3 class="font-semibold text-slate-800">
                    Lista de Usuarios
                </h3>

                <form method="GET"
                    action="{{ route('usuarios.index') }}"
                    class="p-6 border-b bg-slate-50">

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                        <input
                            type="text"
                            name="buscar"
                            value="{{ request('buscar') }}"
                            placeholder="Buscar usuario..."
                            class="rounded-lg border-slate-300">

                        <select
                            name="rol"
                            class="rounded-lg border-slate-300">

                            <option value="">
                                Todos los roles
                            </option>

                            @foreach($roles as $rol)

                                <option
                                    value="{{ $rol->name }}"
                                    {{ request('rol') == $rol->name ? 'selected' : '' }}>

                                    {{ $rol->name }}

                                </option>

                            @endforeach

                        </select>

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

                        <div class="flex gap-2">

                            <button
                                type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">

                                Filtrar

                            </button>

                            <a href="{{ route('usuarios.index') }}"
                            class="bg-slate-300 px-4 py-2 rounded-lg hover:bg-slate-400">

                                Limpiar

                            </a>

                        </div>

                    </div>

                </form>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-600">
                                ID
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-600">
                                Nombre
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-600">
                                Correo
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-600">
                                Rol
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-600">
                                Estado
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-600">
                                Acciones
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($usuarios as $usuario)

                            <tr class="hover:bg-slate-50 transition">

                                <td class="px-6 py-4">
                                    {{ $usuario->id }}
                                </td>

                                <td class="px-6 py-4 font-medium text-slate-800">
                                    {{ $usuario->name }}
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    {{ $usuario->email }}
                                </td>

                                <td class="px-6 py-4">

                                    @foreach($usuario->roles as $rol)

                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">
                                            {{ $rol->name }}
                                        </span>

                                    @endforeach

                                </td>

                                <td class="px-6 py-4 text-center">

                                    @if($usuario->activo)

                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                            Activo
                                        </span>

                                    @else

                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                            Inactivo
                                        </span>

                                    @endif

                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex justify-center gap-2">
                                        @can('editar usuarios')
                                        <a href="{{ route('usuarios.edit', $usuario) }}"
                                        class="px-3 py-1.5 text-sm rounded-lg bg-amber-100 text-amber-700 hover:bg-amber-200 transition">
                                            Editar
                                        </a>
                                        @endcan
                                        @can('eliminar usuarios')
                                        @if($usuario->id !== auth()->id())

                                            <form action="{{ route('usuarios.destroy', $usuario) }}"
                                                method="POST"
                                                class="form-cambiar-estado">

                                                @csrf
                                                @method('DELETE')

                                                @if($usuario->activo)

                                                    <button
                                                        type="submit"
                                                        class="px-3 py-1.5 text-sm rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition">

                                                        Desactivar

                                                    </button>

                                                @else

                                                    <button
                                                        type="submit"
                                                        class="px-3 py-1.5 text-sm rounded-lg bg-green-100 text-green-700 hover:bg-green-200 transition">

                                                        Reactivar

                                                    </button>

                                                @endif

                                            </form>

                                        @endif
                                        @endcan

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="px-6 py-10 text-center text-slate-500">

                                    No hay usuarios registrados.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="p-4 border-t bg-slate-50">

                {{ $usuarios->links() }}

            </div>

        </div>

    </div>

<script>

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.form-cambiar-estado').forEach(form => {

        form.addEventListener('submit', function(e) {

            e.preventDefault();

            Swal.fire({
                title: '¿Está seguro?',
                text: 'Se cambiará el estado del usuario.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Sí, continuar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {

                if (result.isConfirmed) {
                    form.submit();
                }

            });

        });

    });

});

</script>

</x-layouts.admin>