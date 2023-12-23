<div>
    <div class="col-md-12">
        <h4>Les details de la livraison</h4>
        @can('add-delivery-details')
            <div class="row">
                <div class="col-md-6">
                    <x-form.date label="Date de livraison" wire:model.defer="delivery.date" required></x-form.date>
                </div>
                <div class="col-md-6">
                    <x-form.input label="Lieu de livraison" wire:model.defer="delivery.place" required></x-form.input>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        @if($delivery->exit_file_path)
                            <label>Bon de sorti du conteneur</label>
                            <div class="">
                                <button wire:click="downloadFile('deliveries', 'exit_file_path')" class="btn btn-success">
                                    <i class="fas fa-download"></i> Telecharger
                                </button>
                                <button wire:click="deleteFile('deliveries', 'exit_file_path')" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </div>
                        @else
                            <x-form.file-upload label="Bon de sorti" wire:model.lazy="deliveryExitFile"></x-form.file-upload>
                            @error('deliveryExitFile')<div class="text-danger">{{ $message }}</div> @enderror
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        @if($delivery->return_file_path)
                            <label>Bon de retour</label>
                            <div class="">
                                <button wire:click="downloadFile('deliveries', 'return_file_path')" class="btn btn-success">
                                    <i class="fas fa-download"></i> Telecharger
                                </button>
                                <button wire:click="deleteFile('deliveries', 'return_file_path')" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </div>
                        @else
                            <x-form.file-upload label="Bon de retour" wire:model.lazy="deliveryReturnFile"></x-form.file-upload>
                            @error('deliveryReturnFile')<div class="text-danger">{{ $message }}</div>@enderror
                        @endif
                    </div>
                </div>
                <div class="col-12">
                    <h5>Transporteurs</h5>
                    <div class="table-responsive table-bordered-">
                        <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                            <thead>
                            <tr>
                                <th>Conteneur</th>
                                <th>Immatriculation du vehicule</th>
                                <th>Marque du vehicule</th>
                                <th>Chauffeur</th>
                                <th>Numéro du chauffeur</th>
                                <th>
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#transporterFormModal" title="Ajouter un transporteur">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($transporterContainers as $container)
                                <tr>
                                    <td>{{ $container->number }}</td>
                                    <td>{{ $container->transporter->numberplate }}</td>
                                    <td>{{ $container->transporter->marque }}</td>
                                    <td>{{ $container->transporter->driver_name }}</td>
                                    <td>{{ $container->transporter->driver_phone }}</td>
                                    <td>
                                        <button wire:click="editTransporter({{ $container->id }})" class="btn btn-sm btn-warning" title="Modifier le transporteur">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-danger" colspan="6">
                                        <p>Aucun transporteur n'a été ajouté au dossier</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br>
            <button class="btn btn-primary nextBtn float-right" wire:click="submitDeliveryDetailsStep" type="button">Sauvegarder</button>
        @else
            <p>Désolé! Vous avez pas les permissions pour efféctuer ces actions.</p>
        @endcan
        <button class="btn btn-secondary" wire:click="setStep(4)" type="button"><i class="fas fa-arrow-left"></i> Précedent</button>
    </div>
    <x-form-modal id="transporterFormModal" submit="addTransporter" title="Ajouter un nouveau transporteur">
        <x-slot name="content">
            <x-form.select2-dropdown label="Transporteur" wire:model="transporter" routeName="getTransporters" id="transporter"
                                     parentId="transporterFormModal" placeholder="Rechercher le transporteur" required></x-form.select2-dropdown>
            @if(!$isEditMode)
                <x-form.select label="Conteneur" wire:model.lazy="container" :options="$containers" required></x-form.select>
            @endif
        </x-slot>
        <x-slot name="footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                {{ __('Close') }}
            </button>
            <button wire:click="addTransporter" class="btn btn-primary me-2">
                <i class="fa fa-check-circle"></i> {{ __('Save') }}
            </button>
        </x-slot>
    </x-form-modal>
</div>
