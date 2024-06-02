@props([
    'label',
    'append',
    'required' => false,
    'id' => Str::random(5),
])
@if($attributes->wire('model')->value)
    @php($name = $attributes->wire('model')->value)
@endif
<div class="form-group" wire:ignore>
    @isset($label)
        <label for="{{ $id }}">@lang($label): @if($required) <span class="text-danger">*</span> @endif</label>
    @endisset
    <div
        x-data="{ isUploading: false, progress: 0 }"
        x-on:livewire-upload-start="isUploading = true"
        x-on:livewire-upload-finish="isUploading = false"
        x-on:livewire-upload-error="isUploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress"
        class="input-group"
    >
        <!-- File Input -->
        <input type="file" id="{{$id}}" {{ $attributes->merge(['class' => 'form-control']) }}>

        @isset($append))
        <div class="input-group-append">
            <span class="input-group-text {{ $height ? 'form-control-'.$height : '' }}">{{ $append }}</span>
        </div>
        @endisset

        <!-- Progress Bar -->
        <div x-show="isUploading">
            <div class="progress">
                <div
                    class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                    {{-- style="width: 0%;" aria-valuenow="0"  --}}
                    :style="width: progress %;" :aria-valuenow="progress"
                    aria-valuemin="0" aria-valuemax="100"
                    x-text="progress + '%'">
                </div>
            </div>
        </div>

        @error($name)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
