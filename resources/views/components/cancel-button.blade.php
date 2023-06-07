<a type="button" href="{{ url()->previous() }}" {{ $attributes->merge(['class' => 'btn btn-secondary']) }}>
    {{ $slot }}
</a>
