@props(['state'])
<span class="badge {{ $state ? 'badge-success' : 'badge-danger' }}">{{ __($slot) }}</span>
