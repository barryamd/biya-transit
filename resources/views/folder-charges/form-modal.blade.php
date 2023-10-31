<x-form-modal id="chargeFormModal" submit="save">
    <x-slot name="title">
        @if($isEditMode)
            Modifier la charge
        @else
            Ajouter une charge
        @endif
    </x-slot>
    <x-slot name="content">
        <x-form.select2-dropdown label="Dossier" wire:model="charge.folder_id" routeName="getFolders" id="folder"
                             parentId="chargeFormModal" required placeholder="Rechercher le dossier"></x-form.select2-dropdown>
        <x-form.input label="Montant" type="number" wire:model.defer="charge.amount" required></x-form.input>
        <x-form.textarea label="Details" wire:model.defer="charge.description"></x-form.textarea>
    </x-slot>
</x-form-modal>
