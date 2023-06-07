@props([
    'title' => config('titles.'.Route::currentRouteName()),
    'createRoute' => explode('.', Route::currentRouteName())[0].'.create',
    'createText' => config('titles.'.Route::currentRouteName().'new')
])
<div class="card card-outline- card-default">
    <div class="card-header">
        <h3 class="card-title">{{ __($title) }}</h3>
        <div class="card-tools">
            @if('createRoute' != '')
            <a href="{{ route($createRoute) }}" type="button" class="btn btn-tool btn-sm btn-primary">
                <span class="fas fa-plus"></span>
                {{ __($createText) }}
            </a>
            @endif
            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
        </div>
    </div>
    <div class="card-body p-2 pb-3" style="display: block;">
        {{ $slot }}
    </div>
</div>
