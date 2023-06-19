<div class="btn-group btn-group-sm">
    @role(Admin')
    {{--    <a href="{{ route('customers.details', $row->id) }}" class='btn text-info text-lg' title="{{__('Detail') }}"><i class='fas fa-eye'></i></a>--}}
    <button wire:click="openEditModal({{ $row->id }}, 'customerFormModal')" class='btn text-primary text-lg' title="{{__('Edit') }}"><i class='fas fa-edit'></i></button>
    <button wire:click="delete({{ $row->id }})" class="btn text-danger text-lg" title="{{__('Delete') }}"><i class="fas fa-trash"></i></button>
    @endrole
</div>
