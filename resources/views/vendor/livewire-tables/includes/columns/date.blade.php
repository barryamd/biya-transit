@if($value === null)
    N/A
@else
    <div class="badge bg-light-info">
        <div>{{ \Carbon\Carbon::parse($value)->isoFormat('Do MMMM YYYY')}}</div>
        {{--<div>{{ \Carbon\Carbon::parse($value)->translatedFormat('jS M, Y')}}</div>--}}
    </div>
@endif
