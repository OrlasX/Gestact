<x-app-layout>
    @auth
    <!-- Contenedor principal con un fondo de degradado y espacio adicional en la parte inferior -->
    <div class="bg-blueorange pb-60" style="background-image: linear-gradient(to bottom, #a3c1e0, #003366); background-attachment: fixed; z-index: -1;">
        <!-- Slot para el encabezado, mostrando el título de la página -->
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Resultados de Búsqueda') }}
            </h2>
        </x-slot>

        <div class="py-12"> <!-- Ajuste de espacio vertical para el contenedor -->
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Grid para organizar las actas en columnas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @forelse($actas as $acta)
                        <!-- Contenedor para cada acta, con estilo y sombra -->
                        <div class="bg-gray-200 overflow-hidden shadow-xl rounded-lg border border-gray-300 transition duration-300 ease-in-out transform hover:scale-105" style="box-shadow: -10px 10px 20px rgba(0, 0, 0, 0.3);">
                            <!-- Encabezado de acta con un fondo degradado -->
                            <h3 class="text-lg font-bold text-white p-4 rounded-t-lg"
                                style="background: linear-gradient(135deg, #50C878, #2F6B3B);">
                                {{ $acta->nombre }}
                            </h3>
                            <div class="p-6 bg-gray-200">
                                <!-- Mostrar detalles del acta -->
                                <p class="text-sm text-gray-600">
                                    <span class="font-bold">ID:</span> {{ $acta->identificacion }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-bold">Fecha de reunión:</span> {{ \Carbon\Carbon::parse($acta->fecha_reunion)->format('d/m/Y') }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-bold">Hora Inicial:</span> {{ \Carbon\Carbon::parse($acta->hora_inicial)->format('h:i A') }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-bold">Hora Final:</span> {{ \Carbon\Carbon::parse($acta->hora_final)->format('h:i A') }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-bold">Lugar:</span> {{ $acta->lugar_reunion }}
                                </p>
                                <!-- Botón para ver detalles del acta, que redirige a la vista de detalles -->
                                <a href="{{ route('acta.show', ['id' => $acta->id] + request()->query()) }}"
                                   class="mt-4 inline-block bg-gradient-to-b from-red-600 to-red-800 text-white px-4 py-2 rounded-lg hover:from-red-700 hover:to-red-900 transition duration-200 shadow-md transform hover:scale-105">
                                    Ver detalles
                                </a>
                            </div>
                        </div>
                    @empty
                        <!-- Mensaje cuando no se encuentran actas que coincidan con la búsqueda -->
                        <div class="bg-white overflow-hidden shadow-md rounded-lg p-6 col-span-4 text-center">
                            <p class="text-gray-500">No se encontraron actas que coincidan con la búsqueda.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @else
        {{-- Redirige al usuario no autenticado a la vista template --}}
        <script>window.location.href = "{{ route('template') }}";</script>
    @endauth
</x-app-layout>
