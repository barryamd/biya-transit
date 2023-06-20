<x-form-modal id="documentTypeFormModal" submit="save">
    <x-slot name="title">
        @if($isEditMode)
            Modifier le type de document
        @else
            Ajouter un type de document
        @endif
    </x-slot>
    <x-slot name="content">
        <x-form.input label="Libellé" wire:model.defer="label" required></x-form.input>
    </x-slot>
</x-form-modal>
