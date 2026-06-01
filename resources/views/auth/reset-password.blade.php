<x-guest-layout>

    <div class="w-full max-w-md">

        <div class="flex justify-center mb-6">

            <div class="w-20 h-20 rounded-full bg-indigo-100 flex items-center justify-center shadow">

                <span class="text-4xl">
                    🔒
                </span>

            </div>

        </div>

        <div class="bg-white/90 backdrop-blur-sm shadow-2xl rounded-3xl overflow-hidden">

            <div class="bg-indigo-600 p-8 text-center">

                <h1 class="text-3xl font-bold text-white">
                    Restablecer Contraseña
                </h1>

                <p class="text-indigo-100 mt-2">
                    Sistema de Parasitología
                </p>

            </div>

            <div class="p-8">

                @if ($errors->any())

                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">

                        {{ $errors->first() }}

                    </div>

                @endif

                <form method="POST" action="{{ route('password.store') }}">

                    @csrf

                    <input type="hidden"
                           name="token"
                           value="{{ $request->route('token') }}">

                    <div>

                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Correo Electrónico
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $request->email) }}"
                            required
                            autofocus
                            class="w-full rounded-xl border-slate-300">

                    </div>

                    <div class="mt-5">

                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Nueva Contraseña
                        </label>

                        <input
                            type="password"
                            name="password"
                            required
                            class="w-full rounded-xl border-slate-300">

                    </div>

                    <div class="mt-5">

                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Confirmar Contraseña
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            required
                            class="w-full rounded-xl border-slate-300">

                    </div>

                    <div class="mt-8">

                        <button
                            type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition">

                            Restablecer Contraseña

                        </button>

                    </div>

                    <div class="mt-4 text-center">

                        <a href="{{ route('login') }}"
                           class="text-sm text-indigo-600 hover:text-indigo-800">

                            Volver al inicio de sesión

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-guest-layout>