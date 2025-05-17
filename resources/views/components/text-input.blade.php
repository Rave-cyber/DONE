@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-blue-300 bg-white text-blue-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm']) }}>
