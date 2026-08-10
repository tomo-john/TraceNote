<button {{ $attributes->merge([
    'class' => 'rounded-full px-5 py-3 bg-gray-400 text-white w-12 h-12 inline-flex items-center justify-center'
]) }}>
    {{ $slot }}
</button>

