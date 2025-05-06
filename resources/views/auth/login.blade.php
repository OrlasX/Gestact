<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Sección de 'head' que incluye los elementos comunes de encabezado de la plantilla -->
    @include("plantilla.componentes.head")
</head>
<body class="bg-gray-200"> <!-- Fondo gris claro para el cuerpo de la página -->

    <!-- Layout de invitado para una página accesible sin necesidad de autenticación -->
    <x-guest-layout>

        <!-- Componente para mostrar el estado de la sesión (si hay mensajes de estado) -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Título de la página de inicio de sesión -->
        <h1 class="text-2xl font-semibold mb-4">Indsdssdsdsiciar Sesión</h1>

        <!-- Formulario de inicio de sesión que envía los datos a la ruta de login -->
        <form method="POST" action="{{ route('login') }}">
            @csrf <!-- Token CSRF para proteger contra ataques de falsificación de solicitudes -->

            <!-- Campo para la dirección de correo electrónico -->
            <div>
                <x-input-label for="email" :value="__('Correosasasaasaas Electrónico')" />

                <!-- Input de correo electrónico con diseño de gradiente y sombra -->
                <input id="email" class="mb-2 mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                       type="email" name="email" :value="old('email')" required autofocus autocomplete="username">

                <!-- Mensaje de error en caso de fallo de validación en el correo -->
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Campo para la contraseña -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" />

                <!-- Input de contraseña con diseño de gradiente, sombra y transiciones para una mejor experiencia visual -->
                <input id="password" class="mb-2 mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-blue-500 text-gray-800 transition duration-200 ease-in-out"
                       type="password" name="password" required autocomplete="current-password">

                <!-- Mensaje de error en caso de fallo de validación en la contraseña -->
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Contenedor de acciones, alineado a la derecha -->
            <div class="flex items-center justify-end mt-4">

                <!-- Enlace de registro para usuarios no registrados -->
                <div class="flex justify-end mt-3">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-sm text-gray-700 dark:text-gray-500 underline hover:text-gray-900 pr-10">
                            Registrarse
                        </a>
                    @endif
                </div>

                <!-- Botón de inicio de sesión con gradiente azul, sombras y transiciones -->
                <x-primary-button class="mt-4 inline-block bg-gradient-to-b from-blue-600 to-blue-800 text-white px-4 py-2 rounded-lg hover:from-blue-700 hover:to-blue-900 transition duration-200 shadow-md transform hover:scale-105">
                    {{ __('Iniciar Sesión') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>

</body>
</html>
