@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400']) }}>
