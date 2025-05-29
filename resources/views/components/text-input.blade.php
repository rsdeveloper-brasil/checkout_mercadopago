@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'block w-full rounded-md text-primary-200 bg-tertiary-800 border-gray-300 shadow-sm focus:ring-primary-200 sm:text-sm']) !!}>
