@section('title', 'Traitement du dossier : ' . $folder->number)
<div>
    <x-card>
        <div class="stepwizard">
            <div class="stepwizard-row setup-panel">
                <div class="multi-wizard-step">
                    <a href="#step-2" type="button" wire:click="setStep(1)"
                       class="btn {{ $currentStep != 1 ? 'btn-default' : 'btn-primary' }}"
                       @if(!auth()->user()->can('add-exoneration')) disabled="disabled" @endif>1</a>
                    <p>Exonérations</p>
                </div>
                <div class="multi-wizard-step">
                    <a href="#step-1" type="button" wire:click="setStep(2)"
                       class="btn {{ $currentStep != 2 ? 'btn-default' : 'btn-primary' }}"
                       @if(!auth()->user()->can('add-ddi-opening')) disabled="disabled" @endif>2</a>
                    <p>Ouverture DDI</p>
                </div>
                <div class="multi-wizard-step">
                    <a href="#step-3" type="button" wire:click="setStep(3)"
                       class="btn {{ $currentStep != 3 ? 'btn-default' : 'btn-primary' }}"
                       @if(!auth()->user()->can('add-declaration')) disabled="disabled" @endif>3</a>
                    <p>Déclarations</p>
                </div>
                <div class="multi-wizard-step">
                    <a href="#step-4" type="button" wire:click="setStep(4)"
                       class="btn {{ $currentStep != 4 ? 'btn-default' : 'btn-primary' }}"
                       @if(!auth()->user()->can('add-delivery-note')) disabled="disabled" @endif>4</a>
                    <p>Bons de livraisons</p>
                </div>
                <div class="multi-wizard-step">
                    <a href="#step-5" type="button" wire:click="setStep(5)"
                       class="btn {{ $currentStep != 5 ? 'btn-default' : 'btn-primary' }}"
                       @if(!($declaration->id || auth()->user()->can('add-delivery-details'))) disabled="disabled" @endif>5</a>
                    <p>Détails de la livraison</p>
                </div>
            </div>
        </div>

        <div class="row setup-content {{ $currentStep != 1 ? 'd-none' : '' }}" id="step-2">
            @include('folders._process-forms.exonerations')
        </div>

        <div class="row setup-content {{ $currentStep != 2 ? 'd-none' : '' }}" id="step-1">
            @include('folders._process-forms.ddi-opening')
        </div>

        <div class="row setup-content {{ $currentStep != 3 ? 'd-none' : '' }}" id="step-3">
            @include('folders._process-forms.declarations')
        </div>

        <div class="row setup-content {{ $currentStep != 4 ? 'd-none' : '' }}" id="step-4">
            @include('folders._process-forms.delivery-notes')
        </div>

        <div class="row setup-content {{ $currentStep != 5 ? 'd-none' : '' }}" id="step-5">
            @include('folders._process-forms.delivery-details')
        </div>
    </x-card>
</div>

@push('styles')
    <style>
        .multi-wizard-step p {
            margin-top: 12px;
        }
        .stepwizard-row {
            display: table-row;
        }
        .stepwizard {
            display: table;
            position: relative;
            width: 100%;
        }
        .multi-wizard-step button[disabled] {
            filter: alpha(opacity=100) !important;
            opacity: 1 !important;
        }
        .stepwizard-row:before {
            top: 14px;
            bottom: 0;
            content: " ";
            width: 100%;
            height: 1px;
            z-order: 0;
            position: absolute;
            background-color: #fefefe;
        }
        .multi-wizard-step {
            text-align: center;
            position: relative;
            display: table-cell;
        }
    </style>
@endpush
