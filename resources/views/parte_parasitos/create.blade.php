<x-layouts.admin>

    <x-slot:title>
        Nueva Parte Anatómica
    </x-slot:title>

    <div class="max-w-5xl mx-auto">

        <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

            <div class="p-8 border-b">

                <h2 class="text-3xl font-bold text-slate-800">

                    Nueva Parte Anatómica

                </h2>

                <p class="text-slate-500 mt-2">

                    Registre una nueva parte anatómica para un parásito.

                </p>

            </div>

            <form
                action="{{ route('parte-parasitos.store') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf

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
                                    {{ old('parasito_id') == $parasito->id ? 'selected' : '' }}>

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
                            value="{{ old('nombre') }}"
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
                            value="{{ old('orden', 1) }}"
                            required
                            class="w-full rounded-xl border-slate-300">

                    </div>

                    <div>

                        <label class="block font-semibold mb-2">

                            Imagen *

                        </label>

                        <input
                            type="file"
                            id="imagen"
                            name="imagen"
                            accept="image/*"
                            required
                            class="w-full rounded-xl border-slate-300">

                        <div
                            id="preview-container"
                            class="mt-4 hidden">

                            <img
                                id="preview-image"
                                class="w-64 h-64 object-cover rounded-xl border shadow-sm">

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
                            class="w-full rounded-xl border-slate-300">{{ old('descripcion') }}</textarea>

                    </div>

                    <div>

                        <label class="flex items-center gap-3">

                            <input
                                type="checkbox"
                                name="activo"
                                value="1"
                                checked>

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

                        Guardar Parte Anatómica

                    </button>

                </div>

            </form>

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

            document
                .getElementById('preview-container')
                .classList.remove('hidden');

        };

        reader.readAsDataURL(archivo);

    });

</script>

</x-layouts.admin>