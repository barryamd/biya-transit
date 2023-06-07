@props(['icon' => ''])
<div class="input-group mb-3">
    <span class="input-group-prepend">
        <button type="button" class="btn btn-default" disabled><i class="fas fa-{{$icon}}"></i></button>
    </span>
    <input {{ $attributes }} class='form-control'>
</div>
