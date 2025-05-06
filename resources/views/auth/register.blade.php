<x-guest-layout>
    <!-- Formulario de registro de usuario, configurado para aceptar archivos (multipart/form-data) -->
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf <!-- Token CSRF para proteger el formulario contra ataques de falsificación de solicitudes -->

        <!-- Título del formulario de registro -->
        <h1 class="text-2xl font-semibold mb-4">Registrar Usuario</h1>

        <!-- Campo de Nombre completo -->
        <div>
            <x-input-label for="name" :value="__('Nombre completo')" /> <!-- Etiqueta del campo de nombre -->
            <input id="name" class="mb-2 mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-bluee-500 text-gray-800 transition duration-200 ease-in-out" type="text" name="name" :value="old('name')" required autofocus autocomplete="name">
            <x-input-error :messages="$errors->get('name')" class="mt-2" /> <!-- Muestra errores de validación específicos del campo de nombre -->
        </div>

        <!-- Campo de Correo Electrónico -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <input id="email" class="mb-2 mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-bluee-500 text-gray-800 transition duration-200 ease-in-out" type="email" name="email" :value="old('email')" required autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Campo de Contraseña -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <input id="password" class="mb-2 mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-bluee-500 text-gray-800 transition duration-200 ease-in-out"
                   type="password" name="password" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Campo para Confirmar Contraseña -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />
            <input id="password_confirmation" class="mb-2 mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-bluee-500 text-gray-800 transition duration-200 ease-in-out"
                   type="password" name="password_confirmation" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Campo de Cargo -->
        <div class="mt-4">
            <x-input-label for="cargo" :value="__('Cargo')" />
            <input id="cargo" class="mb-2 mt-1 block w-full bg-gradient-to-r from-gray-100 to-gray-300 border border-gray-300 rounded-md shadow-lg shadow-gray-400 px-4 py-2 focus:border-blue-500 focus:ring-bluee-500 text-gray-800 transition duration-200 ease-in-out" type="text" name="cargo" :value="old('cargo')" required >
            <x-input-error :messages="$errors->get('cargo')" class="mt-2" />
        </div>

        <!-- Campo de Firma (carga de imagen) -->
        <div class="mt-4">
            <x-input-label for="firma" :value="__('Firma')" />
            <input id="firma" type="file" name="firma" class="block mt-1 w-full" accept="image/*" required />
            <x-input-error :messages="$errors->get('firma')" class="mt-2" />
        </div>

        <!-- Enlace para redirigir a la página de inicio de sesión, si el usuario ya tiene cuenta -->
        <div class="flex items-center justify-end mt-4">
            <a class="mt-3 underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('template') }}">
                {{ __('Ya estás registrado?') }}
            </a>

            <!-- Botón de registro, estilizado con gradiente y sombra, y animación de escala al hacer hover -->
            <x-primary-button class="mt-4 inline-block bg-gradient-to-b from-blue-600 to-blue-800 text-white px-4 py-2 rounded-lg hover:from-blue-700 hover:to-blue-900 transition duration-200 shadow-md transform hover:scale-105 ml-4">
                {{ __('Registrarse') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
