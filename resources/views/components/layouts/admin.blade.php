<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Panel Administrativo' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100">

    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-white">

            <div class="p-5 border-b border-slate-700">
                <h2 class="font-bold text-xl">
                    Parasitología
                </h2>
            </div>

            <nav class="p-4">

                <ul class="space-y-2">

                    <li>
                        <li>
                            <a href="{{ route('dashboard') }}"
                            class="block px-4 py-2 rounded
                            {{ request()->routeIs('dashboard') ? 'bg-slate-700' : 'hover:bg-slate-800' }}">
                                Dashboard
                            </a>
                        </li>
                    </li>

                    <li>
                        <a href="{{ route('usuarios.index') }}"
                        class="block px-4 py-2 rounded
                        {{ request()->routeIs('usuarios.*') ? 'bg-slate-700' : 'hover:bg-slate-800' }}">
                            Usuarios
                        </a>
                    </li>

                    <li>
                        <a href="#"
                           class="block px-4 py-2 rounded hover:bg-slate-800">
                            Roles
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('parasitos.index') }}"
                        class="block px-4 py-2 rounded
                        {{ request()->routeIs('parasitos.*') ? 'bg-slate-700' : 'hover:bg-slate-800' }}">
                            Parásitos
                        </a>
                    </li>
                    <li>

                        <a href="{{ route('mapa-epidemiologicos.index') }}"
                        class="block px-4 py-2 rounded
                        {{ request()->routeIs('mapa-epidemiologicos.*') ? 'bg-slate-700' : 'hover:bg-slate-800' }}">

                            Mapa Epidemiológico

                        </a>

                    </li>
                    <li>
                        <a href="{{ route('parte-parasitos.index') }}"
                        class="block px-4 py-2 rounded
                        {{ request()->routeIs('parte-parasitos.*') ? 'bg-slate-700' : 'hover:bg-slate-800' }}">

                            Partes Anatómicas

                        </a>
                    </li>
                    
                </ul>

            </nav>

        </aside>

        <!-- Contenido -->
        <div class="flex-1">

            <header class="bg-white shadow">

                <div class="flex justify-between items-center px-6 py-4">

                    <h1 class="text-xl font-semibold">
                        {{ $title ?? 'Dashboard' }}
                    </h1>

                    <div class="relative">

                        <button
                            id="user-menu-button"
                            type="button"
                            class="text-right">

                            <div class="font-medium">
                                {{ Auth::user()->name }}
                            </div>

                            <div class="text-xs text-slate-500">
                                {{ Auth::user()->getRoleNames()->first() }}
                            </div>

                        </button>

                        <div
                            id="user-menu"
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border z-50">

                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-3 hover:bg-slate-50">
                                Mi Perfil
                            </a>

                            <form method="POST"
                                action="{{ route('logout') }}">

                                @csrf

                                <button
                                    type="submit"
                                    class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50">

                                    Cerrar Sesión

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </header>

            <main class="p-6">

                {{ $slot }}

            </main>

        </div>

    </div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

document.addEventListener('DOMContentLoaded', () => {

    const button = document.getElementById('user-menu-button');
    const menu = document.getElementById('user-menu');

    if(button && menu){

        button.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {

            if(!button.contains(e.target) &&
               !menu.contains(e.target)) {

                menu.classList.add('hidden');

            }

        });

    }

});

</script>
</body>
</html>