@section('title', 'Les factures')
<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-body p-2 pb-3" style="display: block;">
                    <livewire:invoice-table />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
