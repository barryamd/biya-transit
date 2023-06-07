@if($value === null)
    N/A
@else
    <div class="truncate my-tooltip tooltip-on-truncate">
        <span>
            {{ str_repeat($value, 30) }}
        </span>
    </div>
@endif
