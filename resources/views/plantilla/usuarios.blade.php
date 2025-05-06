<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Inclusión de la plantilla de componentes de la cabecera -->
    @include("plantilla.componentes.head")
</head>

<body>
    @auth
    <!-- Componente de diseño para invitados, probablemente contiene el layout general -->
    <x-guest-layout>
        <div class="flex justify-between items-center mb-4 ">
            <!-- Título de la página -->
            <h1 class="text-2xl font-semibold">Gestión de Usuarios</h1>
            <!-- Botón para volver al dashboard, con un evento onclick para redirigir -->
            <x-primary-button type="button" onclick="window.location.href='{{ route('dashboard') }}';"
                class="bg-gradient-to-b from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800">
                Volver
            </x-primary-button>
        </div>

        <!-- Iteración sobre la colección de usuarios -->
        @foreach ($usuarios as $usuario)
            <div class="flex justify-between items-center mb-4 p-4 border rounded-lg bg-white bg-opacity-50">
                <div>
                    <!-- Nombre y cargo del usuario -->
                    <h2 class="text-lg font-semibold">{{ $usuario->name }}</h2>
                    <p class="text-gray-600">{{ $usuario->cargo }}</p>
                </div>
                <div>
                    <!-- Verifica si el usuario está activo o inactivo -->
                    @if ($usuario->estado) <!-- Activo -->
                        <form method="POST" action="{{ route('usuarios.desactivar', $usuario->id) }}">
                            @csrf
                            <!-- Botón para desactivar al usuario -->
                            <x-primary-button type="submit" class="bg-gradient-to-b from-red-500 to-red-700 hover:from-red-600 hover:to-red-800">Desactivar</x-primary-button>
                        </form>
                    @else <!-- Inactivo -->
                        <form method="POST" action="{{ route('usuarios.activar', $usuario->id) }}">
                            @csrf
                            <!-- Botón para activar al usuario -->
                            <x-primary-button type="submit" class="bg-gradient-to-b from-green-500 to-green-700 hover:from-green-600 hover:to-green-800">Activar</x-primary-button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach

        <!-- Mensaje cuando no hay usuarios disponibles -->
        @if($usuarios->isEmpty())
            <p class="text-gray-500 text-center">No hay usuarios disponibles.</p>
        @endif
    </div>
    </x-guest-layout>
    @else
        {{-- Redirige al usuario no autenticado a la vista template --}}
        <script>window.location.href = "{{ route('template') }}";</script>
    @endauth
</body>
</html>
