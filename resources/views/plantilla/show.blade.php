<!DOCTYPE html>
<html lang="en">

<head>
    @include('plantilla.componentes.head')
</head>

<body class="">
    @auth
        <x-guest-layout>
            <!-- Contenedor principal del formulario de edición del acta -->

            <!-- Encabezado con el título y botones de acción -->
            <div class="flex justify-between items-center mb-4">
                <!-- Título de la vista -->
                <h1 class="text-2xl font-semibold">Editar Acta</h1>

                <!-- Contenedor para los botones de eliminar y volver -->
                <div class="flex justify-end space-x-4">
                    <!-- Condicional para mostrar el botón de eliminar solo si el usuario es auxiliar o si el acta es editable -->
                    @if (auth()->user()->rol === 'auxiliar' || $acta->editable)
                        <!-- Formulario para eliminar el acta -->
                        <form action="{{ route('acta.destroy', $acta->id) }}" method="POST"
                            onsubmit="return confirm('¿Seguro que quieres eliminar el acta?');">
                            @csrf
                            @method('DELETE')
                            <!-- Botón para confirmar la eliminación del acta -->
                            <x-primary-button type="submit"
                                class="bg-gradient-to-b from-red-500 to-red-700 hover:from-red-600 hover:to-red-800">
                                Eliminar
                            </x-primary-button>
                        </form>
                    @endif

                    <!-- Botón para regresar a la página anterior -->
                    <x-primary-button type="button"
                        onclick="window.location.href='{{ session('last_dashboard_or_search_url', route('dashboard')) }}';"
                        class="bg-gradient-to-b from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800">
                        Volver
                    </x-primary-button>



                </div>
            </div>

            <!-- Formulario para actualizar el acta -->
            <form action="{{ route('acta.update', $acta->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Campo de Nombre -->
                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" id="nombre" name="nombre" required
                        class="mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                        value="{{ old('nombre', $acta->nombre) }}"
                        {{ $acta->editable || auth()->user()->rol === 'auxiliar' ? '' : 'readonly' }} />
                </div>

                <!-- Campo de Apodo -->
                <div class="mb-4">
                    <label for="apodo" class="block text-sm font-medium text-gray-700">Apodo</label>
                    <input type="text" id="apodo" name="apodo" required
                        class="mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                        value="{{ old('apodo', $acta->apodo) }}"
                        {{ $acta->editable || auth()->user()->rol === 'auxiliar' ? '' : 'readonly' }}>
                </div>

                <!-- Campo de Identificación -->
                <div class="mb-4">
                    <label for="identificacion" class="block text-sm font-medium text-gray-700">Identificación</label>
                    <input type="text" id="identificacion" name="identificacion" required
                        class="mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                        value="{{ old('identificacion', $acta->identificacion) }}"
                        {{ $acta->editable || auth()->user()->rol === 'auxiliar' ? '' : 'readonly' }}>
                </div>

                <!-- Campo de Fecha de Reunión -->
                <div class="mb-4">
                    <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha de Reunión</label>
                    <input type="date" id="fecha" name="fecha_reunion" required
                        class="mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                        value="{{ old('fecha_reunion', $acta->fecha_reunion) }}"
                        {{ $acta->editable || auth()->user()->rol === 'auxiliar' ? '' : 'readonly' }}>
                </div>

                <!-- Campos de Hora de Reunión (Inicial y Final) -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <!-- Hora Inicial -->
                    <div>
                        <label for="hora_inicio" class="block text-sm font-medium text-gray-700">Hora Inicial</label>
                        <input type="time" id="hora_inicio" name="hora_inicial" required
                            class="mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                            value="{{ old('hora_inicial', $acta->hora_inicial) }}"
                            {{ $acta->editable || auth()->user()->rol === 'auxiliar' ? '' : 'readonly' }}>
                    </div>

                    <!-- Hora Final -->
                    <div>
                        <label for="hora_final" class="block text-sm font-medium text-gray-700">Hora Final</label>
                        <input type="time" id="hora_final" name="hora_final" required
                            class="mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                            value="{{ old('hora_final', $acta->hora_final) }}"
                            {{ $acta->editable || auth()->user()->rol === 'auxiliar' ? '' : 'readonly' }}>
                    </div>
                </div>

                <!-- Campo de Lugar de Reunión -->
                <div class="mb-4">
                    <label for="lugar" class="block text-sm font-medium text-gray-700">Lugar de Reunión</label>
                    <input type="text" id="lugar" name="lugar_reunion" required
                        class="mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                        value="{{ old('lugar_reunion', $acta->lugar_reunion) }}"
                        {{ $acta->editable || auth()->user()->rol === 'auxiliar' ? '' : 'readonly' }}>
                </div>

                <!-- Sección de Asistentes -->
                <div class="mb-1 flex justify-between items-center">
                    <!-- Etiqueta para la lista de asistentes -->
                    <label class="text-sm font-medium text-gray-700">Asistentes:</label>
                </div>
                <div id="asistentes" class="mb-1">
                    <!-- Recorre la lista de asistentes del acta actual -->
                    @foreach ($acta->asistentes as $asistente)
                        <div class="flex items-center mt-2">
                            <!-- Campo de texto para el nombre del asistente, usando un datalist para autocompletar -->
                            <input list="usuarios" type="text" name="asistentes[]"
                                class="block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                                placeholder="Nombre" value="{{ $asistente->nombre }}" required oninput="updateCargo(this)"
                                {{ $acta->editable || auth()->user()->rol === 'auxiliar' ? '' : 'readonly' }}>

                            <!-- Campo de texto para mostrar el cargo del asistente, solo lectura -->
                            <input type="text" name="cargos_asistentes[]"
                                class="ml-2 block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                                placeholder="Cargo" required readonly value="{{ $asistente->cargo }}"
                                {{ $acta->editable || auth()->user()->rol === 'auxiliar' ? '' : 'readonly' }}>

                            <!-- Botón para eliminar al asistente, visible solo para usuarios auxiliares o si el acta es editable -->
                            @if (auth()->user()->rol === 'auxiliar' || $acta->editable)
                                <button type="button"
                                    class="ml-2 text-red-500 font-semibold underline hover:text-red-600 focus:outline-none"
                                    onclick="removeElement(this, 'asistentes');">
                                    Eliminar
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Botón para añadir un nuevo asistente, solo visible si el usuario es auxiliar o el acta es editable -->
                @if (auth()->user()->rol === 'auxiliar' || $acta->editable)
                    <button type="button" id="add-asistente"
                        class="mt-1 text-blue-500 font-semibold underline hover:text-blue-600 focus:outline-none"
                        onclick="addAsistente()">
                        Añadir Asistente
                    </button>
                @endif

                <!-- Lista de usuarios para autocompletar en el campo de nombre de los asistentes -->
                <datalist id="usuarios">
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->name }}" data-cargo="{{ $usuario->cargo }}">{{ $usuario->cargo }}
                        </option>
                    @endforeach
                </datalist>

                <!-- Sección de Ausentes -->
                <div class="mb-1 flex justify-between items-center">
                    <!-- Etiqueta para la lista de ausentes -->
                    <label class="text-sm font-medium text-gray-700 mt-3">Ausentes:</label>
                </div>
                <div id="ausentes" class="mb-1">
                    <!-- Recorre la lista de ausentes del acta actual -->
                    @foreach ($acta->ausentes as $ausente)
                        <div class="flex items-center mt-2">
                            <!-- Campo de texto para el nombre del ausente, con lista para autocompletar -->
                            <input list="usuarios" type="text" name="ausentes[]"
                                class="block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                                placeholder="Nombre" value="{{ $ausente->nombre }}" oninput="updateCargo(this)"
                                {{ $acta->editable || auth()->user()->rol === 'auxiliar' ? '' : 'readonly' }}>

                            <!-- Campo de texto para el cargo del ausente, solo lectura -->
                            <input type="text" name="cargos_ausentes[]"
                                class="ml-2 block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                                placeholder="Cargo" value="{{ $ausente->cargo }}"
                                {{ $acta->editable || auth()->user()->rol === 'auxiliar' ? '' : 'readonly' }}>

                            <!-- Botón para eliminar al ausente, solo visible si el usuario es auxiliar o el acta es editable -->
                            @if (auth()->user()->rol === 'auxiliar' || $acta->editable)
                                <button type="button"
                                    class="ml-2 text-red-500 font-semibold underline hover:text-red-600 focus:outline-none"
                                    onclick="removeElement(this, 'ausentes');">
                                    Eliminar
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Botón para añadir un nuevo ausente, solo visible si el usuario es auxiliar o el acta es editable -->
                @if (auth()->user()->rol === 'auxiliar' || $acta->editable)
                    <button type="button" id="add-ausente"
                        class="mt-1 text-blue-500 font-semibold underline hover:text-blue-600 focus:outline-none mb-3"
                        onclick="addAusente()">
                        Añadir Ausente
                    </button>
                @endif


                <!-- Invitados -->
                <div class="mb-1 flex justify-between items-center">
                    <!-- Etiqueta para la sección de invitados -->
                    <label class="text-sm font-medium text-gray-700 mt-3">Invitados:</label>
                </div>
                <div id="invitados" class="mb-1">
                    @foreach ($acta->invitados as $invitado)
                        <div class="flex items-center mt-2">
                            <!-- Campo de entrada para el nombre del invitado -->
                            <input type="text" name="invitados[]"
                                class="block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                                placeholder="Nombre" value="{{ $invitado->nombre }}"
                                {{ $acta->editable || auth()->user()->rol === 'auxiliar' ? '' : 'readonly' }}>

                            <!-- Campo de entrada para el cargo del invitado -->
                            <input type="text" name="cargos_invitados[]"
                                class="ml-2 block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                                placeholder="Cargo" value="{{ $invitado->cargo }}"
                                {{ $acta->editable || auth()->user()->rol === 'auxiliar' ? '' : 'readonly' }}>

                            <!-- Botón para eliminar invitado, visible solo si el acta es editable o el usuario es auxiliar -->
                            @if (auth()->user()->rol === 'auxiliar' || $acta->editable)
                                <button type="button"
                                    class="ml-2 text-red-500 font-semibold underline hover:text-red-600 focus:outline-none"
                                    onclick="removeElement(this, 'invitados');">Eliminar</button>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Botón para añadir un nuevo invitado, visible solo si el acta es editable o el usuario es auxiliar -->
                @if (auth()->user()->rol === 'auxiliar' || $acta->editable)
                    <button type="button" id="add-invitado"
                        class="mt-1 text-blue-500 font-semibold underline hover:text-blue-600 focus:outline-none mb-3"
                        onclick="addInvitado()">Añadir Invitado</button>
                @endif

                <!-- Orden del día -->
                <div class="mb-4">
                    <!-- Etiqueta para la sección del orden del día -->
                    <label class="block text-sm font-medium text-gray-700 mt-3">Orden del Día</label>
                    <div id="orden-dia">
                        @foreach ($acta->orden_del_dia as $orden)
                            <div class="orden-item flex flex-col mb-2 mt-4">
                                <div class="flex items-center">
                                    <!-- Campo de entrada para el nombre del punto en el orden del día -->
                                    <input type="text" name="orden_del_dia[]"
                                        class="mb-2 mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                                        value="{{ $orden->nombre }}" placeholder="Punto de la orden" required
                                        {{ $acta->editable || auth()->user()->rol === 'auxiliar' ? '' : 'readonly' }}>

                                    <!-- Botón para eliminar un punto del orden del día, visible solo si el acta es editable o el usuario es auxiliar -->
                                    @if (auth()->user()->rol === 'auxiliar' || $acta->editable)
                                        <button type="button"
                                            class="ml-2 text-red-500 font-semibold underline hover:text-red-600 focus:outline-none"
                                            onclick="removeElementOrden(this, 'orden-dia');">Eliminar</button>
                                    @endif
                                </div>
                                <div class="w-full">
                                    <!-- Campo de texto para la descripción del punto en el orden del día -->
                                    <textarea
                                        class="mt-1 block w-full h-40 bg-gradient-to-r from-gray-100 to-gray-200 border border-gray-300 rounded-lg shadow-lg shadow-gray-400 px-4 py-3 focus:border-blue-500 focus:ring-blue-500 focus:ring-2 text-gray-800 resize-none transition duration-200 ease-in-out"
                                        name="descripcion_orden[]" rows="4" placeholder="Descripción"
                                        {{ $acta->editable || auth()->user()->rol === 'auxiliar' ? '' : 'readonly' }} required>{{ $orden->descripcion }}</textarea>

                                    <!-- Botón para añadir un símbolo de viñeta (●) en la descripción del punto -->
                                    @if (auth()->user()->rol === 'auxiliar' || $acta->editable)
                                        <x-primary-button type="button"
                                            class="mt-2 bg-gradient-to-b from-black to-gray-800 hover:from-gray-800 hover:to-black text-white-500"
                                            onclick="addBullet(this.previousElementSibling)">
                                            Añadir ●
                                        </x-primary-button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Botón para añadir un nuevo punto en el orden del día, visible solo si el acta es editable o el usuario es auxiliar -->
                    @if (auth()->user()->rol === 'auxiliar' || $acta->editable)
                        <button type="button" id="add-orden"
                            class="mt-1 text-blue-500 font-semibold underline hover:text-blue-600 focus:outline-none"
                            onclick="addOrden()">Añadir Orden</button>
                    @endif
                </div>



                <!-- Próxima reunión: Campo para especificar la fecha y el lugar de la próxima reunión del comité -->
                <div class="mb-4">
                    <label for="proxima_reunion" class="block text-sm font-medium text-gray-700">Fecha y Lugar del Próximo
                        Comité Básico de Facultad</label>
                    <input type="text" id="proxima_reunion" name="proxima_reunion" required
                        class="block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                        placeholder="Ej. 10/11/2024 - Sala de juntas"
                        value="{{ old('proxima_reunion', $acta->proxima_reunion) }}"
                        {{ $acta->editable || auth()->user()->rol === 'auxiliar' ? '' : 'readonly' }}>
                </div>

                <!-- Lista de usuarios q ya firmaron -->
                @if (auth()->user()->rol === 'auxiliar' || $acta->editable)
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Firmado por:</label>
                        <ul class="list-disc list-inside">
                            @foreach ($acta->asistentes as $asistente)
                                @if ($asistente->firmado)
                                    <li>{{ $asistente->nombre }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Botón de Actualizar Acta, visible solo para usuarios con permisos de edición -->
                @if (auth()->user()->rol === 'auxiliar' || $acta->editable)
                    <div class="mt-6 mb-3">
                        <x-primary-button
                            class="bg-gradient-to-b from-blue-400 to-blue-700 hover:from-blue-500 hover:to-blue-800 text-white px-4 py-2 rounded-md transition duration-200 shadow-md transform hover:scale-105">
                            Actualizar Acta
                        </x-primary-button>
                    </div>
                @endif

            </form>
            <!-- Botón para firmar el acta, visible solo si el usuario aún no ha firmado -->


            @if ($acta->asistentes->where('nombre', auth()->user()->name)->where('firmado', false)->count() > 0)
                <form action="{{ route('acta.firmar', $acta->id) }}" method="POST" id="firmar-form" class="mb-4 pt-3"
                    onsubmit="return confirm('¿Estás seguro de que quieres firmar este acta?')">
                    @csrf
                    <x-primary-button type="submit"
                        class="bg-gradient-to-b from-gray-500 to-gray-700 hover:from-gray-600 hover:to-gray-800 text-white px-4 py-2 rounded-md transition duration-200 shadow-md transform hover:scale-105">
                        Firmar
                    </x-primary-button>
                </form>
            @endif

            <!-- Botón para generar el acta en PDF, disponible solo cuando todos los asistentes han firmado y el acta es editable -->
            @if ($acta->editable && $acta->asistentes->every(fn($asistente) => $asistente->firmado))
                <form action="{{ route('actas.generar', $acta->id) }}" method="POST" id="generar-acta-form"
                    class="mb-4 pt-3"
                    onsubmit="return confirm('¿Estás seguro de que quieres generar el acta? Una vez generada, no podrá ser editada.')">
                    @csrf
                    <x-primary-button type="submit"
                        class="bg-gradient-to-b from-gray-500 to-gray-700 hover:from-gray-600 hover:to-gray-800 text-white px-4 py-2 rounded-md transition duration-200 shadow-md transform hover:scale-105">
                        Generar Acta
                    </x-primary-button>
                </form>
            @endif


            <!-- Botón para descargar el acta en PDF, disponible solo cuando todos los asistentes han firmado y el acta ya no es editable -->
            @if (!$acta->editable)
                <form action="{{ route('actas.download', $acta->id) }}" method="GET" id="descargar-acta-form"
                    class="mb-4">
                    @csrf
                    <x-primary-button type="submit"
                        class="bg-gradient-to-b from-gray-400 to-gray-600 hover:from-gray-500 hover:to-gray-700 text-white px-4 py-2 rounded-md transition duration-200 shadow-md transform hover:scale-105">
                        Descargar Acta
                    </x-primary-button>
                </form>
            @endif

        </x-guest-layout>
    @else
        {{-- Redirige al usuario no autenticado a la vista template --}}
        <script>
            window.location.href = "{{ route('template') }}";
        </script>
    @endauth

    <script>
        // Función para agregar un nuevo campo de asistente en el formulario
        function addAsistente() {
            const asistentesContainer = document.getElementById('asistentes'); // Contenedor para los asistentes
            const newAsistente = document.createElement('div');
            newAsistente.className = 'flex items-center mt-2'; // Aplicar margen superior para espaciar
            newAsistente.innerHTML = `
        <input list="usuarios" type="text" name="asistentes[]"
            class="block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-orange-500 focus:ring-orange-500 text-gray-800 transition duration-200 ease-in-out"
            placeholder="Nombre" required oninput="updateCargo(this)" />
        <input type="text" name="cargos_asistentes[]"
            class="ml-2 block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-orange-500 focus:ring-orange-500 text-gray-800 transition duration-200 ease-in-out"
            placeholder="Cargo" required readonly />
        <button type="button" class="ml-2 text-red-500 font-semibold underline hover:text-red-600 focus:outline-none" onclick="removeElement(this, 'asistentes');">Eliminar</button>
    `;
            asistentesContainer.appendChild(newAsistente); // Añadir el nuevo asistente al contenedor
        }

        // Función para agregar un nuevo campo de ausente en el formulario
        function addAusente() {
            const ausentesSection = document.getElementById('ausentes'); // Contenedor para los ausentes
            const newAusente = document.createElement('div');
            newAusente.className = 'flex items-center mt-2'; // Aplicar margen superior para igualar espacio
            newAusente.innerHTML = `
        <input list="usuarios" type="text" name="ausentes[]"
            class="block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
            placeholder="Nombre" oninput="updateCargo(this)" />
        <input type="text" name="cargos_ausentes[]"
            class="ml-2 block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
            placeholder="Cargo" />
        <button type="button" class="ml-2 text-red-500 font-semibold underline hover:text-red-600 focus:outline-none" onclick="removeElement(this, 'ausentes');">Eliminar</button>
    `;
            ausentesSection.appendChild(newAusente); // Añadir el nuevo ausente al contenedor
            updateRequiredFields('ausentes'); // Actualizar campos requeridos si es necesario
        }

        // Función para agregar un nuevo campo de invitado en el formulario
        function addInvitado() {
            const invitadosSection = document.getElementById('invitados'); // Contenedor para los invitados
            const newInvitado = document.createElement('div');
            newInvitado.className = 'flex items-center mt-2'; // Aplicar margen superior para igualar espacio
            newInvitado.innerHTML = `
        <input type="text" name="invitados[]"
            class="block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
            placeholder="Nombre" />
        <input type="text" name="cargos_invitados[]"
            class="ml-2 block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
            placeholder="Cargo" />
        <button type="button" class="ml-2 text-red-500 font-semibold underline hover:text-red-600 focus:outline-none" onclick="removeElement(this, 'invitados');">Eliminar</button>
    `;
            invitadosSection.appendChild(newInvitado); // Añadir el nuevo invitado al contenedor
            updateRequiredFields('invitados'); // Actualizar campos requeridos si es necesario
        }


        // Función para agregar un nuevo punto en el orden del día
        function addOrden() {
            const ordenDiaContainer = document.getElementById('orden-dia'); // Contenedor para los puntos del orden del día
            const newOrdenItem = document.createElement('div');
            newOrdenItem.className = 'orden-item flex flex-col mb-2'; // Asignar clase para mantener el estilo consistente
            newOrdenItem.innerHTML = `
        <div class="flex items-center">
            <input type="text" name="orden_del_dia[]" class="mb-2 mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-orange-500 focus:ring-orange-500 text-gray-800 transition duration-200 ease-in-out" placeholder="Punto de la orden" required>
            <button type="button" class="ml-2 text-red-500 font-semibold underline hover:text-red-600 focus:outline-none" onclick="removeElementOrden(this)">Eliminar</button>
        </div>
        <div class="w-full">
            <textarea class="mt-1 block w-full h-40 bg-gradient-to-r from-gray-100 to-gray-200 border border-gray-300 rounded-lg shadow-lg shadow-gray-400 px-4 py-3 focus:border-orange-500 focus:ring-orange-500 focus:ring-2 text-gray-800 resize-none transition duration-200 ease-in-out" name="descripcion_orden[]" rows="4" placeholder="Descripción" required></textarea>
            <x-primary-button type="button" class="mt-2 bg-gradient-to-b from-black to-gray-800 hover:from-gray-800 hover:to-black text-white-500" onclick="addBullet(this.previousElementSibling)">
                Añadir ●
            </x-primary-button>
        </div>
    `;
            ordenDiaContainer.appendChild(newOrdenItem); // Añadir el nuevo elemento de orden del día al contenedor
        }

        // Función para actualizar el cargo de un usuario seleccionado
        function updateCargo(inputElement) {
            const selectedValue = inputElement.value; // Obtener el valor seleccionado del usuario
            const options = document.querySelectorAll(
                '#usuarios option'); // Obtener todas las opciones de la lista de usuarios

            // Buscar el cargo correspondiente al usuario seleccionado
            options.forEach(option => {
                if (option.value === selectedValue) {
                    const isAsistente = inputElement.name ===
                        "asistentes[]"; // Verificar si el usuario es un asistente
                    const cargoInputName = isAsistente ? 'cargos_asistentes[]' :
                        'cargos_ausentes[]'; // Determinar el nombre del campo de cargo

                    const cargoInput = inputElement.parentElement.querySelector(
                        `input[name="${cargoInputName}"]`); // Encontrar el campo de cargo correspondiente
                    if (cargoInput) {
                        cargoInput.value = option.getAttribute(
                            'data-cargo'); // Asignar el cargo al campo correspondiente
                    }
                }
            });
        }


        // Función para eliminar un elemento de un contenedor
        function removeElement(button, containerId) {
            const container = document.getElementById(containerId); // Obtener el contenedor por su ID
            // Comprobar que haya más de un elemento en el contenedor
            if (container.children.length > 1) {
                button.parentElement.remove(); // Eliminar el elemento que contiene el botón
                updateRequiredFields(containerId); // Actualizar los campos requeridos en el contenedor
            } else {
                alert(
                    'Debe haber al menos un elemento en esta lista. No se puede eliminar el último.'
                ); // Avisar si se intenta eliminar el último elemento
            }
        }

        // Función para confirmar la eliminación de un acta
        function confirmDelete() {
            if (confirm('¿Seguro que quieres eliminar el acta?')) { // Preguntar al usuario si está seguro
                document.getElementById('delete-form').submit(); // Si confirma, enviar el formulario de eliminación
            }
        }

        function confirmarFirma() {
            if (confirm("¿Estás seguro de que quieres firmar?")) {
                // Enviar el formulario si se confirma
                document.getElementById('firmar-form').submit();
            }
        }

        // Función para confirmar la generación de un acta
        function confirmarGenerarActa() {
            if (confirm('¿Deseas generar el acta?')) { // Preguntar al usuario si está seguro
                document.getElementById('generar-acta-form')
                    .submit(); // Si confirma, enviar el formulario para generar el acta
            }
        }

        // Función para eliminar un elemento específico del orden del día
        function removeElementOrden(button) {
            const element = button.parentElement.parentElement; // Obtener el elemento que contiene el botón
            const container = element.parentElement; // Obtener el contenedor del elemento

            // Comprobar que haya más de un elemento en el contenedor
            if (container.children.length <= 1) {
                alert('Debes tener al menos un elemento en la orden del día.'); // Avisar si se intenta eliminar el último
                return; // Salir de la función si no se puede eliminar
            }

            element.remove(); // Eliminar el elemento del orden del día
        }

        // Función para actualizar los campos requeridos en un contenedor
        function updateRequiredFields(containerId) {
            const container = document.getElementById(containerId); // Obtener el contenedor por su ID
            const inputs = container.querySelectorAll(
                `input[name="${containerId}[]"]`); // Seleccionar todos los inputs relevantes

            // Si hay dos o más inputs, hacerlos requeridos
            if (inputs.length >= 2) {
                inputs.forEach(input => input.setAttribute('required', 'required'));
            } else {
                inputs.forEach(input => input.removeAttribute('required')); // Si hay menos de dos, quitar el requisito
            }
        }

        // Función para añadir un punto de viñeta al texto de un textarea
        function addBullet(textarea) {
            const bulletPoint = '● '; // Definir el símbolo de la viñeta
            textarea.value += bulletPoint; // Añadir la viñeta al valor del textarea
        }
    </script>
</body>

</html>
