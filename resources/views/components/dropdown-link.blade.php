<a {{ $attributes->merge(['class' => 'block w-full px-4 py-2 text-start text-sm leading-5 text-black bg-gradient-to-b from-gray-200 to-gray-400 hover:from-gray-300 hover:to-gray-500 focus:outline-none rounded-md transition duration-200 ease-in-out shadow-md']) }}>
    {{ $slot }}
</a>
