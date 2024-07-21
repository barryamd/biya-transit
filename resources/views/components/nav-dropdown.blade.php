@props(['menu'])
@canany(array_column($menu['items'], 'permission'))
<li class="nav-item has-treeview {{ menuOpen($menu['items']) }}">
    <a href="#" class="nav-link ">
        <i class="nav-icon fas fa-{{ $menu['icon'] }}"></i>
        <p>
            {{ __($menu['title']) }}
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @foreach($menu['items'] as $child)
            <x-nav-item :item="$child"></x-nav-item>
        @endforeach
    </ul>
</li>
@endcanany
