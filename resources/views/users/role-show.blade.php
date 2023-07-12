@section('title', 'Details du role')
<x-show-section title="Details du role" >
    <div class="row">
        <div class="col-md-6">
            <x-form.input label="Role" wire:model.defer="role" disabled></x-form.input>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Permissions</label>
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
                                    <x-form.checkbox label="Voir" wire:model.defer="rolePermissions" :value="$permissions['view-'.$table]" disabled></x-form.checkbox>
                                @endif
                            </td>
                            <td>
                                @if(array_key_exists('create-'.$table, $permissions))
                                    <x-form.checkbox label="Ajouter" wire:model.defer="rolePermissions" :value="$permissions['create-'.$table]" disabled></x-form.checkbox>
                                @endif
                            </td>
                            <td>
                                @if(array_key_exists('update-'.$table, $permissions))
                                    <x-form.checkbox label="Modifier" wire:model.defer="rolePermissions" :value="$permissions['update-'.$table]" disabled></x-form.checkbox>
                                @endif
                                @if(array_key_exists('edit-'.$table, $permissions))
                                    <x-form.checkbox label="Modifier" wire:model.defer="rolePermissions" :value="$permissions['edit-'.$table]" disabled></x-form.checkbox>
                                @endif
                            </td>
                            <td>
                                @if(array_key_exists('delete-'.$table, $permissions))
                                    <x-form.checkbox label="Supprimer" wire:model.defer="rolePermissions" :value="$permissions['delete-'.$table]" disabled></x-form.checkbox>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <th>Gestion des dossiers</th>
                        <td>
                            <x-form.checkbox label="Voir un dossier" wire:model.defer="rolePermissions" :value="$permissions['view-folder']" disabled></x-form.checkbox>
                        </td>
                        <td>
                            <x-form.checkbox label="Créer un dossier" wire:model.defer="rolePermissions" :value="$permissions['create-folder']" disabled></x-form.checkbox>
                        </td>
                        <td>
                            <x-form.checkbox label="Ajouter DDI" wire:model.defer="rolePermissions" :value="$permissions['add-ddi-opening']" disabled></x-form.checkbox>
                            <x-form.checkbox label="Ajouter Exonération" wire:model.defer="rolePermissions" :value="$permissions['add-exoneration']" disabled></x-form.checkbox>
                            <x-form.checkbox label="Ajouter Déclaration" wire:model.defer="rolePermissions" :value="$permissions['add-declaration']" disabled></x-form.checkbox>
                            <x-form.checkbox label="Ajouter Bon de livraison" wire:model.defer="rolePermissions" :value="$permissions['add-delivery-note']" disabled></x-form.checkbox>
                            <x-form.checkbox label="Ajouter Détails de livraison" wire:model.defer="rolePermissions" :value="$permissions['add-delivery-details']" disabled></x-form.checkbox>
                            <x-form.checkbox label="Fermer un dossier" wire:model.defer="rolePermissions" :value="$permissions['close-folder']"></x-form.checkbox>
                        </td>
                        <td>
                            <x-form.checkbox label="Supprimer un dossier" wire:model.defer="rolePermissions" value="delete-folder" disabled></x-form.checkbox>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-show-section>
