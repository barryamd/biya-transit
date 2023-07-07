@props(['menu'])
<li class="nav-item has-treeview {{ menuOpen($menu['children']) }}">
    <a href="#" class="nav-link ">
        <i class="nav-icon fas fa-{{ $menu['icon'] }}"></i>
        <p>
            {{ __($menu['title']) }}
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @foreach($menu['children'] as $child)
            @can($child['permission'])
                <x-nav-item :item="$child"></x-nav-item>
            @endcan
        @endforeach
    </ul>
</li>
