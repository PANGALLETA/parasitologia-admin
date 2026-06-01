<x-layouts.admin>

    <x-slot:title>
        Editar Usuario
    </x-slot:title>

    <div class="max-w-4xl mx-auto">

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b">

                <h2 class="text-2xl font-bold text-slate-800">
                    Editar Usuario
                </h2>

            </div>

            <form action="{{ route('usuarios.update', $usuario) }}"
                  method="POST"
                  class="p-6">

                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Nombre Completo
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $usuario->name) }}"
                            class="w-full rounded-lg border-slate-300 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Correo Electrónico
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $usuario->email) }}"
                            class="w-full rounded-lg border-slate-300 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Rol
                        </label>

                        <select
                            name="role"
                            class="w-full rounded-lg border-slate-300 shadow-sm">

                            @foreach($roles as $rol)

                                <option
                                    value="{{ $rol->name }}"
                                    @selected($usuario->hasRole($rol->name))
                                >
                                    {{ $rol->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                <div class="mt-6">

                    <label class="inline-flex items-center">

                        <input
                            type="checkbox"
                            name="activo"
                            value="1"
                            {{ $usuario->activo ? 'checked' : '' }}
                            class="rounded border-slate-300">

                        <span class="ml-2">
                            Usuario Activo
                        </span>

                    </label>

                </div>

                <div class="mt-8 flex justify-end gap-3">

                    <a href="{{ route('usuarios.index') }}"
                       class="px-5 py-2 bg-slate-200 rounded-lg hover:bg-slate-300">

                        Cancelar

                    </a>

                    <button
                        type="submit"
                        class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">

                        Actualizar Usuario

                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts.admin>