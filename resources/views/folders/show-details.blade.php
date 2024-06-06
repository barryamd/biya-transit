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
                        <th>Nom du client</th>
                        <td>{{ $folder->customer->user?->full_name }}</td>
                    </tr>
                    <tr>
                        <th>Nom de l'entreprise</th>
                        <td>{{ $folder->customer->name }}</td>
                    </tr>
                    <tr>
                        <th>Numéro CNT/LTA</th>
                        <td>{{ $folder->num_cnt }}</td>
                    </tr>
                    <tr>
                        <th>Poids total de la marchandise</th>
                        <td>{{ number_format($folder->containers_sum_weight, 2, ',', ' ') }} Kgs</td>
                    </tr>
                    <tr>
                        <th>Nombre total de colis</th>
                        <td>{{ number_format($folder->containers_sum_package_number, 0, ',', ' ') }} Colis</td>
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
                    <tr>
                        <th>Autheur</th>
                        <td>{{ $folder->user?->full_name }}</td>
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
                        <th style="width: 20%;">Type du conteneur</th>
                        <th style="width: 25%;">Numéro du conteneur</th>
                        <th style="width: 15%;">Poids</th>
                        <th style="width: 10%;">Nombre de colis</th>
                        <th style="width: 10%">Date d'arrivé</th>
                        <th>Autheur</th>
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
                            <td>{{ $container->user?->full_name }}</td>
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
                        <th style="width: 25%;">Type de document</th>
                        <th style="width: 25%;">Numéro du document</th>
                        <th style="width: 25%;">Fichier jointe</th>
                        <th>Autheur</th>
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
                                <button wire:click="downloadFile('folders', 'attach_file_path', {{$document->id}})" class="btn btn-xs btn-primary"><i class="fas fa-download"></i> Telecharger</button>
                            </td>
                            <td>{{ $document->user?->full_name }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr />

    @php($user = Auth::user())
    @if($user->isNotCustomer() || ($user->isCustomer() && $folder->status == 'Fermé'))
    <div class="row">
        <div class="col-12">
            <h4>Exonérations</h4>
            <div class="table-responsive table-bordered-">
                <table class="mb-1 table table-sm table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">#</th>
                        <th style="width: 15%;">Numéro</th>
                        <th style="width: 15%;">Date</th>
                        <th style="width: 30%;">Produits</th>
                        <th style="width: 20%;">Fichier</th>
                        <th>Autheur</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($exonerations as $i => $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item->number }}</td>
                            <td>{{ dateFormat($item->date) }}</td>
                            <td>{{ $item->products->pluck('designation')->implode(', ') }}</td>
                            <td>
                                @if($item->attach_file_path)
                                    <button wire:click="downloadFile('exonerations', 'attach_file_path', {{$item->id}})" class="btn btn-xs btn-primary">
                                        <i class="fas fa-download"></i> Télécharger
                                    </button>
                                @else
                                    <span class="text-danger">Ce fichier est obligatoire</span>
                                @endif
                            </td>
                            <td>{{ $container->user?->full_name }}</td>
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
                            <th>Autheur</th>
                            <td>{{ $ddiOpening->user?->full_name }}</td>
                        </tr>
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
                                    <span class="text-danger">Ce numéro est obligatoire</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Date d'obtention DDI</th>
                            <td>
                                @if($ddiOpening->ddi_obtained_date)
                                    {{ dateFormat($ddiOpening->ddi_obtained_date) }}
                                @else
                                    <span class="text-danger">Cette date est obligatoire</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Fichier DDI</th>
                            <td>
                                @if($ddiOpening->attach_file_path)
                                    <button wire:click="downloadFile('ddi_openings')" class="btn btn-xs btn-primary">
                                        <i class="fas fa-download"></i> Telecharger
                                    </button>
                                @else
                                    <span class="text-danger">Ce fichier est obligatoire</span>
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
                    Déclaration n°: {{ $item->number }}
                </h5>
                <div class="row">
                    <div class="col-md-6">
                        <table class="mb-1 table table-sm table-striped">
                            <tr>
                                <th>Autheur</th>
                                <td>{{ $item->user?->full_name }}</td>
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
                                        <button wire:click="downloadFile('declarations', 'declaration_file_path', {{$item->id}})" class="btn btn-xs btn-primary">
                                            <i class="fas fa-download"></i> Telecharger
                                        </button>
                                    @else
                                        <span class="text-danger">Ce fichier est obligatoire</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Numéro du bulletin de liquidation</th>
                                <td>
                                    @if($item->liquidation_bulletin)
                                        {{ $item->liquidation_bulletin }}
                                    @else
                                        <span class="text-danger">Ce numéro est obligatoire</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Date de liquidation</th>
                                <td>
                                    @if($item->liquidation_date)
                                        {{ dateFormat($item->liquidation_date) }}
                                    @else
                                        <span class="text-danger">Cette date est obligatoire</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Copie du bulletin de liquidation</th>
                                <td>
                                    @if($item->liquidation_file_path)
                                        <button wire:click="downloadFile('declarations', 'liquidation_file_path', {{$item->id}})" class="btn btn-xs btn-primary">
                                            <i class="fas fa-download"></i> Telecharger
                                        </button>
                                    @else
                                        <div class="text-danger">Ce fichier est obligatoire</div>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="mb-1 table table-sm table-striped">
                            <tr>
                                <th>Numéro de la quittance</th>
                                <td>
                                    @if($item->receipt_number)
                                        {{ $item->receipt_number }}
                                    @else
                                        <span class="text-danger">Ce numéro est obligatoire</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Date de la quittance</th>
                                <td>
                                    @if($item->receipt_date)
                                        {{ dateFormat($item->receipt_date) }}
                                    @else
                                        <span class="text-danger">Cette date est obligatoire</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Copie de la quittance</th>
                                <td>
                                    @if($item->receipt_file_path)
                                        <button wire:click="downloadFile('declarations', 'receipt_file_path', {{$item->id}})" class="btn btn-xs btn-primary">
                                            <i class="fas fa-download"></i> Telecharger
                                        </button>
                                    @else
                                        <div class="text-danger">Ce fichier est obligatoire</div>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Numéro du bon</th>
                                <td>
                                    @if($item->bon_number)
                                        {{ $item->bon_number }}
                                    @else
                                        <span class="text-danger">Ce numéro est obligatoire</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Date du bon</th>
                                <td>
                                    @if($item->bon_date)
                                        {{ dateFormat($item->bon_date) }}
                                    @else
                                        <span class="text-danger">Cette date est obligatoire</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Copie du bon</th>
                                <td>
                                    @if($item->bon_file_path)
                                        <button wire:click="downloadFile('declarations', 'bon_file_path', {{$item->id}})" class="btn btn-xs btn-primary">
                                            <i class="fas fa-download"></i> Telecharger
                                        </button>
                                    @else
                                        <div class="text-danger">Ce fichier est obligatoire</div>
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
            <table class="mb-1 table table-sm table-striped table-hover">
                <tbody>
                <tr>
                    <th style="width: 40%">Numéro Bon de CM</th>
                    <td>
                        @if($folder->bcm)
                            {{ $folder->bcm }}
                        @else
                            <span class="text-danger">Ce numéro est obligatoire</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Numéro Bon de CT</th>
                    <td>
                        @if($folder->bcm)
                            {{ $folder->bct }}
                        @else
                            <span class="text-danger">Ce numéro est obligatoire</span>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="table-responsive table-bordered-">
                <table class="mb-1 table table-sm table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 10%">#</th>
                        <th style="width: 35%;">Fichier Bon de CM</th>
                        <th style="width: 35%;">Fichier Bon de CT</th>
                        <th>Autheur</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($deliveryFiles as $i => $file)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="align-middle">
                                @if($file->bcm_file_path)
                                    <button wire:click="downloadFile('delivery_files', 'bcm_file_path', {{$file->id}})" class="btn btn-xs btn-primary">
                                        <i class="fas fa-download"></i> Telecharger
                                    </button>
                                @else
                                    <span class="text-danger">Ce fichier est obligatoire</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($file->bct_file_path)
                                    <button wire:click="downloadFile('delivery_files', 'bct_file_path', {{$file->id}})" class="btn btn-xs btn-primary">
                                        <i class="fas fa-download"></i> Telecharger
                                    </button>
                                @else
                                    <span class="text-danger">Ce fichier est obligatoire</span>
                                @endif
                            </td>
                            <td>{{ $file->user?->full_name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center text-danger" colspan="4">
                                <span>Les bons de livraison sont obligatoires</span>
                            </td>
                        </tr>
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
                            <th>Autheur</th>
                            <td>{{ $delivery->user?->full_name }}</td>
                        </tr>
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
                                    <button wire:click="downloadFile('deliveries', 'exit_file_path')" class="btn btn-xs btn-primary">
                                        <i class="fas fa-download"></i> Telecharger
                                    </button>
                                @else
                                    <span class="text-danger">Ce fichier est obligatoire</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Bon de retour</th>
                            <td>
                                @if($delivery->return_file_path)
                                    <button wire:click="downloadFile('deliveries', 'return_file_path')" class="btn btn-xs btn-primary">
                                        <i class="fas fa-download"></i> Telecharger
                                    </button>
                                @else
                                    <span class="text-danger">Ce fichier est obligatoire</span>
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
                                    <td>{{ $container->transporter?->numberplate }}</td>
                                    <td>{{ $container->transporter?->marque }}</td>
                                    <td>{{ $container->transporter?->driver_name }}</td>
                                    <td>{{ $container->transporter?->driver_phone }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-danger" colspan="5">
                                        <span>Aucun transporteur n'a été ajouté au dossier</span>
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
    @endif

    @if($user->isNotCustomer())
    <div class="row">
        <div class="col-12">
            <h4>Les charges du dossier</h4>
            <div class="table-responsive table-bordered-">
                <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 10%">#</th>
                        <th style="width: 60%;">Service</th>
                        <th style="width: 30%;">Montant</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($charges as $i => $charge)
                        @if($charge->service)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $charge->service->name }}</td>
                                <td>{{ moneyFormat($charge->amount, 0, '') }}</td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td class="text-center text-danger" colspan="3">
                                <span>Les charges du dossier sont obligatoires</span>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>
    @endif

    <x-slot name="footer">
        <x-cancel-button><i class="fas fa-arrow-left"></i> {{__('Back')}}</x-cancel-button>
        @if($folder->status == 'En attente' || $folder->status == 'En cours')
            @can('update-folder')
                <a href="{{route('folders.edit', $folder)}}" class="btn btn-warning"><i class="fas fa-edit"></i> Modifier le dossier</a>
            @endcan
            @if($user->isNotCustomer())
            <a href="{{route('folders.process', $folder)}}" class="btn btn-success"><i class="fas fa-edit"></i> Traiter le dossier</a>
            @endif
        @endif
        @if($user->isNotCustomer() && $folder->status == 'En cours')
            @can('close-folder')
                <button wire:click="closeFolder" class="btn btn-danger"><i class="fas fa-close"></i> Fermer le dossier</button>
            @endcan
        @endif
    </x-slot>
</x-show-section>
