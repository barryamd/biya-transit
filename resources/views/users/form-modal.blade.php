<x-form-modal id="userFormModal" size="lg" submit="save" title="Nouveau utilisateur">
    <x-slot name="title">
        @if($isEditMode)
            Modifier les infos de l'utilisateur
        @else
            Ajouter un nouveau utilisateur
        @endif
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-md-6">
                <x-form.input label="Prénom" wire:model.defer="user.first_name" required></x-form.input>
            </div>
            <div class="col-md-6">
                <x-form.input label="Nom" wire:model.defer="user.last_name" required></x-form.input>
            </div>

            <div class="col-md-6">
                <x-form.input label="Date de naissance" wire:model.defer="user.birth_date"  type="date" required></x-form.input>
            </div>
            <div class="col-md-6">
                <x-form.input label="Lieu de naissance" wire:model.defer="user.birth_place" required></x-form.input>
            </div>

            <div class="col-md-6">
                <x-form.input label="Numéro de téléphone" wire:model.defer="user.phone_number" required></x-form.input>
            </div>
            <div class="col-md-6">
                <x-form.input label="Adresse Email" type="email" wire:model.defer="user.email" required></x-form.input>
            </div>

            <div class="col-md-6">
                <x-form.password label="Password" wire:model.defer="password" autocomplete="new-password" required></x-form.password>
            </div>
            <div class="col-md-6">
                <x-form.password label="Password confirmation" wire:model.defer="password_confirmation" autocomplete="new-password" required></x-form.password>
            </div>

            <div class="col-md-6">
                <x-form.select2 label="Role" wire:model.defer="role" :options="$roles" placeholder="Séléctionner le rôle" required></x-form.select2>
            </div>
            <div class="col-md-6">
                <x-form.textarea label="Adresse" wire:model.defer="user.address" required></x-form.textarea>
            </div>
        </div>
    </x-slot>
</x-form-modal>
