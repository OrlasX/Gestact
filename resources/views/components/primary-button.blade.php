@props(['disabled' => false])

<button {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'inline-flex items-center px-6 py-3 border border-transparent rounded-lg font-semibold text-sm text-white tracking-wide focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-105'
]) !!}>
    {{ $slot }}
</button>
