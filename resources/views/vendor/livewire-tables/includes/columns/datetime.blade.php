@if($value === null)
    N/A
@else
    <div class="badge bg-light-info">
        <div class="mb-2">{{ \Carbon\Carbon::parse($value)->isoFormat('LT')}}</div>
        {{--<div class="mb-2">{{ \Carbon\Carbon::parse($value)->format('h:i A')}}</div>--}}
        <div>{{ \Carbon\Carbon::parse($value)->isoFormat('Do MMMM YYYY')}}</div>
        {{--<div>{{ \Carbon\Carbon::parse($value)->translatedFormat('jS M, Y')}}</div>--}}
    </div>
@endif
