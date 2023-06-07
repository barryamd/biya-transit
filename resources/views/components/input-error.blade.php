@props(['for'])

@error($for)
    <div {{ $attributes->merge(['class' => 'invalid-feedback']) }}>{{ $message }}</div>
@enderror
