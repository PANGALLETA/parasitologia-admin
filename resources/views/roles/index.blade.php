<x-layouts.admin>

    <x-slot:title>
        Roles y Permisos
    </x-slot:title>

    <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

        <div class="p-8 border-b">

            <div class="flex justify-between items-center">

                <div>

                    <h2 class="text-4xl font-bold text-slate-800">

                        Roles y Permisos

                    </h2>

                    <p class="text-slate-500 mt-2">

                        Administración de roles del sistema.

                    </p>

                </div>
                @can('crear roles')
                <a
                    href="{{ route('roles.create') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold">

                    + Nuevo Rol

                </a>
                @endcan

            </div>

        </div>

        @if(session('success'))

            <div class="mx-6 mt-6 rounded-xl border border-green-200 bg-green-50 p-4 text-green-700">

                {{ session('success') }}

            </div>

        @endif

        @if(session('error'))

            <div class="mx-6 mt-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">

                {{ session('error') }}

            </div>

        @endif

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left">

                            Rol

                        </th>

                        <th class="px-6 py-4 text-center">

                            Usuarios

                        </th>

                        <th class="px-6 py-4 text-center">

                            Permisos

                        </th>

                        <th class="px-6 py-4 text-center">

                            Acciones

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($roles as $role)

                        <tr class="border-t">

                            <td class="px-6 py-4">

                                <div class="font-semibold text-slate-800">

                                    {{ $role->name }}

                                </div>

                            </td>

                            <td class="px-6 py-4 text-center">

                                <span
                                    class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full">

                                    {{ $role->users_count }}

                                </span>

                            </td>

                            <td class="px-6 py-4 text-center">

                                <span
                                    class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

                                    {{ $role->permissions->count() }}

                                </span>

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    <a
                                        href="{{ route('roles.show', $role) }}"
                                        class="bg-blue-100 text-blue-700 px-4 py-2 rounded-lg hover:bg-blue-200">

                                        Visualizar

                                    </a>
                                    @can('editar roles')
                                    <a
                                        href="{{ route('roles.edit', $role) }}"
                                        class="bg-amber-100 text-amber-700 px-4 py-2 rounded-lg hover:bg-amber-200">

                                        Permisos

                                    </a>
                                    @endcan
                                    @can('eliminar roles')
                                    <form
                                        action="{{ route('roles.destroy', $role) }}"
                                        method="POST"
                                        class="form-eliminar inline">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="bg-red-100 text-red-700 px-4 py-2 rounded-lg hover:bg-red-200">

                                            Eliminar

                                        </button>

                                    </form>
                                    @endcan
                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="4"
                                class="text-center py-10 text-slate-500">

                                No existen roles registrados.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

document
    .querySelectorAll('.form-eliminar')
    .forEach(form => {

        form.addEventListener(
            'submit',
            function(e)
            {
                e.preventDefault();

                Swal.fire({

                    title: '¿Eliminar rol?',

                    text: 'Esta acción no se puede deshacer.',

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonText: 'Sí, eliminar',

                    cancelButtonText: 'Cancelar'

                }).then((result) => {

                    if(result.isConfirmed)
                    {
                        form.submit();
                    }

                });
            }
        );

    });

</script>

</x-layouts.admin>