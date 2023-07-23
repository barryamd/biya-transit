<div class="btn-group btn-group-sm">
    {{-- <a href="{{ route('customers.details', $row->id) }}" class='btn text-info text-lg' title="{{__('Detail') }}"><i class='fas fa-eye'></i></a>--}}
    @can('update-transporter')
    <button wire:click="openEditModal({{ $row->id }}, 'customerFormModal')" class='btn text-warning text-lg' title="{{__('Edit') }}"><i class='fas fa-edit'></i></button>
    @endcan
    @can('delete-transporter')
    <button wire:click="delete({{ $row->id }})" class="btn text-danger text-lg" title="{{__('Delete') }}"><i class="fas fa-trash"></i></button>
    @endcan
</div>
