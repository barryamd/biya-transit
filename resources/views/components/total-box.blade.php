@props(['title' => null, 'amount' => null, 'state' => null, 'last' => false])

<div class="description-block {{ $last ? '': 'border-right' }}">
    <span class="description-percentage text-{{ $state }}">
        @if($state == 'success')
            <i class="fas fa-caret-up"></i>
        @elseif($state == 'warning')
            <i class="fas fa-caret-left"></i>
        @elseif($state == 'danger')
            <i class="fas fa-caret-down"></i>
        @endif
        17%
    </span>
    <h5 class="description-header">{{ moneyFormat($amount) }}</h5>
    <span class="description-text">{{ $title }}</span>
</div>
