<!DOCTYPE html>
<html lang="en">

<head>
    @include('plantilla.componentes.head')
</head>

<body class="bg-gray-100">

    @auth
        <x-guest-layout>
            <div class="max-w-5xl mx-auto px-4">
                <div class="flex justify-between items-center mb-4">
                    <h1 class="text-2xl font-semibold">Redactar Acta</h1>
                    <x-primary-button type="button" onclick="window.history.back();"
                        class="bg-gradient-to-b from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800">
                        Volver
                    </x-primary-button>
                </div>

                <form id="actaForm" action="{{ route('acta.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" id="nombre" name="nombre" required
                          class="mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                          value="Acta Comité Básico No. " onblur="fixValue(this)" />
                      </div>




                    <div class="mb-4">
                        <label for="apodo" class="block text-sm font-medium text-gray-700">Apodo</label>
                        <input type="text" id="apodo" name="apodo" required
                            class="mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out" />
                    </div>

                    <!-- Campo para la identificación del acta -->
                    <div class="mb-4">
                        <label for="identificacion" class="block text-sm font-medium text-gray-700">Identificación</label>
                        <input type="text" id="identificacion" name="identificacion" required
                            class="mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out" />
                    </div>

                    <!-- Campo para la fecha de la reunión -->
                    <div class="mb-4">
                        <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha de Reunión</label>
                        <input type="date" id="fecha" name="fecha_reunion" required
                            class="mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out" />
                    </div>

                    <!-- Campo para la hora de inicio y final de la reunión -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="hora_inicio" class="block text-sm font-medium text-gray-700">Hora Inicial</label>
                            <input type="time" id="hora_inicio" name="hora_inicial" required
                                class="mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out" />
                        </div>
                        <div>
                            <label for="hora_final" class="block text-sm font-medium text-gray-700">Hora Final</label>
                            <input type="time" id="hora_final" name="hora_final" required
                                class="mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out" />
                        </div>
                    </div>

                    <!-- Campo para el lugar de la reunión -->
                    <div class="mb-4">
                        <label for="lugar" class="block text-sm font-medium text-gray-700">Lugar de Reunión</label>
                        <input type="text" id="lugar" name="lugar_reunion" required
                            class="mb-2 mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out" />
                    </div>



                    <!-- Asistentes -->
                    <div class="mb-1 flex justify-between items-center">
                        <label class="text-sm font-medium text-gray-700">Asistentes:</label>
                    </div>
                    <div id="asistentes" class="mb-1">
                        <div class="flex items-center mt-1">
                            <input list="usuarios" type="text" name="asistentes[]"
                                class="mt-1 block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                                placeholder="Nombre" required oninput="updateCargo(this)" />
                            <input type="text" name="cargos_asistentes[]"
                                class="ml-2 mt-1 block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                                placeholder="Cargo" required readonly />
                            <button type="button"
                                class="ml-2 text-red-500 font-semibold underline hover:text-red-600 focus:outline-none"
                                onclick="removeElement(this,'asistentes')">Eliminar</button>
                        </div>
                    </div>
                    <button type="button" id="add-asistente"
                        class="mt-1 text-blue-500 font-semibold underline hover:text-blue-600 focus:outline-none mb-3"
                        onclick="addAsistente()">Añadir asistente</button>
                    <!-- Datalist con los usuarios -->
                    <datalist id="usuarios">
                        @foreach ($usuarios as $usuario)
                            <option value="{{ $usuario->name }}" data-cargo="{{ $usuario->cargo }}">
                                {{ $usuario->cargo }}
                            </option>
                        @endforeach
                    </datalist>

                    <!-- Ausentes -->
                    <div class="mb-1 flex justify-between items-center">
                        <label class="text-sm font-medium text-gray-700">Ausentes:</label>
                    </div>
                    <div id="ausentes" class="mb-1">
                        <div class="flex items-center mt-1">
                            <input list="usuarios" type="text" name="ausentes[]"
                                class="mt-1 block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                                placeholder="Nombre" oninput="updateCargo(this)" />
                            <input type="text" name="cargos_ausentes[]"
                                class="ml-2 mt-1 block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                                placeholder="Cargo" />
                            <button type="button"
                                class="ml-2 text-red-500 font-semibold underline hover:text-red-600 focus:outline-none"
                                onclick="removeElement(this,'ausentes')">Eliminar</button>
                        </div>
                    </div>
                    <button type="button" id="add-ausente"
                        class="mt-1 text-blue-500 font-semibold underline hover:text-blue-600 focus:outline-none mb-3"
                        onclick="addAusente()">Añadir ausente</button>

                    <!-- Datalist con los usuarios -->
                    <datalist id="usuarios">
                        @foreach ($usuarios as $usuario)
                            <option value="{{ $usuario->name }}" data-cargo="{{ $usuario->cargo }}">
                                {{ $usuario->cargo }}
                            </option>
                        @endforeach
                    </datalist>

                    <!-- Invitados -->
                    <div class="mb-1">
                        <label class="block text-sm font-medium text-gray-700">Invitados</label>
                        <div id="invitados">
                            <div class="flex items-center">
                                <input type="text" name="invitados[]"
                                    class="mt-1 block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                                    placeholder="Nombre" />
                                <input type="text" name="cargos_invitados[]"
                                    class="ml-2 mt-1 block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                                    placeholder="Cargo" />
                                <button type="button"
                                    class="ml-2 text-red-500 font-semibold underline hover:text-red-600 focus:outline-none"
                                    onclick="removeElement(this,'invitados')">Eliminar</button>
                            </div>
                        </div>
                        <button type="button" id="add-invitado"
                            class="mt-1 text-blue-500 font-semibold underline hover:text-blue-600 focus:outline-none mb-3"
                            onclick="addInvitado()">Añadir invitado</button>
                    </div>

                    <!-- Orden del día -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Orden del Día</label>
                        <div id="orden-dia">
                            <div class="orden-item flex flex-col">
                                <div class="flex items-center">
                                    <input type="text" name="orden_del_dia[]"
                                        class="mb-2 mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                                        placeholder="Titulo de la orden" required />
                                    <button type="button"
                                        class="ml-2 text-red-500 font-semibold underline hover:text-red-600 focus:outline-none"
                                        onclick="removeElementOrden(this)">Eliminar</button>
                                </div>
                                <div class="w-full">
                                    <textarea
                                        class="mt-1 block w-full h-40 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-lg shadow-lg shadow-gray-400 px-4 py-3 focus:border-blue-500 focus:ring-blue-500 focus:ring-2 text-gray-800 resize-none transition duration-200 ease-in-out"
                                        name="descripcion_orden[]" rows="4" placeholder="Descripción" required></textarea>
                                    <x-primary-button type="button"
                                        class="mt-2 bg-gradient-to-b from-black to-gray-800 hover:from-gray-800 hover:to-black text-white-500"
                                        onclick="addBullet(this.previousElementSibling)">
                                        Añadir ●
                                    </x-primary-button>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-orden"
                            class="mt-1 text-blue-500 font-semibold underline hover:text-blue-600 focus:outline-none"
                            onclick="addOrden()">Añadir Orden</button>
                    </div>


                    <!-- Próxima reunión -->
                    <div class="mb-4">
                        <!-- Etiqueta que describe el campo de entrada para la próxima reunión -->
                        <label for="proxima_reunion" class="block text-sm font-medium text-gray-700">Fecha y Lugar del
                            Próximo Comité Básico de Facultad</label>
                        <!-- Campo de entrada de texto para ingresar la fecha y lugar de la próxima reunión, requerido para el formulario -->
                        <input type="text" id="proxima_reunion" name="proxima_reunion" required
                            class="mb-2 mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-outblue">
                    </div>

                    <div class="mt-6">
                        <div class="mt-6">
                            <!-- Botón primario para guardar el acta, que tiene un estilo de gradiente y efectos de hover -->
                            <x-primary-button
                                class="bg-gradient-to-b from-blue-400 to-blue-700 hover:from-blue-500 hover:to-blue-800 text-white px-4 py-2 rounded-md transition duration-200 shadow-md transform hover:scale-105">
                                Guardar Acta
                            </x-primary-button>
                        </div>
                    </div>

                </form>

            </div>

        </x-guest-layout>
    @else
        {{-- Redirige al usuario no autenticado a la vista template --}}
        <script>
            window.location.href = "{{ route('template') }}";
        </script>
    @endauth


    <script>




function fixValue(inputElement) {
  const prefix = "Acta Comité Básico No. ";

  // Si el valor es vacío, no agregar el prefijo
  if (inputElement.value.trim() === '') {
    return;
  }

  // Si el valor no empieza con el prefijo y el campo no está vacío, agregar el prefijo
  if (!inputElement.value.startsWith(prefix)) {
    inputElement.value = prefix + inputElement.value;
  }
}




        // Función para agregar un nuevo asistente en el formulario
        function addAsistente() {
            const asistentesContainer = document.getElementById('asistentes'); // Contenedor de asistentes
            const newAsistente = document.createElement('div'); // Crear un nuevo contenedor para el asistente
            newAsistente.className = 'flex items-center mt-2'; // Estilos para el contenedor
            newAsistente.innerHTML = `
        <input list="usuarios" type="text" name="asistentes[]"
            class="block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
            placeholder="Nombre" required oninput="updateCargo(this)" />
        <input type="text" name="cargos_asistentes[]"
            class="ml-2 block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
            placeholder="Cargo" required readonly />
        <button type="button" class="ml-2 text-red-500 font-semibold underline hover:text-red-600 focus:outline-none" onclick="removeElement(this, 'asistentes');">Eliminar</button>
    `;
            asistentesContainer.appendChild(newAsistente); // Añadir el asistente al contenedor de asistentes
        }

        // Función para agregar un nuevo ausente en el formulario
        function addAusente() {
            const ausentesSection = document.getElementById('ausentes'); // Contenedor de ausentes
            const newAusente = document.createElement('div');
            newAusente.className = 'flex items-center mt-2';
            newAusente.innerHTML = `
        <input list="usuarios" type="text" name="ausentes[]"
            class="block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
            placeholder="Nombre" oninput="updateCargo(this)" />
        <input type="text" name="cargos_ausentes[]"
            class="ml-2 block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
            placeholder="Cargo" />
        <button type="button" class="ml-2 text-red-500 font-semibold underline hover:text-red-600 focus:outline-none" onclick="removeElement(this, 'ausentes');">Eliminar</button>
    `;
            ausentesSection.appendChild(newAusente); // Añadir el ausente al contenedor de ausentes
            updateRequiredFields('ausentes'); // Verificar si se deben actualizar los campos requeridos
        }

        // Función para agregar un nuevo invitado en el formulario
        function addInvitado() {
            const invitadosSection = document.getElementById('invitados'); // Contenedor de invitados
            const newInvitado = document.createElement('div');
            newInvitado.className = 'flex items-center mt-2';
            newInvitado.innerHTML = `
        <input type="text" name="invitados[]"
            class="block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
            placeholder="Nombre" />
        <input type="text" name="cargos_invitados[]"
            class="ml-2 block w-1/2 bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
            placeholder="Cargo" />
        <button type="button" class="ml-2 text-red-500 font-semibold underline hover:text-red-600 focus:outline-none" onclick="removeElement(this, 'invitados');">Eliminar</button>
    `;
            invitadosSection.appendChild(newInvitado); // Añadir el invitado al contenedor de invitados
            updateRequiredFields('invitados'); // Actualizar campos requeridos si es necesario
        }

        // Función para agregar un nuevo punto en el orden del día
        function addOrden() {
            const ordenDiaContainer = document.getElementById('orden-dia'); // Contenedor de orden del día
            const newOrdenItem = document.createElement('div');
            newOrdenItem.className = 'orden-item flex flex-col mb-2'; // Estilos para el contenedor del punto
            newOrdenItem.innerHTML = `
        <div class="flex items-center">
            <input type="text" name="orden_del_dia[]" class="mb-2 mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-orange-500 focus:ring-orange-500 text-gray-800 transition duration-200 ease-in-out" placeholder="Titulo de la orden" required>
            <button type="button" class="ml-2 text-red-500 font-semibold underline hover:text-red-600 focus:outline-none" onclick="removeElementOrden(this)">Eliminar</button>
        </div>
        <div class="w-full">
            <textarea class="mt-1 block w-full h-40 bg-gradient-to-r from-gray-100 to-gray-200 border border-gray-300 rounded-lg shadow-lg shadow-gray-400 px-4 py-3 focus:border-orange-500 focus:ring-orange-500 focus:ring-2 text-gray-800 resize-none transition duration-200 ease-in-out" name="descripcion_orden[]" rows="4" placeholder="Descripción" required></textarea>
            <x-primary-button type="button" class="mt-2 bg-gradient-to-b from-black to-gray-800 hover:from-gray-800 hover:to-black text-white-500" onclick="addBullet(this.previousElementSibling)">
                Añadir ●
            </x-primary-button>
        </div>
    `;
            ordenDiaContainer.appendChild(newOrdenItem); // Añadir el nuevo punto al contenedor de orden del día
        }

        // Función para actualizar el cargo automáticamente al seleccionar un usuario
        function updateCargo(inputElement) {
            const selectedValue = inputElement.value; // Valor seleccionado por el usuario
            const options = document.querySelectorAll('#usuarios option'); // Opciones de usuarios

            options.forEach(option => {
                if (option.value === selectedValue) { // Buscar el cargo del usuario seleccionado
                    const isAsistente = inputElement.name === "asistentes[]";
                    const cargoInputName = isAsistente ? 'cargos_asistentes[]' : 'cargos_ausentes[]';

                    const cargoInput = inputElement.parentElement.querySelector(`input[name="${cargoInputName}"]`);
                    if (cargoInput) {
                        cargoInput.value = option.getAttribute('data-cargo'); // Asignar el cargo correspondiente
                    }
                }
            });
        }

        // Función para eliminar un elemento (asistente, ausente o invitado)
        function removeElement(button, containerId) {
            const container = document.getElementById(containerId); // Contenedor del elemento
            if (container.children.length > 1) { // Verificar que haya más de un elemento
                button.parentElement.remove();
                updateRequiredFields(containerId); // Actualizar los campos requeridos
            } else {
                alert('Debe haber al menos un elemento en esta lista. No se puede eliminar el último.');
            }
        }

        // Función para eliminar un elemento en el orden del día
        function removeElementOrden(button) {
            const element = button.parentElement.parentElement;
            const container = element.parentElement;

            if (container.children.length <= 1) {
                alert('Debes tener al menos un elemento en la orden del día.');
                return;
            }

            element.remove();
        }

        // Función para actualizar los campos requeridos según la cantidad de elementos
        function updateRequiredFields(containerId) {
            const container = document.getElementById(containerId);
            const inputs = container.querySelectorAll(`input[name="${containerId}[]"]`);

            if (inputs.length >= 2) {
                inputs.forEach(input => input.setAttribute('required', 'required'));
            } else {
                inputs.forEach(input => input.removeAttribute('required'));
            }
        }

        // Función para confirmar y validar el formulario antes de enviar
        function validateAndConfirm() {
            const form = document.getElementById('actaForm');

            if (!form.checkValidity()) { // Verificar si el formulario es válido
                form.reportValidity();
                return false;
            }

            return confirm("¿Está seguro de que desea guardar el acta?");
        }

        // Función para añadir un símbolo de viñeta en el campo de texto
        function addBullet(textarea) {
            const bulletPoint = '\n ● ';
            textarea.value += bulletPoint;
        }

        // Ejecutar después de cargar el contenido de la página
        document.addEventListener('DOMContentLoaded', function() {
            const addAsistenteBtn = document.getElementById('addAsistenteBtn');
            addAsistenteBtn.addEventListener('click', addAsistente);
            const addAusenteBtn = document.getElementById('addAusenteBtn');
            addAusenteBtn.addEventListener('click', addAusente);
            const addInvitadoBtn = document.getElementById('addInvitadoBtn');
            addInvitadoBtn.addEventListener('click', addInvitado);
            const addOrdenBtn = document.getElementById('addOrdenBtn');
            addOrdenBtn.addEventListener('click', addOrden);
        });
    </script>
</body>

</html>
