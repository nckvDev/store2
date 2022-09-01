@extends('layouts.app', ['class' => 'bg-neutral'])
@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--9">
    <div class="row">
        <div class="col-xl-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('stock') }}">จัดการข้อมูลผู้ใช้งาน</a></li>
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
                    <form method="post" action="{{ url('/managerole/update/'.$users->id) }}" method="post"
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
                                        <input type="text" name="prefix_id" value="{{ $users->prefix_id }}"
                                            class="form-control">
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
                                <div class="col-xl-8">
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

                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="role">{{ __('สิทธิ์') }}</label>
                                        <select class="form-control" data-toggle="select" title="Simple select"
                                            data-live-search="true" data-live-search-placeholder="Search ..."
                                            name="role">
                                            <option>กรุณาเลือกสิทธิ์</option>
                                            <option value="admin" name="role">admin</option>
                                            <option value=" personnel" name="role">personnel</option>
                                            <option value=" student" name="role">student</option>
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