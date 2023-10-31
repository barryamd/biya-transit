<div class="btn-group btn-group-sm">
    @can('update-charge')
        <a href="{{ route('folder-charges.show', $row->id) }}" class='btn text-warning text-lg' title="{{__('Edit') }}"><i class='fas fa-edit'></i></a>
    @endcan
</div>
