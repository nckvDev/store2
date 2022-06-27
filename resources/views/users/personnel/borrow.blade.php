@extends('layouts.app', ['class' => 'bg-neutral'])
@section('content')
@include('layouts.headers.cards')

<div class="container-fluid mt--9">
    <div class="row">
        <div class="col-xl-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">ยืม-เบิกพัสดุ</li>
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
                    <form id="ajaxform">
                    <!-- <form method="post" action="{{ route('addStock') }}" enctype="multipart/form-data"
                    autocomplete="off"> -->
                    @csrf
                    <div class="pl-lg-2">
                        <div class="row">
                            <div class="col-xl-2">
                                <div class="form-group">
                                    <label class="form-control-label" for="stock_num">{{ __('คำนำหน้า') }}</label>
                                    <input type="text" name="stock_num" id="prefix"
                                        value="{{ auth()->user()->user_prefix->prefix_name }}"
                                        class="form-control form-control-alternative{{ $errors->has('stock_num') ? ' is-invalid' : '' }} "
                                        readonly>
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
                                    <input id="fname" type="text" name="stock_name"
                                        value="{{ auth()->user()->firstname }}"
                                        class="form-control form-control-alternative{{ $errors->has('stock_name') ? ' is-invalid' : '' }} "
                                        readonly>
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
                                    <input id="lname" type="text" name="stock_amount"
                                        value="{{ auth()->user()->lastname }}"
                                        class="form-control form-control-alternative{{ $errors->has('stock_amount') ? ' is-invalid' : '' }} "
                                        readonly>
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
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                        <input
                                            class="form-control datepicker {{ $errors->has('date') ? ' is-invalid' : '' }}"
                                            placeholder="Select date" type="datetime-local" value="{{ \Carbon\Carbon::now() }}">
                                    </div>
                                    @if ($errors->has('date'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('date') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row align-items-center">
                            <h3 class="mb-0 ml-4">{{ __('กรุณาเลือกพัสดุ') }}</h3>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <select class="js-example-basic-multiple" name="states[]" multiple="multiple"
                                    id="borrowItem" style="width:100%">
                                    @foreach($stocks as $row)
                                    <option value="AL">
                                        <tr>
                                            <td>{{ $row->stock_num }}</td>
                                            <td>{{ $row->stock_name }}</td>
                                    </option>
                                    @endforeach
                                    @foreach($devices as $row)
                                    <option value="AL">
                                        <tr>
                                            <td>{{ $row->device_num }}</td>
                                            <td>{{ $row->device_name }}</td>
                                            @if($row->device_status == 1)
                                            @endif
                                        </tr>
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <h3 class="mb-0 ml-4">{{ __('กรุณาเลือกวัสดุสิ้นเปลือง') }}</h3>
                        </div>
                        <div class="row">
                            <div class="col-12" style="display:flex">
                                <select class="js-example-basic-multiple" name="states[]" multiple="multiple"
                                    id="borrowDisposable" style="width:88%">
                                    @foreach($disposables as $row)
                                    <option value="AL">
                                        <tr>
                                            <td>{{ $row->disposable_num }}</td>
                                            <td>{{ $row->disposable_name }}</td>
                                    </option>
                                    @endforeach
                                    <input style="height:65%" type="num" id="numDisposable"
                                        placeholder="กรุณาระบุจำนวน">
                                </select>
                            </div>
                        </div> -->
                        <table id="example" class="display">
                            <thead>
                                <tr>
                                    <th>รหัสพัสดุ</th>
                                    <th>ชื่อพัสดุ</th>
                                    <th>เลือก</th>
                                </tr>
                            </thead>
                            <tbody id="borrowItem">
                                @foreach($stocks as $row)
                                <tr>
                                    <td>{{ $row->stock_num }}</td>
                                    <td>{{ $row->stock_name }}</td>
                                    <td><input type="checkbox" name="title[]" id="idItem" value="{{ $row->stock_num }}">
                                    </td>

                                </tr>
                                @endforeach
                                @foreach($devices as $row)
                                <tr>
                                    <td>{{ $row->device_num }}</td>
                                    <td>{{ $row->device_name }}</td>
                                    <td><input type="checkbox" name="title[]" id="idItem"
                                            value="{{ $row->device_num }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button onclick="submitdata()" type="submit"
                            class="btn btn-success mt-2">{{ __('ยืนยัน') }}</button>
                    </div>
                    <!-- </form> -->
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
<script>
$(function() {
    $('#example').dataTable({
        "language": {
            "search": "ค้นหา:",
            "lengthMenu": "จำนวนข้อมูลที่แสดง _MENU_",
            "info": "หน้าที่ _PAGE_ ถึง _PAGES_",
            "paginate": {
                "previous": "ปัจจุบัน",
                "next": "หน้า"
            }
        }
    });


    $('#button').click(function() {
        alert(table.rows('.selected').data().length + ' row(s) selected');
    });
});

function submitdata() {
    let number = $('input[type="checkbox"]:checked');
    let dataSend = [];
    for (var i = 0; i < number.length; i++) {
        dataSend[i] = number[i].value;
    }
    $.ajax({
        type: 'get',
        url: "#",
        dataSend: dataSend,
        success: (response) => {
            alert('success');
        },
        error: (err) => {
            alert('error');
        }
    });
    console.log('dataSent' ,dataSend);

    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    let data = {
        '_token': CSRF_TOKEN,
        'prefix': $('#prefix').val(),
        'fname': $('#fname').val(),
        'lname': $('#lname').val(),
        'borrowItem': $('#borrowItem').val(),
        'borrowDisposable': $('#borrowDisposable').val(),
        'numDisposable': $('#numDisposable').val()
    }
    console.log('data', data);
    return;
    $.ajax({
        type: 'post',
        url: "/personnel_borrow/borrow",
        data: data,
        success: function(response) {
            if (response.status === true) {
                Swal.fire({
                    icon: 'success',
                    timer: 1000,
                    showCancelButton: false,
                    showConfirmButton: true
                });
                $('#prefix').val('');
                $('#fname').val('');
                $('#lname').val('');
                $('#borrowItem').val('');
                $('#borrowDisposable').val('');
                $('#numDisposable').val('');
            } else {
                Swal.fire({
                    icon: 'success',
                    timer: 1000,
                    showCancelButton: false,
                    showConfirmButton: true
                })
            }

        }
    })
}
</script>
<script src="assets/vendor/select2/dist/js/select2.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
<script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
@endpush
