@php($chargeType = Route::current()->uri())
@section('title')
    @if($chargeType == 'current-charges')
        Charges courantes
    @else
        Charges occasionnelles
    @endif
@endsection
<x-app-layout>
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-body p-2 pb-3" style="display: block;">
                    <livewire:charge-table :type="$chargeType" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
