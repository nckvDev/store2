@extends('layouts.app', ['class' => 'bg-neutral'])

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--9">
        <div class="row">
            <div class="col-xl-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">พัสดุทั้งหมด</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 ">
                <div class="nav-wrapper">
                    <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab"
                               href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1"
                               aria-selected="true"><i class="ni ni-settings mr-2"></i>วัสดุ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab"
                               href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2"
                               aria-selected="false"><i class="fa fa-toolbox mr-2"></i>ครุภัณฑ์</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab"
                               href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3"
                               aria-selected="false"><i class="fa fa-toolbox mr-3"></i>วัสดุสิ้นเปลือง</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel"
                         aria-labelledby="tabs-icons-text-1-tab">
                        <div class="card shadow p-4">
                            <table id="table_stock">
                                <thead>
                                <tr>
                                    <th>รหัสวัสดุ</th>
                                    <th>ชื่อวัสดุ</th>
                                    <th class="text-center">รูปภาพ</th>
                                    <th class="text-center">จำนวน</th>
                                    <th>ประเภท</th>
                                    <th class="text-center">สถานะ</th>
                                    <th class="text-center">จัดการ</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($stocks as $row)
                                    <tr>
                                        <td>{{ $row->stock_num }}</td>
                                        <td>{{ $row->stock_name }}</td>
                                        @if($row->image == 0)
                                            <td><img src="{{asset('images/imageNull/null.png')}}"
                                                     class="rounded mx-auto d-block " width="80" height="80"/></td>
                                        @else
                                            <td><img src="{{ asset($row->image) }}" class="rounded mx-auto d-block "
                                                     width="80"
                                                     height="80"/>
                                                @endif
                                            </td>

                                        <td class="text-center">{{ $row->stock_amount }}</td>

                                        <td>{{ $row->stock_type->type_detail }}</td>
                                            @if($row->stock_status == 0)
                                                <td>
                                                    <div class="rounded text-white bg-green text-center">พร้อมใช้งาน</div>
                                                </td>
                                            @elseif($row->stock_status == 1)
                                                <td>
                                                    <div class="rounded text-white bg-orange text-center">รออนุมัติ</div>
                                                </td>
                                            @elseif($row->stock_status == 2)
                                                <td>
                                                    <div class="rounded text-white bg-red text-center">ถูกยืม</div>
                                                </td>
                                            @endif
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item"
                                                       href="{{ url('/stock/edit/'.$row->id) }}">แก้ไขข้อมูล</a>
                                                    <a class="dropdown-item delete-confirm"
                                                       href="/stock/delete/{{$row->id}}">ลบข้อมูล</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel"
                         aria-labelledby="tabs-icons-text-2-tab">
                        <div class="card shadow p-4">
                            <table id="table_device">
                                <thead>
                                <tr>
                                    <th>รหัสครุภัณฑ์</th>
                                    <th>ชื่อครุภัณฑ์</th>
                                    <th class="text-center">รูปภาพ</th>
                                    <th class="text-center">จำนวน</th>
                                    <th>ปี</th>
                                    <th>ประเภท</th>
                                    <th>สถานะ</th>
                                    <th class="text-center">จัดการข้อมูล</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($devices as $row)
                                    <tr>
                                        <td>{{ $row->device_num }}</td>
                                        <td>{{ $row->device_name }}</td>
                                        @if($row->image == 0)
                                            <td><img src="{{asset('images/imageNull/null.png')}}"
                                                     class="rounded mx-auto d-block " width="80" height="80"/></td>
                                        @else
                                            <td><img src="{{ asset($row->image) }}" class="rounded mx-auto d-block "
                                                     width="80"
                                                     height="80"/>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $row->device_amount }}</td>
                                            <td>{{ $row->device_year }}</td>
                                            <td>{{ $row->device_type->type_detail }}</td>
                                            @if($row->device_status == 0)
                                                <td>
                                                    <div class="rounded text-white bg-green text-center">พร้อมใช้งาน
                                                    </div>
                                                </td>
                                            @elseif($row->device_status == 1)
                                                <td>
                                                    <div class="rounded text-white bg-orange text-center">รออนุมัติ
                                                    </div>
                                                </td>
                                            @elseif($row->device_status == 2)
                                                <td>
                                                    <div class="rounded text-white bg-red text-center">ถูกยืม</div>
                                                </td>
                                            @endif
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-icon-only text-light" href="#"
                                                       role="button"
                                                       data-toggle="dropdown" aria-haspopup="true"
                                                       aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div
                                                        class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                        <a class="dropdown-item"
                                                           href="{{ url('/device/edit/'.$row->id) }}">แก้ไขข้อมูล</a>
                                                        <a class="dropdown-item delete-confirm"
                                                           href="/device/delete/{{$row->id}}">ลบข้อมูล</a>
                                                    </div>
                                                </div>
                                            </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel"
                         aria-labelledby="tabs-icons-text-3-tab">
                        <div class="card shadow p-4">
                            <table id="table_disposable">
                                <thead>
                                <tr>
                                    <th>รหัสวัสดุสิ้นเปลือง</th>
                                    <th>ชื่อวัสดุสิ้นเปลือง</th>
                                    <th class="text-center">รูปภาพ</th>
                                    <th class="text-center">จำนวน</th>
                                    <th>ประเภท</th>
                                    <th class="text-center">สถานะ</th>
                                    <th class="text-center">จัดการข้อมูล</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($disposables as $row)
                                    <tr>
                                        <td>{{ $row->disposable_num }}</td>
                                        <td>{{ $row->disposable_name }}</td>
                                        @if($row->image == 0)
                                            <td><img src="{{asset('images/imageNull/null.png')}}"
                                                     class="rounded mx-auto d-block " width="80" height="80"/></td>
                                        @else
                                            <td><img src="{{ asset($row->image) }}" class="rounded mx-auto d-block "
                                                     width="80"
                                                     height="80"/>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $row->disposable_amount }}</td>
                                            <td>{{ $row->disposable_type->type_detail }}</td>
                                            @if($row->disposable_status == 0)
                                                <td>
                                                    <div class="rounded text-white bg-green text-center"> พร้อมใช้งาน
                                                    </div>
                                                </td>
                                            @elseif($row->disposable_status == 1)
                                                <td>
                                                    <div class="rounded text-white bg-orange text-center"> รออนุมัติ
                                                    </div>
                                                </td>
                                            @elseif($row->disposable_status == 2)
                                                <td>
                                                    <div class="rounded text-white bg-red text-center"> ถูกยืม</div>
                                                </td>
                                            @endif
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <a class="btn btn-sm btn-icon-only text-light" href="#"
                                                       role="button"
                                                       data-toggle="dropdown" aria-haspopup="true"
                                                       aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <div
                                                        class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                        <a class="dropdown-item"
                                                           href="{{ url('/disposable/edit/'.$row->id) }}">แก้ไขข้อมูล</a>
                                                        <a class="dropdown-item delete-confirm"
                                                           href="/disposable/delete/{{$row->id}}">ลบข้อมูล</a>
                                                    </div>
                                                </div>
                                            </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('js')
    <script>
        $(function () {
            $.extend($.fn.dataTableExt.oStdClasses, {
                "sFilterInput": "form-control form-control-sm",
                "sLengthSelect": "form-control form-control-sm"
            });
            $('#table_stock').dataTable({
                "responsive": true,
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
            $('#table_device').dataTable({
                "responsive": true,
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
            $('#table_disposable').dataTable({
                "responsive": true,
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

        $('.delete-confirm').on('click', function (event) {
            event.preventDefault();
            const url = $(this).attr('href');
            Swal.fire({
                title: 'คุณแน่ใจ?',
                text: "คุณต้องการลบข้อมูลนี้หรือไม่!",
                icon: 'warning',
                focusCancel: true,
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'ลบข้อมูลเรียบร้อย',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });
        });
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="assets/vendor/select2/dist/js/select2.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
@endpush
