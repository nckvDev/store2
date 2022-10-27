@extends('layouts.app', ['class' => 'bg-dark'])

@section('content')
    @include('layouts.headers.guest')

    <div class="container-fluid mt--8 pb-5">
        <!-- Table -->
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card bg-secondary shadow border-0">
                    <!-- <div class="card-header bg-transparent pb-4">
                    <div class="text-muted text-center mt-2 mb-4"><small>{{ __('Sign up with') }}</small></div>
                    <div class="text-center">
                        <a href="#" class="btn btn-neutral btn-icon mr-4">
                            <span class="btn-inner--icon"><img src="{{ asset('argon') }}/img/icons/common/github.svg"></span>
                            <span class="btn-inner--text">{{ __('Github') }}</span>
                        </a>
                        <a href="#" class="btn btn-neutral btn-icon">
                            <span class="btn-inner--icon"><img src="{{ asset('argon') }}/img/icons/common/google.svg"></span>
                            <span class="btn-inner--text">{{ __('Google') }}</span>
                        </a>
                    </div>
                </div> -->
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <h2>{{ __(' สมัครสมาชิก') }}</h2>
                        </div>
                        <form role="form" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group{{ $errors->has('user_id') ? ' has-danger' : '' }}">
                                        <div class="input-group input-group-alternative mb-3">
                                            <input
                                                class="form-control{{ $errors->has('user_id') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('รหัสนักศึกษาหรือบุคลากร') }}" type="text"
                                                name="user_id"
                                                value="{{ old('user_id') }}" autofocus>
                                        </div>
                                        @if ($errors->has('user_id'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('user_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-group{{ $errors->has('prefix') ? ' has-danger' : '' }}">
                                        <div class="input-group input-group-alternative c">
                                            {{--                                        <div class="input-group-prepend">--}}
                                            {{--                                            <span class="input-group-text"><i class="ni ni-badge"></i></span>--}}
                                            {{--                                        </div>--}}
                                            <select
                                                class="form-control{{ $errors->has('prefix') ? ' is-invalid' : '' }}"
                                                name="prefix">
                                                <option value="">คำนำหน้า</option>
                                                @foreach($prefixes as $row)
                                                    <option value="{{ $row->id }}" {{ old('prefix') == $row->id ? 'selected' : '' }}>{{ $row->prefix_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($errors->has('prefix'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('prefix') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-group{{ $errors->has('firstname') ? ' has-danger' : '' }}">
                                        <div class="input-group input-group-alternative mb-3">
                                            {{--                                        <div class="input-group-prepend">--}}
                                            {{--                                            <span class="input-group-text"><i class="ni ni-single-02"></i></span>--}}
                                            {{--                                        </div>--}}
                                            <input
                                                class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('ชื่อจริง') }}" type="text" name="firstname"
                                                value="{{ old('firstname') }}" autofocus>
                                        </div>
                                        @if ($errors->has('firstname'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-group{{ $errors->has('lastname') ? ' has-danger' : '' }}">
                                        <div class="input-group input-group-alternative mb-3">
                                            {{--                                        <div class="input-group-prepend">--}}
                                            {{--                                            <span class="input-group-text"><i class="ni ni-single-02"></i></span>--}}
                                            {{--                                        </div>--}}
                                            <input
                                                class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}"
                                                placeholder="{{ __('นามสกุล') }}" type="text" name="lastname"
                                                value="{{ old('lastname') }}" autofocus>
                                        </div>
                                        @if ($errors->has('lastname'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('lastname') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <div class="input-group input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           placeholder="{{ __('อีเมล') }}" type="email" name="email"
                                           value="{{ old('email') }}">
                                </div>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('role') ? ' has-danger' : '' }}">
                                <div class="input-group input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-badge"></i></span>
                                    </div>
                                    <select id="role" class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role">
                                        <option value="">-- เลือกสิทธิ์ --</option>
                                        <option value="admin" {{ old('role') === "admin" ? 'selected' : '' }}>แอดมิน</option>
                                        <option value="personnel" {{ old('role') === "personnel" ? 'selected' : '' }}>บุคลากร</option>
                                        <option value="student" {{ old('role') === "student" ? 'selected' : '' }}>นักศึกษา</option>
                                    </select>
                                </div>
                                @if ($errors->has('role'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-lg-6" id="personnel">
                                    <div class="form-group{{ $errors->has('department') ? ' has-danger' : '' }}">
                                        <div class="input-group input-group-alternative mb-3">
                                            <select
                                                class="form-control{{ $errors->has('department') ? ' is-invalid' : '' }}"
                                                name="department">
                                                <option value="">-- เลือกแผนก --</option>
                                                @foreach($departments as $row)
                                                    <option value="{{ $row->department_name }}" {{ old('department') == $row->department_name ? 'selected' : '' }}>{{ $row->department_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($errors->has('department'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('department') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6" id="student">
                                    <div class="form-group{{ $errors->has('group') ? ' has-danger' : '' }}">
                                        <div class="input-group input-group-alternative mb-3">
                                            <select class="form-control{{ $errors->has('group') ? ' is-invalid' : '' }}"
                                                    name="group">
                                                <option value="">-- เลือกกลุ่ม --</option>
                                                @foreach($groups as $row)
                                                    <option value="{{ $row->group_name }}" {{ old('group') == $row->group_name ? 'selected' : '' }}>{{ $row->group_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if ($errors->has('group'))
                                            <span class="invalid-feedback" style="display: block;" role="alert">
                                                <strong>{{ $errors->first('group') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <div class="input-group input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                           placeholder="{{ __('รหัสผ่าน') }}" type="password" name="password"
                                           id="password" value="{{ old('password') }}">
                                    <i class="bg-white pt-3 pr-3 fa fa-eye" id="togglePassword"
                                       style="cursor: pointer"></i>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control" placeholder="{{ __('ยืนยันรหัสผ่าน') }}" type="password"
                                           name="password_confirmation" id="confirmPassword">
                                    <i class="bg-white pt-3 pr-3 fa fa-eye" id="toggleConfirmPassword"
                                       style="cursor: pointer"></i>
                                </div>
                            </div>
{{--                            <div class="row my-2">--}}
{{--                                <div class="col-12">--}}
{{--                                    <div class="custom-control custom-control-alternative custom-checkbox">--}}
{{--                                        <input class="custom-control-input" id="customCheckRegister" type="checkbox">--}}
{{--                                        <label class="custom-control-label" for="customCheckRegister">--}}
{{--                                            <span class="text-muted">{{ __('I agree with the') }}--}}
{{--                                                 <a href="#!">{{ __('Privacy Policy') }}</a>--}}
{{--                                             </span>--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary mt-4">{{ __('Create account') }}</button>
                            </div>
                        </form>
                        @if (session('error'))
                            <script>
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: 'คุณไม่มีสิทธิ์สมัครเข้าใช้งาน',
                                    confirmButtonText: 'ตกลง'
                                })
                            </script>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        const toggleConfirmPassword = document.querySelector("#toggleConfirmPassword");
        const confirmPassword = document.querySelector("#confirmPassword");

        togglePassword.addEventListener("click", function () {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);

            // toggle the icon
            this.classList.toggle("fa-eye-slash");
        });

        toggleConfirmPassword.addEventListener("click", function () {
            const type = confirmPassword.getAttribute("type") === "password" ? "text" : "password";
            confirmPassword.setAttribute("type", type);

            this.classList.toggle("fa-eye-slash");
        });

        $(document).ready(function () {
            $('#role').change(function () {
                let value = $(this).find(":selected").val();
                localStorage.setItem('isRole', value);
                let getRole = localStorage.getItem('isRole');

                console.log(getRole)
                if (getRole === "personnel") {
                    $("#student").hide();
                    $("#personnel").show().addClass("col-lg-12");
                    // $(".show").css({"display":"flex"})
                } else if (getRole === "admin") {
                    $("#student").hide();
                    $("#personnel").hide();
                } else {
                    $("#student").show();
                    $("#personnel").show().removeClass("col-lg-12");
                    // $(".show").css({"display":"flex"})
                    // $("#personnel").removeClass("col-lg-12");
                }
            });
        });
    </script>
@endsection
