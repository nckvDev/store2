@extends('layouts.app', ['class' => 'bg-neutral'])

@section('content')
    @include('layouts.headers.cards')
    <div class="container-fluid mt--9">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">เบิกวัสดุสิ้นเปลือง</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-7 mb-4">
                <div class="card bg-secondary shadow">
                    <div class="card-body">
                        @php
                            $addData = array();
                        @endphp

                        @if(session('4yTlTDKu3oJOfzD_cart_items'))
                            @foreach(session('4yTlTDKu3oJOfzD_cart_items') as $data)
                                @php
                                    $addData[] = $data->id;
                                @endphp
                            @endforeach
                        @endif

                        <form action="{{ route('student_borrow_disposable.list') }}" method="GET">
                            <h3>ประเภท</h3>
                            <div class="row">
                                <div class="col-sm-5 mb-3">
                                    <select class="form-control" name="type" id="data_type">
                                        <option value="">เลือกประเภทพัสดุ</option>
                                        @foreach($types as $item)
                                            <option
                                                value="{{$item->id}}" {{ old('type') == $item->id ? 'selected' : null }} >
                                                {{$item->type_detail}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-5">
                                    <input class="form-control w-100" name="name" placeholder="ค้นหาชื่อ..">
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-default w-100">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="example" class="mt-3">
                                <thead class="thead-light">
                                <tr>
                                    <th>รหัสพัสดุ</th>
                                    <th>ชื่อพัสดุ</th>
                                    <th>รูปภาพ</th>
                                    <th>จำนวน</th>
                                    <th>เลือก</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($disposables as $item)
                                    <tr>
                                        <form action="{{ route('student_borrow_disposable.add') }}" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <td><input type="text" value="{{ $item->disposable_num }}" name="id"
                                                       readonly style="width: 60px">
                                            </td>
                                            <td><input type="text" value="{{ $item->disposable_name }}" name="name"
                                                       readonly>
                                            </td>
                                            <td><img src="{{ $item->image }}" width="50" height="50" readonly
                                                     alt="image disposable"></td>
                                            {{--                                            <input type="hidden" value="1" name="price" readonly>--}}
                                            <input type="hidden" value="{{ $item->image }}" name="image" readonly>
                                            <td>
                                                <input type="text" value="{{ $item->disposable_amount }}"
                                                       name="quantity"
                                                       readonly style="width: 60px">
                                            </td>

                                            <input type="hidden" value="1" name="price" readonly
                                                   style="width: max-content">
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#exampleModal">เลือก
                                                </button>
                                            </td>
                                        </form>
                                    </tr>
                                @endforeach
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
                            <h3 class="mb-4 ml-4">{{ __('รายการยืม') }}</h3>
                        </div>
                        <div class="container">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('student_borrow_disposable.save') }}" method="post">
                                        @csrf
                                        <div class="table-responsive">
                                            <table id="myTable">
                                                <thead>
                                                {{--                                                                                       {{(dd(session('4yTlTDKu3oJOfzD_cart_items')) )}}--}}
                                                <tr>
                                                    <th>รหัสรายการ</th>
                                                    <th>ชื่อรายการ</th>
                                                    <th>จำนวน</th>
                                                    <th>ลบ</th>
                                                </tr>
                                                </thead>
                                                @foreach ($cartItems as $item)
                                                    <tbody id="borrowItem">
                                                    <tr>
                                                        <td>
                                                            <input type="text" value="{{ $item->id }}"
                                                                   name="borrow_list_id[]"
                                                                   readonly style="width: 60px">
                                                        </td>
                                                        <td><input type="text" value="{{ $item->name }}"
                                                                   name="borrow_name[]"
                                                                   readonly style="width: 60px"></td>
                                                        <input type="hidden" value="{{ $item->price }}"
                                                               name="borrow_id[]"
                                                               readonly>
                                                        <input type="hidden" value="1" name="borrow_status" readonly>
                                                        <td>
                                                            <input type="{{ $item->quantity > 1 ? 'number' : 'text'}}"
                                                                   name="borrow_amount[]" value="1"
                                                                   class="w-10 text-center bg-gray-100">
                                                            <form action="{{ route('student_borrow_disposable.update') }}"
                                                                  method="POST"
                                                                  enctype="multipart/form-data">
                                                                @csrf
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <form action="{{ route('student_borrow_disposable.remove') }}"
                                                                  method="POST"
                                                                  enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" value="{{ $item->id }}" name="id">
                                                                <button type="submit" class="btn btn-danger btn-sm">ลบ
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                @endforeach
                                            </table>
                                        </div>
                                        <a class="btn btn-outline-danger btn-sm mt-4"
                                           href="{{ route('student_borrow_disposable.clear') }}"> ลบทั้งหมด </a>
                                        <button type="submit" class="btn btn-success btn-sm mt-4">ยืนยัน</button>
                                    </form>

                                    @if (session('successes'))
                                        <script>
                                            Swal.fire({
                                                position: 'center',
                                                icon: 'success',
                                                title: 'ยืนยันรายการยืมสำเร็จ',
                                                showConfirmButton: true,
                                            })
                                        </script>
                                    @endif
                                    @if (session('warning'))
                                        <script>
                                            Swal.fire({
                                                position: 'center',
                                                icon: 'warning',
                                                title: 'จำนวนวัสดุไม่เพียงพอ!',
                                                showConfirmButton: true,
                                                confirmButtonText: 'ตกลง'
                                            })
                                        </script>
                                    @endif
                                    @if (session('error'))
                                        <script>
                                            Swal.fire({
                                                position: 'center',
                                                icon: 'error',
                                                title: 'ไม่มีรายการที่เลือก!',
                                                showConfirmButton: true,
                                                confirmButtonText: 'ตกลง'
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
        $(function () {
            $.extend($.fn.dataTableExt.oStdClasses, {
                "sFilterInput": "form-control form-control-sm",
                "sLengthSelect": "form-control form-control-sm"
            });

            $('#example').dataTable({
                "searching": false,
                "lengthChange": false,
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

            $('#myTable').dataTable({
                "searching": false,
                "lengthChange": false,
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": true,
                "bInfo": false,
                "bAutoWidth": false,
                "language": {
                    "zeroRecords": "ไม่พบข้อมูล - ขออภัย",
                },
            });
        });
    </script>
@endpush
