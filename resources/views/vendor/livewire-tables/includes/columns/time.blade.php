@if($value === null)
    N/A
@else
    <div class="badge bg-light-info">
        <div class="mb-2">{{ \Carbon\Carbon::parse($value)->isoFormat('LT')}}</div>
        {{--<div class="mb-2">{{ \Carbon\Carbon::parse($value)->format('h:i A')}}</div>--}}
    </div>
@endif
