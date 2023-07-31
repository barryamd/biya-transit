@section('title', 'Tableau de bord')

<div>
    <div class="row">
        <div class="col-lg-3 col-6">
            <x-small-box type="warning" icon="fas fa-folder-plus" text="Dossiers en attentes"
                         :number="$total['pending_folders'] ?? 0" route="pending-folders"></x-small-box>
        </div>
        <div class="col-lg-3 col-6">
            <x-small-box type="primary" icon="fas fa-folder-open" text="Dossiers en cours"
                         :number="$total['process_folders'] ?? 0" route="progress-folders"></x-small-box>
        </div>
        <div class="col-lg-3 col-6">
            <x-small-box type="success" icon="fas fa-folder-closed" text="Dossiers fermés"
                         :number="$total['closed_folders'] ?? 0" route="closed-folders"></x-small-box>
        </div>
        <div class="col-lg-3 col-6">
            <x-small-box type="danger" icon="fas fa-folder-open" text="Dossiers en retards"
                         :number="$total['late_folders'] ?? 0" route="progress-folders"></x-small-box>
        </div>
        <div class="col-lg-3 col-6">
            <x-small-box type="info" icon="fas fa-users" text="Total clients"
                         :number="$total['customers'] ?? 0" route="customers"></x-small-box>
        </div>
    </div>
</div>
