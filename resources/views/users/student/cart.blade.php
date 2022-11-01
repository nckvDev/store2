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
                        <form action="{{ route('student_borrow.list') }}" method="GET">
                            <h3>ประเภท</h3>
                            <div class="mb-3">
                                <select class="form-control" name="type" id="data_type">
                                    <option value="">เลือกประเภทพัสดุ</option>
                                    @foreach($types as $item)
                                        <option value="{{$item->id}}" {{ old('type') == $item->id ? 'selected' : '' }} >
                                            {{$item->type_detail}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="submit" value="Search" class="btn btn-outline-secondary">
                        </form>

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
                            <tbody id="datalist">
                            @foreach ($stocks as $item)
                                @if($addData)
                                    @if(!in_array($item->stock_num, $addData))
                                        <tr>
                                            <form action="{{ route('student_borrow.add') }}" method="POST"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <td><input type="text" value="{{ $item->stock_num }}" name="id"
                                                           readonly
                                                           style="width: 60px">
                                                </td>
                                                <td><input type="text" value="{{ $item->stock_name }}" name="name"
                                                           readonly>
                                                </td>
                                                <td><img src="{{ $item->image }}" width="80" height="80" readonly>
                                                </td>
                                                <input type="hidden" value="{{ $item->id }}" name="price" readonly>
                                                <input type="hidden" value="{{ $item->image }}" name="image"
                                                       width="50" height="50"
                                                       readonly>
                                                <td>
                                                    <input type="text" value="{{ $item->stock_amount }}"
                                                           name="quantity" readonly style="width: 60px">
                                                </td>

                                                <input type="hidden" value="1" name="price" readonly>
                                                <td>
                                                    <button class="btn btn-primary btn-sm">เลือก</button>
                                                </td>
                                            </form>
                                        </tr>
                                    @endif
                                @else
                                    <tr>
                                        <form action="{{ route('student_borrow.add') }}" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <td><input type="text" value="{{ $item->stock_num }}" name="id" readonly
                                                       style="width: 60px">
                                            </td>
                                            <td><input type="text" value="{{ $item->stock_name }}" name="name"
                                                       readonly>
                                            </td>
                                            <td><img src="{{ $item->image }}" width="50" height="50" readonly>
                                            </td>
                                            <input type="hidden" value="{{ $item->id }}" name="price" readonly>
                                            <input type="hidden" value="{{ $item->image }}" name="image" readonly>
                                            <td>
                                                <input type="text" value="{{ $item->stock_amount }}" name="quantity"
                                                       readonly style="width: 60px">
                                            </td>

                                            <input type="hidden" value="1" name="price" readonly
                                                   style="width: max-content">
                                            <td>
                                                <button class="btn btn-primary btn-sm">เลือก</button>
                                            </td>
                                        </form>
                                    </tr>
                                @endif
                            @endforeach
                            @foreach ($disposables as $item)
                                <tr>
                                    <form action="{{ route('student_borrow.add') }}" method="POST"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <td><input type="text" value="{{ $item->disposable_num }}" name="id"
                                                   readonly style="width: 60px">
                                        </td>
                                        <td><input type="text" value="{{ $item->disposable_name }}" name="name"
                                                   readonly>
                                        </td>
                                        <td><img src="{{ $item->image }}" width="50" height="50" readonly></td>
                                        {{--                                            <input type="hidden" value="1" name="price" readonly>--}}
                                        <input type="hidden" value="{{ $item->image }}" name="image" readonly>
                                        <td>
                                            <input type="text" value="{{ $item->disposable_amount }}" name="quantity"
                                                   readonly style="width: 60px">
                                        </td>

                                        <input type="hidden" value="1" name="price" readonly style="width: max-content">
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
            <div class="col-xl-5 mb-4">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="mb-4 ml-4">{{ __('รายการยืม') }}</h3>
                        </div>
                        <div class="container">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ route('student_borrow.save') }}" method="post">
                                        @csrf
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="started_at">
                                                        วันที่ยืม
                                                    </label>
                                                    <div class="input-group input-group-alternative">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="ni ni-calendar-grid-58"></i></span>
                                                        </div>
                                                        <input class="form-control" name="started_at"
                                                               placeholder="Start date" type="datetime-local"
                                                               pattern="MM-DD-YYYY HH:mm"
                                                               value="{{ old('started_at') }}">
                                                    </div>
                                                    @if ($errors->has('started_at'))
                                                        <span class="invalid-feedback" style="display: block;"
                                                              role="alert">
                                                         <strong>{{ $errors->first('started_at') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="started_at">
                                                        วันที่คืน
                                                    </label>
                                                    <div class="input-group input-group-alternative">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="ni ni-calendar-grid-58"></i></span>
                                                        </div>
                                                        <input class="form-control" name="end_at" placeholder="End date"
                                                               type="datetime-local" pattern="MM-DD-YYYY HH:mm"
                                                               value="{{ old('end_at') }}">
                                                    </div>
                                                    @if ($errors->has('end_at'))
                                                        <span class="invalid-feedback" style="display: block;"
                                                              role="alert">
                                                         <strong>{{ $errors->first('end_at') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        {{--                                        <div class="flex flex-col sm:flex-row">--}}
                                        {{--                                            <svg class="w-5 h-5" fill="none" stroke-linecap="round"--}}
                                        {{--                                                 stroke-linejoin="round"--}}
                                        {{--                                                 stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">--}}
                                        {{--                                                <path--}}
                                        {{--                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">--}}
                                        {{--                                                </path>--}}
                                        {{--                                            </svg>--}}
                                        {{--                                            {{ Cart::getTotalQuantity()}}--}}
                                        {{--                                            </a>--}}
                                        {{--                                        </div>--}}

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
                                                    <input type="hidden" value="{{ $item->price }}" name="borrow_id[]"
                                                           readonly>
                                                    <input type="hidden" value="1" name="borrow_status" readonly>
                                                    <td>
                                                        <input type="{{ $item->quantity > 1 ? 'number' : 'text'}}"
                                                               name="borrow_amount[]" value="1"
                                                               class="w-10 text-center bg-gray-100">
                                                        <form action="{{ route('student_borrow.update') }}"
                                                              method="POST"
                                                              enctype="multipart/form-data">
                                                            @csrf
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('student_borrow.remove') }}"
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
        {{csrf_field()}}
    </div>
@endsection

@push('js')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script>
        // $(document).ready(function () {
        //     var notFoundCount = -7;
        //     $("#search").on("keyup", function () {
        //         var value = $(this).val().toLowerCase(),
        //             $tr = $("#example tbody tr");
        //         $tr.each(function () {
        //             var found = 0;
        //             $(this).find("input").each(function () {
        //                 found += $(this).val().indexOf(value)
        //             });
        //             if (found > notFoundCount) {
        //                 $(this).closest('tr').show();
        //             } else {
        //                 $(this).closest('tr').hide();
        //             }
        //         });
        //     });
        // });

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
            $('[type=search]').each(function () {
                +
                    $(this).attr("placeholder", "Search...");
                $(this).before('<span class="fa fa-search"></span>');
            });
            $('#button').click(function () {
                alert(table.rows('.selected').data().length + ' row(s) selected');
            });

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

        {{--$(function () {--}}
        {{--    $('#data_type').change(function () {--}}
        {{--        const select = $(this).val();--}}
        {{--        console.log(select);--}}
        {{--        $.ajax({--}}
        {{--            method: "GET",--}}
        {{--            url: "{{route('student_borrow.search')}}",--}}
        {{--            data: {selected: select},--}}
        {{--            success: function (msg) {--}}
        {{--                console.log('hello', msg)--}}
        {{--            },--}}
        {{--            error: function (status, error) {--}}
        {{--                alert(status);--}}
        {{--            }--}}
        {{--        });--}}
        {{--    });--}}
        {{--});--}}
    </script>
@endpush
