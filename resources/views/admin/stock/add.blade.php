@extends('layouts.app', ['class' => 'bg-neutral'])
@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--9">
    <div class="row">
        <div class="col-xl-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('stock') }}">วัสดุ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">เพิ่มวัสดุ</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 mb-4">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0 ml-4">{{ __('เพิ่มวัสดุ') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('addStock') }}" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        <div class="pl-lg-2">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="stock_num">{{ __('รหัสวัสดุ') }}</label>
                                        <input type="text" name="stock_num"
                                            value="{{ old('stock_num') ? old('stock_num') : '' }}"
                                            class="form-control form-control-alternative{{ $errors->has('stock_num') ? ' is-invalid' : '' }}"
                                            placeholder="
                                            {{ __('ประเภท') }}" autofocus>
                                        @if ($errors->has('stock_num'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('stock_num') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="stock_name">{{ __('ชื่อวัสดุ') }}</label>
                                        <input type="text" name="stock_name" value="{{ old('stock_name') }}"
                                            class="form-control form-control-alternative{{ $errors->has('stock_name') ? ' is-invalid' : '' }}"
                                            placeholder="
                                            {{ __('ประเภท') }}">
                                        @if ($errors->has('stock_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('stock_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label class="form-control-label"
                                            for="stock_amount">{{ __('จำนวนทั้งหมด') }}</label>
                                        <input type="number" name="stock_amount" value="{{ old('stock_amount') }}"
                                            class="form-control form-control-alternative{{ $errors->has('stock_amount') ? ' is-invalid' : '' }}"
                                            placeholder="
                                            {{ __('ประเภท') }}">
                                        @if ($errors->has('stock_amount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('stock_amount') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="image">{{ __('รูปภาพ') }}</label>
                                        <input type="file" name="image" value="{{ old('image') }}"
                                            class="form-control {{ $errors->has('image') ? ' is-invalid' : '' }}"
                                            placeholder="
                                            {{ __('ประเภท') }}">
                                        @if ($errors->has('image'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('image') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6">
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