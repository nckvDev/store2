@extends('layouts.app', ['class' => 'bg-neutral'])
@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--9">
    <div class="row">
        <div class="col-xl-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('disposable') }}">วัสดุสิ้นเปลือง</a></li>
                    <li class="breadcrumb-item active" aria-current="page">เพิ่มวัสดุสิ้นเปลือง</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 mb-4">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0 ml-4">{{ __('เพิ่มวัสดุสิ้นเปลือง') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('addDisposable') }}" enctype="multipart/form-data"
                        autocomplete="off">
                        @csrf
                        <div class="pl-lg-2">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="form-control-label"
                                            for="disposable_name">{{ __('ชื่อวัสดุสิ้นเปลือง') }}</label>
                                        <input type="text" name="disposable_name" value="{{ old('disposable_name') }}"
                                            class="form-control form-control-alternative{{ $errors->has('disposable_name') ? ' is-invalid' : '' }} placeholder="
                                            {{ __('ประเภท') }}">
                                        @if ($errors->has('disposable_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('disposable_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="type_id">{{ __('ประเภท') }}</label>
                                        <select
                                            class="form-control form-control-alternative{{ $errors->has('type_id') ? ' is-invalid' : '' }}"
                                            name="type_id">
                                            <option value="">เลือก...</option>
                                            @foreach($types as $row)
                                                @if($row->type_category->category_detail === 'วัสดุสิ้นเปลือง')
                                                <option value="{{ $row->id }}" {{ old('type_id') == $row->id ? 'selected' : '' }}>{{ $row->type_detail }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if ($errors->has('type_id'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('type_id') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label class="form-control-label"
                                            for="disposable_amount">{{ __('จำนวนทั้งหมด') }}</label>
                                        <input type="number" id="disposable_amount" name="disposable_amount"
                                            value="{{ old('disposable_amount') }}"
                                            class="form-control form-control-alternative{{ $errors->has('disposable_amount') ? ' is-invalid' : '' }} placeholder="
                                            {{ __('ประเภท') }}">
                                        @if ($errors->has('disposable_amount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('disposable_amount') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label class="form-control-label"
                                               for="amount_minimum">{{ __('จำนวนน้อยสุด') }}</label>
                                        <input type="number" id="amount_minimum" name="amount_minimum" value="{{ old('amount_minimum') }}"
                                               class="form-control form-control-alternative{{ $errors->has('amount_minimum') ? ' is-invalid' : '' }} placeholder="
                                        {{ __('ประเภท') }}">
                                        @if ($errors->has('amount_minimum'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('amount_minimum') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="image">{{ __('รูปภาพ') }}</label>
                                        <input type="file" name="image" value="{{ old('image') }}"
                                            class="form-control form-control-alternative{{ $errors->has('image') ? ' is-invalid' : '' }} placeholder="
                                            {{ __('ประเภท') }}">
                                        @if ($errors->has('image'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('image') }}</strong></span>
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

@push('js')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script>
        let disposableAmount = document.getElementById("disposable_amount");
        let amountMinimum = document.getElementById("amount_minimum");

        $(document).ready(function () {
            $('#amount_minimum').on('change', function(){
                const valAmount = $('#disposable_amount').val();
                const valMinimum = $('#amount_minimum').val();
                if (valAmount < valMinimum){
                    Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        title: 'จำนวนทั้งหมดควรมากกว่าจำนวนน้อยสุด!',
                        showConfirmButton: true,
                        confirmButtonText: 'ตกลง'
                    })
                }
            });
        })
    </script>
@endpush
