@section('title', 'Traitement du dossier : ' . $folder->number)
<div>
    <x-card>
        <div class="stepwizard">
            <div class="stepwizard-row setup-panel">
                <div class="multi-wizard-step">
                    <a href="#step-2" type="button"
                       class="btn {{ $currentStep != 1 ? 'btn-default' : 'btn-primary' }}"
                       @if(!($ddiOpening->id || auth()->user()->can('add-exoneration'))) disabled="disabled" @endif>1</a>
                    <p>Exonérations</p>
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
                                <th style="width: 20%;">Conteneur<span class="text-danger">*</span></th>
                                <th style="width: 15%;">Bon de CM<span class="text-danger">*</span></th>
                                <th style="width: 20%;">Copie du Bon de CM</th>
                                <th style="width: 15%;">Bon de CT<span class="text-danger">*</span></th>
                                <th style="width: 20%;">Copie du Bon de CT</th>
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
                                        <select wire:model.defer="deliveryNotes.{{$i}}.container_id" class="form-control px-1" required>
                                            <option value="">-- Selectionner un conteneur --</option>
                                            @foreach($containers as $value => $container)
                                                <option value="{{$value}}">{{ $container }}</option>
                                            @endforeach
                                        </select>
                                        @error("deliveryNotes.$i.container_id") <span class="text-xs text-danger">{{ $message }}</span> @enderror
                                    </td>
                                    <td>
                                        <input type="text" wire:model.defer="deliveryNotes.{{$i}}.bcm" class="form-control" required>
                                        @error("deliveryNotes.$i.bcm") <span class="text-xs text-danger">{{ $message }}</span> @enderror
                                    </td>
                                    <td class="align-middle">
                                        @if($deliveryNote['bcm_file_path'])
                                            <button wire:click="downloadFile('delivery_notes', 'bcm_file_path', {{$deliveryNote['id']}})" class="btn btn-success">
                                                <i class="fas fa-download"></i>
                                            </button>
                                            <button wire:click="deleteFile('delivery_notes', 'bcm_file_path', {{$deliveryNote['id']}})" class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <input type="file" wire:model.lazy="bcmFiles.{{$i}}" class="form-control px-1" required>
                                            @error('bcmFiles.*') <span class="text-xs text-danger">{{ $message }}</span> @enderror
                                        @endif
                                    </td>
                                    <td>
                                        <input type="text" wire:model.defer="deliveryNotes.{{$i}}.bct" class="form-control" required>
                                        @error("deliveryNotes.$i.bct") <span class="text-xs text-danger">{{ $message }}</span> @enderror
                                    </td>
                                    <td class="align-middle">
                                        @if($deliveryNote['bct_file_path'])
                                            <button wire:click="downloadFile('delivery_notes', 'bct_file_path', {{$deliveryNote['id']}})" class="btn btn-success">
                                                <i class="fas fa-download"></i>
                                            </button>
                                            <button wire:click="deleteFile('delivery_notes', 'bct_file_path', {{$deliveryNote['id']}})" class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <input type="file" wire:model.lazy="bctFiles.{{$i}}" class="form-control px-1" required>
                                            @error('bctFiles.*') <span class="text-xs text-danger">{{ $message }}</span> @enderror
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
                        @error('deliveryNotes')<div class="text-danger">{{ $message }}</div>@enderror
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
                            <x-form.date label="Date de livraison" wire:model.defer="delivery.date" required></x-form.date>
                        </div>
                        <div class="col-md-6">
                            <x-form.input label="Lieu de livraison" wire:model.defer="delivery.place" required></x-form.input>
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
                                    <x-form.file-upload label="Bon de sorti" wire:model.lazy="deliveryExitFile"></x-form.file-upload>
                                    @error('deliveryExitFile')<div class="text-danger">{{ $message }}</div> @enderror
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
                                    @error('deliveryReturnFile')<div class="text-danger">{{ $message }}</div>@enderror
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <h5>Transporteurs</h5>
                            <div class="table-responsive table-bordered-">
                                <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                                    <thead>
                                        <tr>
                                            <th>Conteneur</th>
                                            <th>Immatriculation du vehicule</th>
                                            <th>Marque du vehicule</th>
                                            <th>Chauffeur</th>
                                            <th>Numéro du chauffeur</th>
                                            <th>
                                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#transporterModal" title="Ajouter un transporteur">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($transporterContainers as $container)
                                        <tr>
                                            <td>{{ $container->number }}</td>
                                            <td>{{ $container->transporter->numberplate }}</td>
                                            <td>{{ $container->transporter->marque }}</td>
                                            <td>{{ $container->transporter->driver_name }}</td>
                                            <td>{{ $container->transporter->driver_phone }}</td>
                                            <td>
                                                <button wire:click="openEditTransporterModal({{ $container->id }})" class="btn btn-sm btn-warning" title="Modifier le transporteur">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center text-danger" colspan="6">
                                                <p>Aucun transporteur n'a été ajouté au dossier</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br>
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

    <x-form-modal id="transporterModal" submit="setContainerTransporter" title="Ajouter un nouveau transporteur">
        <x-slot name="content">
            <x-form.select2-dropdown label="Transporteur" wire:model="transporter" routeName="getTransporters" id="transporter"
                                            parentId="transporterModal" placeholder="Rechercher le transporteur" required></x-form.select2-dropdown>
            @if(!$isEditMode)
                <x-form.select label="Conteneur" wire:model.lazy="container" :options="$containers" required></x-form.select>
            @endif
        </x-slot>
        <x-slot name="footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                {{ __('Close') }}
            </button>
            <button wire:click="setContainerTransporter" class="btn btn-primary me-2">
                <i class="fa fa-check-circle"></i> {{ __('Save') }}
            </button>
        </x-slot>
    </x-form-modal>
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
