<x-layouts.admin>

<x-slot:title>
    {{ $parteParasito->nombre }}
</x-slot:title>

<div class="max-w-5xl mx-auto">

    <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

        <div class="p-8 border-b">

            <div class="flex justify-between items-center">

                <div>

                    <h2 class="text-4xl font-bold text-slate-800">

                        {{ $parteParasito->nombre }}

                    </h2>

                    <p class="text-slate-500 mt-2">

                        Parte anatómica del parásito

                        <strong>
                            {{ $parteParasito->parasito->nombre_comun }}
                        </strong>

                    </p>

                </div>

                <a
                    href="{{ route('parte-parasitos.index') }}"
                    class="bg-slate-100 hover:bg-slate-200 px-4 py-2 rounded-xl">

                    Volver

                </a>

            </div>

        </div>

        <div class="p-8">

            <div class="grid md:grid-cols-2 gap-8">

                <div>

                    <img
                        src="{{ asset('storage/' . $parteParasito->imagen) }}"
                        onclick="abrirImagen(this.src)"
                        class="w-full rounded-2xl shadow cursor-pointer hover:opacity-90">

                </div>

                <div>

                    <div class="space-y-6">

                        <div>

                            <div class="text-sm text-slate-500">

                                Parásito

                            </div>

                            <div class="font-semibold text-lg">

                                {{ $parteParasito->parasito->nombre_comun }}

                            </div>

                        </div>

                        <div>

                            <div class="text-sm text-slate-500">

                                Orden

                            </div>

                            <div class="font-semibold text-lg">

                                {{ $parteParasito->orden }}

                            </div>

                        </div>

                        <div>

                            <div class="text-sm text-slate-500">

                                Estado

                            </div>

                            <div>

                                @if($parteParasito->activo)

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">

                                        Activo

                                    </span>

                                @else

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

                                        Inactivo

                                    </span>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="mt-10">

                <h3 class="text-2xl font-bold text-slate-800 mb-4">

                    Descripción

                </h3>

                <div class="bg-slate-50 rounded-2xl p-6 leading-relaxed">

                    {{ $parteParasito->descripcion }}

                </div>

            </div>

        </div>

    </div>

</div>

<div
    id="modalImagen"
    class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4">

    <div class="relative">

        <button
            onclick="cerrarImagen()"
            class="absolute -top-12 right-0 text-white text-4xl font-bold">

            ×

        </button>

        <img
            id="imagenAmpliada"
            class="max-w-[90vw] max-h-[90vh] rounded-2xl shadow-2xl">

    </div>

</div>

<script>

    function abrirImagen(src)
    {
        document
            .getElementById('imagenAmpliada')
            .src = src;

        document
            .getElementById('modalImagen')
            .classList.remove('hidden');
    }

    function cerrarImagen()
    {
        document
            .getElementById('modalImagen')
            .classList.add('hidden');
    }

</script>

</x-layouts.admin>
