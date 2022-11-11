@extends('layouts.app', ['class' => 'bg-neutral'])
@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--9">
    <div class="row">
        <div class="col-xl-12 mb-4">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <h3 class="mb-0">จัดการข้อมูลผู้ใช้งาน</h3>
                        </div>
                        <div class="col-8 text-right">
                            <a href="{{ route('data-import') }}"  class="btn btn-sm btn-primary">เพิ่มผู้ใช้งาน</a>
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
                    <table id="table_id" class="">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รหัสผู้ใช้งาน</th>
                                <th>คำนำหน้า</th>
                                <th>ชื่อ</th>
                                <th>นามสกุล</th>
                                <th>อีเมล</th>
                                <th>แผนก</th>
                                <th>กลุ่ม</th>
                                <th>สิทธิ์ปัจจุบัน</th>
                                <th>จัดการข้อมูล</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $row)
                            <tr>
                                <td>{{ $row->id}}</td>
                                <td>{{ $row->user_id}}</td>
                                <td>{{ $row->prefix_name}}</td>
                                <td>{{ $row->firstname}}</td>
                                <td>{{ $row->lastname}}</td>
                                <td>{{ $row->email}}</td>
                                <td>{{ $row->department ? $row->department : '-'}}</td>
                                <td>{{ $row->group ? $row->group : '-'}}</td>
                                <td>{{ $row->role}}</td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item"
                                                href="{{ url('/manage-role/edit/'.$row->id) }}">แก้ไขข้อมูล</a>
                                            <a class="dropdown-item delete-confirm"
                                                href="{{ url('/manage-role/delete/'.$row->id) }}">ลบข้อมูล</a>
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

@endsection

@push('js')
<script>
$(function() {
    $.extend($.fn.dataTableExt.oStdClasses, {
        "sFilterInput": "form-control form-control-sm",
        "sLengthSelect": "form-control form-control-sm"
    });
    $('#table_id').dataTable({
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

$('.delete-confirm').on('click', function(event) {
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
@endpush
