@extends('layouts.app', ['class' => 'bg-neutral'])
@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--9">
    <div class="row">
        <div class="col-xl-12 mb-4">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">รายงานข้อมูลรายเดือน</h3>
                        </div>
                        <div class="col-4 text-right">
{{--                            {{dd($regMonth)}}--}}
                            <form action="{{route('report_month_xlsm')}}" enctype="multipart/form-data" method="get">
                                <input type="hidden" name="regMonth" value="{{$regMonth}}">
                                <button type="submit" class="btn btn-sm btn-outline-danger" {{$regMonth !== '' ? '' : 'disabled'}}>
                                    Export Excel
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 mb-4">
            <div class="card bg-secondary shadow">
                <div class="card-body">
                    <form action="{{route('report-months')}}" enctype="multipart/form-data" method="get">
                        <div class="mb-2">
                            <h4>ระบุระยะเวลา</h4>
                            <div class="row gaps">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="input-group input-group-alternative">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                            </div>
                                            <input class="form-control datepicker" placeholder="Select date" name="fromMonth" type="month">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <button class="btn btn-primary btn" type="submit">ตกลง</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <table id="table_id">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รหัสผู้ใช้งาน</th>
                                <th>ชื่อ</th>
                                <th>นามสกุล</th>
                                <th>วันที่</th>
                                <th>สถานะ</th>
                                <th>รายละเอียด</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($report_months as $row)
                            <tr>
                                <td>{{ $row->id}}</td>
                                <td>{{ $row->borrow_user->user_id}}</td>
                                <td>{{ $row->borrow_user->firstname}}</td>
                                <td>{{ $row->borrow_user->lastname}}</td>
                                <td>{{ \Carbon\Carbon::parse($row->created_at)->locale('th')->isoFormat('L - LT')  }}</td>
                                @if($row->borrow_status == 1)
                                    <td class="align-middle text-sm">
                                        <span class="badge text-white bg-gradient-warning">รอนุมัติ</span>
                                    </td>
                                @elseif($row->borrow_status == 2)
                                    <td class="align-middle text-sm">
                                        <span class="badge text-white bg-gradient-success">อนุมัติ</span>
                                    </td>
                                @else
                                    <td class="align-middle text-sm">
                                        <span class="badge text-white bg-gradient-danger">ไม่อนุมัติ</span>
                                    </td>
                                @endif
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#Modal{{($row->id)}}">
                                        รายละเอียด
                                    </button>
                                    <div class="modal fade" id="Modal{{($row->id)}}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLabel">รายการยืม</h3>
                                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    @if($row->borrow_status == 1 || $row->borrow_status == 2)
                                                        <div class="row mb-2">
                                                            <div class="col-lg-6"> วันที่ยืม</div>
                                                            <div class="col-lg-6"> วันที่คืน</div>
                                                        </div>
                                                        <div class="mb-4 flex-row justify-content-between">
                                                           <span class="text-gray">
                                                              {{
                                                                 \Carbon\Carbon::parse($row->started_at)->locale('th')->isoFormat('LLL')
                                                              }}
                                                           </span>
                                                            -
                                                            <span class="text-danger">
                                                               {{
                                                                  \Carbon\Carbon::parse($row->end_at)->locale('th')->isoFormat('LLL')
                                                               }}
                                                            </span>
                                                        </div>
                                                    @else
                                                        <div class="mb-4 flex-row justify-content-between">
                                                            <div class="text-danger">ไม่อนุมัติ</div>
                                                            <div>
                                                                <span>หมายเหตุ :</span>
                                                                <span>{{ $row->description }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            @foreach($row->borrow_list_id as $id)
                                                            <div class="mb-2 text-primary"> {{ $id }} </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="col-lg-4">
                                                            @foreach($row->borrow_name as $name)
                                                            <div class="mb-2"> {{ $name }} </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="col-lg-4">
                                                            @foreach($row->borrow_amount as $amount)
                                                            <div class="mb-2"> {{ $amount }} </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-2">
                        <a href="{{route('reportAll')}}" class="btn btn-success ">ย้อนกลับ</a>
                    </div>
                    @if (session('success'))
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
                    @if (session('error'))
                    <script>
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'ยกเลิกรายการยืมสำเร็จ',
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
$(function() {
    $.extend($.fn.dataTableExt.oStdClasses, {
        "sFilterInput": "form-control form-control-sm",
        "sLengthSelect": "form-control form-control-sm"
    });
    $('#table_id').dataTable({
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
    $('[type=search]').each(function() {
        +
        $(this).attr("placeholder", "Search...");
        $(this).before('<span class="fa fa-search"></span>');
    });
    $('#button').click(function() {
        alert(table.rows('.selected').data().length + ' row(s) selected');
    });
});

function submitButton() {

}

function submitCheckbox() {
    checkbox.checked = true;
}
</script>

@endpush
