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
                <x-form.input label="Prénom" wire:model.lazy="user.first_name" required></x-form.input>
            </div>
            <div class="col-md-6">
                <x-form.input label="Nom" wire:model.lazy="user.last_name" required></x-form.input>
            </div>
            <div class="col-md-3">
                <x-form.input label="NIF" wire:model.lazy="customer.nif" required></x-form.input>
            </div>
            <div class="col-md-3">
                <x-form.input label="Nom de l'entreprise" wire:model.lazy="customer.name"></x-form.input>
            </div>
            <div class="col-md-3">
                <x-form.input label="Email 1" type="email" wire:model.lazy="user.email" required></x-form.input>
            </div>
            <div class="col-md-3">
                <x-form.input label="Email 2" type="email" wire:model.lazy="customer.email1"></x-form.input>
            </div>
            <div class="col-md-3">
                <x-form.input label="Email 3" type="email" wire:model.lazy="customer.email2"></x-form.input>
            </div>
            <div class="col-md-3">
                <x-form.input label="Email 4" type="email" wire:model.lazy="customer.email3"></x-form.input>
            </div>
            <div class="col-md-3">
                <x-form.input label="Contact 1" wire:model.lazy="user.phone_number" required></x-form.input>
            </div>
            <div class="col-md-3">
                <x-form.input label="Contact 2" wire:model.lazy="customer.phone_number1"></x-form.input>
            </div>
            <div class="col-md-3">
                <x-form.input label="Contact 3" wire:model.lazy="customer.phone_number2"></x-form.input>
            </div>
            <div class="col-md-3">
                <x-form.input label="Contact 4" wire:model.lazy="customer.phone_number2"></x-form.input>
            </div>
            <div class="col-md-6">
                <x-form.textarea label="Adresse" wire:model.lazy="user.address"></x-form.textarea>
            </div>
        </div>
    </x-slot>
</x-form-modal>
