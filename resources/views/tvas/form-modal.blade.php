<x-form-modal id="tvaFormModal" submit="save">
    <x-slot name="title">
        @if($isEditMode)
            Modifier la tva
        @else
            Ajouter un tva
        @endif
    </x-slot>
    <x-slot name="content">
        <x-form.input label="Taux" wire:model.defer="rate" required></x-form.input>
    </x-slot>
</x-form-modal>
