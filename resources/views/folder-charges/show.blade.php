@section('title')
    Les dépenses du dossier
@endsection
<x-show-section submit="save">
    <div class="row">
        <div class="col-12">
            <h5>Dossier N° {{ $folder->number }}</h5>
            <div class="table-responsive table-bordered-">
                <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 10%">#</th>
                        <th style="width: 60%;">Dépense</th>
                        <th style="width: 30%;">Montant</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($charges as $i => $charge)
                        <tr>
                            <td class="text-center ">{{ $loop->iteration }}</td>
                            <td>{{ $charge->name }}</td>
                            <td>{{ moneyFormat($charge->amount, 0, '') }}</td>
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
