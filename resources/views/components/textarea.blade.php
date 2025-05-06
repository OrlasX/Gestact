@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-gray-200 border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500']) !!}></textarea>
