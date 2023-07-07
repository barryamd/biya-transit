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
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    </div>
                </div>
                <div class="card-body p-2 pb-3" style="display: block;">
                    @if($routeName == 'users.index')
                        <livewire:user-table/>
                    @elseif($routeName == 'roles.index')
                        <livewire:role-table/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
