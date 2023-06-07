@props(['data', 'title' => ''])
<x-card :title="$title">

    {{ $slot }}

    <x-slot name="footer">
        @isset($footer)
            {{ $footer }}
        @else
            <x-cancel-button class="float-left">{{__('Back')}}</x-cancel-button>
            <a href="edit" class="btn btn-primary float-right">{{__('Edit')}}</a>
        @endisset
    </x-slot>
</x-card>

