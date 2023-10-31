<x-form-modal id="chargeFormModal" submit="save">
    <x-slot name="title">
        @if($isEditMode)
            Modifier la charge
        @else
            Ajouter une charge
        @endif
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <x-form.input label="Nom de la charge" wire:model.defer="charge.name" required></x-form.input>
            </div>
            <div class="col-md-7">
                <x-form.input label="Montant" type="number" wire:model.defer="charge.amount" required></x-form.input>
            </div>
            <div class="col-md-5">
                <x-form.input label="Période" type="month" wire:model.defer="charge.period" required></x-form.input>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <x-form.file-upload label="Fichier jointe" wire:model.lazy="file"></x-form.file-upload>
                    @error('file') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                </div>
            </div>
            <div class="col-12">
                <x-form.textarea label="Détails" wire:model.defer="charge.details"></x-form.textarea>
            </div>
        </div>
    </x-slot>
</x-form-modal>
