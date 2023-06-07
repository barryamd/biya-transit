<div class="row invoice-info">
    <div class="col-7 invoice-col">
        <h4>Infos du client</h4>
        <address>
            <b>Nom: </b> {{ $sale->customer->name }}<br>
            <b>Contact:</b> {{ $sale->customer->phone }}<br>
            <b>Adresse:</b> {{ $sale->customer->address }}<br>
        </address>
    </div>
    <div class="col-5 invoice-col mb-3">
        <b>N°:</b> {{ $sale->number }}<br>
        <b>Date:</b> Conakry, {{ Date::create($sale->created_at)->format('d M Y') }}<br>
    </div>
</div>
