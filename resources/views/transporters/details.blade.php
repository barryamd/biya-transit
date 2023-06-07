<x-show-section title="Informations du client">
    <div class="row">
        <div class="col-12 col-sm-8">
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <tbody>
                    <tr>
                        <th style="width:40%">Type de client:</th>
                        <td>{{ $customer->type }}</td>
                    </tr>
                    <tr>
                        <th style="width:40%">Code client:</th>
                        <td>{{ $customer->code }}</td>
                    </tr>
                    <tr>
                        <th style="width:40%">Nom du client:</th>
                        <td>{{ $customer->name }}</td>
                    </tr>
                    <tr>
                        <th style="width:40%">Adresse email:</th>
                        <td>{{ $customer->email }}</td>
                    </tr>
                    <tr>
                        <th style="width:40%">Numéro de téléphone:</th>
                        <td>{{ $customer->phone }}</td>
                    </tr>
                    <tr>
                        <th style="width:40%">Adresse:</th>
                        <td>{{ $customer->address }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12 col-sm-4">
        </div>
    </div>
</x-show-section>

<x-card title="Les achats du clients">
    <livewire:back.customers.sales-report :customer="$customer->id" />
</x-card>

<x-card title="Les reparations du clients">
    <livewire:back.customers.reparations-report-table :customer-id="$customer->id" />
</x-card>

<x-card title="Les retours d'achats du clients">
    <livewire:back.customers.sale-returns-report :customer="$customer->id" />
</x-card>
