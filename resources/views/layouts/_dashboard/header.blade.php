<div id="header" class="app-header">
    <div class="navbar-header">
        <a href="{{ route('home') }}" class="navbar-brand"><span class="navbar-logo"></span> {{ config('app.name') }}</a>
        <button type="button" class="navbar-mobile-toggler" data-toggle="app-sidebar-mobile">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <div class="navbar-nav">
        <div class="navbar-item dropdown">


            @switch(app()->getLocale())
                    @case('id')
                        <a href="#" data-bs-toggle="dropdown" class="navbar-link dropdown-toggle icon" aria-expanded="false">
                            <img src="{{ asset('img/id.png') }}" alt="" width="18px" />
                            {{ strtoupper(app()->getLocale()) }}
                        </a>
                    @break
                    @case('en')
                        <a href="#" data-bs-toggle="dropdown" class="navbar-link dropdown-toggle icon" aria-expanded="false">
                            <img src="{{ asset('img/en.png') }}" alt="" width="18px" />
                            {{ strtoupper(app()->getLocale()) }}
                        </a>
                    @break
                    @default
                @endswitch


            <div class="dropdown-menu media-list dropdown-menu-end" style="">
                <a href="{{ route('localization.switch', ['language' => 'id']) }}" class="dropdown-item media">
                    <div class="media-body">
                        <h6 class="media-heading">
                            <img src="{{ asset('img/id.png') }}" alt="" width="18px" />
                            INA
                        </h6>
                    </div>
                </a>
                <a href="{{ route('localization.switch', ['language' => 'en']) }}" class="dropdown-item media">
                    <div class="media-body">
                        <h6 class="media-heading">
                            <img src="{{ asset('img/en.png') }}" alt="" width="18px" />
                            ENG
                        </h6>
                    </div>
                </a>
            </div>
        </div>
        <div class="navbar-item navbar-user dropdown">
        <a href="#" class="navbar-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
            <img src="{{ asset('template/assets/img/user/user-2.jpg') }}" alt="" />
            <span>
            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
            <b class="caret"></b>
            </span>
        </a>

        <div class="dropdown-menu dropdown-menu-end me-1">
            <a href="javascript:;" class="dropdown-item">Edit Profile</a>
            <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>
    </div>


    </div>
