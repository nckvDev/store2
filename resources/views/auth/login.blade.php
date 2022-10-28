@extends('layouts.app', ['class' => 'bg-dark'])

@section('content')
    @include('layouts.headers.guest')

    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-muted text-center mb-4"><small>{{ __('เข้าสู่ระบบ') }}</small></div>
                        <form role="form" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           placeholder="{{ __('Email') }}" type="email" name="email"
                                           value="{{ old('email') }}" autofocus>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                           name="password" placeholder="{{ __('Password') }}" type="password"
                                           id="password">
                                    <i class="bg-white pt-3 pr-3 fa fa-eye" id="togglePassword"
                                       style="cursor: pointer"></i>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                                @endif
                            </div>
{{--                            <div class="custom-control custom-control-alternative custom-checkbox">--}}
{{--                                <input class="custom-control-input" name="remember" id="customCheckLogin"--}}
{{--                                       type="checkbox" {{ old('remember') ? 'checked' : '' }}>--}}
{{--                                <label class="custom-control-label" for="customCheckLogin">--}}
{{--                                    <span class="text-muted">{{ __('Remember me') }}</span>--}}
{{--                                </label>--}}
{{--                            </div>--}}
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">{{ __('Sign in') }}</button>
                            </div>
                        </form>
                        {{--                        @if (session('error'))--}}
                        {{--                            <script>--}}
                        {{--                                Swal.fire({--}}
                        {{--                                    position: 'center',--}}
                        {{--                                    icon: 'error',--}}
                        {{--                                    title: 'อีเมลรหัสผ่านไม่ถูกต้อง!',--}}
                        {{--                                    showConfirmButton: false,--}}
                        {{--                                    timer: 2500--}}
                        {{--                                })--}}
                        {{--                            </script>--}}
                        {{--                        @endif--}}
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-light">
                                <small>{{ __('Forgot password?') }}</small>
                            </a>
                        @endif
                    </div>
                    {{--                <div class="col-6 text-right">--}}
                    {{--                    <a href="{{ route('register') }}" class="text-light">--}}
                    {{--                        <small>{{ __('Create new account') }}</small>--}}
                    {{--                    </a>--}}
                    {{--                </div>--}}
                </div>
            </div>
        </div>
    </div>
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);

            // toggle the icon
            this.classList.toggle("fa-eye-slash")

        });
    </script>
@endsection
