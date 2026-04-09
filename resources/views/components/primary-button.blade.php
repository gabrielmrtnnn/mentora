<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex items-center px-4 py-2 bg-primary text-white rounded-xl font-semibold text-sm hover:bg-primary/90 transition'
]) }}>
    {{ $slot }}
</button>