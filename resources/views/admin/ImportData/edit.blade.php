@extends('layouts.app', ['class' => 'bg-secondary'])
@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--9">
    <div class="row">
        <div class="col-xl-12 mb-4">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0">{{ __('แก้ไขผู้ใช้งาน') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('/data-import/update/'.$masterUsers->id) }}" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="pl-lg-2">
                            <div class="form-group{{ $errors->has('user_id') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-name">{{ __('รหัสผู้ใช้งาน') }}</label>
                                <input type="text" name="user_id" id="input-name"
                                    class="form-control form-control-alternative{{ $errors->has('user_id') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('รหัสผู้ใช้งาน') }}" value="{{ $masterUsers->user_id }}"
                                    autofocus>
                                @if ($errors->has('user_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('user_id') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('firstname') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-name">{{ __('ชื่อผู้ใช้งาน') }}</label>
                                        <input type="text" name="firstname" id="input-name"
                                            class="form-control form-control-alternative{{ $errors->has('firstname') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('ชื่อจริง') }}" value="{{ $masterUsers->firstname }}"
                                            autofocus>
                                        @if ($errors->has('firstname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('firstname') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('lastname') ? ' has-danger' : '' }}">
                                        <label class="form-control-label"
                                            for="input-name">{{ __('นามสกุลผู้ใช้งาน') }}</label>
                                        <input type="text" name="lastname" id="input-name"
                                            class="form-control form-control-alternative{{ $errors->has('lastname') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('นามสกุล') }}" value="{{ $masterUsers->lastname }}"
                                            autofocus>
                                        @if ($errors->has('lastname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('lastname') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-2">{{ __('บันทึก') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
