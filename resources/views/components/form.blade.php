@props([
    'method' => 'POST',
    'action',
    'hasFiles' => false,
    'model'
])

@php
    $method = strtoupper($method);
@endphp

<form method="{{ $method !== 'GET' ? 'POST' : $method }}" action="{{ $action }}" {!! $hasFiles ? 'enctype="multipart/form-data"' : '' !!} {{ $attributes }}>
    @csrf
    @if (!in_array($method, ['POST', 'GET']))
        @method($method)
    @endif
    {{ $slot }}
</form>

<div class="container-fluid">
    <div class="d-flex flex-column">
        <div class="row">
            <div class="col-12">
                @include('layouts.errors')
            </div>
        </div>
        <div class="card">
            {{Form::hidden('utilsScript',asset('assets/js/int-tel/js/utils.min.js'),['class'=>'utilsScript'])}}
            {{Form::hidden('isEdit',false,['class'=>'isEdit'])}}
            {{Form::hidden('defaultAvatarImageUrl',asset('assets/img/avatar.png'),['class'=>'defaultAvatarImageUrl'])}}
            <div class="card-body p-12">
                {{ Form::open(['route' => 'patients.store', 'files' => 'true', 'id' => 'createPatientForm']) }}
                @include('patients.fields')
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
