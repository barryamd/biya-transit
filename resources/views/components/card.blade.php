@props([ 'outline' => true, 'type' => 'primary', 'title'])
<div class="card @if($outline && $type != 'default') card-outline @endif card-{{ $type }}">
    @if(isset($title))
        <div class="card-header">
            <h3 class="card-title">{{ __($title) }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
    @elseif(isset($header))
        <div class="card-header">
            {{ $header }}
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
    @if(isset($footer))
        <div class="card-footer" style="display: block;">
            {{ $footer }}
        </div>
    @endif
</div>
