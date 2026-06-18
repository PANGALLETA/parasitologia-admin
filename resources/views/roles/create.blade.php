<x-layouts.admin>

    <x-slot:title>
        Nuevo Rol
    </x-slot:title>

    <div class="max-w-6xl mx-auto">

        <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

            <div class="p-8 border-b">

                <h2 class="text-3xl font-bold text-slate-800">

                    Nuevo Rol

                </h2>

                <p class="text-slate-500 mt-2">

                    Registre un nuevo rol y asigne sus permisos.

                </p>

            </div>

            <form
                action="{{ route('roles.store') }}"
                method="POST">

                @csrf

                <div class="p-8">

                    <div>

                        <label
                            class="block font-semibold mb-2">

                            Nombre del Rol *

                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            class="w-full rounded-xl border-slate-300">

                        @error('name')

                            <div
                                class="mt-2 text-red-600 text-sm">

                                {{ $message }}

                            </div>

                        @enderror

                    </div>

                    <div class="mt-10">

                        <h3 class="text-2xl font-bold mb-6">

                            Permisos del Rol

                        </h3>

                        @foreach($permisosAgrupados as $modulo => $permisos)

                            <div class="mb-8 border rounded-2xl overflow-hidden">

                                <div class="bg-slate-100 px-6 py-4 flex justify-between items-center">

                                    <h4 class="font-bold text-lg">

                                        {{ $modulo }}

                                    </h4>

                                    <button
                                        type="button"
                                        onclick="seleccionarModulo('{{ \Illuminate\Support\Str::slug($modulo) }}')"
                                        class="text-indigo-600 font-semibold hover:text-indigo-800">

                                        Seleccionar todo

                                    </button>

                                </div>

                                <div class="p-6">

                                    <div class="grid md:grid-cols-2 gap-4">

                                        @foreach($permisos as $permission)

                                            <label
                                                class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer hover:bg-slate-50">

                                                <input
                                                    type="checkbox"
                                                    class="w-5 h-5 permiso-{{ \Illuminate\Support\Str::slug($modulo) }}"
                                                    name="permissions[]"
                                                    value="{{ $permission->name }}">

                                                <span>

                                                    {{ ucfirst($permission->name) }}

                                                </span>

                                            </label>

                                        @endforeach

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

                <div class="px-8 pb-8">

                    <button
                        type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl">

                        Guardar Rol

                    </button>

                </div>

            </form>

        </div>

    </div>

    <script>

        function seleccionarModulo(modulo)
        {
            document
                .querySelectorAll(
                    '.permiso-' + modulo
                )
                .forEach(check => {

                    check.checked = true;

                });
        }

    </script>

</x-layouts.admin>