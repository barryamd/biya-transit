@php
    $routeName = Route::currentRouteName();
    if ($routeName == 'users.index')
        $title = "Liste des utilisateurs";
    else
        $title = "Liste des roles";
@endphp

@section('title', $title)

<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card card-outline- card-default">
                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                    <div class="card-tools">
                        @if($routeName == 'users.index')
                            @can('create-user')
                            <x-create-button modalId="createUserModal">Nouveau utilisateur</x-create-button>
                            @endcan
                        @elseif($routeName == 'roles.index')
                            @can('create-role')
                            <x-create-button routeName="roles.create">Nouveau role</x-create-button>
                            @endcan
                        @endif
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    </div>
                </div>
                <div class="card-body p-2 pb-3" style="display: block;">
                    @if($routeName == 'users.index')
                        <livewire:back.users.user-table/>
                    @elseif($routeName == 'roles.index')
                        <livewire:back.users.role-table/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
