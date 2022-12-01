@extends('layouts.app', ['class' => 'bg-neutral'])

@section('content')
    @include('layouts.headers.cards')
    <div class="container-fluid mt--9">
        <div class="row">
            <div class="col-xl-12 mb-4">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h3 class="mb-0">รายการครุภัณฑ์</h3>
                            </div>
                            <div class="col-6 text-right">
                                <a href="{{ route('device-import') }}" class="btn btn-sm btn-outline-success">นำเข้าข้อมูล
                                    XLSX & CSV</a>
                                <a href="{{ route('add_device') }}" class="btn btn-sm btn-primary">เพิ่มครุภัณฑ์</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h3>ประเภท</h3>
                        <div class="mb-3">
                            <select class="form-control type" name="type" id="type">
                                <option value="">เลือกประเภทครุภัณฑ์</option>
                                @foreach($types as $row)
                                    <option value="{{$row->id}}">{{$row->type_detail}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="table-responsive">
                            <table id="table_id">
                                <thead>
                                <tr>
                                    <th>รหัสครุภัณฑ์</th>
                                    <th>ชื่อครุภัณฑ์</th>
                                    <th class="text-center">รูปภาพ</th>
                                    <th class="text-center">จำนวน</th>
                                    <th class="text-center">ปี</th>
                                    <th>สถานะ</th>
                                    <th class="text-center">จัดการข้อมูล</th>
                                </tr>
                                </thead>
                                <tbody id="datalist">
                                @foreach($devices as $row)
                                    <tr>
                                        <td>{{ $row->device_num }}</td>
                                        <td>{{ $row->device_name }}</td>
                                        @if($row->image == 0)
                                            <td><img src="{{asset('images/imageNull/null.png')}}" alt="image null"
                                                     class="rounded mx-auto d-block "
                                                     width="80" height="80"/></td>
                                        @else
                                            <td><img src="{{ asset($row->image) }}" class="rounded mx-auto d-block"
                                                     alt="image device"
                                                     width="80"
                                                     height="80"/></td>
                                        @endif
                                        <td class="text-center">{{ $row->device_amount }}</td>
                                        <td class="text-center">{{ $row->device_year }}</td>
                                        @if(($row->device_status == 0 || $row->device_status == 3 || $row->device_status == 5) && ($row->defective_device == 0))
                                            <td>
                                                <div class="rounded text-white bg-gradient-green text-center">
                                                    พร้อมใช้งาน
                                                </div>
                                            </td>
                                        @elseif($row->defective_device == 1)
                                            <td>
                                                <div class="rounded text-white bg-gradient-red text-center">ชำรุด</div>
                                            </td>
                                        @endif
                                        @if($row->device_status == 1)
                                            <td>
                                                <div class="rounded text-white bg-gradient-orange text-center">
                                                    รออนุมัติ
                                                </div>
                                            </td>
                                        @endif
                                        @if($row->device_status == 2)
                                            <td>
                                                <div class="rounded text-white bg-gradient-primary text-center">ถูกยืม
                                                </div>
                                            </td>
                                        @endif
                                        @if($row->device_status == 4)
                                            <td>
                                                <div class="rounded text-white bg-gradient-info text-center">รออนุมัติส่งคืน
                                                </div>
                                            </td>
                                        @endif
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="{{ url('/device/edit/'.$row->id) }}">แก้ไขข้อมูล</a>
                                                    <a class="dropdown-item delete-confirm"
                                                       href="{{ url('/device/delete/'.$row->id) }}">ลบข้อมูล</a>
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
    {{csrf_field()}}
    </div>
@endsection
@push('js')
    <script>
        $(function () {
            $.extend($.fn.dataTableExt.oStdClasses, {
                "sFilterInput": "form-control form-control-sm",
                "sLengthSelect": "form-control form-control-sm"
            });
            $('#table_id').dataTable({
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'ทั้งหมด'],
                ],
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

        $('#type').change(function () {
            if ($(this).val() !== '') {
                let select = $(this).val();
                let _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{route('device.fetch')}}",
                    method: "POST",
                    data: {
                        select: select,
                        _token: _token
                    },
                    success: function (result) {
                        {
                            $("#datalist").html(result)
                        }
                    }
                })
            }
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
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@endpush
