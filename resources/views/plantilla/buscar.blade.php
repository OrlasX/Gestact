<!DOCTYPE html>
<html lang="en">

<head>
    @include('plantilla.componentes.head')

</head>

<body>

    @auth
        <x-guest-layout>
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-semibold">Buscar Acta</h1> <!-- Título de la sección para buscar actas -->
                <x-primary-button type="button" onclick="window.location.href='{{ route('dashboard') }}';"
                    class="bg-gradient-to-b from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800">
                    Volver <!-- Botón para volver al dashboard -->
                </x-primary-button>
            </div>

            <form method="GET" action="{{ route('busqueda') }}">
                <!-- Filtro de Fecha con selectores de año, mes y día -->
                <div class="flex space-x-4">
                    <div class="flex-1 relative">
                        <select id="day" name="day"
                            class="appearance-none mt-1 block w-full bg-gray-100 border border-gray-200 rounded-lg shadow-lg shadow-gray-400 px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out">
                            <option value="">Día</option> <!-- Opción predeterminada -->
                            @for ($d = 1; $d <= 31; $d++)
                                <option value="{{ str_pad($d, 2, '0', STR_PAD_LEFT) }}">{{ $d }}</option>
                                <!-- Opciones para los días del mes -->
                            @endfor
                        </select>
                    </div>

                    <!-- Campo de Mes -->
                    <div class="flex-1 relative">
                        <select id="month" name="month"
                            class="appearance-none mt-1 block w-full bg-gray-200 border border-gray-200 rounded-lg shadow-lg shadow-gray-400 px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out">
                            <option value="">Mes</option> <!-- Opción predeterminada -->
                            @foreach (['01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'] as $num => $mes)
                                <option value="{{ $num }}">{{ $mes }}</option>
                                <!-- Opciones para los meses del año -->
                            @endforeach
                        </select>
                    </div>

                    <!-- Campo de Año -->
                    <div class="flex-1 relative">
                        <select id="year" name="year"
                            class="appearance-none mt-1 block w-full bg-gray-300 border border-gray-200 rounded-lg shadow-lg shadow-gray-400 px-4 py-2 text-gray-700 focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out">
                            <option value="">Año</option> <!-- Opción predeterminada -->
                            @for ($i = now()->year; $i >= 1975; $i--)
                                <!-- Seleccionar años desde el actual hasta 1975 -->
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Campo de hora inicial -->
                <div class="grid grid-cols-2 gap-4 mt-4 mb-1">
                    <div class="">
                        <label for="hora_inicial" class="block text-gray-700">Hora Inicial</label>
                        <!-- Etiqueta para hora inicial -->
                        <input type="time" id="hora_inicial" name="hora_inicial"
                            class="mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out">
                    </div>

                    <!-- Campo de hora final -->
                    <div class="mb-4">
                        <label for="hora_final" class="block text-gray-700">Hora Final</label>
                        <!-- Etiqueta para hora final -->
                        <input type="time" id="hora_final" name="hora_final"
                            class="mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="apodo" class="block text-gray-700">Apodo</label> <!-- Etiqueta para el campo de apodo -->
                    <input type="text" id="apodo" name="apodo"
                        class="mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out">
                </div>

                <div class="mb-4">
                    <label for="lugar" class="block text-gray-700">Lugar de Reunión</label>
                    <!-- Etiqueta para el campo de lugar de reunión -->
                    <input type="text" id="lugar" name="lugar"
                        class="mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out">
                </div>


                <!-- Asistentes -->
                <div id="asistentes" class="mb-1">
                    <label for="hora_inicial" class="block text-gray-700">Asistentes</label>
                    <div class="flex items-center mt-1">
                        <!-- Campo de entrada para el nombre del asistente -->
                        <input list="usuarios" type="text" name="asistentes[]"
                            class="block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                            placeholder="Nombre" oninput="setCargo(this)" required />
                        <!-- Campo de entrada para el cargo del asistente -->
                        <input type="text" name="cargos_asistentes[]"
                            class="ml-2 block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                            placeholder="Cargo" readonly />
                        <!-- Botón para eliminar un asistente -->
                        <button type="button"
                            class="ml-2 text-red-500 font-semibold underline hover:text-red-600 focus:outline-none"
                            onclick="removeElement(this,'asistentes')">Eliminar</button>
                    </div>
                </div>
                <!-- Botón para añadir un nuevo asistente -->
                <button type="button" id="add-asistente"
                    class="mt-1 text-blue-500 font-semibold underline hover:text-blue-600 focus:outline-none pb-3"
                    onclick="addAsistente()">Añadir
                    asistente</button>

                <!-- Datalist para sugerencias de usuarios -->
                <datalist id="usuarios">
                    @foreach ($usuarios as $usuario)
                        <option data-id="{{ $usuario->name }}" data-cargo="{{ $usuario->cargo }}"
                            value=" {{ $usuario->id }} {{ $usuario->name }}">{{ $usuario->cargo }}</option>
                    @endforeach
                </datalist>

                <!-- Campo de texto para buscar en el orden del día -->
                <div class="mb-4">
                    <label for="texto" class="block text-gray-700">Texto en Orden del Día</label>
                    <input type="text" id="texto" name="texto"
                        class="mb-2 mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-orange-500 focus:ring-orange-500 text-gray-800 transition duration-200 ease-in-out"
                        placeholder="Texto a buscar">
                </div>

                <!-- Botón para enviar la búsqueda -->
                <div class="text-center">
                    <x-primary-button type="submit"
                        class="bg-gradient-to-b from-blue-400 to-blue-700 hover:from-blue-500 hover:to-blue-800 text-white px-4 py-2 rounded-md transition duration-200 shadow-md transform hover:scale-105">Buscar</x-primary-button>
                </div>

            </form>
        </x-guest-layout>
    @else
        {{-- Redirige al usuario no autenticado a la vista template --}}
        <script>
            window.location.href = "{{ route('template') }}";
        </script>
    @endauth

    <script>
        // Función para agregar un nuevo asistente al formulario
        function addAsistente() {
            // Obtener el contenedor que alberga todos los asistentes
            const asistentesContainer = document.getElementById('asistentes');

            // Crear un nuevo elemento div que representará a un asistente
            const newAsistente = document.createElement('div');
            newAsistente.className = 'flex items-center mt-2'; // Aplicar estilos al nuevo div

            // Definir el contenido HTML del nuevo div
            newAsistente.innerHTML = `
        <input list="usuarios" type="text" name="asistentes[]"
            class=" block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
            placeholder="Nombre" oninput="setCargo(this)" required />
        <input type="text" name="cargos_asistentes[]"
            class="ml-2 block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
            placeholder="Cargo" readonly />
        <button type="button" class="ml-2 text-red-500 font-semibold underline hover:text-red-600 focus:outline-none" onclick="removeElement(this,'asistentes')">Eliminar</button>
    `;

            // Agregar el nuevo div al contenedor de asistentes
            asistentesContainer.appendChild(newAsistente);
        }

        // Función para eliminar un asistente del formulario
        function removeElement(button, containerId) {
        const container = document.getElementById(containerId);
        const asistenteDivs = container.querySelectorAll('.flex.items-center');

        // Solo permitir eliminar si hay más de un asistente
        if (asistenteDivs.length > 1) {
            button.closest('.flex.items-center').remove();
        } else {
            alert('Debe haber al menos un asistente.');
        }
    }
        // Función para establecer el cargo del asistente basado en la opción seleccionada
        function setCargo(inputElement) {
            // Obtener las opciones del datalist relacionado
            const datalistOptions = document.getElementById('usuarios').options;

            // Buscar la opción que coincide con el valor del input del asistente
            const selectedOption = Array.from(datalistOptions).find(option => option.value === inputElement.value);

            // Si se encuentra una opción seleccionada
            if (selectedOption) {
                // Encontrar el campo de cargo que está al lado del campo de nombre
                const cargoInput = inputElement.nextElementSibling;

                // Rellenar el campo de cargo con el valor del atributo data-cargo de la opción seleccionada
                cargoInput.value = selectedOption.getAttribute('data-cargo');

                // Si se desea, se puede llenar el ID en el campo de asistentes
                inputElement.value = selectedOption.getAttribute('data-id');
            } else {
                // Si no hay coincidencia, limpiar el campo de cargo
                inputElement.nextElementSibling.value = '';
            }
        }
    </script>
</body>

</html>
