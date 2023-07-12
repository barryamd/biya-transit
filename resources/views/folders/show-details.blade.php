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
            <h5>Les details des conteneurs et colis</h5>
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
            <h5>Les documents joints</h5>
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

    <x-slot name="footer">
        <x-cancel-button class="float-left">{{__('Back')}}</x-cancel-button>
        @if($folder->status == 'En cours')
        @can('close-folder')
            <button wire:click="closeFolder" class="btn btn-success float-right">Fermer le dossier</button>
        @endcan
        @endif
    </x-slot>
</x-show-section>
