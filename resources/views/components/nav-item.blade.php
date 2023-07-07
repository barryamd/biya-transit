@props(['item'])
<li class="nav-item">
    <a href="{{ route($item['route']) }}" class="nav-link {{ currentRouteActive($item['route']) }}">
        <i class="nav-icon fa-solid fa-{{$item['icon']}}"></i>
        <p>{{ __($item['title']) }}</p>
    </a>
</li>
