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
                            <h3 class="mb-0">รายการวัสดุสิ้นเปลือง</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('disposable-import') }}"
                                class="btn btn-sm btn-outline-success">นำเข้าข้อมูล
                                XLSX & CSV</a>
                            <a href="{{ route('add_disposable') }}"
                                class="btn btn-sm btn-primary">เพิ่มวัสดุสิ้นเปลือง</a>
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
                    <table id="table_id" class="">
                        <thead>
                            <tr>
                                <th>รหัสวัสดุสิ้นเปลือง</th>
                                <th>ชื่อวัสดุสิ้นเปลือง</th>
                                <th class="text-center">สถานะ</th>
                                <th class="text-center">จำนวนทั้งหมด</th>
                                <th class="text-center">รูปภาพ</th>
                                <th>ประเภท</th>
                                <th class="text-center">จัดการข้อมูล</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($disposables as $row)
                            <tr>
                                <td>{{ $row->disposable_num }}</td>
                                <td>{{ $row->disposable_name }}</td>
                                @if($row->disposable_status == 1)
                                <td>
                                    <div class="rounded text-white bg-green text-center">ปกติ</div>
                                </td>
                                @endif
                                <td class="text-center">{{ $row->disposable_amount }}</td>
                                @if($row->image == 0)
                                <td><img src="{{asset('images/imageNull/null.png')}}" class="rounded mx-auto d-block "
                                        width="80" height="80" /></td>
                                @else
                                <td><img src="{{ asset($row->image) }}" class="rounded mx-auto d-block " width="80"
                                        height="80" />
                                    @endif
                                </td>
                                <td>{{ $row->disposable_type->type_detail }}</td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item"
                                                href="{{ url('/disposable/edit/'.$row->id) }}">แก้ไขข้อมูล</a>
                                            <a class="dropdown-item" onclick="return confirm('ต้องการลบข้อมูล?');"
                                                href="{{ url('/disposable/delete/'.$row->id) }}">ลบข้อมูล</a>
                                        </div>
                                    </div>
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
                    <div class="mt-4">
                        {{ $disposables->links() }}
                    </div>
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
</script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="assets/vendor/select2/dist/js/select2.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
<script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
@endpush