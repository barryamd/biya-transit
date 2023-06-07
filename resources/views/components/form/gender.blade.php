@props([
    'name'  => 'gender',
    'id'    => '',
    'label' => '',
    'maleValue' => '0',
    'femaleValue' => '1',
    'value' => 0
])

<div class="form-group">
    <label for="{{ $name }}" class="form-label">{{ __($label) }}: <span class="text-danger">*</span></label>
    <div class="d-flex align-items-center">
        <div class="form-check me-10">
            <label class="form-label" for="maleOption">{{ __('messages.user.male') }}</label>&nbsp;&nbsp;
            <input type='radio' name='{{ $name }}' id='maleOption' value='{{ $maleValue }}' checked="checked" class="form-check-input">
        </div>
        <div class="form-check me-10">
        <label class="form-label" for="maleOption">{{ __('messages.user.female') }}</label>&nbsp;&nbsp;
            <input type='radio' name='{{ $name }}' id=femaleOption' value='{{ $femaleValue }}'
                   @if ($value == $femaleValue) checked="checked" @endif class="form-check-input">
        </div>
    </div>
</div>
