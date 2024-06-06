@section('title', 'Details de la facture: '.$invoice->number)
<x-show-section>

    <div class="row">
        <div class="col-12">
            <div><span class="float-right">Conakry le {{ $folder->created_at->format('d/m/Y') }}</span></div>
            <div><b>CLIENT :</b> {{ $folder->customer->user->full_name }}</div>
            <br>
            <div><b>N° Facture :</b> {{ $invoice->number }}</div>
            <div><b>N° Dossier :</b> {{ $folder->number }}</div>
            <div><b>N° BL :</b> {{ $folder->number }}</div>
            <div><b>Nombre de conteneurs :</b> {{ $folder->containers_count }}</div>
            <div><b>Numéro des conteneurs :</b> {{ $folder->containers->pluck('number')->implode(', ') }}</div>
        </div>
    </div>
    <hr class="pt-0 mt-0 text-gray">

    {{--
    <div class="row">
        <div class="col-12">
            <h5 class="text-center">DETAIL DU CONTENU</h5>
            <div class="table-responsive table-bordered-">
                <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                    <thead>
                    <tr>
                        <th class="bg-secondary" style="width: 50%;">DESIGNATION</th>
                        <th class="bg-secondary" style="width: 30%;">QUANTITE</th>
                        <th class="bg-secondary" style="width: 20%;">POIDS (KGS)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($containers as $i => $container)
                        <tr>
                            <td>
                                {{ $container->number }}
                            </td>
                            <td>
                                {{ $container->package_number }}
                            </td>
                            <td>
                                {{ number_format($container->weight, 2, ',', ' ') }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr class="pt-0 mt-0 text-gray">
    --}}

    @php($user = Auth::user())
    <div class="row">
        <div class="col-12">
            <h5 class="text-center">FACTURATION</h5>
            <div class="table-responsive table-bordered-">
                <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                    <thead>
                    <tr>
                        <th class="bg-secondary" style="width: 20%;">Service</th>
                        @if($user->isNotCustomer())
                        <th class="bg-secondary text-center" style="width: 20%;">Prix Service</th>
                        <th class="bg-secondary text-center" style="width: 15%;">Marge</th>
                        @endif
                        <th class="bg-secondary text-center" style="width: 20%;">Total</th>
                        <th class="bg-secondary" style="width: 25%;">Observation</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($invoice->charges as $i => $charge)
                        <tr>
                            <td class="text-uppercase">
                                {{ $charge->service->name }}
                            </td>
                            @if($user->isNotCustomer())
                            <td class="text-right pr-5">
                                {{ moneyFormat($charge->amount, 0, '') }}
                            </td>
                            <td class="text-right pr-5">
                                {{ moneyFormat($charge->benefit, 0, '') }}
                            </td>
                            @endif
                            <td class="text-right pr-5">
                                {{ moneyFormat($charge->amount + $charge->benefit, 0, '') }}
                            </td>
                            <td>
                                {{ $charge->service->description }}
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
                <tr>
                    <th style="width: 50%">Sous-Total</th>
                    <td class="text-right" style=" width: 45%">
                        {{ moneyFormat($invoice->subtotal, 0, '') }}
                    </td>
                    <td style="width: 20px;">GNF</td>
                </tr>
                @if($invoice->tva_id)
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
    <hr class="pt-0 mt-0 text-gray">

    <div>
        <b>Arrêté la présente facture à la somme de :</b> {{ $totalInText }} frangs guinéens
    </div>
    <hr class="pt-0 mt-0 text-gray">

    <div class="row">
        <div class="col-12">
{{--            <a href="{{ route('invoice.print', $invoice->folder) }}" target="_blank" class="btn btn-default">--}}
{{--                <i class="fas fa-print"></i> Imprimer--}}
{{--            </a>--}}
            <button onclick="__net_nfet_printing___print()" class="btn btn-default">
                <i class="fas fa-print"></i> Imprimer
            </button>
        </div>
    </div>

    <x-slot name="footer">
        <x-cancel-button class="float-left">{{__('Back')}}</x-cancel-button>
    </x-slot>
</x-show-section>

@push('scripts')
    <script id="__net_nfet_printing_s__" type="text/javascript">
        function __net_nfet_printing___print(){
            var f = document.getElementById('__net_nfet_printing__');
            f.focus();
            f.contentWindow.print();
        }
    </script>
    <iframe style="visibility: hidden; height: 0; width: 0; position: absolute;" id="__net_nfet_printing__"
            src="{{ route('invoice.print', $invoice->folder) }}">
    </iframe>
@endpush
