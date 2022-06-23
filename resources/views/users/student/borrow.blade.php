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
                        <h3 class="mb-0 ml-4">{{ __('ยืมอุปกรณ์') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="#" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="pl-lg-2">
                            <div class="row">
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="stock_num">{{ __('คำนำหน้า') }}</label>
                                        <input type="text" name="stock_num"
                                            value="{{ auth()->user()->user_prefix->prefix_name }}"
                                            class="form-control form-control-alternative{{ $errors->has('stock_num') ? ' is-invalid' : '' }} "
                                            disabled>
                                        @if ($errors->has('stock_num'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('stock_num') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-5">
                                    <div class="form-group">
                                        <label class="form-control-label" for="stock_name">{{ __('ชื่อ') }}</label>
                                        <input type="text" name="stock_name" value="{{ auth()->user()->firstname }}"
                                            class="form-control form-control-alternative{{ $errors->has('stock_name') ? ' is-invalid' : '' }} "
                                            disabled>
                                        @if ($errors->has('stock_name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('stock_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-5">
                                    <div class="form-group">
                                        <label class="form-control-label" for="stock_amount">{{ __('นามสกุล') }}</label>
                                        <input type="text" name="stock_amount" value="{{ auth()->user()->lastname }}"
                                            class="form-control form-control-alternative{{ $errors->has('stock_amount') ? ' is-invalid' : '' }} "
                                            disabled>
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
                                        <label class="form-control-label" for="date">{{ __('วันที่ยืม') }}</label>
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="ni ni-calendar-grid-58"></i></span>
                                            </div>
                                            <input
                                                class="form-control datepicker {{ $errors->has('date') ? ' is-invalid' : '' }}"
                                                placeholder="Select date" type="text"
                                                value="{{ \Carbon\Carbon::now() }}">
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
                                        {{--                                                   class="form-control form-control-alternative{{ $errors->has('amount_minimum') ? ' is-invalid' : '' }}
                                        placeholder="{{ __('ประเภท') }}" >--}}

                                        <select class="form-control form-control-alternative filter" name="filter"
                                            id="filter" data-toggle="select">
                                            <option>-- เลือก --</option>
                                            {{--                                                <option>วัสดุ</option>--}}
                                            {{--                                                <option>วัสดุสิ้นเปลือง</option>--}}
                                            @foreach($types as $row)
                                            <option value="{{$row->id}}">{{$row->type_detail}} {{ $row->id }}</option>
                                            @endforeach
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
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="nav-wrapper">
                                        <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text"
                                            role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab"
                                                    data-toggle="tab" href="#tabs-icons-text-1" role="tab"
                                                    aria-controls="tabs-icons-text-1" aria-selected="true"><i
                                                        class="ni ni-settings mr-2"></i>วัสดุ</a>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel"
                                            aria-labelledby="tabs-icons-text-1-tab">
                                            <div class="card shadow mb-3">
                                                <div class="table-responsive">
                                                    <table class="table align-items-center table-flush">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th scope="col">รหัสอุปกรณ์</th>
                                                                <th scope="col">ชื่ออุปกรณ์</th>
                                                                <th scope="col" class="text-center">สถานะ</th>
                                                                <th scope="col" class="text-center">รูปภาพ</th>
                                                                <th scope="col">ตำแหน่ง</th>
                                                                <th scope="col">ประเภท</th>
                                                                <th scope="col"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($stocks as $row)
                                                            <tr>
                                                                <td>{{ $row->stock_num }}</td>
                                                                <td>{{ $row->stock_name }}</td>
                                                                @if($row->stock_status == 1)
                                                                <td>
                                                                    <div
                                                                        class="rounded text-white bg-green text-center">
                                                                        ปกติ</div>
                                                                </td>
                                                                @endif
                                                                <td><img src="{{ asset($row->image) }}"
                                                                        class="rounded mx-auto d-block " width="80"
                                                                        height="80" /></td>
                                                                <td>{{ $row->position }}</td>
                                                                <td>{{ $row->stock_type->type_detail }}</td>
                                                                <td class="text-right">
                                                                    <a href="#"
                                                                        class="btn btn-sm bg-gradient-green text-white">เลือก</a>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>

                                                    @if (session('delete'))
                                                    <script>
                                                    Swal.fire({
                                                        position: 'center',
                                                        icon: 'error',
                                                        title: 'ลบข้อมูลเรียบร้อย',
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