<div class="d-flex align-items-center mt-2">
    @if(!empty($value))
        <p class="cur-margin">  {{ number_format($value, 0, ',', ' ').' '.getCurrencySymbol() }}</p>
    @else
        N/A
    @endif
</div>

