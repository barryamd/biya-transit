<div class="sidebar">
    <!-- Sidebar user (optional) -->
    {{--
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">Alexander Pierce</a>
        </div>
    </div>
    --}}

    <!-- SidebarSearch Form -->
    {{--<div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>--}}

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
            @foreach(config('menu-items') as $item)
                @if($item['type'] == 'group')
                    <li class="nav-header">{{ $item['title'] }}</li>
                    @foreach($item['children'] as $menu)
                        @can($menu['permission'])
                            @if($menu['type'] == 'collapse')
                                <x-nav-collapse :menu="$menu"></x-nav-collapse>
                            @elseif($menu['type'] == 'item')
                                <x-nav-item :item="$menu"></x-nav-item>
                            @endisset
                        @endcan
                    @endforeach
                    <hr style="width: 100%;text-align:left;margin: 5px;background-color: #ffffff;">
                @elseif($item['type'] == 'collapse')
                    @can($item['permission'])
                    <x-nav-collapse :menu="$item"></x-nav-collapse>
                    @endcan
                @elseif($item['type'] == 'item')
                    @can($item['permission'])
                    <x-nav-item :item="$item"></x-nav-item>
                    @endcan
                @endif
            @endforeach
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
