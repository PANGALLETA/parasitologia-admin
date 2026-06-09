<x-layouts.admin>

<x-slot:title>
    Editar Parte Anatómica
</x-slot:title>

<div class="max-w-5xl mx-auto">

    @if ($errors->any())

        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

            <ul class="list-disc pl-5 text-red-700">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

        <div class="p-8 border-b">

            <h2 class="text-3xl font-bold text-slate-800">

                Editar Parte Anatómica

            </h2>

            <p class="text-slate-500 mt-2">

                Actualice la información de la parte anatómica.

            </p>

        </div>

        <form
            action="{{ route('parte-parasitos.update', $parteParasito) }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="p-8 space-y-6">

                <div>

                    <label class="block font-semibold mb-2">

                        Parásito *

                    </label>

                    <select
                        name="parasito_id"
                        required
                        class="w-full rounded-xl border-slate-300">

                        <option value="">
                            Seleccione...
                        </option>

                        @foreach($parasitos as $parasito)

                            <option
                                value="{{ $parasito->id }}"
                                {{ old('parasito_id', $parteParasito->parasito_id) == $parasito->id ? 'selected' : '' }}>

                                {{ $parasito->nombre_comun }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div>

                    <label class="block font-semibold mb-2">

                        Nombre de la Parte *

                    </label>

                    <input
                        type="text"
                        name="nombre"
                        value="{{ old('nombre', $parteParasito->nombre) }}"
                        required
                        class="w-full rounded-xl border-slate-300">

                </div>

                <div>

                    <label class="block font-semibold mb-2">

                        Orden *

                    </label>

                    <input
                        type="number"
                        name="orden"
                        min="1"
                        value="{{ old('orden', $parteParasito->orden) }}"
                        required
                        class="w-full rounded-xl border-slate-300">

                </div>

                <div>

                    <label class="block font-semibold mb-2">

                        Imagen

                    </label>

                    <input
                        type="file"
                        id="imagen"
                        name="imagen"
                        accept="image/*"
                        class="w-full rounded-xl border-slate-300">

                    <div
                        id="preview-container"
                        class="mt-4">

                        <img
                            id="preview-image"
                            src="{{ asset('storage/' . $parteParasito->imagen) }}"
                            class="w-64 h-64 object-cover rounded-xl border shadow-sm cursor-pointer"
                            onclick="abrirImagen(this.src)">

                    </div>

                </div>

                <div>

                    <label class="block font-semibold mb-2">

                        Descripción *

                    </label>

                    <textarea
                        name="descripcion"
                        rows="5"
                        required
                        class="w-full rounded-xl border-slate-300">{{ old('descripcion', $parteParasito->descripcion) }}</textarea>

                </div>

                <div>

                    <label class="flex items-center gap-3">

                        <input
                            type="checkbox"
                            name="activo"
                            value="1"
                            {{ old('activo', $parteParasito->activo) ? 'checked' : '' }}>

                        <span>

                            Activo

                        </span>

                    </label>

                </div>

            </div>

            <div class="px-8 pb-8">

                <button
                    type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl">

                    Actualizar Parte Anatómica

                </button>

            </div>

        </form>

    </div>

</div>

<!-- Modal Imagen -->

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

    document
        .getElementById('imagen')
        .addEventListener('change', function(e){

            const archivo = e.target.files[0];

            if(!archivo)
                return;

            const reader = new FileReader();

            reader.onload = function(event){

                document
                    .getElementById('preview-image')
                    .src = event.target.result;

            };

            reader.readAsDataURL(archivo);

        });

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

    document
        .getElementById('modalImagen')
        .addEventListener('click', function(e){

            if(e.target === this)
            {
                cerrarImagen();
            }

        });

</script>
</x-layouts.admin>