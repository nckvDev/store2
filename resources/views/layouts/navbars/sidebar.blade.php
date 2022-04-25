<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
            <a class="navbar-brand pt-0" href="{{ route('stock') }}">
                <img src="{{ asset('argon') }}/img/brand/brand-logo-4.png" class="navbar-brand-img" alt="..." >
            </a>
        @endif
        @if(\Illuminate\Support\Facades\Auth::user()->role == 'personnel')
            <a class="navbar-brand pt-0" href="{{ route('personnel_dashboard') }}">
                <img src="{{ asset('argon') }}/img/brand/brand-logo-4.png" class="navbar-brand-img" alt="..." >
            </a>
        @endif
        @if(\Illuminate\Support\Facades\Auth::user()->role == 'student')
            <a class="navbar-brand pt-0" href="{{ route('student_dashboard') }}">
                <img src="{{ asset('argon') }}/img/brand/brand-logo-4.png" class="navbar-brand-img" alt="..." >
            </a>
        @endif
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <i class="ni ni-single-02"></i>
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>


        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
                            <a href="{{ route('stock') }}">
                                <img src="{{ asset('argon') }}/img/brand/brand-logo-4.png">
                            </a>
                        @endif
                        @if(\Illuminate\Support\Facades\Auth::user()->role == 'personnel')
                            <a href="{{ route('personnel_dashboard') }}">
                                <img src="{{ asset('argon') }}/img/brand/brand-logo-4.png">
                            </a>
                        @endif
                        @if(\Illuminate\Support\Facades\Auth::user()->role == 'student')
                            <a href="{{ route('student_dashboard') }}">
                                <img src="{{ asset('argon') }}/img/brand/brand-logo-4.png">
                            </a>
                        @endif

                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
{{--            <form class="mt-4 mb-3 d-md-none">--}}
{{--                <div class="input-group input-group-rounded input-group-merge">--}}
{{--                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">--}}
{{--                    <div class="input-group-prepend">--}}
{{--                        <div class="input-group-text">--}}
{{--                            <span class="fa fa-search"></span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}
            <!-- Navigation -->

{{--            <ul class="navbar-nav">--}}

{{--            </ul>--}}
            <!-- Divider -->
{{--            <hr class="my-3">--}}
            <!-- Heading -->
            @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
            <h6 class="navbar-heading text-muted">Admin</h6>
            <!-- Navigation -->
            <ul class="navbar-nav mb-md-3">
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('type*') ? 'active text-green' : '' }}" href="{{ route('type') }}">
                        <i class="ni ni-archive-2 text-green"></i> {{ __('ประเภท') }}
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('stock*') ? 'active text-orange' : '' }}" href="{{ route('stock') }}">
                        <i class="ni ni-settings text-orange"> </i> {{ __('อุปกรณ์') }}
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('device*') ? 'active text-indigo' : '' }}" href="{{ route('device') }}">
                        <i class="ni ni-app text-indigo"> </i> {{ __('วัสดุ') }}
                    </a>
                </li>
            </ul>
            @endif

            @if(\Illuminate\Support\Facades\Auth::user()->role == 'personnel')
                <h6 class="navbar-heading text-muted">Personnel</h6>
                <ul class="navbar-nav mb-md-3">
                    <li class="nav-item ">
                        <a class="nav-link {{ request()->is('type*') ? 'active text-green' : '' }}" href="{{ route('personnel_borrow') }}">
                            <i class="ni ni-archive-2 text-green"></i> {{ __('ยืมวัสดุ-พัสดุ') }}
                        </a>
                    </li>
                </ul>
            @endif
            @if(\Illuminate\Support\Facades\Auth::user()->role == 'student')
                <h6 class="navbar-heading text-muted">Student</h6>
                <ul class="navbar-nav mb-md-3">
                    <li class="nav-item ">
                        <a class="nav-link {{ request()->is('student_borrow*') ? 'active text-orange' : '' }}" href="{{ route('student_borrow') }}">
                            <i class="ni ni-archive-2 text-orange"></i> {{ __('ยืมวัสดุ') }}
                        </a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</nav>
