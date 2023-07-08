@extends('layouts.print')

@section('content')
    <!-- header row -->
    <h4 class="text-center">FACTURE</h4>
    @include('_includes.invoice-header')
    <!-- /.row -->

    <div class="row">
        <div class="col-12">
            <h5>Facture N°: {{$invoice->number}}</h5>
            <div class="table-responsive table-bordered-">
                <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">#</th>
                        <th style="width: 45%;">Service</th>
                        <th style="width: 50%;">Prix</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($amounts as $i => $amount)
                        <tr>
                            <td class="text-center ">{{ $loop->iteration }}</td>
                            <td>
                                {{ $amount->service->name }}
                            </td>
                            <td>
                                {{ moneyFormat($amount->amount) }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr class="pt-0 mt-0 text-gray">
    <div class="row">
        <div class="col-md-5 pl-3 pr-5">
        </div>
        <div class="col-md-7">
            <table class="table table-sm table-head-fixed- text-nowrap-">
                <tbody>
                @if($invoice->tva_id)
                    <tr>
                        <th style="width: 50%">Sous-Total</th>
                        <td class="text-right" style=" width: 45%">
                            {{ moneyFormat($invoice->subtotal, 0, '') }}
                        </td>
                        <td style="width: 20px;">GNF</td>
                    </tr>
                    <tr>
                        <th>TVA</th>
                        <td class="text-right">
                            {{ moneyFormat($invoice->tax, 0, '') }}
                        </td>
                        <td>GNF</td>
                    </tr>
                @endif
                <tr>
                    <th>Total</th>
                    <td class="text-right">
                        <span class="text-nowrap">{{ moneyFormat($invoice->total, 0, '') }}</span>
                    </td>
                    <td>GNF</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row pt-3">
        <div class="col-6"></div>
        <div class="col-6"><b>Responsable commerciale</b><br><br><b>Signature autorisée</b></div>
    </div>
@endsection
