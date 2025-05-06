@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-md shadow-gray-400 px-4 py-2 focus:border-orange-500 focus:ring-orange-500 focus:ring-2 text-gray-800 transition duration-200 ease-in-out'
]) !!}>
