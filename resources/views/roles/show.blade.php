<x-layouts.admin>

    <x-slot:title>
        Visualizar Rol
    </x-slot:title>

    <div class="max-w-6xl mx-auto">

        <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

            <div class="p-8 border-b">

                <div class="flex justify-between items-center">

                    <div>

                        <h2 class="text-3xl font-bold text-slate-800">

                            Rol: {{ $role->name }}

                        </h2>

                        <p class="text-slate-500 mt-2">

                            Consulta de permisos asignados.

                        </p>

                    </div>

                    <a
                        href="{{ route('roles.index') }}"
                        class="bg-slate-100 hover:bg-slate-200 px-4 py-2 rounded-xl">

                        Volver

                    </a>

                </div>

            </div>

            <div class="p-8">

                @foreach($permisosAgrupados as $modulo => $permisos)

                    <div class="mb-8 border rounded-2xl overflow-hidden">

                        <div class="bg-slate-100 px-6 py-4">

                            <h3 class="font-bold text-lg">

                                {{ $modulo }}

                            </h3>

                        </div>

                        <div class="p-6">

                            <div class="grid md:grid-cols-2 gap-4">

                                @foreach($permisos as $permiso)

                                    @php
                                        $tienePermiso =
                                        $role->hasPermissionTo(
                                            $permiso
                                        );
                                    @endphp

                                    <div
                                        class="flex items-center gap-3 p-4 border rounded-xl">

                                        @if($tienePermiso)

                                            <span class="text-green-600 text-xl">
                                                ✅
                                            </span>

                                        @else

                                            <span class="text-red-600 text-xl">
                                                ❌
                                            </span>

                                        @endif

                                        <span>

                                            {{ ucfirst($permiso) }}

                                        </span>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</x-layouts.admin>