@props(['submit', 'title' => null, 'model' => null])
<form wire:submit.prevent="{{ $submit }}">
    <div class="card card-outline card-default }}">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body" style="display: block;">
            {{ $form }}
        </div>
        <div class="card-footer" style="display: block;">
            @if (isset($actions))
                {{ $actions }}
            @else
                <a href="{{ url()->previous() }}" type="button" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> {{ __('Back') }}</a>
                <button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> {{ __('Save') }}</button>
            @endif
        </div>
    </div>
</form>
