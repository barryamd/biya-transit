<x-form-modal id="createUserModal" size="lg" submit="createNewUser" title="Nouveau utilisateur">
    <x-slot name="content">
        <div class="row">
            <div class="col-md-6">
                <x-form.select2-dropdown-search label="Employé" wire:model="employee" routeName="getEmployees"
                                                parentId="createUserModal" required></x-form.select2-dropdown-search>
            </div>
            <div class="col-md-6">
                <x-form.input label="Username" wire:model.defer="username" required></x-form.input>
            </div>
            <div class="col-md-6">
                <x-form.input label="Email" type="email" wire:model.defer="email" required></x-form.input>
            </div>
            <div class="col-md-6">
                <x-form.password label="Password" wire:model.defer="password" autocomplete="new-password" required></x-form.password>
            </div>
            <div class="col-md-6">
                <x-form.password label="Password confirmation" wire:model.defer="password_confirmation" autocomplete="new-password" required></x-form.password>
            </div>
            <div class="col-md-6">
                <x-form.select2 label="Roles" wire:model.defer="role" :options="$roles" placeholder="Séléctionner les rôles" required></x-form.select2>
            </div>
        </div>
    </x-slot>
</x-form-modal>

<x-form-modal id="editRoleModal" submit="updateUseRole" title="Modifier les rôles de l'utilisateur">
    <x-slot name="content">
        <div class="row">
            <div class="col-12">
                <x-form.select label="Roles" wire:model.defer="role" :options="$roles"
                                placeholder="Séléctionner les rôles" multiple required></x-form.select>
            </div>
        </div>
    </x-slot>
</x-form-modal>
