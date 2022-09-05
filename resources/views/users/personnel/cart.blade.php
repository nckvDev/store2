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

                        <table id="example" class="table align-items-center">
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
                            @foreach ($devices as $item)
                                @if($item->device_status == 0 && $item->defective_device == 0)
                                    @if($addData)
                                        @if(!in_array($item->device_num, $addData))
                                            <tr>
                                                <form action="{{ route('cart.store') }}" method="POST"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    <td><input type="text" value="{{ $item->device_num }}" name="id"
                                                               readonly style="width: 60px">
                                                    </td>
                                                    <td><input type="text" value="{{ $item->device_name }}"
                                                               name="name"
                                                               readonly style="width: 60px">
                                                    </td>
                                                    <td><img src="{{ $item->image }}" width="50" height="50"
                                                             readonly>
                                                    </td>
                                                    <input type="hidden" value="{{ $item->id }}" name="price"
                                                           readonly>
                                                    <input type="hidden" value="{{ $item->image }}" name="image"
                                                           readonly>
                                                    <td>
                                                        <input type="text" value="{{ $item->device_amount }}"
                                                               name="quantity" readonly>
                                                    </td>

                                                    <input type="hidden" value="1" name="price" readonly
                                                           style="width: 60px">
                                                    <td>
                                                        <button class="btn btn-primary btn-sm">เลือก</button>
                                                    </td>
                                                </form>
                                            </tr>
                                        @endif
                                    @else
                                        <tr>
                                            <form action="{{ route('cart.store') }}" method="POST"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <td>
                                                    <input type="text" value="{{ $item->device_num }}" name="id"
                                                           readonly style="width: 60px">
                                                </td>
                                                <td>
                                                    <input type="text" value="{{ $item->device_name }}" name="name"
                                                           readonly style="width: 60px">
                                                </td>
                                                <td>
                                                    <img src="{{ $item->image }}" width="50" height="50" readonly>
                                                </td>
                                                <input type="hidden" value="{{ $item->id }}" name="price" readonly>
                                                <input type="hidden" value="{{ $item->image }}" name="image"
                                                       readonly>
                                                <td>
                                                    <input type="text" value="{{ $item->device_amount }}"
                                                           name="quantity" readonly>
                                                </td>

                                                <input type="hidden" value="1" name="price" readonly
                                                       style="width: 60px">
                                                <td>
                                                    <button class="btn btn-primary btn-sm">เลือก</button>
                                                </td>
                                            </form>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                            @foreach ($stocks as $item)
                                @if($item->stock_status == 0 && $item->defective_stock == 0)
                                    @if($addData)
                                        @if(!in_array($item->stock_num, $addData))
                                            <tr>
                                                <form action="{{ route('cart.store') }}" method="POST"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    <td><input type="text" value="{{ $item->stock_num }}" name="id"
                                                               readonly style="width: 60px">
                                                    </td>
                                                    <td><input type="text" value="{{ $item->stock_name }}"
                                                               name="name"
                                                               readonly style="width: 60px">
                                                    </td>
                                                    <td><img src="{{ $item->image }}" width="80" height="80"
                                                             readonly>
                                                    </td>
                                                    <input type="hidden" value="{{ $item->id }}" name="price"
                                                           readonly>
                                                    <input type="hidden" value="{{ $item->image }}" name="image"
                                                           width="50" height="50"
                                                           readonly>
                                                    <td>
                                                        <input type="text" value="{{ $item->stock_amount }}"
                                                               name="quantity" readonly>
                                                    </td>

                                                    <input type="hidden" value="1" name="price"
                                                           readonly style="width: 60px">
                                                    <td>
                                                        <button class="btn btn-primary btn-sm">เลือก</button>
                                                    </td>
                                                </form>
                                            </tr>
                                        @endif
                                    @else
                                        <tr>
                                            <form action="{{ route('cart.store') }}" method="POST"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <td><input type="text" value="{{ $item->stock_num }}" name="id"
                                                           readonly style="width: 60px">
                                                </td>
                                                <td><input type="text" value="{{ $item->stock_name }}"
                                                           name="name"
                                                           readonly style="width: 60px">
                                                </td>
                                                <td><img src="{{ $item->image }}" width="50" height="50"
                                                         readonly>
                                                </td>
                                                <input type="hidden" value="{{ $item->id }}" name="price" readonly>
                                                <input type="hidden" value="{{ $item->image }}" name="image"
                                                       readonly>
                                                <td>
                                                    <input type="text" value="{{ $item->stock_amount }}"
                                                           name="quantity" readonly>
                                                </td>

                                                <input type="hidden" value="1" name="price" readonly
                                                       style="width: 60px">
                                                <td>
                                                    <button class="btn btn-primary btn-sm">เลือก</button>
                                                </td>
                                            </form>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                            @foreach ($disposables as $item)
                                <tr>
                                    <form action="{{ route('cart.store') }}" method="POST"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <td><input type="text" value="{{ $item->disposable_num }}" name="id"
                                                   readonly style="width: 60px">
                                        </td>
                                        <td><input type="text" value="{{ $item->disposable_name }}" name="name"
                                                   readonly style="width: 60px">
                                        </td>
                                        <td><img src="{{ $item->image }}" width="50" height="50" readonly></td>
                                        {{--                                            <input type="hidden" value="1" name="price" readonly>--}}
                                        <input type="hidden" value="{{ $item->image }}" name="image" readonly>
                                        <td>
                                            <input type="text" value="{{ $item->disposable_amount }}"
                                                   name="quantity" readonly>
                                        </td>

                                        <input type="hidden" value="1" name="price"
                                               readonly style="width: 60px">
                                        <td>
                                            <button class="btn btn-primary btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#exampleModal">เลือก
                                            </button>
                                        </td>

                                        {{--                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"--}}
                                        {{--                                                 aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
                                        {{--                                                <div class="modal-dialog" role="document">--}}
                                        {{--                                                    <div class="modal-content">--}}
                                        {{--                                                        <div class="modal-header">--}}
                                        {{--                                                            <h3 class="modal-title" id="name">--}}
                                        {{--                                                                ระบุจำนวน</h3>--}}
                                        {{--                                                            <button type="button" class="close" data-dismiss="modal"--}}
                                        {{--                                                                    aria-label="Close">--}}
                                        {{--                                                                <span aria-hidden="true">&times;</span>--}}
                                        {{--                                                            </button>--}}
                                        {{--                                                        </div>--}}
                                        {{--                                                        <div class="modal-body">--}}
                                        {{--                                                            <input type="text" value="" name="quantity" id="name"--}}
                                        {{--                                                                   class="form-control form-control-muted"--}}
                                        {{--                                                                   placeholder="กรุณาใส่จำนวน">--}}
                                        {{--                                                        </div>--}}
                                        {{--                                                        <div class="modal-footer">--}}
                                        {{--                                                            <button type="button" class="btn btn-secondary"--}}
                                        {{--                                                                    data-dismiss="modal">ปิด--}}
                                        {{--                                                            </button>--}}
                                        {{--                                                            <button class="btn btn-primary">ตกลง</button>--}}
                                        {{--                                                        </div>--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                </div>--}}
                                        {{--                                            </div>--}}
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
                                    <div class="flex flex-col sm:flex-row">
                                        <svg class="w-5 h-5" fill="none" stroke-linecap="round"
                                             stroke-linejoin="round"
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
                                                    <input type="hidden" value="1" name="borrow_status"
                                                           readonly>
                                                    <td>
                                                        <input type="text" name="borrow_amount[]"
                                                               value="1"
                                                               class="w-10 text-center bg-gray-100"/>
                                                        <form action="{{ route('cart.update') }}" method="POST"
                                                              enctype="multipart/form-data">
                                                            @csrf
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('cart.remove') }}" method="POST"
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
        $(function () {
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


        $(function () {
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
            $('[type=search]').each(function () {
                +
                    $(this).attr("placeholder", "Search...");
                $(this).before('<span class="fa fa-search"></span>');
            });
            $('#button').click(function () {
                alert(table.rows('.selected').data().length + ' row(s) selected');
            });
        });
    </script>


    <script src="assets/vendor/select2/dist/js/select2.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
@endpush
