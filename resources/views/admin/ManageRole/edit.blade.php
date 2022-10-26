@extends('layouts.app', ['class' => 'bg-neutral'])
@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--9">
    <div class="row">
        <div class="col-xl-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('manage-role') }}">จัดการข้อมูลผู้ใช้งาน</a></li>
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
                        <h3 class="mb-0 ml-4">{{ __('แก้ไขข้อมูลผู้ใช้งาน') }}</h3>
                    </div>
                </div>

                <div class="card-body">
                    @foreach($users as $row)
                    <form method="post" action="{{ url('/manage-role/update/'.$users->id) }}" method="post"
                        enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @endforeach
                        <div class="pl-lg-2">
                            <div class="row">
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label class="form-control-label"
                                            for="user_id">{{ __('รหัสผู้ใช้งาน') }}</label>
                                        <input type="text" name="user_id" value="{{ $users->user_id }}"
                                            class="form-control" autofocus>
                                        @if ($errors->has('user_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('user_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="prefix_id">{{ __('คำนำหน้า') }}</label>
                                        <select
                                            class="form-control form-control-alternative{{ $errors->has('prefix_id') ? ' is-invalid' : '' }}"
                                            name="prefix_id">
                                            @foreach($prefixes as $row)
                                                <option value="{{ $row->id }}"
                                                    {{ $row->id ==  $users->prefix_id ? 'selected' : '' }}>
                                                    {{ $row->prefix_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('prefix_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('prefix_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="firstname">{{ __('ชื่อจริง') }}</label>
                                        <input type="text" name="firstname" value="{{ $users->firstname }}"
                                            class="form-control">
                                        @if ($errors->has('firstname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('firstname') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="lastname">{{ __('นามสกุล') }}</label>
                                        <input type="text" name="lastname" value="{{ $users->lastname }}"
                                            class="form-control">
                                        @if ($errors->has('lastname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('lastname') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">{{ __('อีเมล') }}</label>
                                        <input type="text" name="email" value="{{ $users->email }}"
                                            class="form-control">
                                        @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="department">{{ __('แผนก') }}</label>
                                        <input type="text" name="department" value="{{ $users->department }}"
                                            class="form-control">
                                        @if ($errors->has('department'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('department') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="group">{{ __('กลุ่มเรียน') }}</label>
                                        <input type="text" name="group" value="{{ $users->group }}"
                                            class="form-control">

                                        {{--                                            @foreach($users as $row)--}}
                                        {{--                                                <option value="{{ $row->id }}"--}}
                                        {{--                                                    {{ $row->id == $stocks->type_id ? 'selected' : '' }}>--}}
                                        {{--                                                    {{ $row->type_detail }}</option>--}}
                                        {{--                                            @endforeach--}}
                                        @if ($errors->has('group'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('group') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
{{--                                {{dd($users->role)}}--}}

                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="role">{{ __('สิทธิ์') }}</label>
                                        <select class="form-control" data-toggle="select" title="Simple select"
                                            data-live-search="true" data-live-search-placeholder="Search ..."
                                            name="role">
                                            <option value="admin" name="role" {{ $users->role == "admin" ? 'selected' : '' }}>admin</option>
                                            <option value="personnel" name="role"  {{ $users->role == "personnel" ? 'selected' : '' }}>personnel</option>
                                            <option value="student" name="role"  {{ $users->role == "student" ? 'selected' : '' }}>student</option>
                                        </select>
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
