<x-layouts.admin>

<x-slot:title>
    Nuevo Parásito
</x-slot:title>

<div class="max-w-6xl mx-auto">

    @if ($errors->any())

        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4">

            <ul class="list-disc pl-5 text-red-700">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b">

            <h2 class="text-2xl font-bold text-slate-800">
                Registrar Parásito
            </h2>

            <p class="text-slate-500 mt-1">
                Ingrese la información del parásito.
            </p>

        </div>

        <form
            action="{{ route('parasitos.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="p-6">

            @csrf

            <!-- Información General -->

            <div class="mb-8">

                <h3 class="text-lg font-semibold text-slate-800 mb-4">
                    Información General
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Nombre Común *
                        </label>

                        <input
                            type="text"
                            name="nombre_comun"
                            value="{{ old('nombre_comun') }}"
                            class="w-full rounded-lg border-slate-300">

                    </div>

                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Nombre Científico *
                        </label>

                        <input
                            type="text"
                            name="nombre_cientifico"
                            value="{{ old('nombre_cientifico') }}"
                            class="w-full rounded-lg border-slate-300">

                    </div>

                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Familia
                        </label>

                        <input
                            type="text"
                            name="familia"
                            value="{{ old('familia') }}"
                            class="w-full rounded-lg border-slate-300">

                    </div>

                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Género
                        </label>

                        <input
                            type="text"
                            name="genero"
                            value="{{ old('genero') }}"
                            class="w-full rounded-lg border-slate-300">

                    </div>

                </div>

            </div>

            <!-- Descripción -->

            <div class="mb-8">

                <h3 class="text-lg font-semibold text-slate-800 mb-4">
                    Descripción y Morfología
                </h3>

                <div class="space-y-4">

                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Descripción General
                        </label>

                        <textarea
                            name="descripcion_general"
                            rows="5"
                            class="w-full rounded-lg border-slate-300">{{ old('descripcion_general') }}</textarea>

                    </div>

                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Morfología
                        </label>

                        <textarea
                            name="morfologia"
                            rows="5"
                            class="w-full rounded-lg border-slate-300">{{ old('morfologia') }}</textarea>

                    </div>

                </div>

            </div>

            <!-- Información Clínica -->

            <div class="mb-8">

                <h3 class="text-lg font-semibold text-slate-800 mb-4">
                    Información Clínica
                </h3>

                <div class="space-y-4">

                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Hospedadores
                        </label>

                        <textarea
                            name="hospedadores"
                            rows="4"
                            class="w-full rounded-lg border-slate-300">{{ old('hospedadores') }}</textarea>

                    </div>

                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Síntomas
                        </label>

                        <textarea
                            name="sintomas"
                            rows="4"
                            class="w-full rounded-lg border-slate-300">{{ old('sintomas') }}</textarea>

                    </div>

                    <div>

                        <label class="block text-sm font-medium mb-2">
                            Tratamiento
                        </label>

                        <textarea
                            name="tratamiento"
                            rows="4"
                            class="w-full rounded-lg border-slate-300">{{ old('tratamiento') }}</textarea>

                    </div>

                </div>

            </div>

            <!-- Imagen -->

            <!-- Imagen -->

            <div class="mb-8">

                <h3 class="text-lg font-semibold text-slate-800 mb-4">
                    Imagen Principal
                </h3>

                <input
                    type="file"
                    id="imagen_principal"
                    name="imagen_principal"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="w-full rounded-lg border-slate-300">

                <p class="text-xs text-slate-500 mt-2">
                    Formatos permitidos: JPG, JPEG, PNG y WEBP. Máximo 5 MB.
                </p>

                <div
                    id="infoImagen"
                    class="hidden mt-4">

                    <div class="rounded-lg border bg-slate-50 p-4">

                        <p class="text-sm text-slate-700">
                            <strong>Nombre:</strong>
                            <span id="nombreArchivo"></span>
                        </p>

                        <p class="text-sm text-slate-700 mt-1">
                            <strong>Tamaño:</strong>
                            <span id="tamanoArchivo"></span>
                        </p>

                    </div>

                    <img
                        id="previewImagen"
                        src=""
                        alt="Vista previa"
                        class="mt-4 max-h-80 rounded-xl border shadow-sm">
                </div>

            </div>

            <!-- Estado -->

            <div class="mb-8">

                <label class="inline-flex items-center">

                    <input
                        type="checkbox"
                        name="activo"
                        value="1"
                        checked
                        class="rounded border-slate-300">

                    <span class="ml-2">
                        Registro Activo
                    </span>

                </label>

            </div>

            <!-- Botones -->

            <div class="flex justify-end gap-3">

                <a
                    href="{{ route('parasitos.index') }}"
                    class="px-5 py-2 bg-slate-200 rounded-lg hover:bg-slate-300">

                    Cancelar

                </a>

                <button
                    type="submit"
                    class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">

                    Guardar Parásito

                </button>

            </div>

        </form>

    </div>

</div>
<script>

document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('imagen_principal');
    const preview = document.getElementById('previewImagen');
    const info = document.getElementById('infoImagen');
    const nombre = document.getElementById('nombreArchivo');
    const tamano = document.getElementById('tamanoArchivo');

    input.addEventListener('change', function (e) {

        const file = e.target.files[0];

        if (!file) {

            info.classList.add('hidden');
            return;
        }

        const maxSize = 5 * 1024 * 1024;

        if (file.size > maxSize) {

            alert('La imagen seleccionada supera los 5 MB permitidos.');

            input.value = '';
            info.classList.add('hidden');

            return;
        }

        nombre.textContent = file.name;

        tamano.textContent =
            (file.size / 1024 / 1024).toFixed(2) + ' MB';

        const reader = new FileReader();

        reader.onload = function (event) {

            preview.src = event.target.result;

            info.classList.remove('hidden');
        };

        reader.readAsDataURL(file);

    });

});

</script>

</x-layouts.admin>
