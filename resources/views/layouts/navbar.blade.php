<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
{{--        <li class="nav-item mr-2">--}}
{{--            <a href="{{ route('purchases.create') }}" class=" btn btn-warning white">--}}
{{--                <i class="fas fa-th-large nav-icon"></i>--}}
{{--                POS-Achat--}}
{{--            </a>--}}
{{--        </li>--}}

        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="far fa-bell"></i>
                @if($unreadNotifications->count() > 0)
                <span class="badge badge-warning navbar-badge">{{ $unreadNotifications->count() }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">{{ $unreadNotifications->count() }} Notifications</span>
                <div class="dropdown-divider"></div>
                <div class="message-center" style="max-height: 400px !important; overflow: scroll;">
                    @foreach($unreadNotifications->take(5) as $notification)
                        <a href="{{ $notification->data['link'] }}" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                {{--<img src="{{ $notification->data['image'] }}" alt="Image du produit" class="img-size-50 mr-3 img-circle">--}}
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        {{ $notification->data['title'] }}
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">{{ $notification->data['message'] }}</p>
                                    <p class="text-sm text-muted">
                                        <i class="far fa-clock mr-1"></i>
                                        {{ Date::create($notification->created_at->format('Y-m-d H:i:s'))->ago() }}
                                    </p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                    @endforeach
                </div>
                <div class="dropdown-divider"></div>
                <button wire:click.prevent="deleteAll" class="dropdown-item dropdown-footer">Supprimer toutes les notifications</button>
            </div>
        </li>

        <!-- Language Dropdown Menu -->
        {{--<li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="flag-icon @if (App::isLocale('en')) flag-icon-gb @else flag-icon-fr @endif"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-0">
                <a href="{{ route('setlang', 'en') }}" class="dropdown-item active">
                    <i class="flag-icon flag-icon-gb mr-2 @if (App::isLocale('en')) active @endif"></i> {{ __('English') }}
                </a>
                <a href="{{ route('setlang', 'fr') }}" class="dropdown-item">
                    <i class="flag-icon flag-icon-fr mr-2 @if (App::isLocale('fr')) active @endif"></i> {{ __('French') }}
                </a>
            </div>
        </li>--}}

        <!-- User Dropdown Menu -->
        <li class="nav-item dropdown user-menu">
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="{{ Auth::user()->profile_photo_url }}" class="user-image img-circle elevation-2" alt="User Image" title="Alexander Pierce">
                {{--<span class="d-none d-md-inline">Alexander Pierce</span>--}}
            </a>
            @else
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                {{ Auth::user()->name }}
                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
            @endif
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img src="{{ Auth::user()->profile_photo_url }}" class="img-circle elevation-2" alt="User Image">

                    <p>
                        {{ Auth::user()->name }} - Web Developer
                        <small>{{ __('Member since') }} {{ Auth::user()->created_at->format('M. Y') }}</small>
                    </p>
                </li>
                <!-- Menu Body -->
                {{--
                <li class="user-body">
                    <div class="row">
                        <div class="col-4 text-center">
                            <a href="#">Followers</a>
                        </div>
                        <div class="col-4 text-center">
                            <a href="#">Sales</a>
                        </div>
                        <div class="col-4 text-center">
                            <a href="#">Friends</a>
                        </div>
                    </div>
                    <!-- /.row -->
                </li>
                --}}
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a class="btn btn-default btn-flat" href="{{ route('profile.show') }}">
                        {{ __('Profile') }}
                    </a>
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}" class="float-right">
                        @csrf

                        <a class="btn btn-default btn-flat float-right" href="{{ route('logout') }}"
                                             onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>
