<div class="text-center">
    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
        <input type="checkbox" value="1" class="custom-control-input" id="customSwitch{{$row->id}}"
            {{ $value ? 'checked' : ''}} wire:click="enableOrDisable('{{$row->id}}', '{{$column}}')"
        >
        <label class="custom-control-label" for="customSwitch{{$row->id}}"></label>
    </div>
</div>
