<!DOCTYPE html>
<html lang="en">

<head>
    @include('plantilla.componentes.head')
</head>

<body>

    <nav x-data="{ open: false }" class="bg-gradient-to-b from-blue-500 to-blue-800 border-b border-gray-100">

        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9l9-7 9 7v9a2 2 0 01-2 2h-4a2 2 0 01-2-2v-5a2 2 0 00-2-2h-2a2 2 0 00-2 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            </svg>


                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link :href="route('redactar')" :active="request()->routeIs('redactar')"
                            class="text-white hover:text-orange-700 transition duration-200">
                            {{ __('Redactar acta') }}
                        </x-nav-link>
                    </div>

                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link :href="route('buscar')" :active="request()->routeIs('buscar')"
                            class="text-white hover:text-orange-700 transition duration-200">
                            {{ __('Buscar acta') }}
                        </x-nav-link>
                    </div>

                    @if (auth()->user()->rol === 'auxiliar')
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link :href="route('usuarios')" :active="request()->routeIs('usuarios')"
                                class="text-white hover:text-orange-700 transition duration-200">
                                {{ __('Gestionar Usuarios') }}
                            </x-nav-link>
                        </div>
                    @endif




                </div>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-black bg-gradient-to-b from-gray-200 to-gray-400 hover:from-gray-300 hover:to-gray-500 focus:outline-none focus:ring focus:ring-gray-300 transition duration-200 ease-in-out shadow-md">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>


                        <x-slot name="content">



                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    class="bg-gradient-to-b from-gray-200 to-gray-400 hover:from-gray-300 hover:to-gray-500 text-gray-800 font-semibold px-4 py-2 rounded-md transition duration-200 ease-in-out shadow-md"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Cerrar sesión') }}
                                </x-dropdown-link>

                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-orange-600 hover:bg-gray-300 focus:outline-none transition ease-in-out duration-150">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('redactar')" :active="request()->routeIs('redactar')"
                    class="text-white bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 px-4 py-2 rounded-md transition duration-150 ease-in-out">
                    {{ __('Redactar acta') }}
                </x-responsive-nav-link>
            </div>

            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('buscar')" :active="request()->routeIs('buscar')"
                    class="text-white bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 px-4 py-2 rounded-md transition duration-150 ease-in-out">
                    {{ __('Buscar acta') }}
                </x-responsive-nav-link>
            </div>


            @if (auth()->user()->rol === 'auxiliar')
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('usuarios')" :active="request()->routeIs('usuarios')"
                        class="text-white bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 px-4 py-2 rounded-md transition duration-150 ease-in-out">
                        {{ __('Gestionar Usuarios') }}
                    </x-responsive-nav-link>
                </div>
            @endif

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-white">{{ Auth::user()->email }}</div>
                    <div class="font-medium text-sm text-white">{{ Auth::user()->cargo }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            class="text-white bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 px-4 py-2 rounded-md transition duration-150 ease-in-out"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Cerrar sesión') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>

    </nav>

</body>

</html>
