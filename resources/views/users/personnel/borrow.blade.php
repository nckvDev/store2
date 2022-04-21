@extends('layouts.app', ['class' => 'bg-neutral'])
@section('content')
    @include('layouts.headers.cards')
    <div class="container-fluid mt--9">
        <div class="row">
            <div class="col-xl-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">ยืมอุปกรณ์</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 mb-4">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="mb-0 ml-4">{{ __('ยืมวัสดุ-พัสดุ') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('addStock') }}" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <div class="pl-lg-2">
                                <div class="row">
                                    <div class="col-xl-2">
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                   for="stock_num">{{ __('คำนำหน้า') }}</label>
                                            <input type="text" name="stock_num"
                                                   value="{{ auth()->user()->user_prefix->prefix_name }}"
                                                   class="form-control form-control-alternative{{ $errors->has('stock_num') ? ' is-invalid' : '' }} " disabled>
                                            @if ($errors->has('stock_num'))
                                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('stock_num') }}</strong>
                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-5">
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                   for="stock_name">{{ __('ชื่อ') }}</label>
                                            <input type="text" name="stock_name" value="{{ auth()->user()->firstname }}"
                                                   class="form-control form-control-alternative{{ $errors->has('stock_name') ? ' is-invalid' : '' }} " disabled>
                                            @if ($errors->has('stock_name'))
                                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('stock_name') }}</strong>
                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-5">
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                   for="stock_amount">{{ __('นามสกุล') }}</label>
                                            <input type="text" name="stock_amount" value="{{ auth()->user()->lastname }}"
                                                   class="form-control form-control-alternative{{ $errors->has('stock_amount') ? ' is-invalid' : '' }} " disabled>
                                            @if ($errors->has('stock_amount'))
                                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('stock_amount') }}</strong>
                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4">
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                   for="date">{{ __('วันที่ยืม') }}</label>
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                </div>
                                                <input class="form-control datepicker {{ $errors->has('date') ? ' is-invalid' : '' }}" placeholder="Select date" type="text" value="{{ \Carbon\Carbon::now() }}">
                                            </div>
                                            @if ($errors->has('date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('date') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                   for="amount_minimum">{{ __('อุปกรณ์ที่ต้องการยืม') }}</label>
                                            {{--                                            <input type="text" name="amount_minimum" value="{{ old('amount_minimum') }}"--}}
                                            {{--                                                   class="form-control form-control-alternative{{ $errors->has('amount_minimum') ? ' is-invalid' : '' }} placeholder="{{ __('ประเภท') }}" >--}}

                                            <select class="form-control form-control-alternative" data-toggle="select" >
                                                <option>-- เลือก --</option>
                                                <option>วัสดุ</option>
                                                <option>วัสดุสิ้นเปลือง</option>
                                                {{--                                                @foreach($stocks as $row)--}}
                                                {{--                                                <option value="{{$row->id}}">{{$row->stock_name}} {{ $row->id }}</option>--}}
                                                {{--                                                @endforeach --}}
                                            </select>
                                            @if ($errors->has('amount_minimum'))
                                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('amount_minimum') }}</strong>
                                </span>
                                            @endif
                                            {{--                                            <textarea class="form-control form-control-alternative my-2" rows="3" placeholder="Write a large text here ..."></textarea>--}}
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
    <script src="assets/vendor/select2/dist/js/select2.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
@endpush


