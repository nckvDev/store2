@extends('layouts.app', ['class' => 'bg-neutral'])
@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--9">
    <div class="row">
        <div class="col-xl-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('stock') }}">ครุภัณฑ์</a></li>
                    <li class="breadcrumb-item active" aria-current="page">แก้ไข</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 mb-4">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0 ml-4">{{ __('แก้ไขครุภัณฑ์') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('/device/update/'.$devices->id) }}" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        <div class="pl-lg-2">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="device_num">{{ __('รหัสครุภัณฑ์') }}</label>
                                        <input type="text" name="device_num" value="{{ $devices->device_num }}"
                                            class="form-control form-control-alternative{{ $errors->has('device_num') ? ' is-invalid' : '' }}"
                                            placeholder="
                                            {{ __('รหัสครุภัณฑ์') }}" autofocus>
                                        @if ($errors->has('device_num'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('device_num') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-control-label"
                                            for="device_name">{{ __('ชื่อครุภัณฑ์') }}</label>
                                        <input type="text" name="device_name" value="{{ $devices->device_name }}"
                                            class="form-control form-control-alternative{{ $errors->has('device_name') ? ' is-invalid' : '' }}"
                                            placeholder="
                                            {{ __('ชื่อครุภัณฑ์') }}">
                                        @if ($errors->has('device_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('device_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-8">
                                    <div class="form-group">
                                        <label class="form-control-label" for="image">{{ __('รูปภาพ') }}</label>
                                        <input type="file" name="image" value="{{ $devices->image }}"
                                            class="form-control form-control-alternative{{ $errors->has('image') ? ' is-invalid' : '' }}"
                                            placeholder="
                                            {{ __('ประเภท') }}">
                                        <input type="hidden" name="old_image" value="{{ $devices->image }}">
                                        @if ($errors->has('image'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('image') }}</strong></span>
                                        @endif
                                        <br>
                                        <div class="align-center">
                                            <img src="{{ asset($devices->image) }}" alt="" width="200px" height="200px">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="form-control-label"
                                            for="device_amount">{{ __('จำนวน') }}</label>
                                        <input type="text" name="device_amount" value="{{ $devices->device_amount }}"
                                            class="form-control form-control-alternative{{ $errors->has('device_amount') ? ' is-invalid' : '' }}"
                                            placeholder="
                                            {{ __('จำนวน') }}">
                                        @if ($errors->has('device_amount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('device_amount') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="type_id">{{ __('ประเภท') }}</label>
                                        <select
                                            class="form-control form-control-alternative{{ $errors->has('type_id') ? ' is-invalid' : '' }} "
                                            name="type_id">
                                            <option>เลือก...</option>
                                            @foreach($types as $row)
                                            <option value="{{ $row->id }}"
                                                {{ $row->id == $devices->type_id ? 'selected' : '' }}>
                                                {{ $row->type_detail }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('type_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('type_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="form-control-label"
                                            for="defective_device">{{ __('ชำรุด') }}</label>
                                        <input type="number" name="defective_device"
                                            value="{{ $devices->defective_device }}"
                                            class="form-control form-control-alternative{{ $errors->has('defective_device') ? ' is-invalid' : '' }}  placeholder="
                                            {{ __('ประเภท') }}">
                                        @if ($errors->has('defective_device'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('defective_device') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="device_year">{{ __('ปี') }}</label>
                                        <input type="text" name="device_year" value="{{ $devices->device_year }}"
                                            class="form-control form-control-alternative{{ $errors->has('device_year') ? ' is-invalid' : '' }}  placeholder="
                                            {{ __('ประเภท') }}">
                                        @if ($errors->has('device_year'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('device_year') }}</strong>
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
                    @if (session('success'))
                    <script>
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'บันทึกข้อมูลเรียบร้อย',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    </script>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
