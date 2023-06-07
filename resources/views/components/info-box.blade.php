@props([ 'type', 'number', 'text', 'icon', 'route'])
<div class="info-box">
    <span class="info-box-icon bg-{{ $type }} elevation-1"><i class="{{ $icon }}"></i></span>

    <div class="info-box-content">
        <span class="info-box-text">{{ __($text) }}</span>
        <span class="info-box-number">
            {{ $number }}
        </span>
    </div>
</div>
