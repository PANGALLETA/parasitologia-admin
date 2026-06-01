<x-guest-layout>

    <div class="w-full max-w-md">

        <div class="flex justify-center mb-6">

            <div class="w-20 h-20 rounded-full bg-indigo-100 flex items-center justify-center shadow">

                <span class="text-4xl">
                    🔑
                </span>

            </div>

        </div>

        <div class="bg-white/90 backdrop-blur-sm shadow-2xl rounded-3xl overflow-hidden">

            <div class="bg-indigo-600 p-8 text-center">

                <h1 class="text-3xl font-bold text-white">
                    Recuperar Contraseña
                </h1>

                <p class="text-indigo-100 mt-2">
                    Sistema de Parasitología
                </p>

            </div>

            <div class="p-8">

                @if (session('status'))

                    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-green-700">

                        @if(session('status') === 'passwords.sent')

                            Hemos enviado un enlace para restablecer tu contraseña.

                        @else

                            {{ session('status') }}

                        @endif

                    </div>

                @endif

                <p class="mb-6 text-sm text-slate-600">
                    ¿Olvidaste tu contraseña? No te preocupes.
                    Ingresa tu correo electrónico y te enviaremos un enlace para restablecerla.
                </p>

                <form method="POST" action="{{ route('password.email') }}">

                    @csrf

                    <div>

                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Correo Electrónico
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            class="w-full rounded-xl border-slate-300">

                        @error('email')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    <div class="mt-8">

                        <button
                            type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition">

                            Enviar Enlace de Recuperación

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