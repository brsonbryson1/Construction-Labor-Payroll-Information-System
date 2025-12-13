@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'w-full border border-gray-300 focus:border-amber-500 focus:ring-amber-500 rounded-lg shadow-sm px-4 py-3 text-sm'
]) !!}>