@section('title', 'Traitement du dossier : ' . $folder->number)
<div>
    <x-card>
        <div class="stepwizard">
            <div class="stepwizard-row setup-panel">
                <div class="multi-wizard-step">
                    <a href="#step-1" type="button"
                       class="btn {{ $currentStep != 1 ? 'btn-default' : 'btn-primary' }}">1</a>
                    <p>Ouverture DDI</p>
                </div>
                <div class="multi-wizard-step">
                    <a href="#step-2" type="button"
                       class="btn {{ $currentStep != 2 ? 'btn-default' : 'btn-primary' }}"
                       @if(!$ddiOpening->id) disabled="disabled" @endif>2</a>
                    <p>Exonération</p>
                </div>
                <div class="multi-wizard-step">
                    <a href="#step-3" type="button"
                       class="btn {{ $currentStep != 3 ? 'btn-default' : 'btn-primary' }}"
                       @if(!$exoneration->id) disabled="disabled" @endif>3</a>
                    <p>Déclaration</p>
                </div>
                <div class="multi-wizard-step">
                    <a href="#step-4" type="button"
                       class="btn {{ $currentStep != 4 ? 'btn-default' : 'btn-primary' }}"
                       @if(!$declaration->id) disabled="disabled" @endif>4</a>
                    <p>Bon de livraison</p>
                </div>
                <div class="multi-wizard-step">
                    <a href="#step-5" type="button"
                       class="btn {{ $currentStep != 5 ? 'btn-default' : 'btn-primary' }}"
                       @if(!$declaration->id) disabled="disabled" @endif>5</a>
                    <p>Détails de livraison</p>
                </div>
            </div>
        </div>

        <div class="row setup-content {{ $currentStep != 1 ? 'd-none' : '' }}" id="step-1">
            <div class="col-md-12">
                <h4>Ouverture DDI</h4>
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
                            <x-form.file-upload label="Fichier DDI" wire:model.lazy="ddiFile"></x-form.file-upload>
                            @error('ddiFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary nextBtn float-right" wire:click="submitDdiOpeningStep"
                        type="button">Sauvegarder et Passer</button>
            </div>
        </div>

        <div class="row setup-content {{ $currentStep != 2 ? 'd-none' : '' }}" id="step-2">
            <div class="col-md-12">
                <h4>Exonération</h4>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Numero d'exonération" wire:model.defer="exoneration.number" required></x-form.input>
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
                            <x-form.file-upload label="Fichier DDI" wire:model.lazy="exonerationFile" required></x-form.file-upload>
                            @error('exonerationFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary nextBtn float-right " wire:click="submitExonerationStep"
                        type="button">Sauvegarder et Passer</button>
            </div>
        </div>

        <div class="row setup-content {{ $currentStep != 3 ? 'd-none' : '' }}" id="step-3">
            <div class="col-md-12">
                <h4>Declarations</h4>
                <div class="row">
                    <div class="col-md-4">
                        <x-form.input label="Numero de declaration" wire:model.defer="declaration.number" required></x-form.input>
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
                            <x-form.file-upload label="Copie de la declaration" wire:model.lazy="declarationFile" required></x-form.file-upload>
                            @error('declarationFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                    </div>

                    <div class="col-md-4">
                        <x-form.input label="Numero bulletin de liquidation" wire:model.defer="declaration.liquidation_bulletin" required></x-form.input>
                    </div>
                    <div class="col-md-4">
                        <x-form.date label="Date de liquidation" wire:model.defer="declaration.liquidation_date" required></x-form.date>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-form.file-upload label="Copie du bulletin de liquidation" wire:model.lazy="liquidationFile" required></x-form.file-upload>
                            @error('liquidationFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <x-form.input label="Numero de la quittance" wire:model.defer="declaration.receipt_number" required></x-form.input>
                    </div>
                    <div class="col-md-4">
                        <x-form.date label="Date de la quittance" wire:model.defer="declaration.receipt_date" required></x-form.date>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-form.file-upload label="Copie de la quittance" wire:model.lazy="receiptFile" required></x-form.file-upload>
                            @error('receiptFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <x-form.input label="Numero du bon" wire:model.defer="declaration.bon_number" required></x-form.input>
                    </div>
                    <div class="col-md-4">
                        <x-form.date label="Date du bon" wire:model.defer="declaration.bon_date" required></x-form.date>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <x-form.file-upload label="Copie du bon" wire:model.lazy="bonFile" required></x-form.file-upload>
                            @error('bonFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary nextBtn float-right " wire:click="submitDeclarationStep"
                        type="button">Sauvegarder et Passer</button>
            </div>
        </div>

        <div class="row setup-content {{ $currentStep != 4 ? 'd-none' : '' }}" id="step-4">
            <div class="col-md-12">
                <h4>Bon de livraison</h4>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.input label="Bon de compagnie maritime" wire:model.defer="deliveryNote.bcm" required></x-form.input>
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Bon conakry terminal" wire:model.defer="deliveryNote.bct" required></x-form.input>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-form.file-upload label="Fichier de la facture" wire:model.lazy="deliveryNoteFile" required></x-form.file-upload>
                            @error('deliveryNoteFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary nextBtn float-right " wire:click="submitDeliveryNoteStep"
                        type="button">Sauvegarder et Passer</button>
            </div>
        </div>

        <div class="row setup-content {{ $currentStep != 5 ? 'd-none' : '' }}" id="step-5">
            <div class="col-md-12">
                <h4>Les details de la livraison</h4>
                <div class="row">
                    <div class="col-md-6">
                        <x-form.date label="Date de livraison" wire:model.defer="delivery.date" required></x-form.date>
                    </div>
                    <div class="col-md-6">
                        <x-form.input label="Lieu de livraison" wire:model.defer="delivery.place" required></x-form.input>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <x-form.file-upload label="Bon de sorti du conteneur" wire:model.lazy="deliveryFile" required></x-form.file-upload>
                            @error('deliveryFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <x-form.select2-ajax label="Transporteur" wire:model.lazy="delivery.transporter_id" routeName="getTransporters"
                                             required placeholder="Rechercher par la plaque"></x-form.select2-ajax>
                    </div>
                    @if($transporter)
                    <div class="col-12">
                        <h5>Informations du transporteur</h5>
                        <div class="table-responsive table-bordered-">
                            <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                                <tbody>
                                <tr>
                                    <th style="width: 40%">Numéro d'immatriculation</th>
                                    <td>{{ $transporter->numberplate }}</td>
                                </tr>
                                <tr>
                                    <th>Marque</th>
                                    <td>{{ $transporter->marque }}</td>
                                </tr>
                                <tr>
                                    <th>Nom du chauffeur</th>
                                    <td>{{ $transporter->driver_name }}</td>
                                </tr>
                                <tr>
                                    <th>Téléphone du chauffeur</th>
                                    <td>{{ $transporter->driver_phone }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
                <button class="btn btn-primary nextBtn float-right " wire:click="submitDeliveryDetailsStep"
                        type="button">Sauvegarder et Fermer le dossier</button>
            </div>
        </div>
    </x-card>
</div>

@push('styles')
    <style>
        .multi-wizard-step p {
            margin-top: 12px;
        }
        .stepwizard-row {
            display: table-row;
        }
        .stepwizard {
            display: table;
            position: relative;
            width: 100%;
        }
        .multi-wizard-step button[disabled] {
            filter: alpha(opacity=100) !important;
            opacity: 1 !important;
        }
        .stepwizard-row:before {
            top: 14px;
            bottom: 0;
            content: " ";
            width: 100%;
            height: 1px;
            z-order: 0;
            position: absolute;
            background-color: #fefefe;
        }
        .multi-wizard-step {
            text-align: center;
            position: relative;
            display: table-cell;
        }
    </style>
@endpush
