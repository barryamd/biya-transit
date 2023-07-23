<x-form-modal id="containerTypeFormModal" submit="save">
    <x-slot name="title">
        @if($isEditMode)
            Modifier le type de conteneur
        @else
            Ajouter un type de conteneur
        @endif
    </x-slot>
    <x-slot name="content">
        <x-form.input label="Libellé" wire:model.defer="label" required></x-form.input>
    </x-slot>
</x-form-modal>
