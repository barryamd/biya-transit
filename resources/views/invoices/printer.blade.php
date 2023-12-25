@extends('layouts.print')

@section('content')
    <div class="row">
        <div class="col-12">
            <div><span class="float-right">Conakry le {{ $folder->created_at->format('d/m/Y') }}</span></div>
            <div><b>CLIENT :</b> {{ $folder->customer->user->full_name }}</div>
            <br>
            <div><b>N° Facture :</b> {{ $invoice->number }}</div>
            <div><b>N° Dossier :</b> {{ $folder->number }}</div>
            <div><b>N° CNT :</b> {{ $folder->number }}</div>
            <div><b>Nombre de conteneurs :</b> {{ $folder->containers_count }}</div>
            <div><b>Numéro des conteneurs :</b> {{ $folder->containers->pluck('number')->implode(', ') }}</div>
        </div>
    </div>
    <hr class="pt-0 mt-0 text-gray">

{{--    <div class="row">--}}
{{--        <div class="col-12">--}}
{{--            <h5 class="text-center">DETAIL DU CONTENU</h5>--}}
{{--            <div class="table-responsive table-bordered-">--}}
{{--                <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th class="bg-secondary-" style="width: 50%;">DESIGNATION</th>--}}
{{--                        <th class="bg-secondary-" style="width: 30%;">QUANTITE</th>--}}
{{--                        <th class="bg-secondary-" style="width: 20%;">POIDS (KGS)</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                    @foreach ($containers as $i => $container)--}}
{{--                        <tr>--}}
{{--                            <td>--}}
{{--                                {{ $container->number }}--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                {{ $container->package_number }}--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                {{ number_format($container->weight, 2, ',', ' ') }}--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <hr class="pt-0 mt-0 text-gray">--}}

    <div class="row">
        <div class="col-12">
            <h5 class="text-center">FACTURATION</h5>
            <div class="table-responsive table-bordered-">
                <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                    <thead>
                    <tr>
                        <th class="bg-secondary-" style="width: 40%;">DESIGNATIONS</th>
                        <th class="bg-secondary- text-center" style="width: 20%;">MONTANT EN GNF</th>
                        <th class="bg-secondary-" style="width: 40%;">OBSERVATION</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($amounts as $i => $amount)
                        <tr>
                            <td class="text-uppercase">
                                {{ $amount->service->name }}
                            </td>
                            <td class="text-right pr-5">
                                {{ moneyFormat($amount->amount) }}
                            </td>
                            <td>
                                {{ $amount->service->description }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tr>
                        <th>TOTAL</th>
                        <th class="bg-secondary-">
                            {{ moneyFormat($invoice->total) }}
                        </th>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <hr class="pt-0 mt-0 text-gray">

    <div>
        <b>Arrêté la présente facture à la somme de :</b> {{ $totalInText }} frangs guinéens
    </div>
    <hr class="pt-0 mt-0 text-gray">

    <div class="row pt-3">
        <div class="col-6"><b>DOCUMENTS JOINS</b><br>Copie du dossier</div>
        <div class="col-6"><b>DIRECTEUR GENERALE</b></div>
    </div>
@endsection
