@section('title', 'Ouvrir un nouveau dossier')
<div>
    <x-form-section submit="save">
        <x-slot name="form">
            <div class="row">
                <div class="col-md-6">
                    <x-form.select2-ajax label="Client" wire:model="folder.customer_id" routeName="getCustomers" id="customer"
                                         required placeholder="Rechercher le client"></x-form.select2-ajax>
                </div>
                <div class="col-md-6">
                    <x-form.input label="Numero BL" wire:model.defer="folder.num_cnt" required></x-form.input>
                </div>
                <div class="col-md-6">
                    <x-form.input label="Poids Total de la marchandise" wire:model.defer="folder.weight" required></x-form.input>
                </div>
                <div class="col-md-6">
                    <x-form.input label="Port" wire:model.defer="folder.harbor" required></x-form.input>
                </div>
                <div class="col-md-9">
                    <x-form.select2-ajax label="Designation" wire:model="products" routeName="getProducts" id="products"
                                         required placeholder="Rechercher les produits" multiple></x-form.select2-ajax>
                </div>
                <div class="col-md-3 pt-4">
                    <button class="btn btn-primary mt-1" data-toggle="modal" data-target="#addProductModal">
                        <i class="fa fa-plus"></i> Ajouter une designation
                    </button>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <h5>Ajouter les details des conteneurs et colis</h5>
                    <div class="table-responsive table-bordered-">
                        <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">#</th>
                                <th style="width: 15%;">Numero du conteneur</th>
                                <th style="width: 10%;">Poids</th>
                                <th style="width: 15%;">Nombre de colis</th>
                                <th style="width: 10%">Date d'arrivé</th>
                                <th class="text-center" style="width: 5%">
                                    <button wire:click.prevent="addContainer" title="Ajouter" class="btn btn-sm btn-primary w-100-">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($containers as $i => $container)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        <input type="text" wire:model.defer="containers.{{$i}}.number" class="form-control px-1" required>
                                    </td>
                                    <td class="align-middle">
                                        <input type="number" wire:model.defer="containers.{{$i}}.weight" step="000.00" class="form-control px-1" required>
                                    </td>
                                    <td class="align-middle">
                                        <input type="text" wire:model.defer="containers.{{$i}}.package_number" class="form-control px-1" required>
                                    </td>
                                    <td class="align-middle">
                                        <input type="date" wire:model.defer="containers.{{$i}}.arrival_date" class="form-control px-1" required>
                                    </td>
                                    <td class="text-center" style="padding-right: 0.3rem; width: 5px">
                                        <button wire:click.prevent="removeContainer('{{$i}}')" class="btn btn-danger btn-sm" title="Supprimer cette ligne">
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
            <hr>
            <div class="row">
                <div class="col-12">
                    <h5>Ajouter les details des factures</h5>
                    <div class="table-responsive table-bordered-">
                        <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">#</th>
                                <th style="width: 15%;">Type de fichier</th>
                                <th style="width: 25%;">Numéro</th>
                                <th style="width: 25%;">Montant</th>
                                <th style="width: 25%;">Fichier jointe</th>
                                <th class="text-center" style="width: 5%">
                                    <button wire:click.prevent="addInvoice" title="Ajouter" class="btn btn-sm btn-primary w-100-">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($invoices as $i => $invoice)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        <select wire:model.defer="invoices.{{$i}}.type" class="form-control px-1" required>
                                            @foreach($invoiceTypes as $type)
                                                <option value="{{$type}}">{{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" wire:model.defer="invoices.{{$i}}.invoice_number" class="form-control px-1" required>
                                    </td>
                                    <td class="align-middle">
                                        <input type="number" wire:model.defer="invoices.{{$i}}.amount" class="form-control px-1" required>
                                    </td>
                                    <td class="align-middle">
                                        <input type="file" wire:model.lazy="invoicesFiles.{{$i}}" class="form-control px-1" required>
                                        @error('invoicesFiles.*') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                                    </td>
                                    <td class="text-center" style="padding-right: 0.3rem; width: 5px">
                                        <button wire:click.prevent="removeInvoice('{{$i}}')" class="btn btn-danger btn-sm" title="Supprimer cette ligne">
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
            <hr>
            <div class="row">
                <div class="col-12">
                    <x-form.textarea label="Observation" wire:model.defer="folder.observation"></x-form.textarea>
              </div>
            </div>
        </x-slot>
    </x-form-section>

    <x-form-modal id="addProductModal" submit="addNewProduct" title="Ajouter un nouveau produit">
        <x-slot name="content">
            <x-form.input label="Designation du produit" wire:model.defer="productDesignation" required></x-form.input>
        </x-slot>
    </x-form-modal>
</div>
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
