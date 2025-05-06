<x-app-layout>
    @auth
        <!-- Encabezado de la página cuando el usuario está autenticado -->
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>

        <!-- Contenedor principal con fondo en degradado azul -->
        <div class="py-12 bg-blueorange"
            style="background-image: linear-gradient(to bottom, #a3c1e0, #003366); background-attachment: fixed; z-index: -1;">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Sección de cuadrícula que adapta el número de columnas según el tamaño de pantalla -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <!-- Bucle foreach para iterar sobre cada acta y mostrarla como una tarjeta -->
                    @foreach ($actas as $acta)
                        <!-- Tarjeta para cada acta, con fondo gris claro, borde y sombra para darle profundidad -->
                        <div class="bg-gray-100 overflow-hidden shadow-xl rounded-lg border border-gray-300 transition duration-300 ease-in-out transform hover:scale-105"
                            style="box-shadow: -10px 10px 20px rgba(0, 0, 0, 0.3);">

                            <!-- Título del acta, con fondo degradado verde y texto en blanco -->
                            <h3 class="text-lg font-bold text-white p-4 rounded-t-lg"
                                style="background: linear-gradient(135deg, #50C878, #2F6B3B);">
                                {{ $acta->nombre }}
                            </h3>

                            <!-- Contenido de la tarjeta, donde se muestra la información básica del acta -->
                            <div class="p-6 bg-gray-100">
                                <p class="text-sm text-gray-600">
                                    <span class="font-bold">ID:</span> {{ $acta->identificacion }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-bold">Fecha de reunión:</span>
                                    {{ \Carbon\Carbon::parse($acta->fecha_reunion)->format('d/m/Y') }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-bold">Hora Inicial:</span>
                                    {{ \Carbon\Carbon::parse($acta->hora_inicial)->format('h:i A') }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-bold">Hora Final:</span>
                                    {{ \Carbon\Carbon::parse($acta->hora_final)->format('h:i A') }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-bold">Lugar:</span> {{ $acta->lugar_reunion }}
                                </p>

                                <!-- Botón de "Ver detalles" que enlaza a la vista específica del acta -->
                                <a href="{{ route('acta.show', $acta->id) }}"
                                    class="mt-4 inline-block bg-gradient-to-b from-red-600 to-red-800 text-white px-4 py-2 rounded-lg hover:from-red-700 hover:to-red-900 transition duration-200 shadow-md transform hover:scale-105">
                                    Ver detalles
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <!-- Si el usuario no está autenticado, se le redirige a la vista 'template' -->
        <script>
            window.location.href = "{{ route('template') }}";
        </script>
    @endauth
</x-app-layout>
