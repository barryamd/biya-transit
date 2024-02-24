@section('title')
    Ajouter des dépenses
@endsection
<x-form-section submit="save">
    <x-slot name="form">
        <div class="row">
            <div class="col-12">
                <h5>Dossier N° {{ $folder->number }}</h5>
                <div class="table-responsive table-bordered-">
                    <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 5%">#</th>
                            <th style="width: 60%;">Dépense</th>
                            <th style="width: 20%;">Montant</th>
                            <th class="text-center" style="width: 10%">
                                <button wire:click.prevent="addCharge" title="Ajouter" class="btn btn-sm btn-primary w-100-">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($charges as $i => $charge)
                            <tr>
                                <td class="text-center ">{{ $loop->iteration }}</td>
                                <td>
                                    <input type="text" wire:model.lazy="charges.{{$i}}.name" class="form-control" required>
                                </td>
                                <td>
                                    <input type="number" wire:model.lazy="charges.{{$i}}.amount" class="form-control" required>
                                </td>
                                <td class="text-center" style="padding-right: 0.3rem; width: 5px">
                                    <button wire:click.prevent="removeCharge({{$i}}, {{$charge['id']}})" class="btn btn-danger btn-sm" title="Supprimer cette charge">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-slot>
</x-form-section>
