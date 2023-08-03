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
                        <td>{{ number_format($folder->containers_sum_weight, 2, ',', ' ') }} Kgs</td>
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
                        <th style="width: 25%;">Type du conteneur</th>
                        <th style="width: 25%;">Numéro du conteneur</th>
                        <th style="width: 15%;">Poids</th>
                        <th style="width: 15%;">Nombre de colis</th>
                        <th style="width: 15%">Date d'arrivé</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($containers as $i => $container)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="align-middle">
                                {{ $container->type->label }}
                            </td>
                            <td class="align-middle">
                                {{ $container->number }}
                            </td>
                            <td class="align-middle">
                                {{ number_format($container->weight, 2, ',', ' ') }} Kgs
                            </td>
                            <td class="align-middle">
                                {{ $container->package_number }}
                            </td>
                            <td class="align-middle">
                                {{ dateFormat($container->arrival_date) }}
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
                            <td class="align-middle">
                                {{ $document->type->label }}
                            </td>
                            <td class="align-middle">
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
            <h4>Exonérations</h4>
            <div class="table-responsive table-bordered-">
                <table class="mb-1 table table-sm table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">#</th>
                        <th style="width: 20%;">Conteneur</th>
                        <th style="width: 15%;">Numéro</th>
                        <th style="width: 15%;">Date</th>
                        <th style="width: 20%;">Produits</th>
                        <th style="width: 15%;">Fichier</th>
                        <th class="text-center" style="width: 10%">
                            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exonerationFormModal" title="Ajouter une exoneration">
                                <i class="fa fa-plus"></i>
                            </button>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($exonerations as $i => $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->container->number }}</td>
                            <td>{{ $item->number }}</td>
                            <td>{{ dateFormat($item->date) }}</td>
                            <td>{{ $item->products->pluck('designation')->implode(', ') }}</td>
                            <td>
                                @if($item->attach_file_path)
                                    <button wire:click="downloadFile('exonerations', 'attach_file_path', {{$item->id}})" class="btn btn-sm btn-success">
                                        <i class="fas fa-download"></i>
                                    </button>
                                    <button wire:click="deleteFile('exonerations', 'attach_file_path', {{$item->id}})" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @else
                                    <span class="text-danger">Il manque le fichier d'exoneration</span>
                                @endif
                            </td>
                            <td>
                                <button wire:click="editExoneration('{{ $item->id }}')" class="btn btn-sm btn-warning" title="Modifier l'exoneration">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button wire:click="deleteExoneration('{{ $item->id }}')" class="btn btn-sm btn-danger" title="Supprimer l'exoneration">
                                    <i class="fa fa-trash"></i>
                                </button>
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
            <h4>Déclaration</h4>
            @forelse($declarations as $i => $item)
                <h5>
                    Déclaration du conteneur n°: {{ $item->container->number }}
                    <div class="float-right">
                        <button wire:click="editDeclaration('{{ $item->id }}')" class="btn btn-sm btn-warning" title="Modifier la déclaration">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button wire:click="deleteDeclaration('{{ $item->id }}')" class="btn btn-sm btn-danger" title="Supprimer la déclaration">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </h5>
                <div class="row">
                    <div class="col-md-6">
                        <table class="mb-1 table table-sm table-striped">
                            <tr>
                                <th>Numéro de declaration</th>
                                <td>{{ $item->number }}</td>
                            </tr>
                            <tr>
                                <th>Date de declaration</th>
                                <td>{{ dateFormat($item->date) }}</td>
                            </tr>
                            <tr>
                                <th>Bureau de destination</th>
                                <td>{{ $item->destination_office }}</td>
                            </tr>

                            <tr>
                                <th>Verificateur</th>
                                <td>{{ $item->verifier }}</td>
                            </tr>
                            <tr>
                                <th>Copie de la declaration</th>
                                <td>
                                    @if($item->declaration_file_path)
                                        <button wire:click="downloadFile('declarations', 'declaration_file_path')" class="btn btn-xs btn-success">
                                            <i class="fas fa-download"></i> Telecharger
                                        </button>
                                        <button wire:click="deleteFile('declarations', 'declaration_file_path')" class="btn btn-xs btn-danger">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    @else
                                        <div class="text-danger">Il manque la copie de la declaration</div>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Numéro du bulletin de liquidation</th>
                                <td>{{ $item->liquidation_bulletin }}</td>
                            </tr>
                            <tr>
                                <th>Date de liquidation</th>
                                <td>{{ $item->liquidation_date }}</td>
                            </tr>
                            <tr>
                                <th>Copie du bulletin de liquidation</th>
                                <td>
                                    @if($item->liquidation_file_path)
                                        <button wire:click="downloadFile('declarations', 'liquidation_file_path')" class="btn btn-xs btn-success">
                                            <i class="fas fa-download"></i> Telecharger
                                        </button>
                                        <button wire:click="deleteFile('declarations', 'liquidation_file_path')" class="btn btn-xs btn-danger">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    @else
                                        <div class="text-danger">Il manque la copie du bulletin de liquidation</div>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="mb-1 table table-sm table-striped">
                            <tr>
                                <th>Numéro de la quittance</th>
                                <td>{{ $item->receipt_number }}</td>
                            </tr>
                            <tr>
                                <th>Date de la quittance</th>
                                <td>{{ $item->receipt_date }}</td>
                            </tr>
                            <tr>
                                <th>Copie de la quittance</th>
                                <td>
                                    @if($item->receipt_file_path)
                                        <button wire:click="downloadFile('declarations', 'receipt_file_path')" class="btn btn-xs btn-success">
                                            <i class="fas fa-download"></i> Telecharger
                                        </button>
                                        <button wire:click="deleteFile('declarations', 'receipt_file_path')" class="btn btn-xs btn-danger">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    @else
                                        <div class="text-danger">Il manque la copie du bulletin de la quittance</div>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Numéro du bon</th>
                                <td>{{ $item->bon_number }}</td>
                            </tr>
                            <tr>
                                <th>Date du bon</th>
                                <td>{{ $item->bon_date }}</td>
                            </tr>
                            <tr>
                                <th>Copie du bon</th>
                                <td>
                                    @if($item->bon_file_path)
                                        <button wire:click="downloadFile('declarations', 'bon_file_path')" class="btn btn-xs btn-success">
                                            <i class="fas fa-download"></i> Telecharger
                                        </button>
                                        <button wire:click="deleteFile('declarations', 'bon_file_path')" class="btn btn-xs btn-danger">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    @else
                                        <div class="text-danger">Il manque la copie du bon</div>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr/>
            @empty
                <p class="text-danger">Les infos de la déclaration sont obligatoires</p>
            @endforelse
        </div>
    </div>
    <hr>

    <div class="row">
        <div class="col-12">
            <h4>Bons de livraisons</h4>
            <div class="table-responsive table-bordered-">
                <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">#</th>
                        <th style="width: 15%;">Conteneur</th>
                        <th style="width: 20%;">Bon de CM</th>
                        <th style="width: 20%;">Copie du Bon de CM</th>
                        <th style="width: 20%;">Bon de CT</th>
                        <th style="width: 20%;">Copie du Bon de CT</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($deliveryNotes as $i => $deliveryNote)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                {{ $deliveryNote->container->number }}
                            </td>
                            <td>
                                {{ $deliveryNote->bcm }}
                            </td>
                            <td class="align-middle">
                                @if($deliveryNote['bcm_file_path'])
                                    <button wire:click="downloadFile('delivery_notes', 'bcm_file_path', {{$deliveryNote['id']}})" class="btn btn-sm btn-success">
                                        <i class="fas fa-download"></i> Telecharger
                                    </button>
                                @else
                                    <span class="text-danger">Il manque le fichier jointe</span>
                                @endif
                            </td>
                            <td>
                                {{ $deliveryNote->bct }}
                            </td>
                            <td class="align-middle">
                                @if($deliveryNote['bct_file_path'])
                                    <button wire:click="downloadFile('delivery_notes', 'bct_file_path', {{$deliveryNote['id']}})" class="btn btn-sm btn-success">
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
                                    <button wire:click="downloadFile('deliveries', 'exit_file_path')" class="btn btn-sm btn-success">
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
                                    <button wire:click="downloadFile('deliveries', 'return_file_path')" class="btn btn-sm btn-success">
                                        <i class="fas fa-download"></i> Telecharger
                                    </button>
                                @else
                                    <span class="text-danger" >Il manque la copie du Bon de retour</span>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <h5>Transporteurs</h5>
                    <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                            <thead>
                            <tr>
                                <th>Conteneur</th>
                                <th>Immatriculation du vehicule</th>
                                <th>Marque du vehicule</th>
                                <th>Chauffeur</th>
                                <th>Numéro du chauffeur</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($containers as $container)
                                <tr>
                                    <td>{{ $container->number }}</td>
                                    <td>{{ $container->transporter->numberplate }}</td>
                                    <td>{{ $container->transporter->marque }}</td>
                                    <td>{{ $container->transporter->driver_name }}</td>
                                    <td>{{ $container->transporter->driver_phone }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-danger" colspan="5">
                                        <p>Aucun transporteur n'a été ajouté au dossier</p>
                                    </td>
                                </tr>
                            @endforelse
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
            @can('update-folder')
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
