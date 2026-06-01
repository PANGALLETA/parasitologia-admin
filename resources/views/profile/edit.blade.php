<x-layouts.admin>

    <x-slot:title>
        Mi Perfil
    </x-slot:title>

    @if (session('status') === 'profile-updated')

        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            Perfil actualizado correctamente.
        </div>

    @endif

    @if (session('status') === 'password-updated')

        <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            Contraseña actualizada correctamente.
        </div>

    @endif

    <div class="max-w-5xl mx-auto">

        <!-- Información Personal -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b">

                <h2 class="text-2xl font-bold text-slate-800">
                    Mi Perfil
                </h2>

                <p class="text-slate-500 mt-1">
                    Actualiza tu información personal.
                </p>

            </div>

            <form method="POST"
                  action="{{ route('profile.update') }}"
                  class="p-6">

                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Nombre
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', auth()->user()->name) }}"
                            class="w-full rounded-lg border-slate-300">

                        @error('name')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Correo Electrónico
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', auth()->user()->email) }}"
                            class="w-full rounded-lg border-slate-300">

                        @error('email')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div class="bg-slate-50 rounded-lg p-4">

                        <div class="text-sm text-slate-500">
                            Rol
                        </div>

                        <div class="font-semibold">
                            {{ auth()->user()->getRoleNames()->first() }}
                        </div>

                    </div>

                    <div class="bg-slate-50 rounded-lg p-4">

                        <div class="text-sm text-slate-500">
                            Usuario desde
                        </div>

                        <div class="font-semibold">
                            {{ auth()->user()->created_at->format('d/m/Y') }}
                        </div>

                    </div>

                </div>

                <div class="mt-8 flex justify-end">

                    <button
                        type="submit"
                        class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">

                        Guardar Cambios

                    </button>

                </div>

            </form>

        </div>

        <!-- Seguridad -->
        <div class="mt-6 bg-white rounded-2xl shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b">

                <h2 class="text-2xl font-bold text-slate-800">
                    Seguridad
                </h2>

                <p class="text-slate-500 mt-1">
                    Actualiza tu contraseña de acceso.
                </p>

            </div>

            <form method="POST"
                  action="{{ route('password.update') }}"
                  class="p-6">

                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">

                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Contraseña Actual
                        </label>

                        <input
                            type="password"
                            name="current_password"
                            class="w-full rounded-lg border-slate-300">

                        @error('current_password', 'updatePassword')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Nueva Contraseña
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="w-full rounded-lg border-slate-300">

                        @error('password', 'updatePassword')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Confirmar Nueva Contraseña
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="w-full rounded-lg border-slate-300">

                    </div>

                </div>

                <div class="mt-8 flex justify-end">

                    <button
                        type="submit"
                        class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">

                        Actualizar Contraseña

                    </button>

                </div>

            </form>

        </div>

    </div>

</x-layouts.admin>