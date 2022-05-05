@extends('layouts.app', ['class' => 'bg-neutral'])
@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--9">
    <div class="row">
        <div class="col-xl-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('device') }}">ครุภัณฑ์</a></li>
                    <li class="breadcrumb-item active" aria-current="page">เพิ่มครุภัณฑ์</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 mb-4">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0 ml-4">{{ __('เพิ่มครุภัณฑ์') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('addDevice') }}" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        <div class="pl-lg-2">
                            <div class="row">
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label class="form-control-label"
                                            for="device_num">{{ __('รหัสครุภัณฑ์') }}</label>
                                        <input type="text" name="device_num"
                                            value="{{ old('device_num') ? old('device_num') : '' }}"
                                            class="form-control form-control-alternative{{ $errors->has('device_num') ? ' is-invalid' : '' }} "
                                            autofocus>
                                        @if ($errors->has('device_num'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('device_num') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-5">
                                    <div class="form-group">
                                        <label class="form-control-label"
                                            for="device_name">{{ __('ชื่อครุภัณฑ์') }}</label>
                                        <input type="text" name="device_name" value="{{ old('device_name') }}"
                                            class="form-control form-control-alternative{{ $errors->has('device_name') ? ' is-invalid' : '' }} ">
                                        @if ($errors->has('device_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('device_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-5">
                                    <div class="form-group">
                                        <label class="form-control-label" for="type_id">{{ __('ประเภท') }}</label>
                                        <select
                                            class="form-control form-control-alternative{{ $errors->has('type_id') ? ' is-invalid' : '' }}"
                                            name="type_id">
                                            <option>เลือก...</option>
                                            @foreach($types as $row)
                                            <option value="{{ $row->id }}">{{ $row->type_detail }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-5">
                                    <div class="form-group">
                                        <label class="form-control-label" for="image">{{ __('รูปภาพ') }}</label>
                                        <input type="file" name="image" value="{{ old('image') }}"
                                            class="form-control form-control-alternative{{ $errors->has('image') ? ' is-invalid' : '' }} ">
                                        @if ($errors->has('image'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('image') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-5">
                                    <div class="form-group">
                                        <label class="form-control-label" for="location">{{ __('ตำแหน่ง') }}</label>
                                        <input type="text" name="location" value="{{ old('location') }}"
                                            class="form-control form-control-alternative{{ $errors->has('location') ? ' is-invalid' : '' }} ">
                                        @if ($errors->has('location'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('location') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="device_year">{{ __('ปี') }}</label>
                                        <input type="number" name="device_year" value="{{ old('device_year') }}"
                                            class="form-control form-control-alternative{{ $errors->has('device_year') ? ' is-invalid' : '' }} ">
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