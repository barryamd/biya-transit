<div class="col-md-12">
    <h4>Bons de livraison</h4>
    @can('add-delivery-note')
        <div class="table-responsive table-bordered-">
            <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                <thead>
                <tr>
                    <th class="text-center" style="width: 5%">#</th>
                    <th style="width: 20%;">Conteneur<span class="text-danger">*</span></th>
                    <th style="width: 15%;">Bon de CM<span class="text-danger">*</span></th>
                    <th style="width: 20%;">Copie du Bon de CM</th>
                    <th style="width: 15%;">Bon de CT<span class="text-danger">*</span></th>
                    <th style="width: 20%;">Copie du Bon de CT</th>
                    <th class="text-center" style="width: 5%">
                        <button wire:click.prevent="addDeliveryNote" title="Ajouter" class="btn btn-sm btn-primary w-100-">
                            <i class="fas fa-plus"></i>
                        </button>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($deliveryNotes as $i => $deliveryNote)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>
                            <select wire:model.defer="deliveryNotes.{{$i}}.container_id" class="form-control px-1" required>
                                <option value="">-- Selectionner un conteneur --</option>
                                @foreach($containers as $value => $container)
                                    <option value="{{$value}}">{{ $container }}</option>
                                @endforeach
                            </select>
                            @error("deliveryNotes.$i.container_id") <span class="text-xs text-danger">{{ $message }}</span> @enderror
                        </td>
                        <td>
                            <input type="text" wire:model.defer="deliveryNotes.{{$i}}.bcm" class="form-control" required>
                            @error("deliveryNotes.$i.bcm") <span class="text-xs text-danger">{{ $message }}</span> @enderror
                        </td>
                        <td class="align-middle">
                            @if($deliveryNote['bcm_file_path'])
                                <button wire:click="downloadFile('delivery_notes', 'bcm_file_path', {{$deliveryNote['id']}})" class="btn btn-success">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button wire:click="deleteFile('delivery_notes', 'bcm_file_path', {{$deliveryNote['id']}})" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @else
                                <input type="file" wire:model.lazy="bcmFiles.{{$i}}" class="form-control px-1" required>
                                @error('bcmFiles.*') <span class="text-xs text-danger">{{ $message }}</span> @enderror
                            @endif
                        </td>
                        <td>
                            <input type="text" wire:model.defer="deliveryNotes.{{$i}}.bct" class="form-control" required>
                            @error("deliveryNotes.$i.bct") <span class="text-xs text-danger">{{ $message }}</span> @enderror
                        </td>
                        <td class="align-middle">
                            @if($deliveryNote['bct_file_path'])
                                <button wire:click="downloadFile('delivery_notes', 'bct_file_path', {{$deliveryNote['id']}})" class="btn btn-success">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button wire:click="deleteFile('delivery_notes', 'bct_file_path', {{$deliveryNote['id']}})" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @else
                                <input type="file" wire:model.lazy="bctFiles.{{$i}}" class="form-control px-1" required>
                                @error('bctFiles.*') <span class="text-xs text-danger">{{ $message }}</span> @enderror
                            @endif
                        </td>
                        <td class="text-center" style="padding-right: 0.3rem; width: 5px">
                            <button wire:click.prevent="removeDeliveryNote({{$i}})" class="btn btn-danger btn-sm" title="Supprimer cette ligne">
                                <i class="fas fa-times"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            @error('deliveryNotes')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
        <div>
            @can('add-declaration')
                <button class="btn btn-secondary" wire:click="back(3)" type="button">Retourner</button>
            @endcan
            <button class="btn btn-primary nextBtn float-right" wire:click="submitDeliveryNoteStep" type="button">Sauvegarder et Passer</button>
        </div>
    @else
        <p>Désolé! Vous avez pas les permissions pour efféctuer ces actions.</p>
    @endcan
</div>
