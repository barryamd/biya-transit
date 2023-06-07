<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="form">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <div class="row">
            <!-- Profile Photo -->
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-md-8 mb-3">
                <!-- Profile Photo File Input -->
                <input type="file" style="display:none"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <label for="photo">{{ __('Photo') }}</label>

                <!-- Current Profile Photo -->
                <div class="user-image mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="img-circle elevation-2" style="width:5rem; height:5rem;">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview">
                    <span x-bind:style="'display:block; width:5rem; height:5rem; border-radius:9999px; background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'"></span>
                </div>

                <button class="btn btn-light btn-sm mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </button>

                @if ($this->user->profile_photo_path)
                <button type="button" class="btn btn-light btn-sm mt-2" wire:click="deleteProfilePhoto">
                    {{ __('Remove Photo') }}
                </button>
                @endif

                <x-input-error for="photo" class="mt-2"></x-input-error>
            </div>
            @endif

            <!-- Name -->
            <div class="col-md-8">
                <x-form.input label="{{ __('Name') }}" wire:model.defer="state.name"></x-form.input>
            </div>

            <!-- Email -->
            <div class="col-md-8">
                <x-form.input label="{{ __('Email') }}" type="email" wire:model.defer="state.email"></x-form.input>
            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-submit-button wire:loading.attr="disabled" wire:target="photo" >{{ __('Save') }}</x-submit-button>
    </x-slot>
</x-form-section>
