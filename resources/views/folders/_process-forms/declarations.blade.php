<div class="col-md-12">
    <h4>Déclarations</h4>
    @can('add-declaration')
        <div class="row">
            <div class="col-md-4">
                <x-form.input label="Numéro de declaration" wire:model.defer="declaration.number" required></x-form.input>
            </div>
            <div class="col-md-4">
                <x-form.date label="Date de declaration" wire:model.defer="declaration.date" required></x-form.date>
            </div>
            <div class="col-md-4">
                <x-form.input label="Bureau de destination" wire:model.defer="declaration.destination_office" required></x-form.input>
            </div>

            <div class="col-md-4">
                <x-form.input label="Verificateur" wire:model.defer="declaration.verifier" required></x-form.input>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    @if($declaration->declaration_file_path)
                        <label>Copie de la declaration</label>
                        <div class="">
                            <button wire:click="downloadFile('declarations', 'declaration_file_path')" class="btn btn-success">
                                <i class="fas fa-download"></i> Telecharger
                            </button>
                            <button wire:click="deleteFile('declarations', 'declaration_file_path')" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </div>
                    @else
                        <x-form.file-upload label="Copie de la declaration" wire:model.lazy="declarationFile"></x-form.file-upload>
                        @error('declarationFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                    @endif
                </div>
            </div>
            <div class="col-md-4">
            </div>

            <div class="col-md-4">
                <x-form.input label="Numéro du bulletin de liquidation" wire:model.defer="declaration.liquidation_bulletin"></x-form.input>
            </div>
            <div class="col-md-4">
                <x-form.date label="Date de liquidation" wire:model.defer="declaration.liquidation_date"></x-form.date>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    @if($declaration->liquidation_file_path)
                        <label>Copie du bulletin de liquidation</label>
                        <div class="">
                            <button wire:click="downloadFile('declarations', 'liquidation_file_path')" class="btn btn-success">
                                <i class="fas fa-download"></i> Telecharger
                            </button>
                            <button wire:click="deleteFile('declarations', 'liquidation_file_path')" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </div>
                    @else
                        <x-form.file-upload label="Copie du bulletin de liquidation" wire:model.lazy="liquidationFile"></x-form.file-upload>
                        @error('liquidationFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <x-form.input label="Numéro de la quittance" wire:model.defer="declaration.receipt_number"></x-form.input>
            </div>
            <div class="col-md-4">
                <x-form.date label="Date de la quittance" wire:model.defer="declaration.receipt_date"></x-form.date>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    @if($declaration->receipt_file_path)
                        <label>Copie de la quittance</label>
                        <div class="">
                            <button wire:click="downloadFile('declarations', 'receipt_file_path')" class="btn btn-success">
                                <i class="fas fa-download"></i> Telecharger
                            </button>
                            <button wire:click="deleteFile('declarations', 'receipt_file_path')" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </div>
                    @else
                        <x-form.file-upload label="Copie de la quittance" wire:model.lazy="receiptFile"></x-form.file-upload>
                        @error('receiptFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                    @endif
                </div>
            </div>

            <div class="col-md-4">
                <x-form.input label="Numéro du bon" wire:model.defer="declaration.bon_number"></x-form.input>
            </div>
            <div class="col-md-4">
                <x-form.date label="Date du bon" wire:model.defer="declaration.bon_date"></x-form.date>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    @if($declaration->bon_file_path)
                        <label>Copie du bon</label>
                        <div class="">
                            <button wire:click="downloadFile('declarations', 'bon_file_path')" class="btn btn-success">
                                <i class="fas fa-download"></i> Telecharger
                            </button>
                            <button wire:click="deleteFile('declarations', 'bon_file_path')" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </div>
                    @else
                        <x-form.file-upload label="Copie du bon" wire:model.lazy="bonFile"></x-form.file-upload>
                        @error('bonFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                    @endif
                </div>
            </div>
        </div>
        <div>
            @can('add-exoneration')
                <button class="btn btn-secondary" wire:click="back(2)" type="button">Retourner</button>
            @endcan
            <button class="btn btn-primary nextBtn float-right" wire:click="submitDeclarationStep" type="button">Sauvegarder et Passer</button>
        </div>
    @else
        <p>Désolé! Vous avez pas les permissions pour efféctuer ces actions.</p>
    @endcan
</div>
