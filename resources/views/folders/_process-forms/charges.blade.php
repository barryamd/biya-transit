<div class="col-12">
    <h4>Charges</h4>
    @can('add-charges')
        <div class="table-responsive table-bordered-">
            <table class="mb-1 table table-sm table-striped table-hover table-head-fixed- text-nowrap-">
                <thead>
                <tr>
                    <th class="text-center" style="width: 5%">#</th>
                    <th style="width: 55%;">Dépense</th>
                    <th style="width: 35%;">Montant</th>
                    <th class="text-center" style="width: 5%">
                        <button wire:click.prevent="addCharge" title="Ajouter" class="btn btn-sm btn-primary w-100-">
                            <i class="fas fa-plus"></i>
                        </button>
                    </th>
                </tr>
                </thead>
                <tbody>
                @forelse($charges as $i => $charge)
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
                @empty
                    <tr>
                        <td class="text-center text-danger" colspan="4">
                            <p>Aucune charge n'a été ajouté au dossier</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <button class="btn btn-primary float-right ml-2" wire:click="submitChargesStep" type="button">Sauvegarder</button>
    @else
        <p>Désolé! Vous avez pas les permissions pour efféctuer ces actions.</p>
    @endcan
    <button class="btn btn-secondary" wire:click="setStep(5)" type="button"><i class="fas fa-arrow-left"></i> Précedent</button>
</div>
