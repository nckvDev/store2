@extends('layouts.app', ['class' => 'bg-neutral'])

@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--9">
    @csrf
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
        <div class="col-xl-7 mb-4">
            <div class="card bg-secondary shadow">
                <div class="card-body">
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
                                    <label class="form-control-label" for="firstname">{{ __('ชื่อ') }}</label>
                                    <input id="fname" type="text" name="firstname"
                                        value="{{ auth()->user()->firstname }}"
                                        class="form-control form-control-alternative{{ $errors->has('firstname') ? ' is-invalid' : '' }} "
                                        readonly>
                                    @if ($errors->has('firstname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="form-group">
                                    <label class="form-control-label" for="lastname">{{ __('นามสกุล') }}</label>
                                    <input id="lname" type="text" name="lastname"
                                        value="{{ auth()->user()->lastname }}"
                                        class="form-control form-control-alternative{{ $errors->has('lastname') ? ' is-invalid' : '' }} "
                                        readonly>
                                    @if ($errors->has('lastname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <table id="example" class="table align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th>รหัสพัสดุ</th>
                                    <th>ชื่อพัสดุ</th>
                                    <th>รูปภาพ</th>
                                    <th>เลือก</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <form action="{{ route('cart.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @foreach ($devices as $item)
                                        <td><input type="text" value="{{ $item->device_num }}" name="id" readonly></td>
                                        <td><input type="text" value="{{ $item->device_name }}" name="name" readonly>
                                        </td>
                                        <td><img src="{{ $item->image }}" width="80" height="80" readonly></td>
                                        <input type="hidden" value="1" name="price" readonly>
                                        <input type="hidden" value="{{ $item->image }}" name="image" readonly>
                                        <input type="hidden" value="1" name="quantity" readonly>
                                        @endforeach

                                        <td> <button class="btn btn-primary btn-sm">เลือก</button></td>

                                    </form>
                                </tr>
                                <tr>
                                    <form action="{{ route('cart.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @foreach ($stocks as $item)
                                        <td><input type="text" value="{{ $item->stock_num }}" name="id" readonly></td>
                                        <td><input type="text" value="{{ $item->stock_name }}" name="name" readonly>
                                        </td>
                                        <td><img src="{{ $item->image }}" width="80" height="80" readonly></td>
                                        <input type="hidden" value="1" name="price" readonly>
                                        <input type="hidden" value="{{ $item->image }}" name="image" readonly>
                                        <input type="hidden" value="1" name="quantity" readonly>
                                        @endforeach
                                        <td><button class="btn btn-primary btn-sm">เลือก</button></td>
                                    </form>
                                </tr>

                                <tr>
                                      <form action="{{ route('cart.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @foreach ($disposables as $item)

                                        <td><input type="text" value="{{ $item->disposable_num }}" name="id" readonly>
                                        </td>
                                        <td><input type="text" value="{{ $item->disposable_name }}" name="name" readonly>
                                        </td>
                                        <td><img src="{{ $item->image }}" width="80" height="80" readonly></td>
                                        <input type="hidden" value="1" name="price" readonly>
                                        <input type="hidden" value="{{ $item->image }}" name="image" readonly>
                                        <input type="hidden" value="1" name="quantity" readonly>
                                        <td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#exampleModal">เลือก</button>
                                        </td>
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title" id="name">
                                                            ระบุจำนวน</h3>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="text" value="" name="quantity" id="name"
                                                            class="form-control form-control-muted"
                                                            placeholder="กรุณาใส่จำนวน">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">ปิด</button>
                                                        <button class="btn btn-primary">ตกลง</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </form>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5 mb-4">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0 ml-4">{{ __('รายการพัสดุ') }}</h3>
                    </div>
                    <div class="container">
                        <div class="card">
                            <div class="card-body">
                                <div class="flex flex-col sm:flex-row">
                                    <svg class="w-5 h-5" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    {{ Cart::getTotalQuantity()}}
                                    </a>
                                </div>
                                <form action="{{ route('cart.save') }}" method="post">
                                    @csrf
                                    <button class="btn btn-success btn-sm">ยืนยัน</button>
                                    <table id="myTable">
                                        <thead>
                                            <!-- {{(session('4yTlTDKu3oJOfzD_cart_items'))}} -->
                                            <tr>
                                                <th>รหัสพัสดุ</th>
                                                <th>ชื่อพัสดุ</th>
                                                <th>จำนวน</th>
                                                <th>ลบ</th>
                                            </tr>
                                        </thead>
                                        @foreach ($cartItems as $item)
                                        <tbody id="borrowItem">
                                            <tr>
                                                <td>
                                                    <input type="text" value="{{ $item->id }}" name="borrow_id"
                                                        readonly style="width: 60px">
                                                </td>
                                                <td><input type="text" value="{{ $item->name }}" name="borrow_name"
                                                        readonly style="width: 90px"></td>
                                                <td>
                                                    <form action="{{ route('cart.update') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $item->id}}">
                                                        <input type="number" name="quantity"
                                                            value="{{ $item->quantity }}"
                                                            class="w-6 text-center bg-gray-300" />
                                                        <button type="submit"
                                                            class="btn btn-warning btn-sm">แก้ไข</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form action="{{ route('cart.remove') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" value="{{ $item->id }}" name="id">
                                                        <button class="btn btn-danger btn-sm">ลบ</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                </form>
                                <form action="{{ route('cart.clear') }}" method="POST">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">ลบทั้งหมด</button>
                                </form>

                                @if (session('successes'))
                                    <script>
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'success',
                                            title: 'ยืนยันรายการยืมสำเร็จ',
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
    </div>

</div>
@endsection

@push('js')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
$(function() {
    $('#myTable').dataTable({
        "searching": false,
        "lengthChange": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": false,
        ajax: "",
        columns: [{
                data: 'DT_RowIndex'
            },
            {
                data: 'name'
            },
        ]
    });
});


$(function() {
    $.extend($.fn.dataTableExt.oStdClasses, {
        "sFilterInput": "form-control form-control-sm",
        "sLengthSelect": "form-control form-control-sm"
    });
    $('#example').dataTable({
        "language": {
            "search": "ค้นหา ",
            "lengthMenu": "จำนวนข้อมูลที่แสดง _MENU_",
            "zeroRecords": "ไม่พบข้อมูล - ขออภัย",
            "info": "หน้าที่ _PAGE_ ถึง _PAGES_",
            "infoEmpty": "ไม่มีข้อมูล",
            "infoFiltered": "(ค้นหาจาก _MAX_ ข้อมูลทั้งหมด)",
            "paginate": {
                "previous": "ปัจจุบัน",
                "next": "หน้า"
            }
        }
    });
    $('[type=search]').each(function() {
        +
        $(this).attr("placeholder", "Search...");
        $(this).before('<span class="fa fa-search"></span>');
    });
    $('#button').click(function() {
        alert(table.rows('.selected').data().length + ' row(s) selected');
    });
});
</script>


<script src="assets/vendor/select2/dist/js/select2.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
<script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
@endpush
