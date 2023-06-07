@section('title', 'Traitement du dossier : ' . $folder->number)
<div>
    <x-form-section submit="savePaymentDvt" title="Paiement DVT">
        <x-slot name="form">
            <div class="row">
                <div class="col-md-4">
                    <x-form.input label="Numéro de la facture" wire:model.defer="dvtNumber" required></x-form.input>
                </div>
                <div class="col-md-4">
                    <x-form.input label="Montant de la facture" type="number" wire:model.defer="dvtAmount" required></x-form.input>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-form.file-upload label="Fichier de la facture" wire:model.lazy="dvtFile" required></x-form.file-upload>
                        @error('dvtFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="actions">
            <x-submit-button>Sauvegarder</x-submit-button>
        </x-slot>
    </x-form-section>

    <x-form-section submit="savePaymentDdi" title="Paiement DDI">
        <x-slot name="form">
            <div class="row">
                <div class="col-md-4">
                    <x-form.input label="Numéro de la facture" wire:model.defer="ddiNumber" required></x-form.input>
                </div>
                <div class="col-md-4">
                    <x-form.input label="Montant de la facture" type="number" wire:model.defer="ddiAmount" required></x-form.input>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-form.file-upload label="Fichier de la facture" wire:model.lazy="ddiFile" required></x-form.file-upload>
                        @error('ddiFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="actions">
            <x-submit-button>Sauvegarder</x-submit-button>
        </x-slot>
    </x-form-section>

    <x-form-section submit="saveExoneration" title="Exonoration">
        <x-slot name="form">
            <div class="row">
                <div class="col-md-6">
                    <x-form.input label="Montant d'exonoration" type="number" wire:model.defer="exonerationAmount" required></x-form.input>
                </div>
                <div class="col-md-6">
                    <x-form.select2 label="Produits exonorés" wire:model.defer="exonerationProducts" :options="$products" multiple required></x-form.select2>
                </div>
            </div>
        </x-slot>
        <x-slot name="actions">
            <x-submit-button>Sauvegarder</x-submit-button>
        </x-slot>
    </x-form-section>

    <x-form-section submit="savePaymentTm" title="Paiement TM">
        <x-slot name="form">
            <div class="row">
                <div class="col-md-4">
                    <x-form.input label="Numéro de la facture" wire:model.defer="tmNumber" required></x-form.input>
                </div>
                <div class="col-md-4">
                    <x-form.input label="Montant de la facture" type="number" wire:model.defer="tmAmount" required></x-form.input>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-form.file-upload label="Fichier de la facture" wire:model.lazy="tmFile" required></x-form.file-upload>
                        @error('tmFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="actions">
            <x-submit-button>Sauvegarder</x-submit-button>
        </x-slot>
    </x-form-section>

    <x-form-section submit="savePaymentCt" title="Paiement CT">
        <x-slot name="form">
            <div class="row">
                <div class="col-md-4">
                    <x-form.input label="Numéro de la facture" wire:model.defer="ctNumber" required></x-form.input>
                </div>
                <div class="col-md-4">
                    <x-form.input label="Montant de la facture" type="number" wire:model.defer="ctAmount" required></x-form.input>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <x-form.file-upload label="Fichier de la facture" wire:model.lazy="ctFile" required></x-form.file-upload>
                        @error('cTFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="actions">
            <x-submit-button>Sauvegarder</x-submit-button>
        </x-slot>
    </x-form-section>

    <x-form-section submit="saveDeliveries" title="Les details de la livraison">
        <x-slot name="form">
            <div class="row">
                <div class="col-md-6">
                    <x-form.date label="Date de livraison" wire:model.defer="deliveryDate" required></x-form.date>
                </div>
                <div class="col-md-6">
                    <x-form.input label="Lieu de livraison" wire:model.defer="deliveryPlace" required></x-form.input>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <x-form.file-upload label="Fichier de la facture" wire:model.lazy="deliveryFile" required></x-form.file-upload>
                        @error('deliveryFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <x-form.select2-ajax label="Transporteur" wire:model.defer="transporter" routeName="getTransporters"
                                         required placeholder="Rechercher par la plaque"></x-form.select2-ajax>
                </div>
            </div>
        </x-slot>
        <x-slot name="actions">
            <x-submit-button>Sauvegarder</x-submit-button>
        </x-slot>
    </x-form-section>
</div>

{{--<div class="card" wire:ignore>
    <div class="card-header text-center">
        <ul class="nav nav-tabs card-header-tabs nav-fill" role="tablist">
            <li class="nav-item">
                <a class="nav-link @if($activeTab == 'overview') active @endif"
                   data-toggle="tab" href="#overview">Aperçu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($activeTab == 'dvt') active @endif disabled-"
                   data-toggle="pill" href="#dvt" >Paiement DVT</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($activeTab == 'ddi') active @endif disabled-"
                   data-toggle="pill" href="#dvt" >Paiement DDI</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($activeTab == 'exoneration') active @endif"
                   data-toggle="pill" href="#exoneration">Produits exonorés</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($activeTab == 'tm') active @endif disabled-"
                   data-toggle="pill" href="#tm" >Paiement TM</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($activeTab == 'ct') active @endif disabled-"
                   data-toggle="pill" href="#ct" >Paiement CT</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if($activeTab == 'delivery') active @endif disabled-"
                   data-toggle="pill" href="#delivery" >Livraison</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div id="overview" class="container tab-pane @if($activeTab == 'overview')active @endif">
                Aperçu
            </div>
            <div id="dvt" class="container tab-pane @if($activeTab == 'dvt')active @endif">
            </div>
            <div id="dvt" class="container tab-pane @if($activeTab == 'ddi')active @endif">
                Livraison
            </div>
            <div id="exoneration" class="container tab-pane @if($activeTab == 'exoneration')active @endif">
            </div>
            <div id="tm" class="container tab-pane @if($activeTab == 'tm')active @endif">
                Livraison
            </div>
            <div id="ct" class="container tab-pane @if($activeTab == 'ct')active @endif">
                Livraison
            </div>
            <div id="delivery" class="container tab-pane @if($activeTab == 'delivery')active @endif">
            </div>
        </div>
    </div>
</div>--}}
