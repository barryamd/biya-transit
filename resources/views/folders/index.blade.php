@php
    $table = \Illuminate\Support\Facades\Route::current()->uri();
    $status = null;
    if($table == 'pending-folders')
        $status = 'En attente';
    elseif($table == 'progress-folders')
        $status = 'En cours';
    elseif($table == 'closed-folders')
        $status = 'Fermé';
@endphp
@section('title')
    @if($table == 'folders')
        Tous les dossiers
    @elseif($table == 'pending-folders')
        Les dossiers en attentes
    @elseif($table == 'progress-folders')
        Les dossiers en cours de traitements
    @elseif($table == 'closed-folders')
        Les dossiers fermés
    @endif
@endsection
<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-body p-2 pb-3" style="display: block;">
                    <livewire:folder-table :status="$status" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
