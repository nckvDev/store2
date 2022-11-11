<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
            aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
        <a class="navbar-brand pt-0 pb-0" href="{{ route('admin_dashboard') }}">
            <img src="{{ asset('argon') }}/img/brand/brand-logo-2.png" class="navbar-brand-img" alt="...">
        </a>
        @endif
        @if(\Illuminate\Support\Facades\Auth::user()->role == 'personnel')
        <a class="navbar-brand pt-0" href="{{ route('personnel_dashboard') }}">
            <img src="{{ asset('argon') }}/img/brand/brand-logo-2.png" class="navbar-brand-img" alt="...">
        </a>
        @endif
        @if(\Illuminate\Support\Facades\Auth::user()->role == 'student')
        <a class="navbar-brand pt-0" href="{{ route('student_dashboard') }}">
            <img src="{{ asset('argon') }}/img/brand/brand-logo-2.png" class="navbar-brand-img" alt="...">
        </a>
        @endif

        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="media align-items-center">
                        <span
                            class="badge badge-md badge-circle badge-floating badge-primary border-white ni ni-single-02">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }} {{ auth()->user()->firstname }}</h6>
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
                            <img src="{{ asset('argon') }}/img/brand/brand-logo-2.png" alt="logo brand">
                        </a>
                        @endif
                        @if(\Illuminate\Support\Facades\Auth::user()->role == 'personnel')
                        <a href="{{ route('personnel_dashboard') }}">
                            <img src="{{ asset('argon') }}/img/brand/brand-logo-2.png" alt="logo brand">
                        </a>
                        @endif
                        @if(\Illuminate\Support\Facades\Auth::user()->role == 'student')
                        <a href="{{ route('student_dashboard') }}">
                            <img src="{{ asset('argon') }}/img/brand/brand-logo-2.png" alt="logo brand">
                        </a>
                        @endif
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                            data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                            aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            {{--            <form class="mt-4 mb-3 d-md-none">--}}
            {{--                <div class="input-group input-group-rounded input-group-merge">--}}
            {{--                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}"
            aria-label="Search">--}}
            {{--                    <div class="input-group-prepend">--}}
            {{--                        <div class="input-group-text">--}}
            {{--                            <span class="fa fa-search"></span>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </form>--}}
            <!-- Navigation -->

            {{--            <ul class="navbar-nav">--}}

            {{--                <li class="nav-item">--}}
            {{--                    <a class="nav-link" href="{{ route('home') }}">--}}
            {{--                        <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}--}}
            {{--                    </a>--}}
            {{--                </li>--}}
            {{--                <li class="nav-item">--}}
            {{--                    <a class="nav-link active" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">--}}
            {{--                        <i class="fab fa-laravel" style="color: #f4645f;"></i>--}}
            {{--                        <span class="nav-link-text" style="color: #f4645f;">{{ __('Management admin') }}</span>--}}
            {{--                    </a>--}}

            {{--                    <div class="collapse show" id="navbar-examples">--}}
            {{--                        <ul class="nav nav-sm flex-column">--}}
            {{--                            <li class="nav-item">--}}
            {{--                                <a class="nav-link" href="{{ route('device') }}">--}}
            {{--                                    <i class="ni ni-satisfied text-primary"></i>--}}
            {{--                                    {{ __('Device') }}--}}
            {{--                                </a>--}}
            {{--                            </li>--}}
            {{--                            <li class="nav-item">--}}
            {{--                                <a class="nav-link" href="{{ route('UserManager') }}">--}}
            {{--                                    <i class="ni ni-satisfied text-primary"></i>--}}
            {{--                                    {{ __('Manage User ') }}--}}
            {{--                                </a>--}}
            {{--                            </li>--}}
            {{--                            <li class="nav-item">--}}
            {{--                                <a class="nav-link" href="{{ route('LocationManager') }}">--}}
            {{--                                    <i class="ni ni-satisfied text-primary"></i>--}}
            {{--                                    {{ __('Manage Room') }}--}}
            {{--                                </a>--}}
            {{--                            </li>--}}
            {{--                        </ul>--}}
            {{--                    </div>--}}
            {{--                </li>--}}
            {{--                <li class="nav-item">--}}
            {{--                    <a class="nav-link active" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">--}}
            {{--                        <i class="fab fa-laravel" style="color: #f4645f;"></i>--}}
            {{--                        <span class="nav-link-text" style="color: #f4645f;">{{ __('Management staff') }}</span>--}}
            {{--                    </a>--}}

            {{--                    <div class="collapse show" id="navbar-examples">--}}
            {{--                        <ul class="nav nav-sm flex-column">--}}
            {{--                            <li class="nav-item">--}}
            {{--                                <a class="nav-link" href="{{ route('search') }}">--}}
            {{--                                    <i class="ni ni-satisfied text-primary"></i> {{ __('Search Car') }}--}}
            {{--                                </a>--}}
            {{--                            </li>--}}
            {{--                            <li class="nav-item">--}}
            {{--                                <a class="nav-link" href="{{ route('profile.edit') }}">--}}
            {{--                                    {{ __('User profile') }}--}}
            {{--                                </a>--}}
            {{--                            </li>--}}
            {{--                            <li class="nav-item">--}}
            {{--                                <a class="nav-link" href="{{ route('user.index') }}">--}}
            {{--                                    {{ __('User Management') }}--}}
            {{--                                </a>--}}
            {{--                            </li>--}}
            {{--                        </ul>--}}
            {{--                    </div>--}}
            {{--                </li>--}}

            <!-- <li class="nav-item">

                </li>
                <li class="nav-item ">

                </li>
                <li class="nav-item">

                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="ni ni-circle-08 text-pink"></i> {{ __('Register') }}
                    </a>
                </li> -->
            <!-- <li class="nav-item mb-5 mr-4 ml-4 pl-1 bg-danger" style="position: absolute; bottom: 0;">
                    <a class="nav-link text-white" href="https://www.creative-tim.com/product/argon-dashboard-pro-laravel" target="_blank">
                        <i class="ni ni-cloud-download-95"></i> Upgrade to PRO
                    </a>
                </li> -->
            {{--            </ul>--}}
            <!-- Divider -->
            {{--            <hr class="my-3">--}}
            <!-- Heading -->
            @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
            <h6 class="navbar-heading text-muted">Admin</h6>
            <!-- Navigation -->
            <ul class="navbar-nav mb-md-3">
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('admin_dashboard*') ? 'active text-orange' : '' }}"
                       href="{{ route('admin_dashboard') }}">
                        <i class="ni ni-archive-2 text-orange"></i> {{ __('หน้าแรก') }}
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('prefix*') ? 'active text-blue' : '' }}"
                        href="{{ route('prefix') }}">
                        <i class="ni ni-badge text-blue"></i> {{ __('คำนำหน้า') }}
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('type*') ? 'active text-dark' : '' }}"
                        href="{{ route('type') }}">
                        <i class="ni ni-books text-dark"></i> {{ __('ประเภท') }}
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('department*') ? 'active text-red' : '' }}"
                        href="{{ route('department') }}">
                        <i class="ni ni-building text-red"></i> {{ __('แผนก') }}
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('group*') ? 'active text-yellow' : '' }}"
                        href="{{ route('group') }}">
                        <i class="ni ni-paper-diploma text-yellow"></i> {{ __('กลุ่มเรียน') }}
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('manage-role*') ?  'active text-purple' : '' }}"
                        href="{{ route('manage-role') }}">
                        <i class="ni ni-circle-08 text-purple"> </i> {{ __('จัดการข้อมูลผู้ใช้งาน') }}
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('stock*') ? 'active text-orange' : '' }}"
                        href="{{ route('stock') }}">
                        <i class="ni ni-settings text-orange"> </i> {{ __('วัสดุ') }}
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('device*') ? 'active text-indigo' : '' }}"
                        href="{{ route('device') }}">
                        <i class="ni ni-app text-indigo"> </i> {{ __('ครุภัณฑ์') }}
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('disposable*') ? 'active text-red' : '' }}"
                        href="{{ route('disposable') }}">
                        <i class="ni ni-bulb-61 text-red "> </i> {{ __('วัสดุสิ้นเปลือง') }}
                        @if(Session::has('list'))
                        <span
                            class="badge badge-md badge-circle badge-floating badge-danger border-white ml-5 ni ni-bell-55">
                        </span>
                        @endif
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('confirm-form*') ? 'active text-pink' : '' }}"
                        href="{{ route('confirm-form') }}">
                        <i class="ni ni-single-copy-04 text-pink "> </i> {{ __('ยืนยันแบบฟอร์ม') }}
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('confirm-user*') ?  'active text-gray' : '' }}"
                        href="{{ route('form-detail') }}">
                        <i class="ni ni-curved-next text-gray"> </i> {{ __('ตรวจสอบสถานะอนุมัติ') }}
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('reportAll*') || request()->is('report-all*') ?  'active text-green' : '' }}"
                        href="{{ route('reportAll') }}">
                        <i class="ni ni-collection text-green"> </i> {{ __('รายงาน') }}
                    </a>
                </li>
            </ul>
            @endif

            @if(\Illuminate\Support\Facades\Auth::user()->role == 'personnel')
            <h6 class="navbar-heading text-muted">Personnel</h6>
            <ul class="navbar-nav mb-md-3">
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('personnel_dashboard*') ? 'active text-orange' : '' }}"
                        href="{{ url('personnel_dashboard') }}">
                        <i class="ni ni-archive-2 text-orange"></i> {{ __('หน้าแรก') }}
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('personnel_borrow*') ? 'active text-green' : '' }}"
                        href="{{ route('personnel_borrow.list') }}">
                        <i class="ni ni-archive-2 text-green"></i> {{ __('ยืม/เบิกวัสดุ-พัสดุ') }}
                    </a>
                </li>
            </ul>
            @endif

            @if(\Illuminate\Support\Facades\Auth::user()->role == 'student')
            <h6 class="navbar-heading text-muted">Student</h6>
            <ul class="navbar-nav mb-md-3">
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('student_dashboard*') ? 'active text-orange' : '' }}"
                        href="{{ url('student_dashboard') }}">
                        <i class="ni ni-archive-2 text-orange"></i> {{ __('หน้าแรก') }}
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link {{ request()->is('student_borrow*') ? 'active text-green' : '' }}"
                        href="{{ url('student_borrow') }}">
                        <i class="ni ni-archive-2 text-green"></i> {{ __('ยืมวัสดุ') }}
                    </a>
                </li>
            </ul>
            @endif
        </div>
    </div>
</nav>
