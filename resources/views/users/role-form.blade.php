@section('title')
    @if($role->id)
        Modification du role
    @else
        Ajouter un nouveau role
    @endif
@endsection
<x-form-section submit="save">
    <x-slot name="form">
        <div class="row">
            <div class="col-md-6">
                <x-form.input label="Role" wire:model.defer="role.name" required></x-form.input>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label>Permissions<span class="text-danger">*</span></label>
                <div class="table-responsive-sm">
                    <table class="table table-sm table-striped">
                        {{--<thead>
                        <tr>
                            <th>#</th>
                            <th>Voir</th>
                            <th>Ajouter</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                        </thead>--}}
                        <tbody>
                        @foreach($tables as $key => $table)
                            <tr>
                                <th>{{ $groupPermissions[$table] }}</th>
                                <td>
                                    @if(array_key_exists('view-'.$table, $permissions))
                                        <x-form.checkbox label="Voir" wire:model.defer="rolePermissions" :value="$permissions['view-'.$table]"></x-form.checkbox>
                                    @endif
                                </td>
                                <td>
                                    @if(array_key_exists('create-'.$table, $permissions))
                                        <x-form.checkbox label="Ajouter" wire:model.defer="rolePermissions" :value="$permissions['create-'.$table]"></x-form.checkbox>
                                    @endif
                                </td>
                                <td>
                                    @if(array_key_exists('update-'.$table, $permissions))
                                        <x-form.checkbox label="Modifier" wire:model.defer="rolePermissions" :value="$permissions['update-'.$table]"></x-form.checkbox>
                                    @endif
                                    @if(array_key_exists('edit-'.$table, $permissions))
                                        <x-form.checkbox label="Modifier" wire:model.defer="rolePermissions" :value="$permissions['edit-'.$table]"></x-form.checkbox>
                                    @endif
                                </td>
                                <td>
                                    @if(array_key_exists('delete-'.$table, $permissions))
                                        <x-form.checkbox label="Supprimer" wire:model.defer="rolePermissions" :value="$permissions['delete-'.$table]"></x-form.checkbox>
                                    @endif
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                        <tr>
                            <th></th>
                            <td></td>
                            <td></td>
                            <td>
                                <x-form.checkbox label="Ajouter DDI" wire:model.defer="rolePermissions" :value="$permissions['add-ddi-opening']"></x-form.checkbox>
                                <x-form.checkbox label="Ajouter Exonération" wire:model.defer="rolePermissions" :value="$permissions['add-exoneration']"></x-form.checkbox>
                                <x-form.checkbox label="Ajouter Déclaration" wire:model.defer="rolePermissions" :value="$permissions['add-declaration']"></x-form.checkbox>
                                <x-form.checkbox label="Ajouter Bon de livraison" wire:model.defer="rolePermissions" :value="$permissions['add-delivery-note']"></x-form.checkbox>
                                <x-form.checkbox label="Ajouter Détails de livraison" wire:model.defer="rolePermissions" :value="$permissions['add-delivery-details']"></x-form.checkbox>
                                <x-form.checkbox label="Fermer un dossier" wire:model.defer="rolePermissions" :value="$permissions['close-folder']"></x-form.checkbox>
                            </td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </x-slot>
</x-form-section>
