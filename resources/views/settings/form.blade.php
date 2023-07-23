@section('title', 'Paramètres générales')

@can('update-settings')
<x-form-section submit="save" title="Paramètres générales">
    <x-slot name="form">
        <div class="row">
            <div class="col-md-4">
                <x-form.input label="Nom complet" wire:model.lazy="setting.name" required></x-form.input>
            </div>
            <div class="col-md-2">
                <x-form.input label="Abreviation" wire:model.defer="setting.acronym" required></x-form.input>
            </div>
            <div class="col-md-6">
                <x-form.input label="email" wire:model.defer="setting.email"></x-form.input>
            </div>
            <div class="col-md-6">
                <x-form.input label="phone 1" wire:model.defer="setting.phone1" required></x-form.input>
            </div>
            <div class="col-md-6">
                <x-form.input label="phone 2" wire:model.defer="setting.phone2"></x-form.input>
            </div>
            <div class="col-md-6">
                <x-form.input label="phone 3" wire:model.defer="setting.phone3"></x-form.input>
            </div>
            <div class="col-md-6">
                <x-form.textarea label="Address" wire:model.defer="setting.address"></x-form.textarea>
            </div>
            <div class="col-md-6">
                <x-form.input label="BIC" wire:model.defer="setting.bic"></x-form.input>
            </div>
            <div class="col-md-6">
                <x-form.input label="IBAN" wire:model.defer="setting.iban"></x-form.input>
            </div>
            <div class="col-md-6">
                <x-form.input label="Bank" wire:model.defer="setting.bank"></x-form.input>
            </div>
            <div class="col-md-6">
                <x-form.textarea label="Bank Address" wire:model.defer="setting.bank_address"></x-form.textarea>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <x-form.file-upload label="Logo" wire:model="logo"></x-form.file-upload>
                    <div class="row">
                        <div class="col-12">
                            @if ($logo && !$errors->has('logo'))
                                <x-img :src="$logo->temporaryUrl()"></x-img>
                            @elseif ($setting->logo)
                                <x-img :src="asset('uploads/settings/logo.png')"></x-img>
                            @endif
                        </div>
                    </div>
                    @error('logo') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <x-form.file-upload label="Signature" wire:model="signature"></x-form.file-upload>
                    <div class="row">
                        <div class="col-12">
                            @if ($signature && !$errors->has('signature'))
                                <x-img :src="$signature->temporaryUrl()"></x-img>
                            @elseif ($setting->signature)
                                <x-img :src="asset('uploads/settings/signature.jpg')"></x-img>
                            @endif
                        </div>
                    </div>
                    @error('signature') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                </div>
            </div>
{{--            <div class="col-md-12">--}}
{{--                <x-form.text-editor label="Remarques a afficher sur les bon de livraisons" wire:model.defer="setting.delivery_remarks"></x-form.text-editor>--}}
{{--            </div>--}}
{{--            <div class="col-md-12">--}}
{{--                <x-form.text-editor label="Remarques a afficher sur les factures proforma" wire:model.defer="setting.proforma_remarks"></x-form.text-editor>--}}
{{--            </div>--}}
        </div>
    </x-slot>
    <x-slot name="footer">
        <a href="{{ url()->previous() }}" type="button" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
        @can('update-settings')
        <button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> {{ __('Save') }}</button>
        @endcan
    </x-slot>
</x-form-section>
@endcan

@push('styles')
    <!-- summernote -->
{{--    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">--}}
@endpush
@push('scripts')
    <!-- Summernote -->
{{--    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>--}}
@endpush
