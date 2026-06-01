<x-guest-layout>

    <div class="w-full max-w-md">

        <!-- Icono -->
        <div class="flex justify-center mb-6">

            <div class="w-20 h-20 rounded-full bg-indigo-100 flex items-center justify-center shadow">

                <span class="text-4xl">
                    🦠
                </span>

            </div>

        </div>

        <div class="bg-white/90 backdrop-blur-sm shadow-2xl rounded-3xl overflow-hidden">

            <!-- Encabezado -->
            <div class="bg-indigo-600 p-8 text-center">

                <h1 class="text-4xl font-bold text-white">
                    Sistema de Parasitología
                </h1>

                <p class="text-indigo-100 mt-3 text-lg">
                    Panel Administrativo
                </p>

            </div>

            <div class="p-8">

                <!-- Mensajes de éxito -->
                @if (session('status'))

                    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-green-700">

                        @if(session('status') === 'passwords.reset')

                            Tu contraseña ha sido restablecida correctamente.

                        @elseif(session('status') === 'passwords.sent')

                            Hemos enviado un enlace para restablecer tu contraseña.

                        @else

                            {{ session('status') }}

                        @endif

                    </div>

                @endif

                <!-- Errores -->
                @if ($errors->any())

                    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-700">

                        {{ $errors->first() }}

                    </div>

                @endif

                <form method="POST" action="{{ route('login') }}">

                    @csrf

                    <!-- Correo -->
                    <div>

                        <x-input-label
                            for="email"
                            :value="'Correo Electrónico'"
                            class="font-semibold" />

                        <x-text-input
                            id="email"
                            class="block mt-2 w-full rounded-xl"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus />

                    </div>

                    <!-- Contraseña -->
                    <div class="mt-5">

                        <x-input-label
                            for="password"
                            :value="'Contraseña'"
                            class="font-semibold" />

                        <x-text-input
                            id="password"
                            class="block mt-2 w-full rounded-xl"
                            type="password"
                            name="password"
                            required />

                    </div>

                    <!-- Recordarme -->
                    <div class="mt-5 flex items-center">

                        <input
                            id="remember_me"
                            type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            name="remember">

                        <label
                            for="remember_me"
                            class="ml-2 text-sm text-gray-600">

                            Recordarme

                        </label>

                    </div>

                    <!-- Botón -->
                    <div class="mt-8">

                        <button
                            type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition duration-200 shadow-lg">

                            Iniciar Sesión

                        </button>

                    </div>

                    <!-- Recuperar contraseña -->
                    <div class="mt-4 text-center">

                        <a href="{{ route('password.request') }}"
                           class="text-sm text-indigo-600 hover:text-indigo-800">

                            ¿Olvidaste tu contraseña?

                        </a>

                    </div>

                </form>

                <!-- Pie -->
                <div class="mt-8 text-center text-sm text-slate-500">

                    Universidad Tecnológica de Pereira

                    <br>

                    Sistema de Gestión de Parasitología Animal

                </div>

            </div>

        </div>

    </div>

</x-guest-layout>