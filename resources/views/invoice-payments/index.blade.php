@section('title', 'Paiements des factures')
<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-body p-2 pb-3">
                    <livewire:invoice-payment-table/>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
