<div class="col-md-12">
    <h4>
        Déclarations
        @can('add-declaration')
        <button class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#declarationFormModal" title="Ajouter une déclaration">
            <i class="fa fa-plus"></i>
        </button>
        @endcan
    </h4>
    @can('add-declaration')
        @forelse($declarations as $i => $item)
            <h5>
                Déclaration n°: {{ $item->number }}
                <div class="float-right">
                    <button wire:click="editDeclaration('{{ $item->id }}')" class="btn btn-sm btn-warning" title="Modifier la déclaration">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button wire:click="deleteDeclaration('{{ $item->id }}')" class="btn btn-sm btn-danger" title="Supprimer la déclaration">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </h5>
            <div class="row">
                <div class="col-md-6">
                    <table class="mb-1 table table-sm table-striped">
                        <tr>
                            <th>Date de declaration</th>
                            <td>{{ dateFormat($item->date) }}</td>
                        </tr>
                        <tr>
                            <th>Bureau de destination</th>
                            <td>{{ $item->destination_office }}</td>
                        </tr>

                        <tr>
                            <th>Verificateur</th>
                            <td>{{ $item->verifier }}</td>
                        </tr>
                        <tr>
                            <th>Copie de la declaration</th>
                            <td>
                                @if($item->declaration_file_path)
                                    <button wire:click="downloadFile('declarations', 'declaration_file_path', {{$item->id}})" class="btn btn-xs btn-success">
                                        <i class="fas fa-download"></i> Telecharger
                                    </button>
                                    <button wire:click="deleteFile('declarations', 'declaration_file_path', {{$item->id}})" class="btn btn-xs btn-danger">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                @else
                                    <span class="text-danger">Ce fichier est obligatoire</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Numéro du bulletin de liquidation</th>
                            <td>{{ $item->liquidation_bulletin }}</td>
                        </tr>
                        <tr>
                            <th>Date de liquidation</th>
                            <td>{{ $item->liquidation_date }}</td>
                        </tr>
                        <tr>
                            <th>Copie du bulletin de liquidation</th>
                            <td>
                                @if($item->liquidation_file_path)
                                    <button wire:click="downloadFile('declarations', 'liquidation_file_path', {{$item->id}})" class="btn btn-xs btn-success">
                                        <i class="fas fa-download"></i> Telecharger
                                    </button>
                                    <button wire:click="deleteFile('declarations', 'liquidation_file_path', {{$item->id}})" class="btn btn-xs btn-danger">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                @else
                                    <span class="text-danger">Ce fichier est obligatoire</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="mb-1 table table-sm table-striped">
                            <tr>
                                <th>Numéro de la quittance</th>
                                <td>{{ $item->receipt_number }}</td>
                            </tr>
                            <tr>
                                <th>Date de la quittance</th>
                                <td>{{ $item->receipt_date }}</td>
                            </tr>
                            <tr>
                                <th>Copie de la quittance</th>
                                <td>
                                    @if($item->receipt_file_path)
                                        <button wire:click="downloadFile('declarations', 'receipt_file_path', {{$item->id}})" class="btn btn-xs btn-success">
                                            <i class="fas fa-download"></i> Telecharger
                                        </button>
                                        <button wire:click="deleteFile('declarations', 'receipt_file_path', {{$item->id}})" class="btn btn-xs btn-danger">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    @else
                                        <span class="text-danger">Ce fichier est obligatoire</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Numéro du bon</th>
                                <td>{{ $item->bon_number }}</td>
                            </tr>
                            <tr>
                                <th>Date du bon</th>
                                <td>{{ $item->bon_date }}</td>
                            </tr>
                            <tr>
                                <th>Copie du bon</th>
                                <td>
                                    @if($item->bon_file_path)
                                        <button wire:click="downloadFile('declarations', 'bon_file_path', {{$item->id}})" class="btn btn-xs btn-success">
                                            <i class="fas fa-download"></i> Telecharger
                                        </button>
                                        <button wire:click="deleteFile('declarations', 'bon_file_path', {{$item->id}})" class="btn btn-xs btn-danger">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    @else
                                        <span class="text-danger">Ce fichier est obligatoire</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                </div>
            </div>
            <hr/>
        @empty
            <span class="text-danger">Les infos de la déclaration sont obligatoires</span>
        @endforelse
    @else
        <p>Désolé! Vous avez pas les permissions pour efféctuer ces actions.</p>
    @endcan
    <div>
        <button class="btn btn-secondary" wire:click="setStep(2)" type="button"><i class="fas fa-arrow-left"></i> Précedent</button>
        <button class="btn btn-secondary float-right" wire:click="setStep(4)" type="button">Suivant <i class="fas fa-arrow-right"></i></button>
    </div>

    <x-form-modal id="declarationFormModal" size="lg" submit="saveDeclaration" title="Ajouter une déclaration">
        <x-slot name="content">
            <div class="row">
                <div class="col-md-4">
                    <x-form.input label="Numéro de declaration" wire:model.defer="declaration.number" required></x-form.input>
                </div>
                <div class="col-md-4">
                    <x-form.date label="Date de declaration" wire:model.defer="declaration.date" required></x-form.date>
                </div>
                <div class="col-md-4">
                    <x-form.input label="Bureau de destination" wire:model.defer="declaration.destination_office" required></x-form.input>
                </div>

                <div class="col-md-4">
                    <x-form.input label="Verificateur" wire:model.defer="declaration.verifier" required></x-form.input>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        @if($declaration->declaration_file_path)
                            <label>Copie de la declaration</label>
                            <div class="">
                                <button wire:click="downloadFile('declarations', 'declaration_file_path', {{$declaration->id}})" class="btn btn-sm btn-success">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button wire:click="deleteFile('declarations', 'declaration_file_path', {{$declaration->id}})" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @else
                            <x-form.file-upload label="Copie de la declaration" wire:model.lazy="declarationFile"></x-form.file-upload>
                            @error('declarationFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                </div>

                <div class="col-md-4">
                    <x-form.input label="Numéro du bulletin de liquidation" wire:model.defer="declaration.liquidation_bulletin"></x-form.input>
                </div>
                <div class="col-md-4">
                    <x-form.date label="Date de liquidation" wire:model.defer="declaration.liquidation_date"></x-form.date>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        @if($declaration->liquidation_file_path)
                            <label>Copie du bulletin de liquidation</label>
                            <div class="">
                                <button wire:click="downloadFile('declarations', 'liquidation_file_path', {{$declaration->id}})" class="btn btn-sm btn-success">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button wire:click="deleteFile('declarations', 'liquidation_file_path', {{$declaration->id}})" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @else
                            <x-form.file-upload label="Copie du bulletin de liquidation" wire:model.lazy="liquidationFile"></x-form.file-upload>
                            @error('liquidationFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <x-form.input label="Numéro de la quittance" wire:model.defer="declaration.receipt_number"></x-form.input>
                </div>
                <div class="col-md-4">
                    <x-form.date label="Date de la quittance" wire:model.defer="declaration.receipt_date"></x-form.date>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        @if($declaration->receipt_file_path)
                            <label>Copie de la quittance</label>
                            <div class="">
                                <button wire:click="downloadFile('declarations', 'receipt_file_path', {{$declaration->id}})" class="btn btn-sm btn-success">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button wire:click="deleteFile('declarations', 'receipt_file_path', {{$declaration->id}})" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @else
                            <x-form.file-upload label="Copie de la quittance" wire:model.lazy="receiptFile"></x-form.file-upload>
                            @error('receiptFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <x-form.input label="Numéro du bon" wire:model.defer="declaration.bon_number"></x-form.input>
                </div>
                <div class="col-md-4">
                    <x-form.date label="Date du bon" wire:model.defer="declaration.bon_date"></x-form.date>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        @if($declaration->bon_file_path)
                            <label>Copie du bon</label>
                            <div class="">
                                <button wire:click="downloadFile('declarations', 'bon_file_path', {{$declaration->id}})" class="btn btn-sm btn-success">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button wire:click="deleteFile('declarations', 'bon_file_path', {{$declaration->id}})" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @else
                            <x-form.file-upload label="Copie du bon" wire:model.lazy="bonFile"></x-form.file-upload>
                            @error('bonFile') <div class="row text-danger"><div class="col-12">{{ $message }}</div></div> @enderror
                        @endif
                    </div>
                </div>
            </div>
        </x-slot>
    </x-form-modal>
</div>
