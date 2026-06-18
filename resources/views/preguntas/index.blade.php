<x-layouts.admin>

    <x-slot:title>
        Quiz
    </x-slot:title>

    <div class="bg-white rounded-3xl shadow-sm overflow-hidden">

        <div class="p-8 border-b">

            <div class="flex justify-between items-center">

                <div>

                    <h2 class="text-4xl font-bold text-slate-800">

                        Banco de Preguntas

                    </h2>

                    <p class="text-slate-500 mt-2">

                        Administración de preguntas del sistema.

                    </p>

                </div>
                @can('crear quiz')
                <a
                    href="{{ route('preguntas.create') }}"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold">

                    + Nueva Pregunta

                </a>
                @endcan

            </div>

        </div>

        @if(session('success'))

            <div class="mx-6 mt-6 rounded-xl border border-green-200 bg-green-50 p-4 text-green-700">

                {{ session('success') }}

            </div>

        @endif

        <div class="p-6 border-b">

            <form
                method="GET"
                class="flex gap-4">

                <select
                    name="parasito_id"
                    class="flex-1 rounded-xl border-slate-300">

                    <option value="">
                        Todos los parásitos
                    </option>

                    @foreach($parasitos as $parasito)

                        <option
                            value="{{ $parasito->id }}"
                            {{ request('parasito_id') == $parasito->id ? 'selected' : '' }}>

                            {{ $parasito->nombre_comun }}

                        </option>

                    @endforeach

                </select>

                <button
                    type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 rounded-xl">

                    Filtrar

                </button>

            </form>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left">

                            Parásito

                        </th>

                        <th class="px-6 py-4 text-left">

                            Pregunta

                        </th>

                        <th class="px-6 py-4 text-left">

                            Respuesta Correcta

                        </th>

                        <th class="px-6 py-4 text-center">

                            Estado

                        </th>

                        <th class="px-6 py-4 text-center">

                            Acciones

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($preguntas as $pregunta)

                        <tr class="border-t">

                            <td class="px-6 py-4">

                                {{ $pregunta->parasito?->nombre_comun }}

                            </td>

                            <td class="px-6 py-4">

                                {{ $pregunta->pregunta }}

                            </td>

                            <td class="px-6 py-4">

                                {{
                                    optional(
                                        $pregunta->respuestas
                                            ->where(
                                                'es_correcta',
                                                true
                                            )
                                            ->first()
                                    )->respuesta
                                }}

                            </td>

                            <td class="px-6 py-4 text-center">

                                @if($pregunta->activo)

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

                                        Activa

                                    </span>

                                @else

                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">

                                        Inactiva

                                    </span>

                                @endif

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    <a
                                        href="{{ route('preguntas.show', $pregunta) }}"
                                        class="bg-blue-100 text-blue-700 px-4 py-2 rounded-lg hover:bg-blue-200">

                                        Visualizar

                                    </a>
                                    @can('editar quiz')
                                    <a
                                        href="{{ route('preguntas.edit', $pregunta) }}"
                                        class="bg-amber-100 text-amber-700 px-4 py-2 rounded-lg hover:bg-amber-200">

                                        Editar

                                    </a>
                                    @endcan
                                    @can('eliminar quiz')

                                    <form
                                        id="form-eliminar-{{ $pregunta->id }}"
                                        action="{{ route('preguntas.destroy', $pregunta) }}"
                                        method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="button"
                                            onclick="eliminarPregunta({{ $pregunta->id }})"
                                            class="bg-red-100 text-red-700 px-4 py-2 rounded-lg hover:bg-red-200">

                                            Eliminar

                                        </button>

                                    </form>
                                    @endcan

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="text-center py-10 text-slate-500">

                                No existen preguntas registradas.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="p-6">

            {{ $preguntas->links() }}

        </div>

    </div>
<script>

function eliminarPregunta(id)
{
    Swal.fire({

        title: '¿Eliminar pregunta?',

        text: 'También se eliminarán todas las respuestas asociadas.',

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#dc2626',

        cancelButtonColor: '#64748b',

        confirmButtonText: 'Sí, eliminar',

        cancelButtonText: 'Cancelar'

    }).then((result) => {

        if(result.isConfirmed)
        {
            document
                .getElementById(
                    'form-eliminar-' + id
                )
                .submit();
        }

    });
}

</script>
</x-layouts.admin>