@props([ 'type', 'number', 'text', 'number2' => null, 'text2' => '', 'icon', 'route'])
<div class="small-box bg-{{ $type }}">
    <div class="inner">
        <div class="inner">
            <h3>{{ $number }}</h3>
            <p>@lang($text)</p>
        </div>
    </div>
    {{--<div class="inner pb-1">
        <div class="inner">
            <h3>{{ $number }}</h3>
            <p>@lang($text)</p>
        </div>
        <p class="mb-0 text-center">@lang($text)</p>
        <h5 class="text-center">{{ $number }}</h5>
        <p class="mb-0 text-center">@lang($text2)</p>
        <h5 class="text-center">{{ $number2 }}</h5>
    </div>--}}
    <div class="icon my-2 py-0">
        <i class="{{ $icon }}"></i>
    </div>
    <a href="{{ $route }}" class="small-box-footer">@lang('More info') <i class="fas fa-arrow-circle-right"></i></a>
</div>
