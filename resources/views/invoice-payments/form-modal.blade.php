<x-form-modal id="paymentFormModal" size="lg" submit="savePayment">
    <x-slot name="title">
        Effectuer un paiement
    </x-slot>
    <x-slot name="content">
        <div class="row">
            <div class="col-sm-6">
                <x-form.select2-dropdown label="Dossier" wire:model="payment.folder_id" routeName="getFolders"
                                                parentId="paymentFormModal" id="folder" :disabled="$payment->id">
                </x-form.select2-dropdown>
            </div>
            <div class="col-sm-6">
                <div class="float-right">
                    <strong> Montant: </strong>
                    <span class="lead text-bold" style="color: #28a745;font-size:16px">{{ moneyFormat($invoice_amount) }}</span>
                </div>
                <x-form.select label="Facture à payée" wire:model.lazy="payment.invoice_id" :options="[]"
                               placeholder="Séléctionner la facture à payer" id="invoice" required></x-form.select>
            </div>
            <div class="col-sm-6">
                <x-form.input label="Montant du paiement" wire:model.lazy="payment.amount" required></x-form.input>
            </div>
            <div class="col-sm-6">
                <x-form.input label="Montant restant" wire:model.defer="due_amount" type="number" disabled></x-form.input>
            </div>
            <div class="col-sm-6">
                <x-form.input label="Date de paiement" wire:model.defer="payment.created_at" type="date" required></x-form.input>
            </div>
            <div class="col-sm-6">
                <x-form.select label="Mode de paiement" wire:model="payment.type" :options="aPaymentMethods()" required></x-form.select>
            </div>
            @if($payment->type == 'cheque')
                <div class="col-sm-6">
                    <x-form.input label="Numero de chèque" wire:model.defer="payment.check_number" required></x-form.input>
                </div>
                <div class="col-sm-6">
                    <x-form.input label="Date du chèque" wire:model.defer="payment.date" type="date" required></x-form.input>
                </div>
            @endif
            @if($payment->type == 'virement')
                <div class="col-sm-6">
                    <x-form.input label="Banque" wire:model.defer="payment.bank" required></x-form.input>
                </div>
                <div class="col-sm-6">
                    <x-form.input label="Date execution" wire:model.defer="payment.date" type="date" required></x-form.input>
                </div>
            @endif
            <div class="col-sm-12">
                <x-form.textarea label="Note de paiement" wire:model.defer="payment.note"></x-form.textarea>
            </div>
        </div>
    </x-slot>
</x-form-modal>
@push('scripts')
<script>
    Livewire.on('setInvoices', data => $("#invoice").html(data).trigger('change'))
    Livewire.on('setFolder', data => {
        $('#folder')
            .append(new Option(data[1], data[0], true, true))
            .trigger({
                type: 'select2:select',
                params: {
                    data: data
                }
            });
    })
    Livewire.on('setInvoice', data => {
        $('#invoice')
            .append(new Option(data[1], data[0], true, true))
            .trigger({
                type: 'select2:select',
                params: {
                    data: data
                }
            });
    })
</script>
@endpush
