@section('title', 'Traitement du dossier : ' . $folder->number)
<div>
    <x-card>
        <div class="stepwizard">
            <div class="stepwizard-row setup-panel">
                <div class="multi-wizard-step">
                    <a href="#step-2" type="button"
                       class="btn {{ $currentStep != 1 ? 'btn-default' : 'btn-primary' }}"
                       @if(!($ddiOpening->id || auth()->user()->can('add-exoneration'))) disabled="disabled" @endif>1</a>
                    <p>Exonération</p>
                </div>
                <div class="multi-wizard-step">
                    <a href="#step-1" type="button"
                       class="btn {{ $currentStep != 2 ? 'btn-default' : 'btn-primary' }}"
                       @if(!auth()->user()->can('add-ddi-opening')) disabled="disabled" @endif>2</a>
                    <p>Ouverture DDI</p>
                </div>
                <div class="multi-wizard-step">
                    <a href="#step-3" type="button"
                       class="btn {{ $currentStep != 3 ? 'btn-default' : 'btn-primary' }}"
                       @if(!($exoneration->id || auth()->user()->can('add-declaration'))) disabled="disabled" @endif>3</a>
                    <p>Déclarations</p>
                </div>
                <div class="multi-wizard-step">
                    <a href="#step-4" type="button"
                       class="btn {{ $currentStep != 4 ? 'btn-default' : 'btn-primary' }}"
                       @if(!($declaration->id || auth()->user()->can('add-delivery-note'))) disabled="disabled" @endif>4</a>
                    <p>Bons de livraisons</p>
                </div>
                <div class="multi-wizard-step">
                    <a href="#step-5" type="button"
                       class="btn {{ $currentStep != 5 ? 'btn-default' : 'btn-primary' }}"
                       @if(!($declaration->id || auth()->user()->can('add-delivery-details'))) disabled="disabled" @endif>5</a>
                    <p>Détails de la livraison</p>
                </div>
            </div>
        </div>

        <div class="row setup-content {{ $currentStep != 1 ? 'd-none' : '' }}" id="step-2">
            <div class="col-md-12">
                <h4>Exonération</h4>
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
        </div>

        <div class="row setup-content {{ $currentStep != 2 ? 'd-none' : '' }}" id="step-1">
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
        </div>

        <div class="row setup-content {{ $currentStep != 3 ? 'd-none' : '' }}" id="step-3">
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
                            <x-form.input label="Numéro du bulletin de liquidation" wire:model.defer="declaration.liquidation_bulletin" required></x-form.input>
                        </div>
                        <div class="col-md-4">
                            <x-form.date label="Date de liquidation" wire:model.defer="declaration.liquidation_date" required></x-form.date>
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
                            <x-form.input label="Numéro de la quittance" wire:model.defer="declaration.receipt_number" required></x-form.input>
                        </div>
                        <div class="col-md-4">
                            <x-form.date label="Date de la quittance" wire:model.defer="declaration.receipt_date" required></x-form.date>
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
                            <x-form.input label="Numéro du bon" wire:model.defer="declaration.bon_number" required></x-form.input>
                        </div>
                        <div class="col-md-4">
                            <x-form.date label="Date du bon" wire:model.defer="declaration.bon_date" required></x-form.date>
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
        </div>

        <div class="row setup-content {{ $currentStep != 4 ? 'd-none' : '' }}" id="step-4">
            <div class="col-md-12">
                <h4>Bons de livraison</h4>
                @can('add-delivery-note')
                    <div class="table-responsive table-bordered-">
                        <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">#</th>
                                <th style="width: 30%;">Bon de compagnie maritime <span class="text-danger">*</span></th>
                                <th style="width: 30%;">Bon conakry terminal <span class="text-danger">*</span></th>
                                <th style="width: 30%;">Fichier jointe</th>
                                <th class="text-center" style="width: 5%">
                                    <button wire:click.prevent="addDeliveryNote" title="Ajouter" class="btn btn-sm btn-primary w-100-">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($deliveryNotes as $i => $deliveryNote)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        <input type="text" wire:model.defer="deliveryNotes.{{$i}}.bcm" class="form-control" required>
                                    </td>
                                    <td>
                                        <input type="text" wire:model.defer="deliveryNotes.{{$i}}.bct" class="form-control" required>
                                    </td>
                                    <td class="align-middle">
                                        @if($deliveryNote['attach_file_path'])
                                            <button wire:click="downloadFile('delivery_notes', 'attach_file_path', {{$deliveryNote['id']}})" class="btn btn-success">
                                                <i class="fas fa-download"></i> Telecharger
                                            </button>
                                            <button wire:click="deleteFile('delivery_notes', 'attach_file_path', {{$deliveryNote['id']}})" class="btn btn-danger">
                                                <i class="fas fa-trash"></i> Supprimer
                                            </button>
                                        @else
                                            <input type="file" wire:model.lazy="deliveryNoteFiles.{{$i}}" class="form-control px-1" required>
                                            @error('deliveryNoteFiles.*') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                                        @endif
                                    </td>
                                    <td class="text-center" style="padding-right: 0.3rem; width: 5px">
                                        <button wire:click.prevent="removeDeliveryNote('{{$i}}')" class="btn btn-danger btn-sm" title="Supprimer cette ligne">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        @can('add-declaration')
                            <button class="btn btn-secondary" wire:click="back(3)" type="button">Retourner</button>
                        @endcan
                        <button class="btn btn-primary nextBtn float-right" wire:click="submitDeliveryNoteStep" type="button">Sauvegarder et Passer</button>
                    </div>
                @else
                    <p>Désolé! Vous avez pas les permissions pour efféctuer ces actions.</p>
                @endcan
            </div>
        </div>

        <div class="row setup-content {{ $currentStep != 5 ? 'd-none' : '' }}" id="step-5">
            <div class="col-md-12">
                <h4>Les details de la livraison</h4>
                @can('add-delivery-details')
                    <div class="row">
                        <div class="col-md-6">
                            <x-form.date label="Date de la livraison" wire:model.defer="delivery.date" required></x-form.date>
                        </div>
                        <div class="col-md-6">
                            <x-form.input label="Lieu de la livraison" wire:model.defer="delivery.place" required></x-form.input>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                @if($delivery->exit_file_path)
                                    <label>Bon de sorti du conteneur</label>
                                    <div class="">
                                        <button wire:click="downloadFile('deliveries', 'exit_file_path')" class="btn btn-success">
                                            <i class="fas fa-download"></i> Telecharger
                                        </button>
                                        <button wire:click="deleteFile('deliveries', 'exit_file_path')" class="btn btn-danger">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </div>
                                @else
                                    <x-form.file-upload label="Bon de sorti du conteneur" wire:model.lazy="deliveryExitFile"></x-form.file-upload>
                                    @error('deliveryExitFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                @if($delivery->return_file_path)
                                    <label>Bon de retour</label>
                                    <div class="">
                                        <button wire:click="downloadFile('deliveries', 'return_file_path')" class="btn btn-success">
                                            <i class="fas fa-download"></i> Telecharger
                                        </button>
                                        <button wire:click="deleteFile('deliveries', 'return_file_path')" class="btn btn-danger">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </div>
                                @else
                                    <x-form.file-upload label="Bon de retour" wire:model.lazy="deliveryReturnFile"></x-form.file-upload>
                                    @error('deliveryReturnFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                                @endif
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
                    <div>
                        @can('add-delivery-note')
                            <button class="btn btn-secondary" wire:click="back(4)" type="button">Retourner</button>
                        @endcan
                        <button class="btn btn-primary nextBtn float-right" wire:click="submitDeliveryDetailsStep" type="button">Sauvegarder</button>
                    </div>
                @else
                    <p>Désolé! Vous avez pas les permissions pour efféctuer ces actions.</p>
                @endcan
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
