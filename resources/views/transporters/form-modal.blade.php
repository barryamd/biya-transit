<x-form-modal id="transporterFormModal" submit="save">
    <x-slot name="title">
        @if($isEditMode)
            Modifier les infos du transporteur
        @else
            Ajouter un nouveau transporteur
        @endif
    </x-slot>
    <x-slot name="content">
        <x-form.input label="Numéro d'immatriculation" wire:model.defer="transporter.numberplate" required></x-form.input>
        <x-form.input label="Marque" wire:model.defer="transporter.marque" required></x-form.input>
        <x-form.input label="Nom du chauffeur" wire:model.defer="transporter.driver_name" required></x-form.input>
        <x-form.input label="Téléphone du chauffeur" wire:model.defer="transporter.driver_phone" required></x-form.input>
    </x-slot>
</x-form-modal>
