@section('title', 'Details du dossier: '.$folder->number)
<x-show-section>
    <!-- title row -->
    <div class="row">
        <div class="col-12">
            <div class="table-responsive table-bordered-">
                <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                    <tbody>
                    <tr>
                        <th style="width: 40%">Numero du dossier</th>
                        <td>{{ $folder->number }}</td>
                    </tr>
                    <tr>
                        <th>Numero CNT</th>
                        <td>{{ $folder->num_cnt }}</td>
                    </tr>
                    <tr>
                        <th>Bateau</th>
                        <td>{{ $folder->ship }}</td>
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
                        <th style="width: 15%;">Numero du conteneur</th>
                        <th style="width: 30%;">Designation</th>
                        <th style="width: 10%;">Poids</th>
                        <th style="width: 15%;">Numero du colis</th>
                        <th style="width: 10%">Date d'embarquement</th>
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
                                {{ $container->designation }}
                            </td>
                            <td class="align-middle">
                                {{ $container->weight }}
                            </td>
                            <td class="align-middle">
                                {{ $container->package_number }}
                            </td>
                            <td class="align-middle">
                                {{ $container->filling_date->format('d/m/Y') }}
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
            <h5>Les factures d'achats</h5>
            <div class="table-responsive table-bordered-">
                <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">#</th>
                        <th style="width: 30%;">Numero de la facture</th>
                        <th style="width: 30%;">Montant de la facture</th>
                        <th style="width: 30%;">Fichier jointe</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($purchaseInvoices as $i => $invoice)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                {{ $invoice->invoice_number }}
                            </td>
                            <td class="align-middle">
                                {{ moneyFormat($invoice->amount) }}
                            </td>
                            <td class="align-middle">
                                <button wire:click="download('purchase_invoices', {{$invoice->id}})" class="btn btn-sm btn-primary"><i class="fas fa-download"></i> Telecharger</button>
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
    </x-slot>
</x-show-section>
