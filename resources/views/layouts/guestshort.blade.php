<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <@include("plantilla.componentes.head")
</head>
<body class="font-sans text-gray-900 antialiased">

    <div class="relative min-h-screen">

        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('/images/unicatolica.jpg'); background-attachment: fixed; z-index: -1;"></div>

        <div class="relative flex items-center justify-center min-h-screen">
            <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>

        </div>

    </div>
</body>
</html>
