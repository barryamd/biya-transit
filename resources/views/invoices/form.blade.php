@section('title')
    @if($invoice->id)
        Modifier la facture
    @else
        Ajouter une facture
    @endif
@endsection
<x-form-section submit="save">
    <x-slot name="form">
        <div class="row">
            <div class="col-md-6">
                <x-form.select2-ajax label="Dossier" wire:model="invoice.folder_id" routeName="getFolders" id="folder"
                                     :selectedOptions="[$selectedFolder]" required placeholder="Rechercher le dossier"></x-form.select2-ajax>
            </div>
            <div class="col-md-6">
                <x-form.select label="TVA" wire:model.lazy="invoice.tva_id" :options="$tvas"></x-form.select>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <h5>Ajouter les montants</h5>
                <div class="table-responsive table-bordered-">
                    <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 5%">#</th>
                            <th style="width: 30%;">Service</th>
                            <th style="width: 20%;">Prix Service</th>
                            <th style="width: 20%;">Marge</th>
                            <th style="width: 20%;">Total</th>
                            <th class="text-center" style="width: 5%">
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
                                    <select wire:model.defer="charges.{{$i}}.service_id" class="form-control px-1" required>
                                        <option value="">-- Selectionner un service rendu --</option>
                                        @foreach($services as $value => $service)
                                            <option value="{{$value}}">{{ $service }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" wire:model.lazy="charges.{{$i}}.amount" wire:change="setTotal" class="form-control px-1 text-right" required>
                                </td>
                                <td>
                                    <input type="number" wire:model.lazy="charges.{{$i}}.benefit" wire:change="setTotal" class="form-control px-1 text-right" required>
                                </td>
                                <td>
                                    {{ moneyFormat($charge['amount'] + $charge['benefit']) }} GNF
                                </td>
                                <td class="text-center" style="padding-right: 0.3rem; width: 5px">
                                    <button wire:click.prevent="removeCharge({{$i}})" class="btn btn-danger btn-sm" title="Supprimer cette ligne">
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
    </x-slot>
</x-form-section>
@push('scripts')
    <script>
        Livewire.on('newProductAdded', data => {
            $('#products').append(new Option(data[1], data[0], true, true)).trigger({
                type: 'select2:select',
                params: {
                    data: data
                }
            });
        })
    </script>
@endpush
