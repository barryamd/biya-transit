<div class="col-md-12">
    <h4>Bons de livraison</h4>
    @can('add-delivery-note')
        <div class="row">
            <div class="col-md-6">
                <x-form.input label="Numero Bon de CM" wire:model.defer="folder.bcm" class="form-control" required></x-form.input>
            </div>
            <div class="col-md-6">
                <x-form.input label="Numero Bon de CT" wire:model.defer="folder.bct" class="form-control" required></x-form.input>
            </div>
        </div>
        <div class="table-responsive table-bordered-">
            <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                <thead>
                <tr>
                    <th class="text-center" style="width: 5%">#</th>
                    <th style="width: 45%;">Fichier Bon de CM</th>
                    <th style="width: 45%;">Fichier Bon de CT</th>
                    <th class="text-center" style="width: 5%">
                        <button wire:click.prevent="addDeliveryFile" title="Ajouter" class="btn btn-sm btn-primary w-100-">
                            <i class="fas fa-plus"></i>
                        </button>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($deliveryFiles as $i => $file)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            @if($file['bcm_file_path'])
                                <button wire:click="downloadFile('delivery_files', 'bcm_file_path', {{$file['id']}})" class="btn btn-sm btn-success">
                                    <i class="fas fa-download"></i> Telecharger
                                </button>
                                <button wire:click="deleteFile('delivery_files', 'bcm_file_path', {{$file['id']}})" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            @else
                                <input type="file" wire:model.lazy="bcmFiles.{{$i}}" class="form-control px-1" required>
                                @error('bctFiles.'.$i) <span class="text-xs text-danger">Aucun fichier n'a été chargé</span> @enderror
                            @endif
                        </td>
                        <td class="align-middle">
                            @if($file['bct_file_path'])
                                <button wire:click="downloadFile('delivery_files', 'bct_file_path', {{$file['id']}})" class="btn btn-sm btn-success">
                                    <i class="fas fa-download"></i> Telecharger
                                </button>
                                <button wire:click="deleteFile('delivery_files', 'bct_file_path', {{$file['id']}})" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            @else
                                <input type="file" wire:model.lazy="bctFiles.{{$i}}" class="form-control px-1" required>
                                @error('bctFiles.'.$i) <span class="text-xs text-danger">Aucun fichier n'a été chargé</span> @enderror
                            @endif
                        </td>
                        <td class="text-center" style="padding-right: 0.3rem; width: 5px">
                            <button wire:click.prevent="removeDeliveryFile({{$i}}, {{$file['id']}})" class="btn btn-danger btn-sm" title="Supprimer cette ligne">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @error('deliveryFiles')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <button class="btn btn-primary nextBtn float-right ml-2" wire:click="submitDeliveryNoteStep" type="button">Sauvegarder et Passer</button>
    @else
        <p>Désolé! Vous avez pas les permissions pour efféctuer ces actions.</p>
    @endcan

    <div>
        <button class="btn btn-secondary" wire:click="setStep(3)" type="button"><i class="fas fa-arrow-left"></i> Précedent</button>
        <button class="btn btn-secondary float-right" wire:click="setStep(5)" type="button">Suivant <i class="fas fa-arrow-right"></i></button>
    </div>
</div>
