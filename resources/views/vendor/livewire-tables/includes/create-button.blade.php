{{--@hasanyrole($roles)--}}
@can($permission)
@isset($route)
    <div class="ml-0 ml-md-2 mt-3 mt-md-0">
        <a href="{{ route($route) }}" class="btn btn-primary d-block w-100 d-md-inline" title="{{$title}}">
            <span class="fas fa-plus"></span>
        </a>
    </div>
@endisset
@isset($modal)
    <div class="ml-0 ml-md-2 mt-3 mt-md-0">
        <button class="btn btn-primary d-block w-100 d-md-inline" data-toggle="modal" data-target="#{{$modal}}" title="{{$title}}">
            <span class="fas fa-plus"></span>
        </button>
    </div>
@endisset
{{--@endhasanyrole--}}
@endcan
