@section('title', "Liste des clients")
<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-body p-2 pb-3" style="display: block;">
                    <livewire:customer-table/>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
