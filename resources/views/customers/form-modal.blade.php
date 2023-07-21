<x-form-modal id="customerFormModal" size="lg" submit="save">
    <x-slot name="title">
        @if($isEditMode)
            Modifier les infos du client
        @else
            Ajouter un nouveau client
        @endif
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-md-6">
                <x-form.input label="Prénom" wire:model.defer="user.first_name" required></x-form.input>
            </div>
            <div class="col-md-6">
                <x-form.input label="Nom" wire:model.defer="user.last_name" required></x-form.input>
            </div>
            <div class="col-md-3">
                <x-form.input label="NIF" wire:model.defer="customer.nif" required></x-form.input>
            </div>
            <div class="col-md-3">
                <x-form.input label="Nom de l'entreprise" wire:model.defer="customer.name"></x-form.input>
            </div>
            <div class="col-md-3">
                <x-form.input label="Email 1" type="email" wire:model.defer="user.email" required></x-form.input>
            </div>
            <div class="col-md-3">
                <x-form.input label="Email 2" type="email" wire:model.defer="customer.email1"></x-form.input>
            </div>
            <div class="col-md-3">
                <x-form.input label="Email 3" type="email" wire:model.defer="customer.email2"></x-form.input>
            </div>
            <div class="col-md-3">
                <x-form.input label="Email 4" type="email" wire:model.defer="customer.email3"></x-form.input>
            </div>
            <div class="col-md-3">
                <x-form.input label="Contact 1" wire:model.defer="user.phone_number" required></x-form.input>
            </div>
            <div class="col-md-3">
                <x-form.input label="Contact 2" wire:model.defer="customer.phone_number1"></x-form.input>
            </div>
            <div class="col-md-3">
                <x-form.input label="Contact 3" wire:model.defer="customer.phone_number2"></x-form.input>
            </div>
            <div class="col-md-3">
                <x-form.input label="Contact 4" wire:model.defer="customer.phone_number2"></x-form.input>
            </div>
            @if(!$isEditMode)
                <div class="col-md-6">
                    <x-form.password label="Password" wire:model.defer="password" autocomplete="new-password" required></x-form.password>
                </div>
                <div class="col-md-6">
                    <x-form.password label="Password confirmation" wire:model.defer="password_confirmation" autocomplete="new-password" required></x-form.password>
                </div>
            @endif
            <div class="col-md-6">
                <x-form.input label="Adresse" wire:model.defer="user.address"></x-form.input>
            </div>
        </div>
    </x-slot>
</x-form-modal>
