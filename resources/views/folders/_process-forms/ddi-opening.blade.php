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
        <div>
            @can('add-exoneration')
                <button class="btn btn-secondary" wire:click="back(1)" type="button">Retourner</button>
            @endcan
            <button class="btn btn-primary nextBtn float-right" wire:click="submitDdiOpeningStep"
                    type="button">Sauvegarder et Passer</button>
        </div>
    @endcan
</div>
