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
                <x-form.select2-ajax label="Client" wire:model="folder.folder_id" routeName="getFolders" id="folder"
                                     required placeholder="Rechercher le dossier"></x-form.select2-ajax>
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
                            <th style="width: 40%;">Service</th>
                            <th style="width: 50%;">Prix</th>
                            <th class="text-center" style="width: 5%">
                                <button wire:click.prevent="addAmount" title="Ajouter" class="btn btn-sm btn-primary w-100-">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($amounts as $i => $amount)
                            <tr>
                                <td class="text-center ">{{ $loop->iteration }}</td>
                                <td>
                                    <select wire:model.defer="invoices.{{$i}}.service_id" class="form-control px-1" required>
                                        <option value="">-- Selectionner un service rendu --</option>
                                        @foreach($services as $value => $service)
                                            <option value="{{$value}}">{{ $service }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" wire:model.lazy="invoices.{{$i}}.amount" wire:change="updateTotal" class="form-control px-1" required>
                                </td>
                                <td class="text-center" style="padding-right: 0.3rem; width: 5px">
                                    <button wire:click.prevent="removeAmount('{{$i}}')" class="btn btn-danger btn-sm" title="Supprimer cette ligne">
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
