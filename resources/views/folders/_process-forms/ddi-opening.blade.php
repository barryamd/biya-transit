<div class="col-md-12">
    <h4>Ouverture DDI</h4>
    @can('add-ddi-opening')
        <div class="row">
            <div class="col-md-6">
                <x-form.input label="Numéro DVT" wire:model.defer="ddiOpening.dvt_number" required></x-form.input>
            </div>
            <div class="col-md-6">
                <x-form.date label="Date d'obtention DVT" wire:model.defer="ddiOpening.dvt_obtained_date" required></x-form.date>
            </div>
            <div class="col-md-6">
                <x-form.input label="Numéro DDI" wire:model.defer="ddiOpening.ddi_number"></x-form.input>
            </div>
            <div class="col-md-6">
                <x-form.date label="Date d'obtention DDI" wire:model.defer="ddiOpening.ddi_obtained_date"></x-form.date>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    @if($ddiOpening->attach_file_path)
                        <label>Fichier DDI</label>
                        <div class="">
                            <button wire:click="downloadFile('ddi_openings')" class="btn btn-sm btn-success">
                                <i class="fas fa-download"></i> Telecharger
                            </button>
                            <button wire:click="deleteFile('ddi_openings')" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </div>
                    @else
                        <x-form.file-upload label="Fichier DDI" wire:model.lazy="ddiFile"></x-form.file-upload>
                        @error('ddiFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                    @endif
                </div>
            </div>
        </div>
        <button class="btn btn-primary float-right ml-2" wire:click="submitDdiOpeningStep"
                type="button">Sauvegarder et Passer</button>
    @endcan
    <div>
        <button class="btn btn-secondary" wire:click="setStep(1)" type="button"><i class="fas fa-arrow-left"></i> Précedent</button>
        <button class="btn btn-secondary float-right" wire:click="setStep(3)" type="button">Suivant <i class="fas fa-arrow-right"></i></button>
    </div>
</div>
