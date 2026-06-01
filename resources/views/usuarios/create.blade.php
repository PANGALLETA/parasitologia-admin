<x-layouts.admin>

    <x-slot:title>
        Crear Usuario
    </x-slot:title>

    <div class="max-w-4xl mx-auto">

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b">

                <h2 class="text-2xl font-bold text-slate-800">
                    Nuevo Usuario
                </h2>

                <p class="text-slate-500 mt-1">
                    Registra administradores, profesores o estudiantes.
                </p>

            </div>

            <form action="{{ route('usuarios.store') }}"
                  method="POST"
                  class="p-6">

                @if ($errors->any())
                    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
                        <ul class="list-disc pl-5 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Nombre Completo
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="w-full border-slate-300 rounded-lg shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Correo Electrónico
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full rounded-lg border-slate-300 shadow-sm">

                        @error('email')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Rol
                        </label>

                        <select
                            name="role"
                            class="w-full border-slate-300 rounded-lg shadow-sm">

                            <option value="">
                                Seleccione...
                            </option>

                            @foreach($roles as $rol)

                                <option value="{{ $rol->name }}">
                                    {{ $rol->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Contraseña
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="w-full border-slate-300 rounded-lg shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Confirmar Contraseña
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="w-full border-slate-300 rounded-lg shadow-sm">
                    </div>

                </div>

                <div class="mt-6">

                    <label class="inline-flex items-center">

                        <input
                            type="checkbox"
                            name="activo"
                            value="1"
                            checked
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

                        Guardar Usuario

                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts.admin>