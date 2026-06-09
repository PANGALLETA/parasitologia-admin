<x-layouts.admin>

    <x-slot:title>
        Asistente IA
    </x-slot:title>

    <div class="h-[85vh] flex flex-col">

        <div
            id="chat"
            class="flex-1 overflow-y-auto p-8">

            <div
                id="bienvenida"
                class="text-center mt-40">

                <h1 class="text-5xl font-semibold text-slate-700">

                    ¿Por dónde deberíamos empezar?

                </h1>

            </div>

        </div>

        <div class="p-6">

            <div class="max-w-4xl mx-auto">

                <div
                    class="bg-white rounded-3xl shadow border flex items-center p-3">

                    <input
                        id="mensaje"
                        type="text"
                        placeholder="Pregunta sobre parasitología..."
                        class="flex-1 border-0 focus:ring-0">

                    <button
                        onclick="preguntarIA()"
                        class="bg-black text-white px-5 py-2 rounded-xl">

                        Enviar

                    </button>

                </div>

            </div>

        </div>

    </div>

    <script>

        async function preguntarIA()
        {
            let mensaje =
                document.getElementById(
                    'mensaje'
                ).value;

            if(!mensaje)
                return;

            document
                .getElementById(
                    'bienvenida'
                )
                ?.remove();

            const chat =
                document.getElementById(
                    'chat'
                );

            chat.innerHTML += `
                <div class="flex justify-end mb-4">

                    <div
                        class="bg-indigo-600 text-white p-4 rounded-2xl max-w-xl">

                        ${mensaje}

                    </div>

                </div>
            `;

            document
                .getElementById(
                    'mensaje'
                ).value = '';

            const response =
                await fetch(
                    "{{ route('asistente-ia.preguntar') }}",
                    {

                        method: 'POST',

                        headers: {

                            'Content-Type':
                            'application/json',

                            'X-CSRF-TOKEN':
                            '{{ csrf_token() }}'

                        },

                        body: JSON.stringify({

                            mensaje

                        })

                    }
                );

            const data =
                await response.json();

            chat.innerHTML += `
                <div class="flex justify-start mb-4">

                    <div
                        class="bg-white border p-4 rounded-2xl max-w-xl">

                        ${data.respuesta}

                    </div>

                </div>
            `;

            chat.scrollTop =
                chat.scrollHeight;
        }

    </script>

</x-layouts.admin>