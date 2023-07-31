<div class="col-md-12">
    <h4>Exonérations</h4>
    @can('add-exoneration')
    <div class="row">
        <div class="col-md-6">
            <x-form.input label="Numéro d'exonération" wire:model.defer="exoneration.number" required></x-form.input>
        </div>
        <div class="col-md-6">
            <x-form.date label="Date d'exonération" wire:model.defer="exoneration.date" required></x-form.date>
        </div>
        <div class="col-md-6">
            <x-form.select2 label="Produits exonérés" wire:model.defer="exonerationProducts" :options="$products" multiple required></x-form.select2>
        </div>
        <div class="col-md-6">
            <x-form.input label="Chargé d'étude" wire:model.defer="exoneration.responsible" required></x-form.input>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                @if($exoneration->attach_file_path)
                    <label>Fichier Exonération</label>
                    <div class="">
                        <button wire:click="downloadFile('exonerations')" class="btn btn-success">
                            <i class="fas fa-download"></i> Telecharger
                        </button>
                        <button wire:click="deleteFile('exonerations')" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </div>
                @else
                    <x-form.file-upload label="Fichier Exonération" wire:model.lazy="exonerationFile"></x-form.file-upload>
                    @error('exonerationFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                @endif
            </div>
        </div>
    </div>
    <button class="btn btn-primary nextBtn float-right" wire:click="submitExonerationStep" type="button">Sauvegarder et Passer</button>
    @else
        <p>Désolé! Vous avez pas les permissions pour efféctuer ces actions.</p>
    @endcan
</div>
