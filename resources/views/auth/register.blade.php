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
                        <small>{{ __(' Sign up with credentials') }}</small>
                    </div>
                    <form role="form" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group{{ $errors->has('prefix') ? ' has-danger' : '' }}">
                                    <div class="input-group input-group-alternative mb-3">
                                        {{--                                        <div class="input-group-prepend">--}}
                                        {{--                                            <span class="input-group-text"><i class="ni ni-badge"></i></span>--}}
                                        {{--                                        </div>--}}
                                        <select class="form-control{{ $errors->has('prefix') ? ' is-invalid' : '' }}"
                                            name="prefix">
                                            <option value="">Prefix</option>
                                            @foreach($prefixs as $row)
                                            <option value="{{ $row->id }}">{{ $row->prefix_name }}</option>
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
                                        <input class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('FirstName') }}" type="text" name="firstname"
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
                                        <input class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('lastname') }}" type="text" name="lastname"
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
                                    placeholder="{{ __('Email') }}" type="email" name="email"
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
                                <select class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role">
                                    <option value="">-- Select Roles --</option>
                                    <option value="personnel">Personnel</option>
                                    <option value="student">Student</option>
                                </select>
                            </div>
                            @if ($errors->has('role'))
                            <span class="invalid-feedback" style="display: block;" role="alert">
                                <strong>{{ $errors->first('role') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>
                                <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('Password') }}" type="password" name="password">
                            </div>
                            @if ($errors->has('password'))
                            <span class="invalid-feedback" style="display: block;" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>
                                <input class="form-control" placeholder="{{ __('Confirm Password') }}" type="password"
                                    name="password_confirmation">
                            </div>
                        </div>
                        <!-- <div class="text-muted font-italic">
                            <small>{{ __('password strength') }}: <span class="text-success font-weight-700">{{ __('strong') }}strong</span></small>
                        </div> -->
                        {{--                        <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">--}}
                        {{--                            <div class="input-group input-group-alternative mb-3">--}}
                        {{--                                <div class="input-group-prepend">--}}
                        {{--                                    <span class="input-group-text"><i class="ni ni-square-pin"></i></span>--}}
                        {{--                                </div>--}}
                        {{--                                <textarea class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                        aria-label="With textarea" placeholder="{{ __('Address') }}" name="address"
                        value="{{ old('address') }}" autofocus></textarea>--}}
                        {{--                            </div>--}}

                        {{--                            @if ($errors->has('address'))--}}
                        {{--                            <span class="invalid-feedback" style="display: block;" role="alert">--}}
                        {{--                                <strong>{{ $errors->first('address') }}</strong>--}}
                        {{--                            </span>--}}
                        {{--                            @endif--}}
                        {{--                        </div>--}}
                        <div class="row my-2">
                            <div class="col-12">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="custom-control-input" id="customCheckRegister" type="checkbox">
                                    <label class="custom-control-label" for="customCheckRegister">
                                        <span class="text-muted">{{ __('I agree with the') }} <a
                                                href="#!">{{ __('Privacy Policy') }}</a></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mt-4">{{ __('Create account') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection