<x-form-modal id="customerFormModal" submit="save">
    <x-slot name="title">
        @if($isEditMode)
            Modifier les infos du client
        @else
            Ajouter un nouveau client
        @endif
    </x-slot>
    <x-slot name="content">
        <x-form.input label="Nom" wire:model.defer="customer.name" required></x-form.input>
        <x-form.input label="NIF" wire:model.defer="customer.nif"></x-form.input>
        <x-form.input label="Téléphone" wire:model.defer="customer.phone" required></x-form.input>
        @if(!$customer->id)
            <x-form.input label="Email" wire:model.defer="email"></x-form.input>
        @endif
    </x-slot>
</x-form-modal>
