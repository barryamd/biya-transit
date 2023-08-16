<x-form-modal id="expenseFormModal" submit="save">
    <x-slot name="title">
        @if($isEditMode)
            Modifier la depense
        @else
            Ajouter une depense
        @endif
    </x-slot>
    <x-slot name="content">
        <x-form.select2-dropdown label="Dossier" wire:model="expense.folder_id" routeName="getFolders" id="folder"
                             parentId="expenseFormModal" required placeholder="Rechercher le dossier"></x-form.select2-dropdown>
        <x-form.input label="Type de depense" wire:model.defer="expense.type" required></x-form.input>
        <x-form.input label="Montant" type="number" wire:model.defer="expense.amount" required></x-form.input>
        <x-form.textarea label="Details" wire:model.defer="expense.description"></x-form.textarea>
    </x-slot>
</x-form-modal>
