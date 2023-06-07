@props([
    'label' => '',
    'name'  => '',
    'id'    => Str::random(5),
])
@if($attributes->wire('model')->value)
    @php($name = $attributes->wire('model')->value)
@endif
<div class="form-group">
    @if ($label !='none')
        <label for="{{ $id }}" class="form-label">{{ __($label) }}: @if (isset($attributes['required'])) <span class="text-danger">*</span>@endif</label>
    @endif
    <div x-cloak x-data="{ show: false }" class="input-group">
        <input :type="show ? 'text' : 'password'" name="{{ $name }}" id="{{ $id }}" value="" {{ $attributes->merge(['class' => 'form-control']) }} />
        <span class="input-group-append">
            <button @click="show = !show" type="button" class="btn btn-default">
                <i :class="{ 'd-none': show }" class="fa fa-eye-slash"></i>
                <i :class="{ 'd-none': !show }" class="fa fa-eye"></i>
            </button>
        </span>
    </div>
    @error($name)
    <p class="text-danger" role="alert">{{ $message }}</p>
    @enderror
</div>
