<div class="btn-group m-0">
    <button type="button" class="btn btn-sm btn-primary dropdown-toggle m-0" data-toggle="dropdown" aria-expanded="false">
        Actions
    </button>
    <div class="dropdown-menu" style="">
        @if($showRouteName)
            <a class="dropdown-item btn btn-primary btn-sm" href="{{ route($showRouteName, $id) }}">
                <i class="fas fa-folder"></i>
                {{ __('View') }}
            </a>
            <div class="dropdown-divider"></div>
        @endif
        @if($editRouteName)
        <a class="dropdown-item btn btn-info btn-sm" href="{{ route($editRouteName, $id) }}">
            <i class="fas fa-pencil-alt"></i>
            {{ __('Edit') }}
        </a>
        <div class="dropdown-divider"></div>
        @endif
        <a wire:click.prevent="delete({{ $id }})" type="button" class="dropdown-item btn btn-danger btn-sm">
            <i class="fas fa-trash"></i>
            {{ __('Delete') }}
        </a>
    </div>
</div>
{{--
<a type="button" class="dropdown-item btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-sm-{{ $id }}">
    <i class="fas fa-trash"></i>
    {{ __('Delete') }}
</a>
<div class="modal fade" id="modal-sm-{{ $id }}">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    {{ __('Delete resource') }} n° {{ $id }}
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ __('Are you sure you want to delete this resource?')}}
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">{{ __('No') }}</button>
                <button wire:click.prevent="delete({{ $id }})" type="button" class="btn btn-sm btn-danger">{{ __('Yes') }}</button>
            </div>
        </div>
    </div>
</div>
--}}
