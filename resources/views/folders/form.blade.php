@section('title', 'Ouvrir un nouveau dossier')
<div>
    <x-form-section submit="save">
        <x-slot name="form">
            <div class="row">
                @if(!auth()->user()->customer)
                    <div class="col-md-6">
                        <x-form.select2-ajax label="Client" wire:model="folder.customer_id" routeName="getCustomers" id="customer"
                                             :selectedOptions="$selectedCustomer" required placeholder="Rechercher le client"></x-form.select2-ajax>
                    </div>
                @endif
                <div class="col-md-6">
                    <x-form.select label="Type de dossier" wire:model="folder.type" :options="['IMPORT' => 'IMPORT', 'EXPORT'=> 'EXPORT']"
                                         required placeholder="Selectionner le type"></x-form.select>
                </div>
                {{--
                <div class="col-md-6">
                    <x-form.input label="Numero BL" wire:model.defer="folder.num_cnt" required></x-form.input>
                </div>
                --}}
                <div class="col-md-6">
                    <x-form.input label="Poids Total de la marchandise" wire:model.defer="totalWeight" disabled></x-form.input>
                </div>
                <div class="col-md-6">
                    <x-form.input label="Port" wire:model.defer="folder.harbor" required></x-form.input>
                </div>
                <div class="col-md-6">
                    <x-form.select2 label="Pays" wire:model="folder.country" :options="countries()"
                                   required placeholder="Selectionner le pays"></x-form.select2>
                </div>
                <div class="col-md-9">
                    <x-form.select2-ajax label="Designation" wire:model="selectedProducts" :selectedOptions="$products" multiple routeName="getProducts"
                                         id="products" required placeholder="Rechercher les produits"></x-form.select2-ajax>
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
                    <h5>Joindre des documents</h5>
                    <div class="table-responsive table-bordered-">
                        <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">#</th>
                                <th style="width: 30%;">Type de document</th>
                                <th style="width: 30%;">Numéro du document</th>
                                <th style="width: 30%;">Fichier jointe</th>
                                <th class="text-center" style="width: 5%">
                                    <button wire:click.prevent="addDocument" title="Ajouter" class="btn btn-sm btn-primary w-100-">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($documents as $i => $document)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>
                                        <select wire:model.defer="documents.{{$i}}.type_id" class="form-control px-1" required>
                                            <option value="">-- Selectionner un type --</option>
                                            @foreach($documentTypes as $value => $type)
                                                <option value="{{$value}}">{{ $type }}</option>
                                            @endforeach
                                        </select>
                                        @error("documents.$i.type_id") <span class="text-xs text-danger">{{ $message }}</span> @enderror
                                    </td>
                                    <td>
                                        <input type="text" wire:model.defer="documents.{{$i}}.number" class="form-control px-1" required>
                                        @error("documents.$i.number") <span class="text-xs text-danger">{{ $message }}</span> @enderror
                                    </td>
                                    <td class="align-middle">
                                        @if($document['attach_file_path'])
                                            <button wire:click="downloadDocumentFile({{$document['id']}})" class="btn btn-sm btn-success">
                                                <i class="fas fa-download"></i> Telecharger
                                            </button>
                                            <button wire:click="deleteDocumentFile({{$document['id']}})" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Supprimer
                                            </button>
                                        @else
                                            <input type="file" wire:model.lazy="documentsFiles.{{$i}}" class="form-control px-1" required>
                                            @error("documentsFiles.$i") <span class="text-xs text-danger">{{ $message }}</span> @enderror
                                        @endif
                                    </td>
                                    <td class="text-center" style="padding-right: 0.3rem; width: 5px">
                                        <button wire:click.prevent="removeDocument('{{$i}}')" class="btn btn-danger btn-sm" title="Supprimer cette ligne">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @error('documents')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            @if($folder->hasLta())
            <hr>
                <div class="row">
                    <div class="col-12">
                        <h5>Ajouter les details des conteneurs et colis</h5>
                        <div class="table-responsive table-bordered-">
                            <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                                <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%">#</th>
                                    <th style="width: 25%;">Type de conteneur</th>
                                    <th style="width: 20%;">Numero du conteneur</th>
                                    <th style="width: 10%;">Poids</th>
                                    <th style="width: 20%;">Nombre de colis</th>
                                    <th style="width: 15%">Date d'arrivé</th>
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
                                            <select wire:model.defer="containers.{{$i}}.type_id" class="form-control px-1" required>
                                                <option value="">-- Selectionner un type --</option>
                                                @foreach($containerTypes as $value => $type)
                                                    <option value="{{$value}}">{{ $type }}</option>
                                                @endforeach
                                            </select>
                                            @error("containers.$i.type_id") <span class="text-xs text-danger">{{ $message }}</span> @enderror
                                        </td>
                                        <td>
                                            <input type="text" wire:model.defer="containers.{{$i}}.number" class="form-control px-1" required>
                                            @error("containers.$i.number") <span class="text-xs text-danger">{{ $message }}</span> @enderror
                                        </td>
                                        <td class="align-middle">
                                            <input type="number" wire:model.defer="containers.{{$i}}.weight" wire:change="setTotalWeight" step="000.00" class="form-control px-1" required>
                                            @error("containers.$i.weight") <span class="text-xs text-danger">{{ $message }}</span> @enderror
                                        </td>
                                        <td class="align-middle">
                                            <input type="text" wire:model.defer="containers.{{$i}}.package_number" class="form-control px-1" required>
                                            @error("containers.$i.package_number") <span class="text-xs text-danger">{{ $message }}</span> @enderror
                                        </td>
                                        <td class="align-middle">
                                            <input type="date" wire:model.defer="containers.{{$i}}.arrival_date" class="form-control px-1" required>
                                            @error("containers.$i.arrival_date") <span class="text-xs text-danger">{{ $message }}</span> @enderror
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
                            @error('containers')<div class="text-danger">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            @endif
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
        <x-slot name="footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                {{ __('Close') }}
            </button>
            <button wire:click="addNewProduct" class="btn btn-primary me-2">
                <i class="fa fa-check-circle"></i> {{ __('Save') }}
            </button>
        </x-slot>
    </x-form-modal>
</div>
@push('scripts')
    @if($folder->id)
        <script>
            $(document).ready(function() {
                $('#customer').select2().val(@this.get({{$folder->customer_id}})).trigger('change.select2');
            });
        </script>
    @endif
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
