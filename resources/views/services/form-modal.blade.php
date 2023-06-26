<x-form-modal id="serviceFormModal" submit="save">
    <x-slot name="title">
        @if($isEditMode)
            Modifier le nom du service
        @else
            Ajouter un service
        @endif
    </x-slot>
    <x-slot name="content">
        <x-form.input label="Nom" wire:model.defer="name" required></x-form.input>
    </x-slot>
</x-form-modal>
