@props([
    'required' => '',
    'name' => '',
    'label' => '',
    'value' => '',
])

@if ($label === 'none')

@elseif ($label === '')
    @php
        //remove underscores from name
        $label = str_replace('_', ' ', $name);
        //detect subsequent letters starting with a capital
        $label = preg_split('/(?=[A-Z])/', $label);
        //display capital words with a space
        $label = implode(' ', $label);
        //uppercase first letter and lower the rest of a word
        $label = ucwords(strtolower($label));
    @endphp
@endif

<div class="form-group">
    <div class="row2" io-image-input="true">
        {{ Form::label('image',__('messages.common.profile').(':'), ['class' => 'form-label']) }}
        <div class="d-block">
            <?php
            $style = 'style=';
            $background = 'background-image:';
            ?>

            <div class="image-picker">
                <div class="image previewImage" id="patientPreviewImage"
                {{$style}}"{{$background}} url({{ asset('assets/img/avatar.png')}}">
                <span class="picker-edit rounded-circle text-gray-500 fs-small" title="{{ __('messages.common.profile') }}">
                    <label>
                        <i class="fa-solid fa-pen" id="profileImageIcon"></i>
                        <input type="file" id="patientProfileImage" name="image"
                               class="image-upload d-none profileImage" accept=".png, .jpg, .jpeg, .gif"/>
                        <input type="hidden" name="avatar_remove"/>
                    </label>
                </span>
            </div>
        </div>
    </div>
</div>
