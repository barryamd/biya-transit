@section('title', 'Details du dossier: '.$folder->number)
<x-show-section>
    <!-- title row -->
    <div class="row">
        <div class="col-12">
            <div class="table-responsive table-bordered-">
                <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                    <tbody>
                    <tr>
                        <th style="width: 40%">Numéro du dossier</th>
                        <td>{{ $folder->number }}</td>
                    </tr>
                    <tr>
                        <th>Numéro CNT</th>
                        <td>{{ $folder->num_cnt }}</td>
                    </tr>
                    <tr>
                        <th>Poids total de la marchandise</th>
                        <td>{{ $folder->weight }}</td>
                    </tr>
                    <tr>
                        <th>Port</th>
                        <td>{{ $folder->harbor }}</td>
                    </tr>
                    <tr>
                        <th>Pays</th>
                        <td>{{ $folder->country }}</td>
                    </tr>
                    <tr>
                        <th>Désignations</th>
                        <td>{{ implode(', ', $folder->products->pluck('designation')->toArray()) }}</td>
                    </tr>
                    <tr>
                        <th>Observation</th>
                        <td>{{ $folder->observation }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $folder->status }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-12">
            <h4>Les details des conteneurs et colis</h4>
            <div class="table-responsive table-bordered-">
                <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">#</th>
                        <th style="width: 15%;">Numéro du conteneur</th>
                        <th style="width: 10%;">Poids</th>
                        <th style="width: 15%;">Nombre de colis</th>
                        <th style="width: 10%">Date d'arrivé</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($folder->containers as $i => $container)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                {{ $container->number }}
                            </td>
                            <td class="align-middle">
                                {{ $container->weight }}
                            </td>
                            <td class="align-middle">
                                {{ $container->package_number }}
                            </td>
                            <td class="align-middle">
                                {{ $container->arrival_date->format('d/m/Y') }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-12">
            <h4>Les documents joints à l'ouverture du dossier</h4>
            <div class="table-responsive table-bordered-">
                <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">#</th>
                        <th style="width: 30%;">Type de document</th>
                        <th style="width: 35%;">Numéro du document</th>
                        <th style="width: 30%;">Fichier jointe</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($documents as $i => $document)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                {{ $document->type->label }}
                            </td>
                            <td>
                                {{ $document->number }}
                            </td>
                            <td class="align-middle">
                                <button wire:click="download('folders', {{$document->id}})" class="btn btn-sm btn-primary"><i class="fas fa-download"></i> Telecharger</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr />

    <div class="row">
        <div class="col-12">
            <h4>Ouverture DDI</h4>
            <div class="table-responsive table-bordered-">
                @if($ddiOpening)
                    <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                        <tbody>
                        <tr>
                            <th style="width: 40%">Numéro DVT</th>
                            <td>{{ $ddiOpening->dvt_number }}</td>
                        </tr>
                        <tr>
                            <th>Date d'obtention DVT</th>
                            <td>{{ dateFormat($ddiOpening->dvt_obtained_date) }}</td>
                        </tr>
                        <tr>
                            <th>Numéro DDI</th>
                            <td>
                                @if($ddiOpening->ddi_number)
                                    {{ $ddiOpening->ddi_number }}
                                @else
                                    <span class="text-danger" >Il manque le Numéro DDI</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Date d'obtention DDI</th>
                            <td>
                                @if($ddiOpening->ddi_obtained_date)
                                    {{ dateFormat($ddiOpening->ddi_obtained_date) }}
                                @else
                                    <span class="text-danger" >Il manque la Date d'obtention DDI</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Fichier DDI</th>
                            <td>
                                @if($ddiOpening->attach_file_path)
                                    <button wire:click="downloadFile('ddi_openings')" class="btn btn-sm btn-success">
                                        <i class="fas fa-download"></i> Telecharger
                                    </button>
                                @else
                                    <span class="text-danger" >Il manque la copie du Fichier DDI</span>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                @else
                    <span class="text-danger">Les infos de l'ouverture DDI sont obligatoires</span>
                @endif
            </div>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-12">
            <h4>Exonérations</h4>
            <div class="table-responsive table-bordered-">
                @if($exoneration)
                    <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                        <tbody>
                        <tr>
                            <th style="width: 40%">Numéro d'exonération</th>
                            <td>{{ $exoneration->number }}</td>
                        </tr>
                        <tr>
                            <th>Date d'exonération</th>
                            <td>{{ dateFormat($exoneration->date) }}</td>
                        </tr>
                        <tr>
                            <th>Produits exonérés</th>
                            <td>{{ implode(', ', $exoneration->products->pluck('designation')->toArray()) }}</td>
                        </tr>
                        <tr>
                            <th>Fichier Exonération</th>
                            <td>
                                @if($exoneration->attach_file_path)
                                    <button wire:click="downloadFile('exonerations')" class="btn btn-sm btn-success">
                                        <i class="fas fa-download"></i> Telecharger
                                    </button>
                                @else
                                    <span class="text-danger" >Il manque le Fichier d'Exonération</span>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-12">
            <h4>Déclaration</h4>
            <div class="table-responsive table-bordered-">
                @if($declaration)
                    <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                        <tbody>
                        <tr>
                            <th style="width: 40%">Numéro de declaration</th>
                            <td>{{ $declaration->number }}</td>
                        </tr>
                        <tr>
                            <th>Date de declaration</th>
                            <td>{{ dateFormat($declaration->date) }}</td>
                        </tr>
                        <tr>
                            <th>Bureau de destination</th>
                            <td>{{ $declaration->destination_office }}</td>
                        </tr>
                        <tr>
                            <th>Verificateur</th>
                            <td>{{ $declaration->verifier }}</td>
                        </tr>
                        <tr>
                            <th>Copie de la declaration</th>
                            <td>
                                @if($declaration->declaration_file_path)
                                    <button wire:click="downloadFile('declarations', 'declaration_file_path')" class="btn btn-sm btn-success">
                                        <i class="fas fa-download"></i> Telecharger
                                    </button>
                                @else
                                    <span class="text-danger" >Il manque la copie de la declaration</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Numéro du bulletin de liquidation</th>
                            <td>{{ $declaration->liquidation_bulletin }}</td>
                        </tr>
                        <tr>
                            <th>Date de liquidation</th>
                            <td>{{ dateFormat($declaration->liquidation_date) }}</td>
                        </tr>
                        <tr>
                            <th>Copie du bulletin de liquidation</th>
                            <td>
                                @if($declaration->liquidation_file_path)
                                    <button wire:click="downloadFile('declarations', 'liquidation_file_path')" class="btn btn-sm btn-success">
                                        <i class="fas fa-download"></i> Telecharger
                                    </button>
                                @else
                                    <span class="text-danger" >Il manque la copie du bulletin de liquidation</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Numéro de la quittance</th>
                            <td>{{ $declaration->receipt_number }}</td>
                        </tr>
                        <tr>
                            <th>Date de la quittance</th>
                            <td>{{ dateFormat($declaration->receipt_date) }}</td>
                        </tr>
                        <tr>
                            <th>Copie de la quittance</th>
                            <td>
                                @if($declaration->receipt_file_path)
                                    <button wire:click="downloadFile('declarations', 'receipt_file_path')" class="btn btn-sm btn-success">
                                        <i class="fas fa-download"></i> Telecharger
                                    </button>
                                @else
                                    <span class="text-danger" >Il manque la copie du bulletin de liquidation</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Numéro du bon</th>
                            <td>{{ $declaration->bon_number }}</td>
                        </tr>
                        <tr>
                            <th>Date du bon</th>
                            <td>{{ dateFormat($declaration->bon_date) }}</td>
                        </tr>
                        <tr>
                            <th>Copie du bon</th>
                            <td>
                                @if($declaration->bon_file_path)
                                    <button wire:click="downloadFile('declarations', 'bon_file_path')" class="btn btn-sm btn-success">
                                        <i class="fas fa-download"></i> Telecharger
                                    </button>
                                @else
                                    <span class="text-danger" >Il manque la copie du bulletin de liquidation</span>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                @else
                    <span class="text-danger">Les infos de la déclaration sont obligatoires</span>
                @endif
            </div>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-12">
            <h4>Bons de livraison</h4>
            <div class="table-responsive table-bordered-">
                <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">#</th>
                        <th style="width: 32%;">Bon de compagnie maritime</th>
                        <th style="width: 32%;">Bon conakry terminal</th>
                        <th style="width: 31%;">Fichier jointe</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($deliveryNotes as $i => $deliveryNote)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                {{ $deliveryNote->bcm }}
                            </td>
                            <td>
                                {{ $deliveryNote->bct }}
                            </td>
                            <td class="align-middle">
                                @if($deliveryNote['attach_file_path'])
                                    <button wire:click="downloadFile('delivery_notes', 'attach_file_path', {{$deliveryNote['id']}})" class="btn btn-sm btn-success">
                                        <i class="fas fa-download"></i> Telecharger
                                    </button>
                                @else
                                    <span class="text-danger">Il manque le fichier jointe</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <p class="text-danger">Les bons de livraison sont obligatoires</p>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-12">
            <h4>Les details de la livraison</h4>
            <div class="table-responsive table-bordered-">
                @if($delivery)
                    <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                        <tbody>
                        <tr>
                            <th style="width: 40%">Date de livraison</th>
                            <td>{{ dateFormat($delivery->date) }}</td>
                        </tr>
                        <tr>
                            <th>Lieu de livraison</th>
                            <td>{{ $delivery->place }}</td>
                        </tr>
                        <tr>
                            <th>Bon de sorti du conteneur</th>
                            <td>
                                @if($delivery->exit_file_path)
                                    <button wire:click="downloadFile('deliveries', 'exit_file_path')" class="btn btn-success">
                                        <i class="fas fa-download"></i> Telecharger
                                    </button>
                                @else
                                    <span class="text-danger" >Il manque la copie du Bon de sorti du conteneur</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Bon de retour</th>
                            <td>
                                @if($delivery->return_file_path)
                                    <button wire:click="downloadFile('deliveries', 'return_file_path')" class="btn btn-success">
                                        <i class="fas fa-download"></i> Telecharger
                                    </button>
                                @else
                                    <span class="text-danger" >Il manque la copie du Bon de retour</span>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <h5>Informations du transporteur</h5>
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
                @else
                    <span class="text-danger">Les details de la livraison sont obligatoires</span>
                @endif
            </div>
        </div>
    </div>
    <hr>

    <x-slot name="footer">
        <x-cancel-button><i class="fas fa-arrow-left"></i> {{__('Back')}}</x-cancel-button>
        @if($folder->status == 'En attente')
            @can('edit-folder')
                <a href="{{route('folders.edit', $folder)}}" class="btn btn-warning"><i class="fas fa-edit"></i> Modifier le dossier</a>
            @endcan
        @endif
        @if($folder->status == 'En attente' || $folder->status == 'En cours')
            @can('process-folder')
                <a href="{{route('folders.process', $folder)}}" class="btn btn-success"><i class="fas fa-edit"></i> Traiter le dossier</a>
            @endcan
        @endif
        @if($folder->status == 'En cours')
            @can('close-folder')
                <button wire:click="closeFolder" class="btn btn-danger"><i class="fas fa-close"></i> Fermer le dossier</button>
            @endcan
        @endif
    </x-slot>
</x-show-section>
