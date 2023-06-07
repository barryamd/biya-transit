<x-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>

    <x-slot name="form">
        <div class="row">
            <div class="col-md-8">
                <x-form.password label="{{ __('Current Password') }}" wire:model.defer="state.current_password" autocomplete="current-password"></x-form.password>
            </div>

            <div class="col-md-8">
                <x-form.password label="{{ __('New Password') }}" wire:model.defer="state.password" autocomplete="new-password"></x-form.password>
            </div>

            <div class="col-md-8">
                <x-form.password label="{{ __('Confirm Password') }}" wire:model.defer="state.password_confirmation" autocomplete="new-password"></x-form.password>
            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-submit-button>{{ __('Save') }}</x-submit-button>
    </x-slot>
</x-form-section>
